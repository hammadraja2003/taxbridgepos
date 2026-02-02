@extends('admin.layouts.adminlayout')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header Section -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="font-weight-bold mb-1 text-dark">Edit Package</h4>
                    <p class="text-muted small mb-0">Modify the subscription package details and its features.</p>
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
                    <form action="{{ route('admin.packages.update', encrypt($package->package_id)) }}" method="POST" id="editPackageForm">
                        @csrf
                        @method('PUT')
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Package Name *</label>
                                <input type="text" name="package_name" class="form-control shadow-xs" placeholder="e.g. Premium Plan" value="{{ old('package_name', $package->package_name) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Billing Cycle *</label>
                                <select name="package_billing_cycle" class="form-control shadow-xs" required>
                                    <option value="monthly" {{ old('package_billing_cycle', $package->package_billing_cycle) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="quarterly" {{ old('package_billing_cycle', $package->package_billing_cycle) == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                                    <option value="yearly" {{ old('package_billing_cycle', $package->package_billing_cycle) == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                    <option value="custom" {{ old('package_billing_cycle', $package->package_billing_cycle) == 'custom' ? 'selected' : '' }}>Custom</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Price *</label>
                                <div class="input-group shadow-xs">
                                    <span class="input-group-text bg-light border-end-0 text-muted">$</span>
                                    <input type="number" name="package_price" class="form-control border-start-0 ps-0" step="0.01" placeholder="0.00" value="{{ old('package_price', $package->package_price) }}" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Description</label>
                                <textarea name="package_description" class="form-control shadow-xs" rows="3" placeholder="Enter package description...">{{ old('package_description', $package->package_description) }}</textarea>
                            </div>
                        </div>

                        <div class="border-top pt-4 mb-3">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h6 class="m-0 font-weight-bold text-dark"><i class="ti ti-list-check mr-2 text-info"></i>Package Features</h6>
                            </div>
                            
                            <div class="bg-light rounded p-3 mb-3 border">
                                <div id="featuresWrapper" class="d-flex flex-column gap-2">
                                    <!-- Features multi-select dropdown with pre-selected values -->
                                    {!! getFeatureType('feature_key', $package->features->pluck('feature_key')->toArray(), 'feature_key', 'form-control select', true, true) !!}
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-3">
                            <a href="{{ route('admin.packages.index') }}" class="btn btn-light rounded-pill px-4 border shadow-sm">Cancel</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                                <i class="ti ti-check mr-1"></i> Update Package
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
@endpush
@endsection
