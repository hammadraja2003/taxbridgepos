@extends('admin.layouts.adminlayout')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header Section -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="font-weight-bold mb-1 text-dark">Business Assigned Packages</h4>
                    <p class="text-muted small mb-0">Overview and management of all active and expired business subscriptions.</p>
                </div>
                <a href="{{ route('admin.business_packages.assign.form') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <i class="ti ti-plus mr-1"></i> Assign New Package
                </a>
            </div>

            <!-- Filter Section -->
            <div class="card shadow-sm border-0 mb-4 overflow-hidden">
                <div class="card-header bg-light border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-dark"><i class="ti ti-filter mr-2 text-primary"></i>Refine List</h6>
                    <button type="button" class="btn btn-sm btn-link text-muted p-0" onclick="toggleFilters()" id="toggleBtn">
                        <span id="toggleText">Hide Filters</span> <i class="ti ti-chevron-up ml-1" id="toggleIcon"></i>
                    </button>
                </div>
                <div class="card-body p-4" id="filterContainer">
                    <form method="GET" action="{{ route('admin.business_packages.index') }}" id="filterForm">
                        <div class="row g-3" id="filterRow">
                            <div class="col-md-3">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Business</label>
                                <select name="business_id" class="form-control shadow-xs">
                                    <option value="">All Businesses</option>
                                    @foreach($businesses as $business)
                                        <option value="{{ $business->bus_config_id }}" {{ request('business_id') == $business->bus_config_id ? 'selected' : '' }}>
                                            {{ $business->bus_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Package</label>
                                <select name="package_id" class="form-control shadow-xs">
                                    <option value="">All Packages</option>
                                    @foreach($packages as $package)
                                        <option value="{{ $package->package_id }}" {{ request('package_id') == $package->package_id ? 'selected' : '' }}>
                                            {{ $package->package_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Status</label>
                                <select name="status" class="form-control shadow-xs">
                                    <option value="">All Statuses</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                                    <option value="trial" {{ request('status') == 'trial' ? 'selected' : '' }}>Trial (All)</option>
                                    <option value="trial_active" {{ request('status') == 'trial_active' ? 'selected' : '' }}>Trial Active</option>
                                    <option value="trial_expired" {{ request('status') == 'trial_expired' ? 'selected' : '' }}>Trial Expired</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Expiring Soon</label>
                                <select name="expiring_soon" class="form-control shadow-xs">
                                    <option value="">Not Filtered</option>
                                    <option value="7" {{ request('expiring_soon') == '7' ? 'selected' : '' }}>Within 7 Days</option>
                                    <option value="15" {{ request('expiring_soon') == '15' ? 'selected' : '' }}>Within 15 Days</option>
                                    <option value="30" {{ request('expiring_soon') == '30' ? 'selected' : '' }}>Within 30 Days</option>
                                </select>
                            </div>

                            <!-- Advanced Filters (Initially Hidden Row) -->
                            <div class="col-12 mt-0 pt-0" id="advancedFiltersRow" style="display: none;">
                                <div class="row g-3 pt-3">
                                    <div class="col-md-3">
                                        <label class="form-label font-weight-bold text-muted small text-uppercase">Start Date From</label>
                                        <input type="date" name="start_date_from" class="form-control shadow-xs" value="{{ request('start_date_from') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label font-weight-bold text-muted small text-uppercase">Start Date To</label>
                                        <input type="date" name="start_date_to" class="form-control shadow-xs" value="{{ request('start_date_to') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label font-weight-bold text-muted small text-uppercase">End Date From</label>
                                        <input type="date" name="end_date_from" class="form-control shadow-xs" value="{{ request('end_date_from') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label font-weight-bold text-muted small text-uppercase">End Date To</label>
                                        <input type="date" name="end_date_to" class="form-control shadow-xs" value="{{ request('end_date_to') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label font-weight-bold text-muted small text-uppercase">Min Discount %</label>
                                        <input type="number" name="discount_min" class="form-control shadow-xs" min="0" max="100" value="{{ request('discount_min') }}" placeholder="e.g. 10">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label font-weight-bold text-muted small text-uppercase">Max Discount %</label>
                                        <input type="number" name="discount_max" class="form-control shadow-xs" min="0" max="100" value="{{ request('discount_max') }}" placeholder="e.g. 50">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label font-weight-bold text-muted small text-uppercase">Min Price</label>
                                        <input type="number" name="price_min" class="form-control shadow-xs" min="0" step="0.01" value="{{ request('price_min') }}" placeholder="e.g. 1000">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label font-weight-bold text-muted small text-uppercase">Max Price</label>
                                        <input type="number" name="price_max" class="form-control shadow-xs" min="0" step="0.01" value="{{ request('price_max') }}" placeholder="e.g. 5000">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between pt-4">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary px-4 rounded-pill shadow-xs">
                                    <i class="ti ti-search mr-1"></i> Apply
                                </button>
                                <a href="{{ route('admin.business_packages.index') }}" class="btn btn-light px-4 rounded-pill border shadow-xs">
                                    <i class="ti ti-refresh mr-1"></i> Reset
                                </a>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" onclick="toggleAdvancedFilters()" id="advancedToggleBtn">
                                <i class="ti ti-adjustments mr-1" id="advIcon"></i> <span id="advText">More Filters</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table Section -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 py-3 px-4 text-muted small text-uppercase font-weight-bold">Business / Status</th>
                                    <th class="border-0 py-3 text-muted small text-uppercase font-weight-bold">Package / Cycle</th>
                                    <th class="border-0 py-3 text-muted small text-uppercase font-weight-bold">Duration</th>
                                    <th class="border-0 py-3 text-right text-muted small text-uppercase font-weight-bold">Pricing</th>
                                    <th class="border-0 py-3 px-4 text-muted small text-uppercase font-weight-bold">Usage & Limits</th>
                                    <th class="border-0 py-3 text-center text-muted small text-uppercase font-weight-bold">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $today = \Carbon\Carbon::now(); @endphp
                                @forelse ($assigned as $a)
                                    @php
                                        $isTrial = $a->is_trial;
                                        // Use endOfDay() to ensure we compare against the full last day
                                        $endDate = \Carbon\Carbon::parse($a->end_date)->endOfDay();
                                        $isExpired = $today->gt($endDate);
                                        $daysLeft = (int) $today->diffInDays($endDate, false);
                                        if ($daysLeft < 0) $daysLeft = 0;

                                        $statusLabel = $isExpired ? 'Expired' : ($a->is_active ? 'Active' : 'Inactive');
                                        $statusClass = $isExpired ? 'bg-danger-subtle text-danger' : ($a->is_active ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary');
                                        $statusIcon = $isExpired ? 'ti-alert-circle' : ($a->is_active ? 'ti-circle-check' : 'ti-circle-x');
                                    @endphp

                                    <tr class="{{ $isExpired ? 'opacity-75' : '' }}">
                                        <td class="px-4">
                                            <div class="font-weight-bold text-dark mb-1">{{ $a->business->bus_name }}</div>
                                            <div class="d-flex align-items-center">
                                                <span class="badge {{ $statusClass }} py-1 px-2 rounded-pill font-weight-bold shadow-xs">
                                                    <i class="ti {{ $statusIcon }} mr-1"></i> {{ $statusLabel }}
                                                </span>
                                                @if($isTrial)
                                                    <span class="badge bg-info-subtle text-info ml-2 py-1 px-2 rounded-pill font-weight-bold shadow-xs">
                                                        <i class="ti ti-test-pipe mr-1"></i> Trial
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="font-weight-bold text-dark">{{ $a->package->package_name }}</div>
                                            <div class="text-muted small"><i class="ti ti-calendar-event mr-1"></i>{{ ucfirst($a->package->package_billing_cycle) }} Billing</div>
                                        </td>
                                        <td>
                                            <div class="small text-dark font-weight-bold">
                                                {{ \Carbon\Carbon::parse($a->start_date)->format('M d, Y') }}
                                            </div>
                                            <div class="small text-muted">
                                                to {{ \Carbon\Carbon::parse($a->end_date)->format('M d, Y') }}
                                            </div>
                                            <div class="mt-1">
                                                <span class="badge bg-light text-dark border py-1 rounded-pill">
                                                    <i class="ti ti-hourglass mr-1"></i> {{ $daysLeft }} days left
                                                </span>
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            <div class="text-muted small" style="text-decoration: line-through;">{{ number_format($a->package->package_price, 2) }}</div>
                                            <div class="font-weight-bold text-dark fs-5">{{ number_format($a->price_after_discout, 2) }}</div>
                                            @if($a->discount > 0)
                                                <div class="text-success small font-weight-bold">Save {{ $a->discount }}%</div>
                                            @endif
                                        </td>
                                        <td class="px-4" style="min-width: 280px;">
                                            @foreach ($a->features as $f)
                                                @php
                                                    $usage = $a->usage->firstWhere('feature_key', $f->feature_key);
                                                    $used = $usage->used_count ?? 0;
                                                    $limit = $f->limit_value;
                                                    $percent = $limit > 0 ? min(round(($used / $limit) * 100), 100) : 0;
                                                    $barColor = $percent > 90 ? 'bg-danger' : ($percent > 70 ? 'bg-warning' : 'bg-primary');
                                                @endphp
                                                <div class="mb-2">
                                                    <div class="d-flex justify-content-between small mb-1">
                                                        <span class="text-dark font-weight-bold">{{ $f->feature_key }}</span>
                                                        <span class="text-muted">{{ $used }} / {{ $limit }}</span>
                                                    </div>
                                                    <div class="progress shadow-sm" style="height: 6px; border-radius: 10px;">
                                                        <div class="progress-bar {{ $barColor }}" role="progressbar" style="width: {{ $percent }}%" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-icon btn-light border rounded-circle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right shadow border-0 py-2 mt-2">
                                                    @if ($isExpired)
                                                        <form action="{{ route('admin.business_packages.renew') }}" method="POST" class="px-2">
                                                            @csrf
                                                            <input type="hidden" name="business_packages_id" value="{{ \Illuminate\Support\Facades\Crypt::encryptString($a->business_packages_id) }}" />
                                                            <button type="submit" class="dropdown-item rounded-sm py-2">
                                                                <i class="ti ti-refresh mr-2 text-warning"></i> Renew Package
                                                            </button>
                                                        </form>
                                                    @endif

                                                    <form action="{{ route('admin.business_packages.toggle') }}" method="POST" class="px-2">
                                                        @csrf
                                                        <input type="hidden" name="business_packages_id" value="{{ \Illuminate\Support\Facades\Crypt::encryptString($a->business_packages_id) }}" />
                                                        @if ($a->is_active)
                                                            <button type="submit" class="dropdown-item rounded-sm py-2">
                                                                <i class="ti ti-circle-x mr-2 text-danger"></i> Deactivate
                                                            </button>
                                                        @else
                                                            <button type="submit" class="dropdown-item rounded-sm py-2">
                                                                <i class="ti ti-circle-check mr-2 text-success"></i> Activate
                                                            </button>
                                                        @endif
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="text-muted mb-3">
                                                <i class="ti ti-inbox fs-1 opacity-25"></i>
                                            </div>
                                            <h5 class="text-muted font-weight-bold">No Records Found</h5>
                                            <p class="text-muted small">No assigned packages found matching your current filters.</p>
                                            <a href="{{ route('admin.business_packages.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-4">Clear All Filters</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($assigned->count() > 0)
                <div class="card-footer bg-white border-top py-3 px-4">
                    <div class="text-muted small">
                        Showing <span class="font-weight-bold text-dark">{{ $assigned->count() }}</span> total assignment(s)
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .font-weight-bold { font-weight: 600 !important; }
    .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .shadow-sm { box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important; }
    .bg-success-subtle { background-color: rgba(40, 167, 69, 0.1); }
    .bg-danger-subtle { background-color: rgba(220, 53, 69, 0.1); }
    .bg-info-subtle { background-color: rgba(23, 162, 184, 0.1); }
    .bg-secondary-subtle { background-color: rgba(108, 117, 125, 0.1); }
    .text-success { color: #28a745 !important; }
    .text-danger { color: #dc3545 !important; }
    .text-info { color: #17a2b8 !important; }
    .table-hover tbody tr:hover { background-color: rgba(0,0,0,0.01); }
    .btn-icon { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; padding: 0; }
    .dropdown-item:hover { background-color: #f8f9fa; }
    .fs-5 { font-size: 1.15rem; }
    .opacity-75 { opacity: 0.75; }
</style>

@push('scripts')
<script>
    function toggleFilters() {
        const container = document.getElementById('filterContainer');
        const icon = document.getElementById('toggleIcon');
        const text = document.getElementById('toggleText');
        
        if (container.style.display === 'none') {
            container.style.display = 'block';
            icon.classList.replace('ti-chevron-down', 'ti-chevron-up');
            text.textContent = 'Hide Filters';
        } else {
            container.style.display = 'none';
            icon.classList.replace('ti-chevron-up', 'ti-chevron-down');
            text.textContent = 'Show Filters';
        }
    }

    function toggleAdvancedFilters() {
        const advRow = document.getElementById('advancedFiltersRow');
        const text = document.getElementById('advText');
        const icon = document.getElementById('advIcon');
        
        if (advRow.style.display === 'none') {
            advRow.style.display = 'block';
            text.textContent = 'Less Filters';
            icon.classList.replace('ti-adjustments', 'ti-minus');
        } else {
            advRow.style.display = 'none';
            text.textContent = 'More Filters';
            icon.classList.replace('ti-minus', 'ti-adjustments');
        }
    }

    // Auto-expand advanced filters if any are active
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const advancedParams = ['start_date_from', 'start_date_to', 'end_date_from', 'end_date_to', 'discount_min', 'discount_max', 'price_min', 'price_max'];
        
        const hasAdvanced = advancedParams.some(param => urlParams.has(param) && urlParams.get(param) !== '');
        if (hasAdvanced) {
            toggleAdvancedFilters();
        }
    });
</script>
@endpush
@endsection

