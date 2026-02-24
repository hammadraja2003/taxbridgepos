<?php
namespace App\Traits;

trait MailInfo {

	public function setMailInfo($mail_setting) 
    {
        // Legacy Config (Laravel < 7)
        config()->set('mail.driver', $mail_setting->driver);
        config()->set('mail.host', $mail_setting->host);
        config()->set('mail.port', $mail_setting->port);
        config()->set('mail.from.address', $mail_setting->from_address);
        config()->set('mail.from.name', $mail_setting->from_name);
        config()->set('mail.username', $mail_setting->username);
        config()->set('mail.password', $mail_setting->password);
        config()->set('mail.encryption', $mail_setting->encryption);

        // Modern Config (Laravel 8/9/10+)
        // Assuming driver is 'smtp'. If it's something else, we might need more logic.
        $driver = $mail_setting->driver;
        config()->set('mail.default', $driver);
        
        if ($driver === 'smtp') {
            config()->set('mail.mailers.smtp.transport', 'smtp');
            config()->set('mail.mailers.smtp.host', $mail_setting->host);
            config()->set('mail.mailers.smtp.port', $mail_setting->port);
            config()->set('mail.mailers.smtp.encryption', $mail_setting->encryption);
            config()->set('mail.mailers.smtp.username', $mail_setting->username);
            config()->set('mail.mailers.smtp.password', $mail_setting->password);
            config()->set('mail.mailers.smtp.timeout', null);
            config()->set('mail.mailers.smtp.auth_mode', null);
        }
        
        // Force the mailer to reload configuration
        // For Laravel 8/9/10+, we need to purge the resolved mailer instance
        try {
            if (app()->bound('mail.manager')) {
                app('mail.manager')->forgetMailers();
            }
        } catch (\Exception $e) {
            // Check if facade works
            \Illuminate\Support\Facades\Mail::purge($driver);
        }
    }
}