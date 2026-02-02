<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserDetails;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use App\Models\BusinessConfiguration;
use App\Models\AdminMailSetting;
use App\Traits\MailInfo;
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
            // ✅ Get business details
            $business = BusinessConfiguration::where('db_name', $newDb)->first();
            if (!$business) {
                return back()->with('error', "Business configuration not found for DB: {$newDb}");
            }
            
            // ✅ Force update credentials for the cloned business
            $business->update([
                'db_username' => 'root',
                'db_password' => '' // Null/Empty
            ]);

            // ✅ Get all users related to this business
            $users = User::where('bus_config_id', $business->bus_config_id)->get();

            $loginUrl = url('/login');
            try {
                // ✅ Fetch the current global mail credentials from Master DB
                $mail_setting = AdminMailSetting::latest()->first();
                if ($mail_setting) {
                    $this->setMailInfo($mail_setting);
                }

                foreach ($users as $recipient) {
                    $mailData = [
                        'name' => $recipient->name,
                        'email' => $recipient->email,
                        'password' => Crypt::encryptString('12345678'), 
                        'login_url' => $loginUrl,
                        'db_name' => $newDb
                    ];
                    Mail::to($recipient->email)->send(new UserDetails((object)$mailData));
                }
            } catch (Exception $e) {
                Log::error("❌ Mail sending failed: " . $e->getMessage());
                return back()->with('error', 'Created but email failed');
            }
            return back()->with('success', "Database `$newDb` cloned successfully from `$sourceDb` (schema + triggers only, no data).");
        } catch (\Exception $e) {
            DB::statement("DROP DATABASE IF EXISTS `$newDb`");
            return back()->with('error', "Cloning failed: " . $e->getMessage());
        }
    }
}
