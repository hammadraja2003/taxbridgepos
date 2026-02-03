<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\BusinessConfiguration;
use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class BusinessController extends Controller
{
    public function index(Request $request)
    {
        // Fetch data from both tables using join
        $query = DB::connection('master')->table('business_configurations')
            ->leftJoin('general_settings', 'business_configurations.bus_config_id', '=', 'general_settings.bus_config_id')
            ->select(
                'business_configurations.bus_config_id',
                'business_configurations.bus_name',
                'business_configurations.bus_ntn_cnic',
                'business_configurations.bus_reg_num',
                'business_configurations.bus_address',
                'business_configurations.bus_province',
                'business_configurations.bus_contact_person',
                'business_configurations.bus_contact_num',
                'business_configurations.bus_account_title',
                'business_configurations.bus_account_number',
                'business_configurations.bus_acc_branch_name',
                'business_configurations.fbr_env',
                'business_configurations.created_at',
                'general_settings.site_title',
                'general_settings.currency',
                'general_settings.timezone',
                'general_settings.theme',
                'general_settings.is_rtl',
                'general_settings.is_zatca',
                'business_configurations.db_username',
                'business_configurations.db_password'
            )
            ->addSelect([
                'users_count' => DB::connection('master')->table('users')
                    ->whereColumn('users.bus_config_id', 'business_configurations.bus_config_id')
                    ->selectRaw('count(*)'),
                'scenarios_count' => DB::connection('master')->table('business_scenarios')
                    ->whereColumn('business_scenarios.bus_config_id', 'business_configurations.bus_config_id')
                    ->selectRaw('count(*)')
            ]);

        // Apply Filters
        if ($request->filled('bus_name')) {
            $query->where('business_configurations.bus_name', 'like', '%' . $request->bus_name . '%');
        }

        if ($request->filled('bus_ntn_cnic')) {
            $query->where('business_configurations.bus_ntn_cnic', 'like', '%' . $request->bus_ntn_cnic . '%');
        }

        if ($request->filled('bus_contact_num')) {
            $query->where('business_configurations.bus_contact_num', 'like', '%' . $request->bus_contact_num . '%');
        }

        if ($request->filled('bus_province')) {
            $query->where('business_configurations.bus_province', $request->bus_province);
        }

        if ($request->filled('fbr_env')) {
            $query->where('business_configurations.fbr_env', $request->fbr_env);
        }

        $businesses = $query->orderBy('business_configurations.created_at', 'desc')->paginate(10);

        return view('admin.businesses.index', compact('businesses'));
    }
     public function showRegisterForm(Request $request)
    {
        $id = $request->query('id') ?? $request->input('id');
        try {
            $decryptedId = decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Invalid Business ID');
        }

        $business = BusinessConfiguration::where('bus_config_id', $decryptedId)->firstOrFail();
        return view('admin.businesses.register_user', compact('business', 'id'));
    }

    /**
     * Register a new user for the business.
     */
    public function registerBusinessUser(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
            'phone' => 'nullable|string|max:20',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $decryptedId = decrypt($request->id);
                $business = BusinessConfiguration::where('bus_config_id', $decryptedId)->firstOrFail();
                
                User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'phone' => $request->phone ?? $business->bus_contact_num ?? 'N/A',
                    'bus_config_id' => $decryptedId,
                    'role_id' => 1, // Default Admin
                    'is_active' => 1,
                    'is_deleted' => 0,
                ]);
            });

            return redirect()->route('admin.businesses.index')->with('success', 'User registered successfully for ' . $request->name);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error registering user: ' . $e->getMessage());
        }
    }
     public function general(Request $request)
    {
        $busConfigId = $request->query('bus_config_id') ?? $request->query('id');

        if ($busConfigId) {
            try {
                $busConfigId = decrypt($busConfigId);
            } catch (\Exception $e) {
                // If decryption fails, assume it's a plain ID (optional, depends on strictness)
            }
            $business_config = BusinessConfiguration::where('bus_config_id', $busConfigId)->first();
            $general_setting = GeneralSetting::where('bus_config_id', $busConfigId)->first();
            $admin_user = User::where('bus_config_id', $busConfigId)->first();
            
            // Fetch selected scenarios if editing
            $selectedScenarioIds = DB::connection('master')->table('business_scenarios')
                ->where('bus_config_id', $busConfigId)
                ->pluck('scenario_id')
                ->toArray();
        } else {
            $business_config = null;
            $general_setting = null;
            $admin_user = null;
            $selectedScenarioIds = [];
        }
        
        $scenarios = DB::connection('master')->table('sandbox_scenarios')->get();
        
        // Hardcoded currency list for admin context as currencies are tenant-specific
        $lims_currency_list = [
            (object)['id' => 1, 'name' => 'US Dollar', 'code' => 'USD'],
            (object)['id' => 2, 'name' => 'Pakistani Rupee', 'code' => 'PKR'],
        ];
        
        $zones_array = array();
        $timestamp = time();
        foreach (timezone_identifiers_list() as $key => $zone) {
            $zones_array[$key]['zone'] = $zone;
            $zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
        }

        return view('admin.businesses.general', compact(
            'general_setting', 
            'business_config', 
            'admin_user', 
            'scenarios', 
            'selectedScenarioIds',
            'lims_currency_list',
            'zones_array'
        ));
    }

    public function storeGeneral(Request $request)
    {
        $id = $request->input('bus_config_id');
        
        $request->validate([
            'bus_name' => 'required|string|max:255',
            'bus_ntn_cnic' => 'required|string|max:50',
            'site_title' => 'required|string|max:255',
            'currency' => 'required',
            'timezone' => 'required',
            'user_email' => $id ? 'nullable|email' : 'required|email|unique:users,email',
            'user_password' => $id ? 'nullable|min:6|confirmed' : 'required|min:6|confirmed',
            'sandbox_api_key' => 'required_if:fbr_env,sandbox|nullable|string',
            'production_api_key' => 'required_if:fbr_env,production|nullable|string',
            'date_format' => 'required',
            'site_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'favicon' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
        ]);

        try {
            DB::beginTransaction();

            // 1. Business Configuration
            $business = $id ? BusinessConfiguration::findOrFail($id) : new BusinessConfiguration();
            $business->bus_name = $request->bus_name;
            $business->bus_ntn_cnic = $request->bus_ntn_cnic;
            $business->bus_reg_num = $request->bus_reg_num;
            $business->bus_address = $request->bus_address;
            $business->bus_province = $request->bus_province;
            $business->bus_contact_person = $request->bus_contact_person;
            $business->bus_contact_num = $request->bus_contact_num;
            $business->bus_account_title = $request->bus_account_title;
            $business->bus_account_number = $request->bus_account_number;
            $business->bus_acc_branch_name = $request->bus_acc_branch_name;
            $business->bus_acc_branch_code = $request->bus_acc_branch_code;
            $business->bus_IBAN = $request->bus_IBAN ?? '';
            $business->bus_swift_code = $request->bus_swift_code ?? '';
            $business->fbr_env = $request->fbr_env ?? 'sandbox';
            $business->sandbox_api_key = $request->sandbox_api_key;
            $business->production_api_key = $request->production_api_key;
            
            if (!$id) {
                // Default DB settings for new business
                $business->db_host = 'localhost';
                // Auto-generate DB name from business name
                $business->db_name = \Illuminate\Support\Str::slug($request->bus_name, '_') . '_pos'; 
                $business->db_username = 'dummy';
                $business->db_password = 'dummy'; // Null/Empty
            }
            
            $business->save();
            $bus_id = $business->bus_config_id;

            // 2. General Settings
            $setting = GeneralSetting::where('bus_config_id', $bus_id)->first() ?? new GeneralSetting();
            $setting->bus_config_id = $bus_id;
            $setting->site_title = $request->site_title;
            $setting->currency = $request->currency;
            $setting->timezone = $request->timezone;
            $setting->is_rtl = $request->has('is_rtl');
            $setting->company_name = $request->bus_name;
            $setting->developed_by = 'TaxBridge';
            
            // Map inputs to DB fields
            $setting->date_format = $request->date_format ?? 'd-m-Y';
            $setting->invoice_format = $request->invoice_format ?? 'standard';
            $setting->currency_position = $request->currency_position ?? 'suffix';
            $setting->decimal = $request->decimal ?? 2;
            $setting->staff_access = $request->staff_access ?? 'all';
            $setting->without_stock = $request->without_stock ?? 'no';
            $setting->is_packing_slip = $request->has('is_packing_slip') ? 1 : 0;
            $setting->theme = 'default.css';
            $setting->modules = 'manufacturing';
            $setting->show_products_details_in_sales_table = $request->has('show_products_details_in_sales_table') ? 1 : 0;
            $setting->show_products_details_in_purchase_table = $request->has('show_products_details_in_purchase_table') ? 1 : 0;

            // Handle File Uploads
            if ($request->hasFile('site_logo')) {
                $image = $request->file('site_logo');
                $imageName = 'logo_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/logo'), $imageName);
                $setting->site_logo = $imageName;
            }

            if ($request->hasFile('favicon')) {
                $icon = $request->file('favicon');
                $iconName = 'favicon_' . time() . '.' . $icon->getClientOriginalExtension();
                $icon->move(public_path('images/logo'), $iconName);
                $setting->favicon = $iconName;
            }
            
            $setting->save();

            // 3. Admin User (if new or password provided)
            if (!$id || $request->filled('user_email') || $request->filled('user_password')) {
                $user = User::where('bus_config_id', $bus_id)->where('role_id', 1)->first() ?? new User();
                $user->bus_config_id = $bus_id;
                $user->role_id = 1; // Admin
                if ($request->filled('user_name')) $user->name = $request->user_name;
                if ($request->filled('user_email')) $user->email = $request->user_email;
                if ($request->filled('user_password')) $user->password = Hash::make($request->user_password);
                $user->phone = $request->bus_contact_num ?? 'N/A';
                $user->is_active = true;
                $user->is_deleted = 0;
                $user->save();
            }

            // 4. Scenarios
            if ($request->has('scenarios')) {
                $business->scenarios()->sync($request->scenarios);
            }

            DB::commit();
            return redirect()->route('admin.businesses.index')->with('success', 'Business configuration saved successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    // public function index_bk()
    // {
    //     $businesses = AdminBusiness::withCount(['users', 'scenarios'])
    //         ->orderBy('bus_name')
    //         ->paginate(15);
    //     return view('admin.businesses.index', compact('businesses'));
    // }
    public function show($encryptedId)
    {
        try {
            $id = Crypt::decryptString($encryptedId);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
             return back()
                ->withInput()
                ->withErrors(['toast_error' =>  'Invalid ID']);
        }
        $business = BusinessConfiguration::with(['users.role', 'scenarios'])->findOrFail($id);
        $general_setting = GeneralSetting::where('bus_config_id', $id)->first();
        return view('admin.businesses.show', compact('business', 'general_setting'));
    }
    public function createUser($encryptedId)
    {
        try {
            $id = Crypt::decryptString($encryptedId);            
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
             return back()
                ->withInput()
                ->withErrors(['toast_error' =>  $e->getMessage()]);
        }
        return view('admin.businesses.createbusinessuser', compact('id'));
    }
    public function registerUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => 'required|string|min:6',
        ]);

        try {
            DB::beginTransaction();

            $busConfigId = $request->id;
            $business = BusinessConfiguration::where('bus_config_id', $busConfigId)->first();

            // Create user
            $user = User::create([
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'bus_config_id' => $busConfigId,
                'email' => $request->email ?? null,
                'phone' => $business->bus_contact_num ?? 'N/A',
                'role_id' => 1, // Default to admin for now, or fetch from request if needed
                'is_active' => true,
                'is_deleted' => 0,
            ]);

            DB::commit();
            return redirect()->route('admin.businesses.index')
                ->with('message', 'User added successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->withErrors(['toast_error' => $e->getMessage()]);
        }
    }
}
