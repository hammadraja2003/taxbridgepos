@extends('admin.layouts.adminlayout')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header Section -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="font-weight-bold mb-1 text-dark">Assign Package to Business</h4>
                    <p class="text-muted small mb-0">Select a business and assign a subscription package with custom features.</p>
                </div>
                <a href="{{ route('admin.business_packages.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="ti ti-list mr-1"></i> Assigned List
                </a>
            </div>

            <div class="card shadow-sm border-0 mb-4 overflow-hidden">
                <div class="card-header bg-light border-bottom py-3">
                    <h6 class="m-0 font-weight-bold text-dark"><i class="ti ti-user-plus mr-2 text-primary"></i>Assignment Details</h6>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form action="{{ route('admin.business_packages.assign') }}" method="POST" id="assignPackageForm">
                        @csrf
                        <!-- Business and Package selection -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Select Business *</label>
                                <select name="business_id" class="form-control shadow-xs" required>
                                    <option value="">-- Choose Business --</option>
                                    @foreach ($businesses as $b)
                                        <option value="{{ $b->bus_config_id }}">{{ $b->bus_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Select Package *</label>
                                <select name="package_id" id="packageSelect" class="form-control shadow-xs" required>
                                    <option value="">-- Choose Package --</option>
                                    @foreach ($packages as $p)
                                        <option value="{{ $p->package_id }}" 
                                                data-price="{{ $p->package_price }}"
                                                data-features='@json($p->features)'>
                                            {{ $p->package_name }} ({{ number_format($p->package_price, 2) }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Pricing and Trial -->
                        <div class="bg-light rounded p-4 mb-4 border shadow-xs">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-3">
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" name="is_trial" id="isTrial" {{ old('is_trial') ? 'checked' : '' }}>
                                        <label class="form-check-label font-weight-bold ml-2" for="isTrial">Assign as Trial</label>
                                    </div>
                                    <label class="form-label font-weight-bold text-muted small text-uppercase mb-1">Trial Period (Days)</label>
                                    <input type="number" name="trial_days" id="trialDays" class="form-control shadow-xs bg-white" min="1" value="{{ old('trial_days', 7) }}" disabled>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label font-weight-bold text-muted small text-uppercase mb-1">Standard Price</label>
                                    <div class="input-group shadow-xs">
                                        <span class="input-group-text bg-white border-end-0 text-muted">$</span>
                                        <input type="number" id="packagePrice" class="form-control border-start-0 bg-light" readonly>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label font-weight-bold text-muted small text-uppercase mb-1">Discount (%)</label>
                                    <input type="number" name="discount" id="discount" class="form-control shadow-xs bg-white" min="0" max="100" value="0">
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label font-weight-bold text-muted small text-uppercase mb-1">Final Price</label>
                                    <div class="input-group shadow-xs">
                                        <span class="input-group-text bg-white border-end-0 text-muted">$</span>
                                        <input type="number" name="price_after_discount" id="priceAfterDiscount" class="form-control border-start-0 bg-light" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Custom Features -->
                        <div class="border-top pt-4 mb-3">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h6 class="m-0 font-weight-bold text-dark"><i class="ti ti-list-check mr-2 text-info"></i>Feature Configuration</h6>
                                {{-- <button type="button" id="addFeature" class="btn btn-sm btn-primary-subtle text-primary rounded-pill border-primary-subtle">
                                    <i class="ti ti-plus mr-1"></i> Add Custom Feature
                                </button> --}}
                            </div>
                            
                            <div class="bg-light rounded p-3 mb-3 border">
                                <div class="row g-2 mb-2 text-muted small text-uppercase font-weight-bold px-1">
                                    <div class="col-5">Feature Key</div>
                                    <div class="col-3">Limit Type</div>
                                    <div class="col-3">Limit Value</div>
                                    <div class="col-1 text-center"></div>
                                </div>
                                <div id="featuresWrapper" class="d-flex flex-column gap-2 text-center text-muted small py-3" style="min-height: 50px;">
                                    <div class="empty-state">
                                        <i class="ti ti-info-circle fs-4 mb-1"></i>
                                        <p class="mb-0">Select a package to load default features or add custom ones.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-3">
                            <a href="{{ route('admin.business_packages.index') }}" class="btn btn-light rounded-pill px-4 border shadow-sm">Cancel</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                                <i class="ti ti-check mr-1"></i> Assign Package
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
    .form-switch .form-check-input { width: 2.5em; height: 1.25em; cursor: pointer; }
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let featureIndex = 0;
        const wrapper = document.getElementById('featuresWrapper');
        const addFeatureBtn = document.getElementById('addFeature');
        const packageSelect = document.getElementById('packageSelect');
        const isTrialCheckbox = document.getElementById('isTrial');
        const trialDaysInput = document.getElementById('trialDays');
        const discountInput = document.getElementById('discount');
        const priceInput = document.getElementById('packagePrice');
        const finalPriceInput = document.getElementById('priceAfterDiscount');

        // Feature Keys Options
        const moduleOptions = [
            'Product and Categories', 'Purchase and Sale', 'Sale Return', 
            'Purchase Return', 'Expense', 'Income', 'Stock Transfer', 
            'Quotation', 'Product Delivery', 'Stock Count and Adjustment', 
            'Report', 'HRM', 'Accounting', 'Manufacturing'
        ];

        // Function to create a new feature row
        function createFeatureRow(key = '', type = 'monthly', value = 0, index) {
            const row = document.createElement('div');
            row.classList.add('feature-row', 'row', 'g-2', 'align-items-center');
            
            let optionsHtml = '<option value="" disabled>Select Feature</option>';
            moduleOptions.forEach(opt => {
                optionsHtml += `<option value="${opt}" ${key === opt ? 'selected' : ''}>${opt}</option>`;
            });

            row.innerHTML = `
                <div class="col-5">
                    <select name="features[${index}][feature_key]" class="form-control form-control-sm shadow-xs border-0" required>
                        ${optionsHtml}
                        ${key && !moduleOptions.includes(key) ? `<option value="${key}" selected>${key}</option>` : ''}
                    </select>
                </div>
                <div class="col-3">
                    <select name="features[${index}][limit_type]" class="form-control form-control-sm shadow-xs border-0" required>
                        <option value="monthly" ${type === 'monthly' ? 'selected' : ''}>Monthly</option>
                        <option value="quarterly" ${type === 'quarterly' ? 'selected' : ''}>Quarterly</option>
                        <option value="yearly" ${type === 'yearly' ? 'selected' : ''}>Yearly</option>
                        <option value="total" ${type === 'total' ? 'selected' : ''}>Total</option>
                    </select>
                </div>
                <div class="col-3">
                    <input type="number" name="features[${index}][limit_value]" class="form-control form-control-sm shadow-xs border-0" placeholder="e.g. 100" value="${value}" required>
                </div>
                <div class="col-1 text-center">
                    <button type="button" class="btn btn-icon btn-sm text-danger btn-remove p-0" title="Remove">
                        <i class="ti ti-x fs-5"></i>
                    </button>
                </div>
            `;
            return row;
        }

        // Handle Package Selection
        packageSelect.addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            if (!selected.value) {
                wrapper.innerHTML = '<div class="empty-state text-center text-muted small py-3"><i class="ti ti-info-circle fs-4 mb-1"></i><p class="mb-0">Select a package to load default features or add custom ones.</p></div>';
                priceInput.value = '';
                finalPriceInput.value = '';
                return;
            }

            const features = selected.dataset.features ? JSON.parse(selected.dataset.features) : [];
            wrapper.innerHTML = ''; // Clear previous
            
            features.forEach((f, idx) => {
                wrapper.appendChild(createFeatureRow(f.feature_key, f.limit_type, f.limit_value, idx));
                featureIndex = idx + 1;
            });

            priceInput.value = selected.dataset.price ? parseFloat(selected.dataset.price) : 0;
            calculateFinalPrice();
        });

        // Add custom feature - Button removed from UI
        if(addFeatureBtn) {
            addFeatureBtn.addEventListener('click', function() {
                if (wrapper.querySelector('.empty-state')) wrapper.innerHTML = '';
                wrapper.appendChild(createFeatureRow('', 'monthly', 0, featureIndex));
                featureIndex++;
            });
        }

        // Remove feature
        wrapper.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-remove');
            if (btn) {
                btn.closest('.feature-row').remove();
                if (wrapper.children.length === 0) {
                    wrapper.innerHTML = '<div class="empty-state text-center text-muted small py-3"><i class="ti ti-info-circle fs-4 mb-1"></i><p class="mb-0">Select a package to load default features or add custom ones.</p></div>';
                }
            }
        });

        // Trial Toggle Function
        function toggleTrialState() {
            if (isTrialCheckbox.checked) {
                trialDaysInput.disabled = false;
                discountInput.value = 0;
                discountInput.disabled = true;
                finalPriceInput.value = 0;
            } else {
                trialDaysInput.disabled = true;
                // Only reset to 7 if disabled, keeping user input if they re-enable? No, UI standard is reset or keep.
                // Current logic was: trialDaysInput.value = 7; 
                // Let's keep value as is so it doesn't jarringly change if user misclicks. But strict requirement might imply resetting.
                // Let's stick to previous behavior of defaulting if needed, but not forcing it constantly.
                discountInput.disabled = false;
                calculateFinalPrice();
            }
        }

        isTrialCheckbox.addEventListener('change', toggleTrialState);
        
        // Initialize state on load (in case of validation errors returning old input)
        toggleTrialState();

        // Calculations
        discountInput.addEventListener('input', calculateFinalPrice);

        function calculateFinalPrice() {
            if (isTrialCheckbox.checked) return;
            const price = parseFloat(priceInput.value) || 0;
            const discount = parseFloat(discountInput.value) || 0;
            const final = price - (price * discount / 100);
            finalPriceInput.value = final.toFixed(2);
        }
    });

    // Simple Shake animation from earlier
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
