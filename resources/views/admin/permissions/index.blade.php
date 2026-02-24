@extends('admin.layouts.adminlayout')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 fw-bold">Permission Management</h5>
                    <div class="d-flex">
                        <div class="input-group me-2">
                            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search permissions..." value="{{ request('search') }}">
                            <span class="input-group-text bg-white">
                                <i class="ti ti-search"></i>
                            </span>
                        </div>
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addPermissionModal">
                            <i class="ti ti-plus"></i> Add Permission
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th>#</th>
                                    <th>Permission Name</th>
                                    <th>Guard</th>
                                    <th>Created At</th>
                                    <!-- <th class="text-end">Actions</th> -->
                                </tr>
                            </thead>
                            <tbody id="permissions_table_body">
                                @include('admin.permissions.table_body')
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addPermissionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.roles_permissions.store_permission') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New Permission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Permission Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. manage-users" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Permission</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        let timeout = null;
        
        // Listen for input on the search field
        $('input[name="search"]').on('keyup', function() {
            clearTimeout(timeout);
            const query = $(this).val();

            timeout = setTimeout(function() {
                fetchPermissions(query);
            }, 300); // Debounce for 300ms
        });

        // Handle clear search button click
        $(document).on('click', '#clear_search', function(e) {
            e.preventDefault();
            $('input[name="search"]').val('');
            $(this).hide();
            fetchPermissions('');
        });

        function fetchPermissions(query) {
            // Show loading state if needed
            // $('#permissions_table_body').html('<tr><td colspan="5" class="text-center py-4">Loading...</td></tr>');

            $.ajax({
                url: "{{ route('admin.roles_permissions.permissions') }}",
                type: "GET",
                data: { search: query },
                success: function(response) {
                    $('#permissions_table_body').html(response);
                    
                    // Toggle clear button visibility
                    if (query.length > 0) {
                        if ($('#clear_search').length === 0) {
                             // Assuming you might want to dynamically add the clear button if it was removed, 
                             // but for now relying on the input clearing or server side logic isn't enough for just the button.
                             // Since the button in the header was PHP generated, we might need to handle it in JS or just always show it when typing.
                             // For simplicity given existing structure:
                             $('.input-group').find('.btn-outline-danger').remove(); // Remove existing to avoid duplicates if re-adding
                             if (query) {
                                 $('.input-group').append('<button type="button" id="clear_search" class="btn btn-outline-danger btn-sm" title="Clear Search"><i class="ti ti-x"></i></button>');
                             }
                        } else {
                            if (query) $('#clear_search').show();
                            else $('#clear_search').hide();
                        }
                    } else {
                         $('#clear_search').remove();
                    }
                },
                error: function(xhr) {
                    console.error('Error fetching permissions:', xhr);
                    $('#permissions_table_body').html('<tr><td colspan="5" class="text-center text-danger py-4">Error loading permissions. Please try again.</td></tr>');
                }
            });
        }
    });
</script>
@endpush
@endsection
