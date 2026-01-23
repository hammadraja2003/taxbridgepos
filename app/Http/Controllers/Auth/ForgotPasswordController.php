<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\BusinessConfiguration;
use App\Models\GeneralSetting;
use App\Models\MailSetting;
use App\Models\User;
use App\Traits\MailInfo;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Cache;
use Config;
use DB;

class ForgotPasswordController extends Controller
{
    /*
     * |--------------------------------------------------------------------------
     * | Password Reset Controller
     * |--------------------------------------------------------------------------
     * |
     * | This controller is responsible for handling password reset emails and
     * | includes a trait which assists in sending these notifications from
     * | your application to your users. Feel free to explore this trait.
     * |
     */

    use SendsPasswordResetEmails;
    use MailInfo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Override the default view path for the forgot password form.
     */
    public function showLinkRequestForm()
    {
        return view('backend.auth.passwords.email');
    }

    // public function sendResetLinkEmail(Request $request)
    // {
    //     $mail_setting = MailSetting::latest()->first();
    //     if ($mail_setting) {
    //         $this->setMailInfo($mail_setting);
    //         $this->validateEmail($request);

    //         // We will send the password reset link to this user. Once we have attempted
    //         // to send the link, we will examine the response then see the message we
    //         // need to show to the user. Finally, we'll send out a proper response.
    //         $response = $this->broker()->sendResetLink(
    //             $this->credentials($request)
    //         );

    //         return $response == Password::RESET_LINK_SENT
    //             ? $this->sendResetLinkResponse($request, $response)
    //             : $this->sendResetLinkFailedResponse($request, $response);
    //     } else {
    //         return back()
    //             ->withInput($request->only('email'))
    //             ->withErrors(['email' => __('db.Mail settings are not configured. Please contact the administrator.')]);
    //     }
    // }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        Config::set('database.default', 'master');
        DB::purge('master');
        DB::reconnect('master');

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => __('passwords.user'),
            ]);
        }

        $business = BusinessConfiguration::find($user->bus_config_id);

        if (!$business) {
            return back()->withErrors([
                'email' => 'Business configuration not found.',
            ]);
        }
        // 3️⃣ TENANT DB CONNECT
        Config::set('database.connections.tenant.host', $business->db_host ?: '127.0.0.1');
        Config::set('database.connections.tenant.port', $business->db_port ?? 3306);
        Config::set('database.connections.tenant.database', $business->db_name);
        Config::set('database.connections.tenant.username', $business->db_username);
        Config::set('database.connections.tenant.password', $business->db_password);

        DB::purge('tenant');
        DB::reconnect('tenant');

        // app(\App\Services\TenantManager::class)->setTenant($business->id);

        // 4️⃣ TENANT DB: mail settings uthao
        $mail_setting = MailSetting::latest()->first();

        if (!$mail_setting) {
            return back()->withErrors([
                'email' => 'Mail settings not configured for this business.',
            ]);
        }

        // 5️⃣ Mail config set karo
        $this->setMailInfo($mail_setting);

        // 6️⃣ RESET LINK SEND (MASTER DB USERS TABLE)
        Config::set('database.default', 'master');
        DB::purge('master');
        DB::reconnect('master');

        $response = $this->broker()->sendResetLink([
            'email' => $request->email,
        ]);

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($request, $response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }
}
