<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permissions as Permission;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolePermissionController extends Controller
{
    public function index(Request $request)
    {
        $businesses = DB::connection('master')
            ->table('business_configurations')
            ->select('bus_config_id', 'bus_name')
            ->get();
        $busConfigId = $request->input('bus_config_id');

        if ($busConfigId) {
            $roles = Roles::leftJoin('business_configurations', 'roles.bus_config_id', '=', 'business_configurations.bus_config_id')
                ->where('roles.bus_config_id', $busConfigId)
                ->select('roles.*', 'business_configurations.bus_name as business_name')
                ->get();
        } else {
            $roles = collect();
        }
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

    public function permissions(Request $request)
    {
        $query = Permission::orderBy('id', 'desc');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query
                ->where('name', 'like', "%{$search}%")
                ->orWhere('guard_name', 'like', "%{$search}%");
        }

        $permissions = $query->get();

        if ($request->ajax()) {
            return view('admin.permissions.table_body', compact('permissions'))->render();
        }

        return view('admin.permissions.index', compact('permissions'));
    }

    public function createRole()
    {
        $permissions = Permission::all();
        $businesses = DB::table('business_configurations')->select('bus_config_id', 'bus_name')->get();
        return view('admin.roles.create', compact('permissions', 'businesses'));
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191',
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

    public function changePermissions($id)
    {
        try {
            $decryptedId = decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Invalid Role ID');
        }

        $role = Roles::findOrFail($decryptedId);
        $permissions = $role->permissions;
        $all_permission = [];
        foreach ($permissions as $permission) {
            $all_permission[] = $permission->name;
        }

        if (empty($all_permission)) {
            $all_permission[] = 'dummy text';
        }

        return view('admin.roles.change_permissions', compact('role', 'all_permission'));
    }

    public function updatePermissions(Request $request, $id)
    {
        try {
            try {
                $decryptedId = decrypt($id);
            } catch (\Exception $e) {
                if (is_numeric($id)) {
                    $decryptedId = $id;
                } else {
                    throw $e;
                }
            }

            $role = Roles::findOrFail($decryptedId);

            // Logic adapted from RoleController::setPermission to handle permission names as keys
            $existing_permissions = Permission::pluck('name')->toArray();

            // Identify potential new permissions from request keys (excluding standard fields)
            $request_keys = array_keys($request->except(['_token', 'role_id']));
            $new_permissions = array_diff($request_keys, $existing_permissions);

            // Full list of permissions to process (existing in DB + new ones from request)
            $permissions_to_process = array_unique(array_merge($existing_permissions, $new_permissions));

            foreach ($permissions_to_process as $permission_name) {
                // Ensure permission exists
                $permission = Permission::firstOrCreate(['name' => $permission_name, 'guard_name' => 'web']);

                if ($request->has(str_replace('.', '_', $permission_name))) {
                    // Note: PHP converts dots in request keys to underscores.
                    // However, our permission names might have dashes.
                    // The standard behavior for Request::has with standard HTML forms
                    // usually works with the input name attribute.
                    // But if keys have dots, PHP replaces them with underscores in $request->all().
                    // We should check $request->has($permission_name) which usually abstracts this,
                    // but let's be safe. standard names like 'users-add' are fine.

                    if (!$role->hasPermissionTo($permission_name)) {
                        $role->givePermissionTo($permission);
                    }
                } else {
                    if ($role->hasPermissionTo($permission_name)) {
                        $role->revokePermissionTo($permission_name);
                    }
                }
            }

            return redirect()->route('admin.roles_permissions.index')->with('success', 'Permissions updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating permissions: ' . $e->getMessage());
        }
    }
}
