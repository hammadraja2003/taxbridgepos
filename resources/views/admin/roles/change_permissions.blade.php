@extends('admin.layouts.adminlayout')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="ti ti-shield-check me-2 text-primary"></i> Change Permissions : <span class="text-primary">{{ $role->name }}</span>
                        <span class="badge bg-light text-dark ms-3 shadow-sm border">
                            Total: <span class="fw-bold">{{ $totalPermissions }}</span>
                        </span>
                        <span class="badge bg-primary-soft text-primary ms-2 shadow-sm border">
                            Assigned: <span class="fw-bold">{{ $assignedPermissions }}</span>
                        </span>
                    </h5>
                    <a href="{{ route('admin.roles_permissions.index') }}" class="btn btn-light btn-sm">
                        <i class="ti ti-arrow-left me-1"></i> Back to Roles
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.roles_permissions.update_permissions', $role->id) }}" method="POST" id="permissionsForm">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 250px;">Module Name</th>
                                        <th class="text-center">View</th>
                                        <th class="text-center">Add</th>
                                        <th class="text-center">Edit</th>
                                        <th class="text-center">Delete</th>
                                        <th class="text-center">Import / Other</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($modules as $moduleName => $actions)
                                    <tr>
                                        <td class="fw-bold text-dark">{{ $moduleName }}</td>
                                        
                                        {{-- View --}}
                                        <td class="text-center">
                                            @if($actions['view'])
                                                <div class="form-check d-inline-block">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]" 
                                                        value="{{ $actions['view']->id }}" 
                                                        id="perm_{{ $actions['view']->id }}"
                                                        {{ in_array($actions['view']->id, $rolePermissions) ? 'checked' : '' }}>
                                                </div>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>

                                        {{-- Add --}}
                                        <td class="text-center">
                                            @if($actions['add'])
                                                <div class="form-check d-inline-block">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]" 
                                                        value="{{ $actions['add']->id }}" 
                                                        id="perm_{{ $actions['add']->id }}"
                                                        {{ in_array($actions['add']->id, $rolePermissions) ? 'checked' : '' }}>
                                                </div>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>

                                        {{-- Edit --}}
                                        <td class="text-center">
                                            @if($actions['edit'])
                                                <div class="form-check d-inline-block">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]" 
                                                        value="{{ $actions['edit']->id }}" 
                                                        id="perm_{{ $actions['edit']->id }}"
                                                        {{ in_array($actions['edit']->id, $rolePermissions) ? 'checked' : '' }}>
                                                </div>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>

                                        {{-- Delete --}}
                                        <td class="text-center">
                                            @if($actions['delete'])
                                                <div class="form-check d-inline-block">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]" 
                                                        value="{{ $actions['delete']->id }}" 
                                                        id="perm_{{ $actions['delete']->id }}"
                                                        {{ in_array($actions['delete']->id, $rolePermissions) ? 'checked' : '' }}>
                                                </div>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>

                                        {{-- Import --}}
                                        <td class="text-center">
                                            @if($actions['import'])
                                                <div class="form-check d-inline-block">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]" 
                                                        value="{{ $actions['import']->id }}" 
                                                        id="perm_{{ $actions['import']->id }}"
                                                        {{ in_array($actions['import']->id, $rolePermissions) ? 'checked' : '' }}>
                                                </div>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4 text-end">
                            <a href="{{ route('admin.roles_permissions.index') }}" class="btn btn-light me-2">Cancel</a>
                            <button type="button" id="submitBtn" class="btn btn-primary px-4">
                                <i class="ti ti-device-floppy me-1"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#submitBtn').on('click', function() {
            const btn = $(this);
            const originalText = btn.html();
            
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Saving...');

            $.ajax({
                url: $('#permissionsForm').attr('action'),
                type: 'POST',
                data: $('#permissionsForm').serialize(),
                success: function(response) {
                    if (response.success) {
                        // Use SweetAlert or Toastr if available, otherwise native alert
                        alert('Permissions updated successfully!');
                        window.location.href = "{{ route('admin.roles_permissions.index') }}";
                    } else {
                        alert(response.message || 'Error updating permissions.');
                        btn.prop('disabled', false).html(originalText);
                    }
                },
                error: function(xhr) {
                    alert('An error occurred. Please try again.');
                    console.error(xhr);
                    btn.prop('disabled', false).html(originalText);
                }
            });
        });
    });
</script>
@endpush
@endsection
