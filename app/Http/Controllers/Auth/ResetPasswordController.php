<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
     * |--------------------------------------------------------------------------
     * | Password Reset Controller
     * |--------------------------------------------------------------------------
     * |
     * | This controller is responsible for handling password reset requests
     * | and uses a simple trait to include this behavior. You're free to
     * | explore this trait and override any methods you wish to tweak.
     * |
     */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('backend.auth.passwords.reset', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    protected function resetPassword($user, $password)
    {
        $user->password = bcrypt($password);
        $user->save();

        // User ko logout kar do
        \Auth::logout();

        // Session regenerate karo
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }

    public function redirectPath()
    {
        return '/login';
    }
}
