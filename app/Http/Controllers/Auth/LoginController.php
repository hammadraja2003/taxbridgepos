<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;
use Cache;
use DB;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = null;

    /**
     * Create a new controller instance.
     *
     *
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        // getting theme
        if (isset($_COOKIE['theme']))
            $theme = $_COOKIE['theme'];
        else
            $theme = 'light';

        $numberOfUserAccount = \App\Models\User::where('is_active', true)->where('bus_config_id', session('bus_config_id'))->count();
        return view('backend.auth.login', compact('theme', 'numberOfUserAccount'));
    }

    // public function login(Request $request)
    // {
    //     $input = $request->all();

    //     $this->validate($request, [
    //         'name' => 'required',
    //         'password' => 'required',
    //     ]);

    //     $fieldType = filter_var($request->name, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
    //     $credentials = array($fieldType => $input['name'], 'password' => $input['password']);

    //     if (Auth::guard('web')->attempt($credentials, $request->boolean('remember'))) {
    //         $user = Auth::guard('web')->user();

    //         // --- Validate tenant configuration before login ---
    //         if (empty($user->bus_config_id) || $user->bus_config_id == 0 || $user->bus_config_id <= 0 || $user->is_active != 1) {
    //             // Logout user if validation fails
    //             Auth::logout();
    //             $request->session()->invalidate();
    //             $request->session()->regenerateToken();

    //             return redirect()->route('login')->with('delete_message', 'Your account is not configured. Please contact administrator.');
    //         }

    //         // --- Session regeneration ---
    //         $request->session()->regenerate();

    //         // --- Set tenant context ---
    //         try {
    //             app(\App\Services\TenantManager::class)->setTenant($user->bus_config_id);
    //             $request->session()->put('bus_config_id', $user->bus_config_id);
    //         } catch (\Exception $e) {
    //             // Logout if tenant setup fails
    //             Auth::logout();
    //             $request->session()->invalidate();
    //             $request->session()->regenerateToken();

    //             return redirect()->route('login')->with('delete_message', 'Unable to configure tenant. Please contact administrator.');
    //         }

    //         return redirect()->intended('/dashboard');
    //     }

    //     // --- Invalid credentials ---
    //     return redirect()->route('login')->with('delete_message', 'Username And Password Are Wrong.');
    // }
    public function login(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'name' => 'required',
            'password' => 'required',
        ]);

        $fieldType = filter_var($request->name, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        $credentials = array($fieldType => $input['name'], 'password' => $input['password']);

        if (Auth::guard('web')->attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::guard('web')->user();

            // --- Validate tenant configuration before login ---
            if (empty($user->bus_config_id) || $user->bus_config_id == 0 || $user->bus_config_id <= 0 || $user->is_active != 1) {
                // Logout user if validation fails
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->with('delete_message', 'Your account is not configured. Please contact administrator.');
            }

            // --- Session regeneration ---
            $request->session()->regenerate();

            // --- Set tenant context ---
            try {
                app(\App\Services\TenantManager::class)->setTenant($user->bus_config_id);
                $request->session()->put('bus_config_id', $user->bus_config_id);
            } catch (\Exception $e) {
                // Logout if tenant setup fails
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->with('delete_message', 'Unable to configure tenant. Please contact administrator.');
            }

            // ✅ ADD 2FA CHECK HERE - BEFORE REDIRECTING TO DASHBOARD
            if ($user->hasTwoFactorEnabled()) {
                // Store user ID in session but don't mark as fully authenticated
                session(['2fa_user_id' => $user->id]);

                // Logout the user temporarily
                Auth::logout();

                // Redirect to 2FA verification page
                return redirect()->route('mfa.verify');
            }

            // Mark as 2FA verified for users without 2FA
            session(['2fa_verified' => true]);

            return redirect()->intended('/dashboard');
        }

        // --- Invalid credentials ---
        return redirect()->route('login')->with('delete_message', 'Username And Password Are Wrong.');
    }

    /**
     * Override the authenticated method to check for 2FA
     */
    protected function authenticated(Request $request, $user)
    {
        // Check if user has 2FA enabled
        if ($user->hasTwoFactorEnabled()) {
            // Store user ID in session but don't mark as fully authenticated
            session(['2fa_user_id' => $user->id]);

            // Logout the user temporarily
            Auth::logout();

            // Redirect to 2FA verification page
            return redirect()->route('mfa.verify');
        }
        // Mark as 2FA verified for users without 2FA
        session(['2fa_verified' => true]);
        return redirect()->intended($this->redirectPath());
    }

    /**
     * Show 2FA verification form
     */
    public function showVerifyForm()
    {
        if (!session('2fa_user_id')) {
            return redirect()->route('login');
        }
        return view('backend.mfa.verify');
    }

    /**
     * Verify 2FA code
     */
    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);
        $userId = session('2fa_user_id');

        if (!$userId) {
            return redirect()->route('login')->withErrors(['code' => 'Session expired. Please login again.']);
        }
        $user = \App\Models\User::find($userId);
        if (!$user || !$user->hasTwoFactorEnabled()) {
            return redirect()->route('login')->withErrors(['code' => 'Invalid session.']);
        }
        $google2fa = new Google2FA();
        $secret = decrypt($user->two_factor_secret);
        // Check if it's a recovery code
        if (strlen($request->code) === 10) {
            if ($user->useRecoveryCode($request->code)) {
                $this->completeLogin($user);
                return redirect()
                    ->intended($this->redirectPath())
                    ->with('warning', 'You used a recovery code. Please generate new ones.');
            }
        } else {
            // Verify 2FA code
            $valid = $google2fa->verifyKey($secret, $request->code);
            if ($valid) {
                $this->completeLogin($user);
                return redirect()->intended($this->redirectPath());
            }
        }
        return back()->withErrors(['code' => 'The verification code is invalid.']);
    }

    /** Complete the login process */
    // private function completeLogin($user)
    // {
    //     Auth::login($user);
    //     session(['2fa_verified' => true]);
    //     session()->forget('2fa_user_id');
    //     session()->regenerate();
    // }

    /**
     * Complete the login process
     */
    private function completeLogin($user)
    {
        Auth::login($user);
        session(['2fa_verified' => true]);
        session()->forget('2fa_user_id');

        // ✅ RESTORE TENANT CONTEXT AFTER 2FA VERIFICATION
        try {
            app(\App\Services\TenantManager::class)->setTenant($user->bus_config_id);
            session()->put('bus_config_id', $user->bus_config_id);
        } catch (\Exception $e) {
            Auth::logout();
            session()->invalidate();
            return redirect()->route('login')->with('delete_message', 'Unable to configure tenant.');
        }

        session()->regenerate();
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');  // Replace with your desired URL
    }
}
