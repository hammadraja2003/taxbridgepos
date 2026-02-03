@extends('admin.layouts.adminlayout')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 fw-bold">Role Management</h5>
                    <a href="{{ route('admin.roles_permissions.permissions') }}" class="btn btn-primary btn-sm">
                        <i class="ti ti-shield-check me-1"></i> Permissions
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th>#</th>
                                    <th>Role Name</th>
                                    <th>Business</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $key => $role)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td class="fw-semibold">{{ $role->name }}</td>
                                    <td>{{ $role->business_name ?? 'N/A' }}</td>
                                    <td class="text-muted small">{{ $role->description }}</td>
                                    <td>
                                        @if($role->is_active)
                                            <span class="badge bg-success-soft text-success">Active</span>
                                        @else
                                            <span class="badge bg-danger-soft text-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-icon btn-light" type="button" data-toggle="dropdown">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                                <li><a class="dropdown-item" href="#"><i class="ti ti-edit me-2"></i> Edit</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#"><i class="ti ti-trash me-2"></i> Delete</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
