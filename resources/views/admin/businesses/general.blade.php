@extends('admin.layouts.adminlayout')

@section('content')
<div class="container-fluid py-4">
    <div class="row ">
        <div class="col-lg-12">
            <!-- Header Section -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="font-weight-bold mb-1 text-dark">
                        {{ $business_config ? 'Edit Business Configuration' : 'Register New Business' }}
                    </h4>
                    <p class="text-muted small mb-0">Configure business details, administrative account, and system preferences.</p>
                </div>
                <a href="{{ route('admin.businesses.index') }}" class="btn btn-outline-secondary btn-xs rounded-pill px-3">
                    <i class="ti ti-arrow-left mr-1"></i> Back to List
                </a>
            </div>

            @if(session()->has('error'))
                <div class="alert alert-danger shadow-sm border-0 mb-4">
                    <i class="ti ti-alert-circle mr-2"></i> {{ session()->get('error') }}
                </div>
            @endif

            <form action="{{ route('admin.businesses.general.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @if($business_config)
                    <input type="hidden" name="bus_config_id" value="{{ $business_config->bus_config_id }}">
                @endif

                <!-- Section 1: Business Information -->
                <div class="card shadow-sm border-0 mb-4 overflow-hidden">
                    <div class="card-header bg-light border-bottom py-3">
                        <h6 class="m-0 font-weight-bold text-dark"><i class="ti ti-building mr-2 text-primary"></i>Business Information</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Business Name *</label>
                                <input type="text" name="bus_name" class="form-control shadow-xs" value="{{ old('bus_name', $business_config->bus_name ?? '') }}" required placeholder="e.g. Secureism Pvt Ltd">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">NTN / CNIC *</label>
                                <input type="text" name="bus_ntn_cnic" class="form-control shadow-xs" value="{{ old('bus_ntn_cnic', $business_config->bus_ntn_cnic ?? '') }}" required placeholder="e.g. 1234567-8">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Registration Number</label>
                                <input type="text" name="bus_reg_num" class="form-control shadow-xs" value="{{ old('bus_reg_num', $business_config->bus_reg_num ?? '') }}" placeholder="e.g. REG-9922">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Province</label>
                                <select name="bus_province" class="form-control shadow-xs">
                                    <option value="">Select Province</option>
                                    @foreach(['Punjab', 'Sindh', 'KPK', 'Balochistan', 'Gilgit Baltistan', 'Azad Kashmir', 'Islamabad'] as $p)
                                        <option value="{{ $p }}" {{ old('bus_province', $business_config->bus_province ?? '') == $p ? 'selected' : '' }}>{{ $p }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Full Address</label>
                                <textarea name="bus_address" class="form-control shadow-xs" rows="2" placeholder="Enter complete business address">{{ old('bus_address', $business_config->bus_address ?? '') }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Contact Person</label>
                                <input type="text" name="bus_contact_person" class="form-control shadow-xs" value="{{ old('bus_contact_person', $business_config->bus_contact_person ?? '') }}" placeholder="e.g. Ahmed Jawad">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Contact Number</label>
                                <input type="text" name="bus_contact_num" class="form-control shadow-xs" value="{{ old('bus_contact_num', $business_config->bus_contact_num ?? '') }}" placeholder="e.g. +92 300 1234567">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Banking Information -->
                <div class="card shadow-sm border-0 mb-4 overflow-hidden">
                    <div class="card-header bg-light border-bottom py-3">
                        <h6 class="m-0 font-weight-bold text-dark"><i class="ti ti-building-bank mr-2 text-success"></i>Banking Information</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Account Title</label>
                                <input type="text" name="bus_account_title" class="form-control shadow-xs" value="{{ old('bus_account_title', $business_config->bus_account_title ?? '') }}" placeholder="e.g. Secureism Business Account">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Account Number</label>
                                <input type="text" name="bus_account_number" class="form-control shadow-xs" value="{{ old('bus_account_number', $business_config->bus_account_number ?? '') }}" placeholder="e.g. 01234567890101">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">IBAN</label>
                                <input type="text" name="bus_IBAN" class="form-control shadow-xs" value="{{ old('bus_IBAN', $business_config->bus_IBAN ?? '') }}" placeholder="e.g. PK00 MEZN 0001...">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">SWIFT Code</label>
                                <input type="text" name="bus_swift_code" class="form-control shadow-xs" value="{{ old('bus_swift_code', $business_config->bus_swift_code ?? '') }}" placeholder="e.g. MEZNPPKXXX">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Branch Name</label>
                                <input type="text" name="bus_acc_branch_name" class="form-control shadow-xs" value="{{ old('bus_acc_branch_name', $business_config->bus_acc_branch_name ?? '') }}" placeholder="e.g. Blue Area Branch">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Branch Code</label>
                                <input type="text" name="bus_acc_branch_code" class="form-control shadow-xs" value="{{ old('bus_acc_branch_code', $business_config->bus_acc_branch_code ?? '') }}" placeholder="e.g. 0501">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Admin User Account -->
                <div class="card shadow-sm border-0 mb-4 overflow-hidden">
                    <div class="card-header bg-light border-bottom py-3">
                        <h6 class="m-0 font-weight-bold text-dark"><i class="ti ti-user-cog mr-2 text-info"></i>Admin User Account</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Admin Name *</label>
                                <input type="text" name="user_name" class="form-control shadow-xs" value="{{ old('user_name', $admin_user->name ?? '') }}" {{ !$business_config ? 'required' : '' }} placeholder="Username for login">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Admin Email *</label>
                                <input type="email" name="user_email" class="form-control shadow-xs" value="{{ old('user_email', $admin_user->email ?? '') }}" {{ !$business_config ? 'required' : '' }} placeholder="john@example.com">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Password {{ $business_config ? '(Leave blank to keep current)' : '*' }}</label>
                                <input type="password" name="user_password" class="form-control shadow-xs" {{ !$business_config ? 'required' : '' }} placeholder="••••••••">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Confirm Password</label>
                                <input type="password" name="user_password_confirmation" class="form-control shadow-xs" {{ !$business_config ? 'required' : '' }} placeholder="••••••••">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 4: System Settings -->
                <div class="card shadow-sm border-0 mb-4 overflow-hidden">
                    <div class="card-header bg-light border-bottom py-3">
                        <h6 class="m-0 font-weight-bold text-dark"><i class="ti ti-settings mr-2 text-secondary"></i>System Settings</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Site Title *</label>
                                <input type="text" name="site_title" class="form-control shadow-xs" value="{{ old('site_title', $general_setting->site_title ?? '') }}" required placeholder="e.g. TaxBridge POS">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Currency *</label>
                                <select name="currency" class="form-control shadow-xs" required>
                                    @foreach($lims_currency_list as $currency)
                                        <option value="{{ $currency->id }}" {{ old('currency', $general_setting->currency ?? '') == $currency->id ? 'selected' : '' }}>{{ $currency->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">FBR Environment <span class="text-danger">*</span></label>
                                <select name="fbr_env" id="fbr_env_select" class="form-control shadow-xs" required>
                                    <option value="sandbox" {{ old('fbr_env', $business_config->fbr_env ?? '') == 'sandbox' ? 'selected' : '' }}>Sandbox</option>
                                    <option value="production" {{ old('fbr_env', $business_config->fbr_env ?? '') == 'production' ? 'selected' : '' }}>Production</option>
                                </select>
                            </div>
                            
                            <!-- API Keys (Conditional) -->
                            <div class="col-md-6" id="sandbox_key_wrapper">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">
                                    Sandbox API Key <span class="text-danger sandbox-required">*</span>
                                </label>
                                <input type="text" name="sandbox_api_key" class="form-control shadow-xs" 
                                    value="{{ old('sandbox_api_key', $business_config->sandbox_api_key ?? '') }}" 
                                    placeholder="Enter Sandbox API Key">
                            </div>
                            
                            <div class="col-md-6" id="production_key_wrapper">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">
                                    Production API Key <span class="text-danger production-required" style="display:none;">*</span>
                                </label>
                                <input type="text" name="production_api_key" class="form-control shadow-xs" 
                                    value="{{ old('production_api_key', $business_config->production_api_key ?? '') }}" 
                                    placeholder="Enter Production API Key">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Timezone *</label>
                                <select name="timezone" class="form-control shadow-xs selectpicker" data-live-search="true" required>
                                    @foreach($zones_array as $zone)
                                        <option value="{{ $zone['zone'] }}" {{ old('timezone', $general_setting->timezone ?? '') == $zone['zone'] ? 'selected' : '' }}>{{ $zone['diff_from_GMT'] }} - {{ $zone['zone'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                                <div class="form-check mt-4 pt-2">
                                    <input type="checkbox" name="is_rtl" class="form-check-input" id="is_rtl" {{ old('is_rtl', $general_setting->is_rtl ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label font-weight-bold text-muted small text-uppercase" for="is_rtl">Enable RTL Layout</label>
                                </div>
                            </div>

                            <!-- Branding -->
                            <div class="col-md-12 my-3"><hr class="text-muted"></div>
                            
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Site Logo</label>
                                <input type="file" name="site_logo" class="form-control shadow-xs">
                                @if(isset($general_setting->site_logo))
                                    <div class="mt-2">
                                        <img src="{{ asset('images/logo/'.$general_setting->site_logo) }}" alt="Site Logo" height="40">
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Favicon</label>
                                <input type="file" name="favicon" class="form-control shadow-xs">
                                @if(isset($general_setting->favicon))
                                    <div class="mt-2">
                                        <img src="{{ asset('images/logo/'.$general_setting->favicon) }}" alt="Favicon" height="30">
                                    </div>
                                @endif
                            </div>

                            <!-- Formatting Preferences -->
                            <div class="col-md-12 my-3"><hr class="text-muted"></div>

                            <div class="col-md-3">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Date Format</label>
                                <select name="date_format" class="form-control shadow-xs">
                                    @php $formats = ['d-m-Y', 'm-d-Y', 'Y-m-d', 'd/m/Y', 'm/d/Y', 'Y/m/d']; @endphp
                                    @foreach($formats as $fmt)
                                        <option value="{{ $fmt }}" {{ old('date_format', $general_setting->date_format ?? 'd-m-Y') == $fmt ? 'selected' : '' }}>
                                            {{ date($fmt) }} ({{ $fmt }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-3">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Currency Position</label>
                                <select name="currency_position" class="form-control shadow-xs">
                                    <option value="prefix" {{ old('currency_position', $general_setting->currency_position ?? 'suffix') == 'prefix' ? 'selected' : '' }}>Prefix ($100)</option>
                                    <option value="suffix" {{ old('currency_position', $general_setting->currency_position ?? 'suffix') == 'suffix' ? 'selected' : '' }}>Suffix (100$)</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Decimal Places</label>
                                <select name="decimal" class="form-control shadow-xs">
                                    <option value="0" {{ old('decimal', $general_setting->decimal ?? 2) == 0 ? 'selected' : '' }}>0</option>
                                    <option value="2" {{ old('decimal', $general_setting->decimal ?? 2) == 2 ? 'selected' : '' }}>2</option>
                                    <option value="3" {{ old('decimal', $general_setting->decimal ?? 2) == 3 ? 'selected' : '' }}>3</option>
                                    <option value="4" {{ old('decimal', $general_setting->decimal ?? 2) == 4 ? 'selected' : '' }}>4</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Invoice Format</label>
                                <select name="invoice_format" class="form-control shadow-xs">
                                    <option value="standard" {{ old('invoice_format', $general_setting->invoice_format ?? 'standard') == 'standard' ? 'selected' : '' }}>Standard</option>
                                    <option value="gst" {{ old('invoice_format', $general_setting->invoice_format ?? 'standard') == 'gst' ? 'selected' : '' }}>GST</option>
                                </select>
                            </div>

                            <!-- Inventory Options -->
                            <div class="col-md-12 my-3"><hr class="text-muted"></div>

                            <div class="col-md-4">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Staff Access</label>
                                <select name="staff_access" class="form-control shadow-xs">
                                    <option value="all" {{ old('staff_access', $general_setting->staff_access ?? 'all') == 'all' ? 'selected' : '' }}>All Records</option>
                                    <option value="own" {{ old('staff_access', $general_setting->staff_access ?? 'all') == 'own' ? 'selected' : '' }}>Own Records</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Sell Without Stock</label>
                                <select name="without_stock" class="form-control shadow-xs">
                                    <option value="no" {{ old('without_stock', $general_setting->without_stock ?? 'no') == 'no' ? 'selected' : '' }}>No</option>
                                    <option value="yes" {{ old('without_stock', $general_setting->without_stock ?? 'no') == 'yes' ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <div class="mt-4">
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" name="is_packing_slip" class="form-check-input" id="is_packing_slip" {{ old('is_packing_slip', $general_setting->is_packing_slip ?? 0) ? 'checked' : '' }}>
                                        <label class="form-check-label font-weight-bold text-muted small" for="is_packing_slip">Packing Slip</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" name="show_products_details_in_sales_table" class="form-check-input" id="show_prod_sale" {{ old('show_products_details_in_sales_table', $general_setting->show_products_details_in_sales_table ?? 0) ? 'checked' : '' }}>
                                        <label class="form-check-label font-weight-bold text-muted small" for="show_prod_sale">Det. in Sale</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" name="show_products_details_in_purchase_table" class="form-check-input" id="show_prod_pur" {{ old('show_products_details_in_purchase_table', $general_setting->show_products_details_in_purchase_table ?? 0) ? 'checked' : '' }}>
                                        <label class="form-check-label font-weight-bold text-muted small" for="show_prod_pur">Det. in Purch</label>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>

                <!-- Section 5: Allowed Scenarios -->
                <div class="card shadow-sm border-0 mb-5 overflow-hidden">
                    <div class="card-header bg-light border-bottom py-3">
                        <h6 class="m-0 font-weight-bold text-dark"><i class="ti ti-layout-grid mr-2 text-warning"></i>Allowed Scenarios</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label font-weight-bold text-muted small text-uppercase mb-2">Select Accessible Scenarios</label>
                                <select name="scenarios[]" class="form-control selectpicker shadow-xs" 
                                    multiple="multiple" 
                                    data-live-search="true" 
                                    data-actions-box="true" 
                                    data-style="btn-outline-light text-dark border shadow-xs"
                                    data-selected-text-format="count > 3"
                                    title="Choose scenarios...">
                                    @foreach($scenarios as $scenario)
                                        <option value="{{ $scenario->scenario_id }}" {{ in_array($scenario->scenario_id, $selectedScenarioIds) ? 'selected' : '' }}>
                                            {{ $scenario->scenario_description }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted mt-2 d-block">Hold Ctrl to select multiple or use the multi-select dropdown features.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="text-center mb-5 pb-5">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm">
                        <i class="ti ti-device-floppy mr-1"></i> Save Configuration
                    </button>
                    <a href="{{ route('admin.businesses.index') }}" class="btn btn-light btn-lg rounded-pill px-5 ml-3 border shadow-sm">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .font-weight-600 { font-weight: 600; }
    .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .btn-xs { padding: 4px 12px; font-size: 11px; }
    .form-control:focus { border-color: #0d6efd; box-shadow: 0 0 0 0.25rem rgba(13,110,253,.1); }
    .card-header { letter-spacing: 0.025em; }
    .bg-light { background-color: #f8fafc !important; }
    .selectpicker + .btn { background: #fff !important; border-color: #dee2e6 !important; }
    .selectpicker + .btn:focus { box-shadow: 0 0 0 0.25rem rgba(13,110,253,.1) !important; }
</style>
<script>
    (function() {
        const envSelect = document.getElementById('fbr_env_select');
        const sandboxInput = document.querySelector('input[name="sandbox_api_key"]');
        const productionInput = document.querySelector('input[name="production_api_key"]');
        const sandboxStar = document.querySelector('.sandbox-required');
        const productionStar = document.querySelector('.production-required');
        const form = document.querySelector('form[action*="businesses/general"]');

        function syncRequired() {
            const env = envSelect ? envSelect.value : 'sandbox';
            if (!sandboxInput || !productionInput) return;

            if (env === 'sandbox') {
                sandboxInput.required = true;
                productionInput.required = false;
                if (sandboxStar) sandboxStar.style.display = 'inline';
                if (productionStar) productionStar.style.display = 'none';
            } else if (env === 'production') {
                sandboxInput.required = false;
                productionInput.required = true;
                if (sandboxStar) sandboxStar.style.display = 'none';
                if (productionStar) productionStar.style.display = 'inline';
            }
        }

        if (envSelect) {
            envSelect.addEventListener('change', syncRequired);
        }
        // Initialize on load
        document.addEventListener('DOMContentLoaded', syncRequired);
        // Also run immediately in case DOMContentLoaded already fired
        syncRequired();

        // Since the form has novalidate, add a lightweight guard
        if (form) {
            form.addEventListener('submit', function(e) {
                syncRequired();
                const env = envSelect ? envSelect.value : 'sandbox';
                if (env === 'sandbox' && sandboxInput && !sandboxInput.value.trim()) {
                    e.preventDefault();
                    sandboxInput.focus();
                    alert('Sandbox API Key is required when FBR Environment is Sandbox.');
                }
                if (env === 'production' && productionInput && !productionInput.value.trim()) {
                    e.preventDefault();
                    productionInput.focus();
                    alert('Production API Key is required when FBR Environment is Production.');
                }
            });
        }
    })();
</script>
@endsection
