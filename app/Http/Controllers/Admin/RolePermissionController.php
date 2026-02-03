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
    public function index()
    {
        $roles = Roles::leftJoin('business_configurations', 'roles.bus_config_id', '=', 'business_configurations.bus_config_id')
            ->where('role_type', '1')
            ->select('roles.*', 'business_configurations.bus_name as business_name')
            ->get();
            
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Display a listing of the permissions.
     */
    public function permissions()
    {
        $permissions = Permission::orderBy('id', 'desc')->get();
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
            
            // Optional: Check if permission is assigned to roles
            if ($permission->roles()->count() > 0) {
                return back()->with('error', 'Cannot delete permission that is assigned to roles.');
            }

            $permission->delete();
            return redirect()->route('admin.roles_permissions.permissions')->with('success', 'Permission deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting permission: ' . $e->getMessage());
        }
    }
}
