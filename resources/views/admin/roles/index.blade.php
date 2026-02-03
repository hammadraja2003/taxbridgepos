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
                    <!-- Business Filter Section -->
                    <div class="mb-4">
                        <div class="card border-0 shadow-sm bg-light">
                            <div class="card-body py-3">
                                <div class="row align-items-center">
                                    <div class="col-md-3">
                                        <div class="d-flex align-items-center">
                                            {{-- <div class="me-3">
                                                <i class="ti ti-building-store text-primary" style="font-size: 24px;"></i>
                                            </div> --}}
                                            <div class="flex-grow-1">
                                                <label for="business_filter" class="form-label font-weight-bold text-muted small text-uppercase mb-1">
                                                    Filter by Business
                                                </label>
                                                <select id="business_filter" class="form-control shadow-xs">
                                                    <option value="">All Businesses</option>
                                                    @foreach($businesses as $business)
                                                        <option value="{{ $business->bus_config_id }}">{{ $business->bus_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-end mt-3">
                                        <button type="button" id="apply_filter" class="btn btn-primary shadow-sm px-4">
                                            <i class="ti ti-search me-2"></i>Apply Filter
                                        </button>
                                        <button type="button" id="clear_filter" class="btn btn-outline-secondary shadow-sm px-3 ms-2" style="display: none;">
                                            <i class="ti ti-x"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Empty State Message -->
                    <div id="empty_state" class="text-center py-5">
                        <i class="ti ti-filter" style="font-size: 48px; color: #ccc;"></i>
                        <p class="text-muted mt-3">Please select a business from the filter above to view roles.</p>
                    </div>

                    <!-- Roles Table -->
                    <div id="roles_table_container" style="display: none;">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Role Name</th>
                                        <th>Role Type</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="roles_tbody">
                                    <!-- Roles will be loaded here via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<script>
$(document).ready(function() {
    // Apply Filter Button Click
    $('#apply_filter').on('click', function() {
        const busConfigId = $('#business_filter').val();
        
        if (!busConfigId) {
            alert('Please select a business first.');
            return;
        }

        loadRoles(busConfigId);
    });

    // Clear Filter Button Click
    $('#clear_filter').on('click', function() {
        $('#business_filter').val('');
        $('#clear_filter').hide();
        $('#empty_state').html('<i class="ti ti-filter" style="font-size: 48px; color: #ccc;"></i><p class="text-muted mt-3">Please select a business from the filter above to view roles.</p>').show();
        $('#roles_table_container').hide();
    });

    // Load Roles via AJAX
    function loadRoles(busConfigId) {
        $.ajax({
            url: '{{ route("admin.roles_permissions.index") }}',
            type: 'GET',
            data: { bus_config_id: busConfigId },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    displayRoles(response.roles);
                    $('#clear_filter').show(); // Show clear button after successful load
                }
            },
            error: function(xhr) {
                alert('Error loading roles. Please try again.');
                console.error(xhr);
            }
        });
    }

    // Display Roles in Table
    function displayRoles(roles) {
        const tbody = $('#roles_tbody');
        tbody.empty();

        if (roles.length === 0) {
            $('#empty_state').html('<i class="ti ti-info-circle" style="font-size: 48px; color: #ccc;"></i><p class="text-muted mt-3">No roles found for the selected business.</p>').show();
            $('#roles_table_container').hide();
            return;
        }

        $('#empty_state').hide();
        $('#roles_table_container').show();

        roles.forEach(function(role, index) {
            const statusBadge = role.is_active 
                ? '<span class="badge bg-success-soft text-success">Active</span>'
                : '<span class="badge bg-danger-soft text-danger">Inactive</span>';

            const encryptedId = btoa(role.id); // Simple base64 encoding for demo
            
            const row = `
                <tr>
                    <td>${index + 1}</td>
                    <td class="fw-semibold">${role.name}</td>
                    <td>${role.role_type_name || 'N/A'}</td>
                    <td class="text-muted small">${role.description || ''}</td>
                    <td>${statusBadge}</td>
                    <td class="text-end">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-icon btn-light" type="button" data-toggle="dropdown">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                              
                                <li><a class="dropdown-item" href="${ "{{ route('admin.roles_permissions.change_permissions', 'ROLE_ID') }}".replace('ROLE_ID', role.encrypted_id) }"><i class="ti ti-shield-check me-2"></i> Change Permission</a></li>
                             
                            </ul>
                        </div>
                    </td>
                </tr>
            `;
            tbody.append(row);
        });
    }

});
</script>

<style>
    .bg-light {
        background-color: #f8f9fa !important;
    }
    
    .form-select:focus,
    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    
    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: white;
    }
    
    #business_filter {
        background-color: white;
    }
    
    .card.bg-light {
        border-radius: 8px;
    }
    
    .ti-building-store {
        opacity: 0.9;
    }
    
    .shadow-xs {
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    
    .font-weight-bold {
        font-weight: 600;
    }
    
    .text-uppercase {
        text-transform: uppercase;
    }
    
    .modal-header.bg-primary .close {
        color: white;
        opacity: 1;
        text-shadow: none;
    }
    
    .modal-header.bg-primary .close:hover {
        color: white;
        opacity: 0.8;
    }
</style>
@endpush
@endsection
