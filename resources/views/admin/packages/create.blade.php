@extends('admin.layouts.adminlayout')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header Section -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="font-weight-bold mb-1 text-dark">Create New Package</h4>
                    <p class="text-muted small mb-0">Define a new subscription package and its features.</p>
                </div>
                <a href="{{ route('admin.packages.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="ti ti-arrow-left mr-1"></i> Back to List
                </a>
            </div>

            <div class="card shadow-sm border-0 mb-4 overflow-hidden">
                <div class="card-header bg-light border-bottom py-3">
                    <h6 class="m-0 font-weight-bold text-dark"><i class="ti ti-package mr-2 text-primary"></i>Package Details</h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.packages.store') }}" method="POST" id="createPackageForm">
                        @csrf
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Package Name *</label>
                                <input type="text" name="package_name" class="form-control shadow-xs" placeholder="e.g. Premium Plan" value="{{ old('package_name') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Billing Cycle *</label>
                                <select name="package_billing_cycle" class="form-control shadow-xs" required>
                                    <option value="monthly">Monthly</option>
                                    <option value="quarterly">Quarterly</option>
                                    <option value="yearly">Yearly</option>
                                    <option value="custom">Custom</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Price *</label>
                                <div class="input-group shadow-xs">
                                    {{-- <span class="input-group-text bg-light border-end-0 text-muted">$</span> --}}
                                    <input type="number" name="package_price" class="form-control border-start-0 ps-0" step="0.01" placeholder="0.00" value="{{ old('package_price') }}" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Description</label>
                                <textarea name="package_description" class="form-control shadow-xs" rows="3" placeholder="Enter package description...">{{ old('package_description') }}</textarea>
                            </div>
                        </div>

                        <div class="border-top pt-4 mb-3">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h6 class="m-0 font-weight-bold text-dark"><i class="ti ti-list-check mr-2 text-info"></i>Package Features</h6>
                                <button type="button" id="addFeature" class="btn btn-sm btn-primary-subtle text-primary rounded-pill border-primary-subtle">
                                    <i class="ti ti-plus mr-1"></i> Add Feature
                                </button>
                            </div>
                            
                            <div class="bg-light rounded p-3 mb-3 border">
                                <div class="row g-2 mb-2 text-muted small text-uppercase font-weight-bold px-1">
                                    <div class="col-5">Feature Key</div>
                                    <div class="col-3">Limit Type</div>
                                    <div class="col-3">Limit Value</div>
                                    <div class="col-1 text-center"></div>
                                </div>
                                <div id="featuresWrapper" class="d-flex flex-column gap-2">
                                    <!-- Features will be added here dynamically -->
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-3">
                            <a href="{{ route('admin.packages.index') }}" class="btn btn-light rounded-pill px-4 border shadow-sm">Cancel</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                                <i class="ti ti-check mr-1"></i> Create Package
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .font-weight-bold { font-weight: 600 !important; }
    .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .bg-primary-subtle { background-color: rgba(13, 110, 253, 0.1); }
    .text-primary-subtle { color: rgba(13, 110, 253, 0.8); }
    .border-primary-subtle { border-color: rgba(13, 110, 253, 0.2); }
    .feature-row { transition: all 0.2s; }
    .feature-row:hover .btn-remove { opacity: 1; }
    .btn-remove { transition: all 0.2s; opacity: 0.6; }
    .btn-remove:hover { opacity: 1; }
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let featureIndex = 0;
        const wrapper = document.getElementById('featuresWrapper');
        const addFeatureBtn = document.getElementById('addFeature');

        // Function to create a new feature row
        function createFeatureRow(index) {
            const row = document.createElement('div');
            row.classList.add('feature-row', 'row', 'g-2', 'align-items-center');
            
            row.innerHTML = `
                <div class="col-5">
                    <select name="features[${index}][feature_key]" class="form-control form-control-sm shadow-xs border-0" required>
                        <option value="" disabled selected>Select Feature</option>
                        <option value="Product and Categories">Product and Categories</option>
                        <option value="Purchase and Sale">Purchase and Sale</option>
                        <option value="Sale Return">Sale Return</option>
                        <option value="Purchase Return">Purchase Return</option>
                        <option value="Expense">Expense</option>
                        <option value="Income">Income</option>
                        <option value="Stock Transfer">Stock Transfer</option>
                        <option value="Quotation">Quotation</option>
                        <option value="Product Delivery">Product Delivery</option>
                        <option value="Stock Count and Adjustment">Stock Count and Adjustment</option>
                        <option value="Report">Report</option>
                        <option value="HRM">HRM</option>
                        <option value="Accounting">Accounting</option>
                        <option value="Manufacturing">Manufacturing</option>
                    </select>
                </div>
                <div class="col-3">
                    <select name="features[${index}][limit_type]" class="form-control form-control-sm shadow-xs border-0" required>
                        <option value="monthly">Monthly</option>
                        <option value="quarterly">Quarterly</option>
                        <option value="yearly">Yearly</option>
                        <option value="total">Total</option>
                    </select>
                </div>
                <div class="col-3">
                    <input type="number" name="features[${index}][limit_value]" class="form-control form-control-sm shadow-xs border-0" placeholder="e.g. 100" required>
                </div>
                <div class="col-1 text-center">
                    <button type="button" class="btn btn-icon btn-sm text-danger btn-remove p-0" title="Remove">
                        <i class="ti ti-x fs-5"></i>
                    </button>
                </div>
            `;
            return row;
        }

        // Add first row on page load
        wrapper.appendChild(createFeatureRow(featureIndex));
        featureIndex++;

        // Add new feature row
        addFeatureBtn.addEventListener('click', function() {
            wrapper.appendChild(createFeatureRow(featureIndex));
            featureIndex++;
        });

        // Remove feature row (Event delegation)
        wrapper.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-remove');
            if (btn) {
                const rows = wrapper.querySelectorAll('.feature-row');
                if (rows.length > 1) {
                    btn.closest('.feature-row').remove();
                } else {
                     // Optional: Toast or quieter alert
                     // alert('At least one feature is required.');
                     // Instead of alert, visually shake the row or show tooltip
                     const row = btn.closest('.feature-row');
                     row.classList.add('shake');
                     setTimeout(() => row.classList.remove('shake'), 500);
                }
            }
        });
    });
</script>
<style>
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
    .shake { animation: shake 0.4s cubic-bezier(.36,.07,.19,.97) both; }
</style>
@endpush
@endsection
