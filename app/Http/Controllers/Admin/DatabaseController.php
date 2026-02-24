<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\UserDetails;
use App\Models\AdminMailSetting;
use App\Models\BusinessConfiguration;
use App\Models\Roles as Role;
use App\Models\User;
use App\Traits\MailInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Exception;

class DatabaseController extends Controller
{
    use MailInfo;

    public function showCloneForm()
    {
        $databases = DB::select('SHOW DATABASES');
        $dbList = collect($databases)->pluck('Database');
        $filtered = $dbList->reject(function ($db) {
            return in_array($db, [
                'information_schema',
                'mysql',
                'performance_schema',
                'sys'
            ]);
        });
        return view('admin.DB.clone', ['databases' => $filtered]);
    }

    public function clone(Request $request)
    {
        $request->validate([
            'source_db' => 'required|string',
            'new_db' => 'required|string|regex:/^[a-zA-Z0-9_]+$/',
            'db_username' => 'required|string',
            'db_password' => 'nullable|string'
        ]);

        $sourceDb = trim($request->source_db);
        $newDb = trim($request->new_db);

        try {
            $escapedNewDb = addslashes($newDb);
            $exists = DB::select("SHOW DATABASES LIKE '$escapedNewDb'");

            if (!empty($exists)) {
                return back()->with('error', "Database `$newDb` already exists. Please choose another name.");
            }

            DB::statement("CREATE DATABASE `$newDb` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

            $escapedSource = addslashes($sourceDb);
            $tables = DB::select("SHOW TABLES FROM `$escapedSource`");
            $key = 'Tables_in_' . $sourceDb;

            foreach ($tables as $table) {
                $tableName = $table->$key;
                DB::statement("CREATE TABLE `$newDb`.`$tableName` LIKE `$sourceDb`.`$tableName`");

                // Copy data for essential setup tables
                $essentialTables = ['currencies', 'languages', 'translations', 'units', 'taxes', 'invoice_settings', 'barcodes'];
                if (in_array($tableName, $essentialTables)) {
                    DB::statement("INSERT INTO `$newDb`.`$tableName` SELECT * FROM `$sourceDb`.`$tableName`");
                }

                $triggers = DB::select("SHOW TRIGGERS FROM `$sourceDb` WHERE `Table` = '$tableName'");
                foreach ($triggers as $trigger) {
                    $triggerName = $trigger->Trigger;
                    $timing = $trigger->Timing;
                    $event = $trigger->Event;
                    $statement = $trigger->Statement;
                    $cleanStatement = str_replace("`$sourceDb`.", '', $statement);

                    DB::statement("
                        CREATE TRIGGER `$newDb`.`$triggerName`
                        $timing $event ON `$newDb`.`$tableName`
                        FOR EACH ROW $cleanStatement
                    ");
                }
            }

            $newBusinessConfig = BusinessConfiguration::where('db_name', $newDb)->first();

            if (!$newBusinessConfig) {
                $sourceBusinessConfig = BusinessConfiguration::where('db_name', $sourceDb)->first();

                if ($sourceBusinessConfig) {
                    $newBusinessConfig = $sourceBusinessConfig->replicate();
                    $newBusinessConfig->db_name = $newDb;
                    $newBusinessConfig->db_username = $request->db_username;
                    $newBusinessConfig->db_password = $request->db_password;
                    $newBusinessConfig->save();
                } else {
                    return back()->with('error', "Source business configuration not found for DB: {$sourceDb}");
                }
            }

            BusinessConfiguration::where('bus_config_id', $newBusinessConfig->bus_config_id)->update([
                'db_username' => $request->db_username,
                'db_password' => $request->db_password
            ]);

            $adminRole = Role::where('bus_config_id', $newBusinessConfig->bus_config_id)
                ->where('role_type', '1')
                ->first();

            if (!$adminRole) {
                return back()->with('error', 'No admin role found for the new business configuration.');
            }

            $admins = User::where('bus_config_id', $newBusinessConfig->bus_config_id)
                ->where('role_id', $adminRole->id)
                ->where('is_active', 1)
                ->where('is_deleted', 0)
                ->get();

            logger()->info('Admins Found', [
                'count' => $admins->count(),
                'emails' => $admins->pluck('email')->toArray()
            ]);

            if ($admins->isEmpty()) {
                logger()->error('No admin users found for bus_config_id: ' . $newBusinessConfig->bus_config_id . ' with role_id: ' . $adminRole->id);
                return back()->with('error', 'No admin users found for the new business configuration.');
            }

            $loginUrl = url('/login');

            try {
                $mail_setting = AdminMailSetting::latest()->first();

                if ($mail_setting) {
                    $this->setMailInfo($mail_setting);
                }
                $encryptedPassword = Crypt::encryptString('12345678');
                foreach ($admins as $admin) {
                    $mailData = [
                        'name' => $admin->name,
                        'email' => $admin->email,
                        'login_url' => $loginUrl,
                        'db_name' => $newDb,
                        'db_username' => $request->db_username,
                        'db_password' => $request->db_password,
                    ];

                    Mail::to($admin->email)->send(new UserDetails((object) $mailData));
                }
            } catch (Exception $e) {
                return back()->with('error', 'Database cloned but email failed: ' . $e->getMessage());
            }

            return back()->with('success', "Database `$newDb` cloned successfully from `$sourceDb`. Credentials sent to admin email(s).");
        } catch (\Exception $e) {
            DB::statement("DROP DATABASE IF EXISTS `$newDb`");
            return back()->with('error', 'Cloning failed: ' . $e->getMessage());
        }
    }
}
