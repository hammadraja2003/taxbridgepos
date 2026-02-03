@extends('admin.layouts.adminlayout')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header Card -->
            <div class="card shadow-sm border-0 mb-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="bg-white px-4 py-4 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="mr-4">
                                @if (!empty($business->bus_logo))
                                    @php
                                        $disk = env('FILESYSTEM_DISK', config('filesystems.default', 'uploads'));
                                        try {
                                            $url = Storage::disk($disk)->url($business->bus_logo);
                                        } catch (\Throwable $e) {
                                            $url = null;
                                        }
                                    @endphp
                                    <div class="bg-light p-1 rounded-circle border shadow-xs" style="width: 43px; height: 40px;">
                                        <img src="{{ $url }}" alt="Logo" class="rounded-circle" style="width: 100%; height: 100%; object-fit: contain;">
                                    </div>
                                @else
                                    <div class="bg-light p-1 rounded-circle border shadow-xs d-flex align-items-center justify-content-center" style="width: 43px; height: 40px;">
                                        <i class="ti ti-building fa-2x text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h4 class="font-weight-bold mb-1 text-dark">{{ $business->bus_name }}</h4>
                                <div class="text-muted small">
                                    <span class="mr-3"><i class="ti ti-tag mr-1"></i> NTN: {{ $business->bus_ntn_cnic }}</span>
                                    <span><i class="ti ti-map-pin mr-1"></i> {{ $business->bus_province }}</span>
                                </div>
                            </div>
                            <div class="ml-auto text-right">
                                <a href="{{ route('admin.businesses.index') }}" class="btn btn-outline-secondary btn-xs rounded-pill px-3 mr-1">
                                    <i class="ti ti-arrow-left mr-1"></i> Back
                                </a>
                                <a href="{{ route('admin.businesses.general', ['id' => encrypt($business->bus_config_id)]) }}" class="btn btn-primary btn-xs rounded-pill px-3 shadow-xs">
                                    <i class="ti ti-pencil mr-1"></i> Edit
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Left Column: Details -->
                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white border-0 py-3">
                            <h6 class="m-0 font-weight-bold text-dark"><i class="ti ti-info-circle mr-1 text-primary"></i> Basic Information</h6>
                        </div>
                        <div class="card-body pt-0">
                            <div class="mb-3">
                                <label class="text-xs text-uppercase font-weight-bold text-muted mb-1 d-block">Contact Person</label>
                                <div class="text-dark font-weight-600">{{ $business->bus_contact_person }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="text-xs text-uppercase font-weight-bold text-muted mb-1 d-block">Phone Number</label>
                                <div class="text-dark">{{ $business->bus_contact_num }}</div>
                            </div>
                            <div class="mb-0">
                                <label class="text-xs text-uppercase font-weight-bold text-muted mb-1 d-block">Full Address</label>
                                <div class="text-dark small">{{ $business->bus_address }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white border-0 py-3">
                            <h6 class="m-0 font-weight-bold text-dark"><i class="ti ti-building-bank mr-1 text-success"></i> Banking Information</h6>
                        </div>
                        <div class="card-body pt-0">
                            <div class="mb-3">
                                <label class="text-xs text-uppercase font-weight-bold text-muted mb-1 d-block">Account Title</label>
                                <div class="text-dark font-weight-600">{{ $business->bus_account_title }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="text-xs text-uppercase font-weight-bold text-muted mb-1 d-block">Account Number</label>
                                <div class="text-dark font-monospace small">{{ $business->bus_account_number }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="text-xs text-uppercase font-weight-bold text-muted mb-1 d-block">IBAN</label>
                                <div class="text-dark font-monospace small">{{ $business->bus_IBAN ?: '-' }}</div>
                            </div>
                            <div class="mb-0">
                                <label class="text-xs text-uppercase font-weight-bold text-muted mb-1 d-block">SWIFT Code</label>
                                <div class="text-dark font-monospace small">{{ $business->bus_swift_code ?: '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- FBR & Technical Configuration -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white border-0 py-3">
                            <h6 class="m-0 font-weight-bold text-dark"><i class="ti ti-server mr-1 text-info"></i> FBR & Technical Config</h6>
                        </div>
                        <div class="card-body pt-0">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">FBR Environment:</span>
                                @if($business->fbr_env === 'sandbox')
                                    <span class="badge badge-warning text-uppercase px-2" style="font-size: 9px;">Sandbox</span>
                                @else
                                    <span class="badge badge-success text-uppercase px-2" style="font-size: 9px;">Production</span>
                                @endif
                            </div>
                            <div class="mb-2">
                                <label class="text-xs text-muted mb-0 d-block">Database Name</label>
                                <span class="text-dark font-weight-600 small">{{ $business->db_name }}</span>
                            </div>
                            <div class="mb-2">
                                <label class="text-xs text-muted mb-0 d-block">Database Host</label>
                                <span class="text-dark small">{{ $business->db_host }}</span>
                            </div>
                            <hr class="my-2 opacity-25">
                            <!-- <div class="mb-2">
                                <label class="text-xs text-muted mb-0 d-block">Sandbox API Key</label>
                                <code class="small text-break">{{ $business->sandbox_api_key ?: 'Not Set' }}</code>
                            </div>
                            <div class="mb-2">
                                <label class="text-xs text-muted mb-0 d-block">Production API Key</label>
                                <code class="small text-break">{{ $business->production_api_key ?: 'Not Set' }}</code>
                            </div> -->
                            <div class="mb-2">
                                <label class="text-xs text-muted mb-0 d-block">FBR Token (Sandbox)</label>
                                <code class="small text-break">{{ $business->fbr_api_token_sandbox ?: 'Not Set' }}</code>
                            </div>
                            <div class="mb-0">
                                <label class="text-xs text-muted mb-0 d-block">FBR Token (Prod)</label>
                                <code class="small text-break">{{ $business->fbr_api_token_prod ?: 'Not Set' }}</code>
                            </div>
                        </div>
                    </div>

                    
                </div>

                <!-- Right Column: Users & Scenarios -->
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-dark"><i class="ti ti-users mr-1 text-primary"></i> Team Members</h6>
                            <a href="{{ route('admin.businesses.create-user', \Illuminate\Support\Facades\Crypt::encryptString($business->bus_config_id)) }}" class="btn btn-primary btn-xs rounded-pill px-3">
                                <i class="ti ti-user-plus mr-1"></i> Add User
                            </a>
                        </div>
                        <div class="card-body pt-0">
                            @if ($business->users->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="text-muted small text-uppercase">
                                            <tr>
                                                <th class="border-top-0 px-0">Name</th>
                                                <th class="border-top-0">Email</th>
                                                <th class="border-top-0">Joined</th>
                                                <th class="border-top-0 text-right px-0">Role</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($business->users as $user)
                                                <tr>
                                                    <td class="px-0">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar bg-light text-primary rounded-circle d-flex align-items-center justify-content-center mr-2" style="width: 32px; height: 32px; font-size: 12px; font-weight: bold;">
                                                                {{ substr($user->name, 0, 1) }}
                                                            </div>
                                                            <span class="text-dark font-weight-600 small">{{ $user->name }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="small">{{ $user->email }}</td>
                                                    <td class="small text-muted">{{ $user->created_at?->format('d M, Y') }}</td>
                                                    <td class="text-right px-0">
                                                        <span class="badge badge-light text-primary border px-2 py-1" style="font-size: 10px;">{{ $user->role->name ?? 'N/A' }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4 text-muted small italic">
                                    <i class="ti ti-users d-block fa-2x mb-2 opacity-25"></i>
                                    No users found for this business.
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-0 py-3">
                            <h6 class="m-0 font-weight-bold text-dark"><i class="ti ti-layout-grid mr-1 text-info"></i> Allowed Scenarios</h6>
                        </div>
                        <div class="card-body pt-0">
                            @if ($business->scenarios->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="text-muted small text-uppercase">
                                            <tr>
                                                <th class="border-top-0 px-0">#</th>
                                                <th class="border-top-0">Description</th>
                                                <th class="border-top-0 text-right px-0">Sale Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($business->scenarios as $index => $scenario)
                                                <tr>
                                                    <td class="px-0 text-muted small font-weight-600">{{ $index + 1 }}</td>
                                                    <td class="small font-weight-600 text-dark">{{ $scenario->scenario_description ?? '-' }}</td>
                                                    <td class="text-right px-0">
                                                        <span class="badge badge-pill bg-light text-dark border px-2 py-1" style="font-size: 10px;">{{ $scenario->sale_type ?? '-' }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4 text-muted small italic">
                                    <i class="ti ti-package d-block fa-2x mb-2 opacity-25"></i>
                                    No scenarios assigned.
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- General Settings -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white border-0 py-3">
                            <h6 class="m-0 font-weight-bold text-dark"><i class="ti ti-settings mr-1 text-secondary"></i> Business Preferences & Identity</h6>
                        </div>
                        <div class="card-body pt-0">
                            @if($general_setting)
                                <div class="row">
                                    <!-- Brand & Identity -->
                                    <div class="col-12 mb-4">
                                        <div class="p-3 bg-light rounded-sm border-left border-primary" style="border-left-width: 3px !important;">
                                            <div class="row align-items-center">
                                                <div class="col-md-6 mb-2 mb-md-0">
                                                    <label class="text-xs text-uppercase font-weight-bold text-muted mb-1 d-block">Site Identity</label>
                                                    <h5 class="mb-0 font-weight-bold text-primary">{{ $general_setting->site_title }}</h5>
                                                    <div class="small text-muted">{{ $general_setting->company_name }}</div>
                                                </div>
                                                <div class="col-md-6 text-md-right">
                                                    <div class="small">
                                                        <span class="text-muted">VAT:</span> <span class="font-weight-600">{{ $general_setting->vat_registration_number ?: 'N/A' }}</span><br>
                                                        <span class="text-muted">Developer:</span> <span class="font-weight-600">{{ $general_setting->developed_by }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Config Grid -->
                                    <div class="col-md-6 pr-md-4">
                                        <h6 class="text-xs font-weight-bold text-uppercase text-primary mb-3"><i class="ti ti-world mr-1"></i> Regional & Format</h6>
                                        <ul class="list-unstyled mb-4">
                                            <li class="d-flex justify-content-between mb-2 pb-2 border-bottom border-light">
                                                <span class="small text-muted">Currency</span>
                                                <span class="small font-weight-600">{{ $general_setting->currency == 1 ? 'USD' : ($general_setting->currency == 2 ? 'PKR' : $general_setting->currency) }} ({{ $general_setting->currency_position }})</span>
                                            </li>
                                            <li class="d-flex justify-content-between mb-2 pb-2 border-bottom border-light">
                                                <span class="small text-muted">Timezone</span>
                                                <span class="small font-weight-600">{{ $general_setting->timezone }}</span>
                                            </li>
                                            <li class="d-flex justify-content-between mb-2 pb-2 border-bottom border-light">
                                                <span class="small text-muted">Date Format</span>
                                                <code class="small text-dark">{{ $general_setting->date_format }}</code>
                                            </li>
                                            <li class="d-flex justify-content-between mb-2">
                                                <span class="small text-muted">Decimal Points</span>
                                                <span class="small font-weight-600">{{ $general_setting->decimal }}</span>
                                            </li>
                                        </ul>

                                        <h6 class="text-xs font-weight-bold text-uppercase text-success mb-3"><i class="ti ti-calendar-event mr-1"></i> Subscription Details</h6>
                                        <div class="bg-light p-2 rounded small mb-4">
                                            <div class="d-flex justify-content-between mb-1">
                                                <span class="text-muted">Valid Until:</span>
                                                <span class="font-weight-bold {{ $general_setting->expiry_date ? 'text-dark' : 'text-success' }}">{{ $general_setting->expiry_date ?: 'Life-time Access' }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span class="text-muted">Grace Period:</span>
                                                <span class="font-weight-600">{{ $general_setting->expiry_alert_days }} Days</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 pl-md-4 border-left">
                                        <h6 class="text-xs font-weight-bold text-uppercase text-warning mb-3"><i class="ti ti-adjustments-horizontal mr-1"></i> System Behavior</h6>
                                        <ul class="list-unstyled mb-4">
                                            <li class="d-flex justify-content-between mb-2 pb-2 border-bottom border-light">
                                                <span class="small text-muted">Staff Access</span>
                                                <span class="badge badge-soft-info px-2 py-1" style="font-size: 10px; background: #e0f2fe; color: #0369a1;">{{ ucfirst($general_setting->staff_access) }}</span>
                                            </li>
                                            <li class="d-flex justify-content-between mb-2 pb-2 border-bottom border-light">
                                                <span class="small text-muted">Invoice Layout</span>
                                                <span class="small font-weight-600">{{ ucfirst($general_setting->invoice_format) }}</span>
                                            </li>
                                            <li class="d-flex justify-content-between mb-2 pb-2 border-bottom border-light">
                                                <span class="small text-muted">Visual Theme</span>
                                                <span class="small font-weight-600 text-capitalize">{{ $general_setting->theme }}</span>
                                            </li>
                                            <li class="d-flex justify-content-between mb-2">
                                                <span class="small text-muted">Default Margin</span>
                                                <span class="small font-weight-600">{{ $general_setting->default_margin_value }}%</span>
                                            </li>
                                        </ul>

                                        <h6 class="text-xs font-weight-bold text-uppercase text-info mb-3"><i class="ti ti-table mr-1"></i> UX Preferences</h6>
                                        <div class="small">
                                            <div class="custom-control custom-checkbox mb-1">
                                                <input type="checkbox" class="custom-control-input" {{ $general_setting->show_products_details_in_sales_table ? 'checked' : '' }} disabled>
                                                <label class="custom-control-label">Product Details in Sales</label>
                                            </div>
                                            <div class="custom-control custom-checkbox mb-1">
                                                <input type="checkbox" class="custom-control-input" {{ $general_setting->show_products_details_in_purchase_table ? 'checked' : '' }} disabled>
                                                <label class="custom-control-label">Product Details in Purchase</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Status Badges -->
                                    <div class="col-12 mt-2">
                                        <hr class="my-3 opacity-25">
                                        <div class="d-flex flex-wrap gap-2">
                                            @if($general_setting->is_rtl) 
                                                <div class="badge badge-pill bg-soft-secondary border px-3 py-2 text-muted" style="background:#f1f5f9">
                                                    <i class="ti ti-text-direction-rtl mr-1"></i> RTL Support
                                                </div>
                                            @endif
                                            @if($general_setting->is_packing_slip) 
                                                <div class="badge badge-pill bg-soft-secondary border px-3 py-2 text-muted" style="background:#f1f5f9">
                                                    <i class="ti ti-file-text mr-1"></i> Packing Slips
                                                </div>
                                            @endif
                                            @if($general_setting->without_stock == 'yes') 
                                                <div class="badge badge-pill bg-soft-danger border px-3 py-2 text-danger" style="background:#fef2f2">
                                                    <i class="ti ti-package-off mr-1"></i> Negative Stock Sales
                                                </div>
                                            @endif
                                            @if($general_setting->is_zatca) 
                                                <div class="badge badge-pill bg-soft-primary border px-3 py-2 text-primary" style="background:#eff6ff">
                                                    <i class="ti ti-shield-check mr-1"></i> ZATCA Integration
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="ti ti-settings-off fa-3x text-muted opacity-25 mb-3 d-block"></i>
                                    <p class="text-muted small">No detailed settings have been configured for this tenant yet.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-gradient { background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); }
    .font-weight-600 { font-weight: 600; }
    .text-xs { font-size: 0.75rem; }
    .btn-xs { padding: 4px 12px; font-size: 11px; }
    .font-monospace { font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace; }
    .opacity-75 { opacity: 0.75; }
    .table-hover tbody tr:hover { background-color: rgba(13, 110, 253, 0.02); }
    .badge-pill { border-radius: 50rem; }
</style>
@endsection
