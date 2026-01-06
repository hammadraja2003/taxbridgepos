<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roles;
use Auth;
use Illuminate\Validation\Rule;
use App\Models\Roles as Role;
use App\Models\Permissions as Permission;

class RoleController extends Controller
{
    public function index()
    {
        if(Auth::user()->role_id <= 2) {
            $bus_config_id = session('bus_config_id');
            $lims_role_all = Roles::where('is_active', true)->where('bus_config_id', $bus_config_id)->get();
            return view('backend.role.create', compact('lims_role_all'));
        }
        else
            return redirect()->back()->with('not_permitted', __('db.Sorry! You are not allowed to access this module'));
    }

    public function store(Request $request)
    {
        $connection = getConnectionName(\App\Models\Roles::class);
        $this->validate($request, [
            'name' => [
                'max:255',
                Rule::unique($connection.'.roles')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
        ]);

        $data = $request->all();
        $bus_config_id = session('bus_config_id');
        $data['bus_config_id'] = $bus_config_id;
        Roles::create($data);
        return redirect('role')->with('message', __('db.Data inserted successfully'));
    }

    public function edit($id)
    {
        if(Auth::user()->role_id <= 2) {
            $lims_role_data = Roles::find($id);
            return $lims_role_data;
        }
        else
            return redirect()->back()->with('not_permitted', __('db.Sorry! You are not allowed to access this module'));
    }

    public function update(Request $request, $id)
    {
        $connection = getConnectionName(\App\Models\Roles::class);
        $this->validate($request, [
            'name' => [
                'max:255',
                Rule::unique($connection.'.roles')->ignore($request->role_id)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
        ]);

        $input = $request->all();
        $bus_config_id = session('bus_config_id');
        $input['bus_config_id'] = $bus_config_id;
        $lims_role_data = Roles::where('id', $input['role_id'])->first();
        $lims_role_data->update($input);
        return redirect('role')->with('message', __('db.Data updated successfully'));
    }

    public function permission($id)
    {
        if(Auth::user()->role_id <= 2) {
            $lims_role_data = Roles::find($id);
            $permissions = Role::findByName($lims_role_data->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';
            return view('backend.role.permission', compact('lims_role_data', 'all_permission'));
        }
        else
            return redirect()->back()->with('not_permitted', __('db.Sorry! You are not allowed to access this module'));
    }

    public function setPermission(Request $request)
    {
        if(!env('USER_VERIFIED'))
            return redirect()->back()->with('not_permitted', __('db.This feature is disable for demo!'));
        
        $lims_permissions = Permission::pluck('name')->toArray();
        
        $lims_new_request_permissions = array_diff(
            array_keys($request->except('_token', 'role_id')),
            $lims_permissions
        );
        
        $lims_permissions = array_merge($lims_permissions, $lims_new_request_permissions);
        $lims_permissions = array_unique($lims_permissions);

        $role = Role::firstOrCreate(['id' => $request['role_id']]);

        foreach ($lims_permissions as $permission_name) {
            $permission = Permission::firstOrCreate(['name' => $permission_name]);
            
            if($request->has($permission_name)) {
                if(!$role->hasPermissionTo($permission_name)) {
                    $role->givePermissionTo($permission);
                }
            }
            else {
                if($permission) $role->revokePermissionTo($permission_name);
            }
        }

        $key_prefix = 'tenant_' . session('bus_config_id') . '_';
        cache()->forget($key_prefix . 'permissions');

        return redirect('role')->with('message', __('db.Permission updated successfully'));
    }

    public function destroy($id)
    {
        if(!env('USER_VERIFIED'))
            return redirect()->back()->with('not_permitted', __('db.This feature is disable for demo!'));
        $lims_role_data = Roles::find($id);
        $lims_role_data->is_active = false;
        $lims_role_data->save();
        return redirect('role')->with('not_permitted', __('db.Data deleted successfully'));
    }
}
