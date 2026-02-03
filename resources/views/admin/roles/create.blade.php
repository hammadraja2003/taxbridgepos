@extends('admin.layouts.adminlayout')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Create New Role</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.roles_permissions.store_role') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Role Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="e.g. Manager" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Role Type <span class="text-danger">*</span></label>
                                <select name="role_type" class="form-control" required>
                                    <option value="1">Admin</option>
                                    <option value="2">Standard</option>
                                    <option value="3">Support</option>
                                    <option value="4">Restricted</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Associated Business <span class="text-danger">*</span></label>
                            <select name="bus_config_id" class="form-control selectpicker" data-live-search="true" title="Select Business" required>
                                @foreach($businesses as $business)
                                    <option value="{{ $business->bus_config_id }}">{{ $business->bus_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Briefly describe this role's responsibilities..."></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold d-block">Permissions</label>
                            <div class="row g-3">
                                @foreach($permissions as $permission)
                                <div class="col-md-4">
                                    <div class="form-check custom-checkbox">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="form-check-input" id="perm_{{ $permission->id }}">
                                        <label class="form-check-label" for="perm_{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="isActive" checked>
                                <label class="form-check-label fw-semibold" for="isActive">Set as Active</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.roles_permissions.index') }}" class="btn btn-light px-4">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4">Save Role</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
