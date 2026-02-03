@extends('admin.layouts.adminlayout')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                        <h5 class="mb-0 fw-bold">Business Management</h5>
                        <a href="{{ route('admin.businesses.general') }}" class="btn btn-primary d-flex align-items-center">
                            <i class="fa fa-plus-circle mr-2"></i> Add New Business
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-right-0">
                                        <i class="fa fa-search text-muted"></i>
                                    </span>
                                    <input type="text" id="businessSearch" class="form-control border-left-0" placeholder="Search businesses...">
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="businessTable" class="table table-hover align-middle border-top mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Business Info</th>
                                        <th>Contact Details</th>
                                        <th>Banking Info</th>
                                        <th class="text-center">Stats</th>
                                        <th class="text-center">Environment</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="businessData">
                                    @forelse ($businesses as $b)
                                        <tr>
                                            <!-- Business Info -->
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="mr-3">
                                                        @if (!empty($b->bus_logo))
                                                            @php
                                                                $disk = env('FILESYSTEM_DISK', config('filesystems.default', 'uploads'));
                                                                try {
                                                                    $url = Storage::disk($disk)->url($b->bus_logo);
                                                                } catch (\Throwable $e) {
                                                                    $url = null;
                                                                }
                                                            @endphp
                                                            <img src="{{ $url }}" alt="Logo" class="rounded border shadow-xs" style="width: 45px; height: 45px; object-fit: contain; padding: 2px;">
                                                        @else
                                                            <div class="rounded bg-light d-flex align-items-center justify-content-center border" style="width: 45px; height: 45px;">
                                                                <i class="fa fa-building text-muted"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <div class="font-weight-bold text-dark">{{ $b->bus_name }}</div>
                                                        <small class="text-muted">NTN: {{ $b->bus_ntn_cnic }}</small>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Contact Details -->
                                            <td>
                                                <div class="text-sm">
                                                    <div class="font-weight-600">{{ $b->bus_contact_person }}</div>
                                                    <div class="text-muted"><i class="fa fa-phone-alt fa-xs mr-1"></i> {{ $b->bus_contact_num }}</div>
                                                    <small class="text-muted font-italic">{{ $b->bus_province }}</small>
                                                </div>
                                            </td>

                                            <!-- Banking Info -->
                                            <td>
                                                <div class="text-sm">
                                                    <div class="text-dark">{{ $b->bus_account_title }}</div>
                                                    <div class="text-muted font-monospace small">{{ $b->bus_account_number }}</div>
                                                    <small class="text-muted">{{ $b->bus_acc_branch_name }}</small>
                                                </div>
                                            </td>

                                            <!-- Stats -->
                                            <td class="text-center">
                                                <div class="mb-1">
                                                    <span class="badge badge-pill badge-info px-2 py-1" title="Users">
                                                        <i class="fa fa-users mr-1"></i> {{ $b->users_count }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="badge badge-pill badge-secondary px-2 py-1" title="Scenarios">
                                                        <i class="fa fa-list-check mr-1"></i> {{ $b->scenarios_count }}
                                                    </span>
                                                </div>
                                            </td>

                                            <!-- Environment -->
                                            <td class="text-center">
                                                @if($b->fbr_env === 'sandbox')
                                                    <span class="badge badge-warning text-uppercase shadow-sm" style="font-size: 10px; letter-spacing: 0.5px;">Sandbox</span>
                                                @else
                                                    <span class="badge badge-success text-uppercase shadow-sm" style="font-size: 10px; letter-spacing: 0.5px;">Production</span>
                                                @endif
                                            </td>

                                            <!-- Actions -->
                                            <td class="text-right">
                                                <div class="btn-group shadow-sm border rounded overflow-hidden bg-white">
                                                    <a href="{{ route('admin.businesses.show', \Illuminate\Support\Facades\Crypt::encryptString($b->bus_config_id)) }}"
                                                       class="btn btn-sm btn-white border-0" title="View Details">
                                                        <i class="ti ti-eye text-warning"></i>
                                                    </a>
                                                    <a href="{{ route('admin.businesses.general', ['id' => encrypt($b->bus_config_id)]) }}"
                                                       class="btn btn-sm btn-white border-0" title="Edit Configuration">
                                                        <i class="ti ti-pencil text-primary"></i>
                                                    </a>
                                                    <a href="{{ route('admin.businesses.create-user', \Illuminate\Support\Facades\Crypt::encryptString($b->bus_config_id)) }}"
                                                       class="btn btn-sm btn-white border-0" title="Manage Users">
                                                        <i class="ti ti-user text-info"></i>
                                                    </a>
                                                    @if ($b->db_username == 'dummy' || $b->db_password == 'dummy')
                                                        <a href="{{ route('admin.db.clone.form') }}"
                                                           class="btn btn-sm btn-white border-0" title="Clone Database">
                                                            <i class="ti ti-database text-danger"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-muted italic">
                                                <i class="fa fa-box-open d-block fa-2x mb-2 opacity-25"></i>
                                                No businesses found in the system.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4 d-flex justify-content-center">
                            {{ $businesses->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        $(document).ready(function() 
        {
            $("#businessSearch").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#businessData tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            $('[title]').tooltip();
        });
    </script>
    @endpush
    <style>
        .font-weight-600 { font-weight: 600; }
        .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
        .font-monospace { font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace; }
        .btn-white { background: #fff; color: #4b5563; }
        .btn-white:hover { background: #f9fafb; color: #111827; }
        .table-hover tbody tr:hover { background-color: rgba(59, 130, 246, 0.02); }
        .badge-pill { border-radius: 50rem; }
        .badge-info { background-color: #e0f2fe; color: #0369a1; }
        .badge-secondary { background-color: #f3f4f6; color: #4b5563; }
        .badge-warning { background-color: #fef3c7; color: #92400e; }
        .badge-success { background-color: #dcfce7; color: #166534; }
    </style>
@endsection
