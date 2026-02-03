<?php
namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        // getting theme
        if (isset($_COOKIE['theme']))
            $theme = $_COOKIE['theme'];
        else
            $theme = 'light';

        $numberOfUserAccount = \App\Models\User::where('is_active', true)->where('bus_config_id', session('bus_config_id'))->count();
        return view('admin.auth.adminlogin', compact('theme', 'numberOfUserAccount'));
        // return view('admin.auth.adminlogin');
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('admin.admin_dashboard');
        }
        return back()->withErrors(['message' => 'Invalid credentials.']);
    }
}
