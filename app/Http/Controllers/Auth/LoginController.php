<?php



namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Cache;
use DB;


class LoginController extends Controller

{
    use AuthenticatesUsers;

    protected $redirectTo = null;

    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        //getting theme
        if(isset($_COOKIE['theme']))
            $theme = $_COOKIE['theme'];
        else
            $theme = 'light';

        $numberOfUserAccount = \App\Models\User::where('is_active', true)->where('bus_config_id', session('bus_config_id'))->count();
        return view('backend.auth.login', compact('theme', 'numberOfUserAccount'));
    }

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

            return redirect()->intended('/dashboard');
        }

        // --- Invalid credentials ---
        return redirect()->route('login')->with('delete_message', 'Username And Password Are Wrong.');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login'); // Replace with your desired URL
    }
}
