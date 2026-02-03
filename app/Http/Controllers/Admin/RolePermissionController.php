<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use App\Models\Permissions as Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of the roles.
     */
    public function index(Request $request)
    {
        // Get all businesses for the filter dropdown
        $businesses = DB::table('business_configurations')
            ->select('bus_config_id', 'bus_name')
            ->get();

        // Check if business filter is applied
        $busConfigId = $request->input('bus_config_id');
        
        if ($busConfigId) {
            $roles = Roles::leftJoin('business_configurations', 'roles.bus_config_id', '=', 'business_configurations.bus_config_id')
                ->where('roles.bus_config_id', $busConfigId)
                ->select('roles.*', 'business_configurations.bus_name as business_name')
                ->get();
        } else {
            // Return empty collection if no business is selected
            $roles = collect();
        }

        // Return JSON for AJAX requests
        if ($request->ajax()) {
            $roles->transform(function ($role) {
                $role->encrypted_id = encrypt($role->id);
                $role->role_type_name = ucfirst(getRoleType($role->role_type) ?? 'Unknown');
                return $role;
            });
            
            return response()->json([
                'success' => true,
                'roles' => $roles,
            ]);
        }
            
        return view('admin.roles.index', compact('roles', 'businesses'));
    }

    /**
     * Display a listing of the permissions.
     */
    public function permissions(Request $request)
    {
        $query = Permission::orderBy('id', 'desc');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('guard_name', 'like', "%{$search}%");
        }

        $permissions = $query->get();

        if ($request->ajax()) {
            return view('admin.permissions.table_body', compact('permissions'))->render();
        }

        return view('admin.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function createRole()
    {
        $permissions = Permission::all();
        $businesses = DB::table('business_configurations')->select('bus_config_id', 'bus_name')->get();
        return view('admin.roles.create', compact('permissions', 'businesses'));
    }

    /**
     * Store a newly created role in storage.
     */
    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191|unique:roles,name',
            'role_type' => 'required|in:1,2,3,4',
            'bus_config_id' => 'required|integer',
            'permissions' => 'nullable|array',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $role = Roles::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'role_type' => $request->role_type,
                    'bus_config_id' => $request->bus_config_id,
                    'guard_name' => 'web',
                    'is_active' => $request->has('is_active') ? 1 : 0,
                ]);

                if ($request->has('permissions')) {
                    $role->permissions()->sync($request->permissions);
                }
            });

            return redirect()->route('admin.roles_permissions.index')->with('success', 'Role created successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error creating role: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Store a newly created permission in storage.
     */
    public function storePermission(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191|unique:permissions,name',
        ]);

        try {
            Permission::create([
                'name' => $request->name,
                'guard_name' => 'web',
            ]);

            return redirect()->route('admin.roles_permissions.permissions')->with('success', 'Permission created successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error creating permission: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Update the specified permission in storage.
     */
    public function updatePermission(Request $request, $id)
    {
        try {
            $decryptedId = decrypt($id);
        } catch (\Exception $e) {
            return back()->with('error', 'Invalid Permission ID');
        }

        $request->validate([
            'name' => 'required|string|max:191|unique:permissions,name,' . $decryptedId,
        ]);

        try {
            $permission = Permission::findOrFail($decryptedId);
            $permission->update([
                'name' => $request->name,
            ]);

            return redirect()->route('admin.roles_permissions.permissions')->with('success', 'Permission updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating permission: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified permission from storage.
     */
    public function destroyPermission($id)
    {
        try {
            $decryptedId = decrypt($id);
            $permission = Permission::findOrFail($decryptedId);
            
            // Explicitly check role_has_permissions table as requested
            $assignedCount = DB::table('role_has_permissions')
                ->where('permission_id', $decryptedId)
                ->count();
                
            if ($assignedCount > 0) {
                return back()->with('error', "Cannot delete permission! It is currently assigned to {$assignedCount} role(s).");
            }

            $permission->delete();
            return redirect()->route('admin.roles_permissions.permissions')->with('success', 'Permission deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting permission: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for changing role permissions.
     */
    /**
     * Show the form for changing role permissions.
     */
    public function changePermissions($id)
    {
        try {
            $decryptedId = decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Invalid Role ID');
        }

        $role = Roles::findOrFail($decryptedId);
        
        // Get all permissions
        $permissions = Permission::orderBy('name')->get();
        
        // Get current role permissions from role_has_permissions table explicitly using master connection
        $rolePermissions = DB::connection('master')->table('role_has_permissions')
            ->where('role_id', $decryptedId)
            ->pluck('permission_id')
            ->toArray();
        
        // Group permissions by module (Server-side logic port of the JS logic)
        $modules = [];
        $actionMap = [
            'view' => ['view', 'index', 'show', 'list', 'read'],
            'add' => ['add', 'create', 'store', 'write'],
            'edit' => ['edit', 'update'],
            'delete' => ['delete', 'destroy', 'remove'],
            'import' => ['import', 'upload']
        ];

        foreach ($permissions as $permission) {
            $lowerName = strtolower($permission->name);
            $moduleName = 'Other';
            $actionType = null;
            
            // Try to find action in name
            foreach ($actionMap as $type => $keywords) {
                foreach ($keywords as $keyword) {
                    // Regex to match keyword as a whole word or separated by . - _
                    // In PHP, we can check basic string operations or regex
                    // $regex = "/(^|[._\\-\\s])$keyword([._\\-\\s]|$)/i";
                     
                    // Simplified logic similar to JS robust check
                    $separators = ['.', '-', '_', ' '];
                    $found = false;
                    
                    // Check EndsWith
                    foreach ($separators as $sep) {
                        if (str_ends_with($lowerName, $sep . $keyword)) {
                            $moduleName = substr($permission->name, 0, -strlen($keyword) - 1);
                            $actionType = $type;
                            $found = true;
                            break;
                        }
                    }
                    if ($found) break;

                    // Check StartsWith
                    foreach ($separators as $sep) {
                         if (str_starts_with($lowerName, $keyword . $sep)) {
                            $moduleName = substr($permission->name, strlen($keyword) + 1);
                            $actionType = $type;
                            $found = true;
                            break;
                        }
                    }
                    if ($found) break;
                }
                if ($actionType) break;
            }

            // Fallback
            if (!$actionType) {
                $moduleName = $permission->name;
                $actionType = 'view';
            }

            // Standardize module name formatting
            // Replace separators with spaces and Title Case
            $moduleName = ucwords(str_replace(['-', '_', '.'], ' ', $moduleName));

            if (!isset($modules[$moduleName])) {
                $modules[$moduleName] = ['view' => null, 'add' => null, 'edit' => null, 'delete' => null, 'import' => null];
            }
            
            // Prioritize specific module mapping
            if ($modules[$moduleName][$actionType] === null) {
                $modules[$moduleName][$actionType] = $permission;
            }
        }
        
        // Sort modules by name
        ksort($modules);
        
        $totalPermissions = $permissions->count();
        $assignedPermissions = count($rolePermissions);

        return view('admin.roles.change_permissions', compact('role', 'modules', 'rolePermissions', 'totalPermissions', 'assignedPermissions'));
    }

    /**
     * Update role permissions.
     */
    public function updatePermissions(Request $request, $id)
    {
        try {
            //$decryptedId = decrypt($id);
            $role = Roles::findOrFail($id);
            
            $request->validate([
                'permissions' => 'nullable|array',
                'permissions.*' => 'exists:permissions,id',
            ]);
            
            // Sync permissions
            $role->permissions()->sync($request->input('permissions', []));
            
            return response()->json([
                'success' => true,
                'message' => 'Permissions updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating permissions: ' . $e->getMessage()
            ], 500);
        }
    }
}
