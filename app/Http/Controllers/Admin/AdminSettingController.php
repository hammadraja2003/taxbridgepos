<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminMailSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Traits\MailInfo;

class AdminSettingController extends Controller
{
    use MailInfo;

    public function mailSetting()
    {
        $mail_setting_data = AdminMailSetting::latest()->first();
        return view('admin.setting.mail_setting', compact('mail_setting_data'));
    }

    public function mailSettingStore(Request $request)
    {
        $request->validate([
            'driver' => 'required',
            'host' => 'required',
            'port' => 'required',
            'from_address' => 'required|email',
            'from_name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'encryption' => 'required',
        ]);

        $data = $request->all();
        $mail_setting = AdminMailSetting::latest()->first();
        if (!$mail_setting) {
            $mail_setting = new AdminMailSetting;
        }
        
        $mail_setting->driver = $data['driver'];
        $mail_setting->host = $data['host'];
        $mail_setting->port = $data['port'];
        $mail_setting->from_address = $data['from_address'];
        $mail_setting->from_name = $data['from_name'];
        $mail_setting->username = $data['username'];
        $mail_setting->password = trim($data['password']);
        $mail_setting->encryption = $data['encryption'];
        $mail_setting->save();

        try {
            $this->setMailInfo($mail_setting);
            // Send test mail to check settings
            Mail::raw('This is a test mail to confirm your GLOBAL Admin SMTP settings are working.', function ($message) use ($mail_setting) {
                $message->to($mail_setting->from_address)
                        ->subject('Admin Global Mail Test');
            });

            return redirect()->back()->with('success', 'Global mail settings updated and test mail sent to ' . $mail_setting->from_address);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Settings saved but mail failed: ' . $e->getMessage());
        }
    }
}
