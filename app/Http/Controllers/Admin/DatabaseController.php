<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserDetails;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\BusinessConfiguration;
use App\Models\AdminMailSetting;
use App\Traits\MailInfo;
use Illuminate\Support\Facades\Crypt;
use Exception;
class DatabaseController extends Controller
{
    use MailInfo;
    public function showCloneForm()
    {
        $databases = DB::select("SHOW DATABASES");
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
            'new_db' => 'required|string|regex:/^[a-zA-Z0-9_]+$/'
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
            $key = "Tables_in_" . $sourceDb;
            foreach ($tables as $table) {
                $tableName = $table->$key;
                DB::statement("CREATE TABLE `$newDb`.`$tableName` LIKE `$sourceDb`.`$tableName`");
                $triggers = DB::select("SHOW TRIGGERS FROM `$sourceDb` WHERE `Table` = '$tableName'");
                foreach ($triggers as $trigger) {
                    $triggerName = $trigger->Trigger;
                    $timing = $trigger->Timing;
                    $event = $trigger->Event;
                    $statement = $trigger->Statement;
                    $cleanStatement = str_replace("`$sourceDb`.", "", $statement);
                    DB::statement("
                    CREATE TRIGGER `$newDb`.`$triggerName`
                    $timing $event ON `$newDb`.`$tableName`
                    FOR EACH ROW $cleanStatement
                ");
                }
            }
            // ✅ Get all business admins (role_id = 1)
            $admins = User::select('users.*', 'business_configurations.db_name', 'business_configurations.bus_config_id')
                ->join('business_configurations', 'business_configurations.bus_config_id', '=', 'users.bus_config_id')
                ->where('business_configurations.db_name', $newDb)
                ->where('users.role_id', 1)
                ->get();

            if ($admins->isEmpty()) {
                return back()->with('error', "No admin users found for DB: {$newDb}");
            }
            
            // ✅ Force update credentials for the cloned business
            BusinessConfiguration::where('bus_config_id', $admins->first()->bus_config_id)->update([
                'db_username' => 'root',
                'db_password' => '' // Null/Empty
            ]);

            $loginUrl = url('/login');
            try {
                // ✅ Fetch the current global mail credentials from Master DB
                $mail_setting = AdminMailSetting::latest()->first();
                if ($mail_setting) {
                    $this->setMailInfo($mail_setting);
                }

                $encryptedPassword = Crypt::encryptString('12345678');

                foreach ($admins as $admin) {
                    $mailData = [
                        'name' => $admin->name,
                        'email' => $admin->email,
                        'password' => $encryptedPassword,
                        'login_url' => $loginUrl,
                        'db_name' => $newDb
                    ];
                    Mail::to($admin->email)->send(new UserDetails((object)$mailData));
                }
            } catch (Exception $e) {
                Log::error("❌ Mail sending failed: " . $e->getMessage());
                return back()->with('error', 'Created but email failed: ' . $e->getMessage());
            }
            return back()->with('success', "Database `$newDb` cloned successfully from `$sourceDb` (schema + triggers only, no data).");
        } catch (\Exception $e) {
            DB::statement("DROP DATABASE IF EXISTS `$newDb`");
            return back()->with('error', "Cloning failed: " . $e->getMessage());
        }
    }
}
