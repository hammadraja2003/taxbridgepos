@extends('admin.layouts.adminlayout')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header Section -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="font-weight-bold mb-1 text-dark">Package Management</h4>
                    <p class="text-muted small mb-0">Manage your business subscription packages and features.</p>
                </div>
                <a href="{{ route('admin.packages.create') }}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
                    <i class="ti ti-plus mr-1"></i> Create New Package
                </a>
            </div>



            <div class="card shadow-sm border-0 overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="px-4 py-3 text-uppercase text-muted font-weight-bold small border-0">Package Name</th>
                                    <th class="px-4 py-3 text-uppercase text-muted font-weight-bold small border-0">Price</th>
                                    <th class="px-4 py-3 text-uppercase text-muted font-weight-bold small border-0">Billing Cycle</th>
                                    <th class="px-4 py-3 text-uppercase text-muted font-weight-bold small border-0">Features</th>
                                    <th class="px-4 py-3 text-uppercase text-muted font-weight-bold small text-end border-0">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($packages as $package)
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm rounded-circle bg-primary-subtle text-primary mr-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                <i class="ti ti-package"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-dark font-weight-bold">{{ $package->package_name }}</h6>
                                                @if($package->package_description)
                                                    <small class="text-muted">{{ Str::limit($package->package_description, 40) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <h6 class="mb-0 font-weight-bold text-dark">{{ number_format($package->package_price, 2) }}</h6>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge rounded-pill bg-light text-dark border">
                                            {{ ucfirst($package->package_billing_cycle) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="d-flex flex-wrap gap-1 align-items-center">
                                            @php
                                                $visibleCount = 3;
                                                $totalFeatures = $package->features->count();
                                            @endphp
                                            
                                            @foreach ($package->features->take($visibleCount) as $f)
                                                <span class="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle px-2 py-1" style="font-size: 0.7rem; font-weight: 500;">
                                                    {{ ucwords(str_replace('_', ' ', $f->feature_key)) }}
                                                </span>
                                            @endforeach
                                            
                                            @if($totalFeatures > $visibleCount)
                                                <span class="badge rounded-pill bg-info-subtle text-info border border-info-subtle px-2 py-1 position-relative feature-more-badge" 
                                                      style="font-size: 0.7rem; font-weight: 500; cursor: pointer;"
                                                      data-bs-toggle="tooltip" 
                                                      data-bs-html="true"
                                                      data-bs-placement="top"
                                                      title="@foreach($package->features->skip($visibleCount) as $feature)<span class='d-block'>• {{ ucwords(str_replace('_', ' ', $feature->feature_key)) }}</span>@endforeach">
                                                    <i class="ti ti-dots" style="font-size: 0.65rem;"></i> +{{ $totalFeatures - $visibleCount }} more
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-end">
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.packages.edit', encrypt($package->package_id)) }}" class="btn btn-icon btn-light btn-sm rounded-circle shadow-sm" data-bs-toggle="tooltip" title="Edit Package">
                                                <i class="ti ti-edit text-warning"></i>
                                            </a>
                                            <form action="{{ route('admin.packages.destroy', encrypt($package->package_id)) }}" method="POST" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-icon btn-light btn-sm rounded-circle shadow-sm" onclick="return confirm('Are you sure you want to delete this package? This action cannot be undone.')" data-bs-toggle="tooltip" title="Delete Package">
                                                    <i class="ti ti-trash text-danger"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <div class="mb-3 p-3 bg-light rounded-circle">
                                                <i class="ti ti-package-off text-muted display-6"></i>
                                            </div>
                                            <h6 class="text-muted font-weight-bold">No packages found</h6>
                                            <p class="text-muted small mb-3">Get started by creating your first subscription package.</p>
                                            <a href="{{ route('admin.packages.create') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                                                <i class="ti ti-plus mr-1"></i> Add Package
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($packages->hasPages())
                <div class="card-footer bg-white border-top py-3">
                    {{ $packages->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-subtle { background-color: rgba(13, 110, 253, 0.1) !important; }
    .text-primary-subtle { color: rgba(13, 110, 253, 0.8) !important; }
    .border-primary-subtle { border-color: rgba(13, 110, 253, 0.2) !important; }
    .bg-info-subtle { background-color: rgba(13, 202, 240, 0.1) !important; }
    .text-info-subtle { color: rgba(13, 202, 240, 0.9) !important; }
    .border-info-subtle { border-color: rgba(13, 202, 240, 0.25) !important; }
    .btn-icon { width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center; }
    .avatar-sm { width: 32px; height: 32px; font-size: 14px; }
    .font-weight-bold { font-weight: 600 !important; }
    .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .gap-1 { gap: 0.25rem !important; }
    .gap-2 { gap: 0.5rem !important; }
    .feature-more-badge {
        transition: background-color 0.2s ease, border-color 0.2s ease;
    }
    .feature-more-badge:hover {
        background-color: rgba(13, 202, 240, 0.18) !important;
        border-color: rgba(13, 202, 240, 0.35) !important;
    }
    .tooltip-inner {
        text-align: left !important;
        max-width: 300px !important;
        padding: 0.5rem 0.75rem !important;
    }
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Bootstrap tooltips with improved settings
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                html: true,
                trigger: 'hover',
                delay: { show: 200, hide: 100 },
                boundary: 'window'
            });
        });
    });
</script>
@endpush
@endsection
