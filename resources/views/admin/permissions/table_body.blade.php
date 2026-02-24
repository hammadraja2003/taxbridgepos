@foreach($permissions as $key => $permission)
<tr>
    <td>{{ $key + 1 }}</td>
    <td class="fw-semibold">{{ $permission->name }}</td>
    <td><span class="badge bg-light text-dark font-monospace">{{ $permission->guard_name }}</span></td>
    <td class="text-muted small">{{ $permission->created_at?->format('d M, Y') ?? 'N/A' }}</td>
    <!-- <td class="text-end">
        <div class="dropdown">
            <button class="btn btn-sm btn-icon btn-light" type="button" data-toggle="dropdown">
                <i class="ti ti-dots-vertical"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#editPermissionModal{{ $permission->id }}"><i class="ti ti-edit me-2"></i> Edit</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('admin.roles_permissions.destroy_permission', encrypt($permission->id)) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure?')">
                            <i class="ti ti-trash me-2"></i> Delete
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </td> -->
</tr>

<!-- Edit Modal -->
<div class="modal fade" id="editPermissionModal{{ $permission->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.roles_permissions.update_permission', encrypt($permission->id)) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Permission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Permission Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $permission->name }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Permission</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
