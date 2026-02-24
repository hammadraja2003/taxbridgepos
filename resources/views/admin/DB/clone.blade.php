@extends('admin.layouts.adminlayout')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 py-4">
                <!-- Header Section -->
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="font-weight-bold mb-1 text-dark">Database Utility</h4>
                        <p class="text-muted small mb-0">Clone database schemas and triggers for new tenant provisioning.</p>
                    </div>
                    <a href="{{ route('admin.businesses.index') }}" class="btn btn-outline-secondary btn-xs rounded-pill px-3">
                        <i class="ti ti-arrow-left mr-1"></i> Back to Businesses
                    </a>
                </div>
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="card shadow-sm border-0 overflow-hidden">
                            <div class="bg-primary-transparent px-4 py-3 border-bottom d-flex align-items-center">
                                <div class="bg-primary text-white rounded p-2 mr-3">
                                    <i class="ti ti-database-import fs-4"></i>
                                </div>
                                <h6 class="m-0 font-weight-bold text-dark">Clone Existing Database</h6>
                            </div>

                            <div class="card-body p-4">
                                <form class="app-form needs-validation" action="{{ route('admin.db.clone') }}" method="POST" novalidate>
                                    @csrf

                                    <!-- Row 1: Source DB & Target DB -->
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label font-weight-bold text-muted small text-uppercase mb-2">
                                                <i class="ti ti-database mr-1 text-primary"></i> Source Database <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group shadow-xs rounded">
                                                <span class="input-group-text bg-white border-right-0">
                                                    <i class="ti ti-search text-muted"></i>
                                                </span>
                                                <select name="source_db" class="form-control border-left-0 @error('source_db') is-invalid @enderror" required>
                                                    <option value="">-- Choose existing database --</option>
                                                    @foreach ($databases as $db)
                                                        <option value="{{ $db }}" {{ old('source_db') == $db ? 'selected' : '' }}>
                                                            {{ $db }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label font-weight-bold text-muted small text-uppercase mb-2">
                                                <i class="ti ti-edit mr-1 text-primary"></i> New Database Name <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group shadow-xs rounded">
                                                <span class="input-group-text bg-white border-right-0">
                                                    <i class="ti ti-tag text-muted"></i>
                                                </span>
                                                <input type="text" name="new_db"
                                                    class="form-control border-left-0 @error('new_db') is-invalid @enderror"
                                                    placeholder="e.g. client_db_name"
                                                    value="{{ old('new_db') }}"
                                                    pattern="^[a-zA-Z0-9_]+$"
                                                    required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Row 2: DB Username & Password -->
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label font-weight-bold text-muted small text-uppercase mb-2">
                                                <i class="ti ti-user mr-1 text-primary"></i> Database Username <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group shadow-xs rounded">
                                                <span class="input-group-text bg-white border-right-0">
                                                    <i class="ti ti-user text-muted"></i>
                                                </span>
                                                <input type="text" name="db_username"
                                                    class="form-control border-left-0 @error('db_username') is-invalid @enderror"
                                                    placeholder="DB User Name"
                                                    value="{{ old('db_username') }}"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label font-weight-bold text-muted small text-uppercase mb-2">
                                                <i class="ti ti-key mr-1 text-primary"></i> Database Password
                                            </label>
                                            <div class="input-group shadow-xs rounded">
                                                <span class="input-group-text bg-white border-right-0">
                                                    <i class="ti ti-lock text-muted"></i>
                                                </span>
                                                <input type="password" name="db_password"
                                                    class="form-control border-left-0 @error('db_password') is-invalid @enderror"
                                                    placeholder="DB password">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Info Box -->
                                    <div class="bg-light rounded p-3 mb-4 border-left border-primary shadow-xs">
                                        <div class="d-flex">
                                            <i class="ti ti-info-circle text-primary mr-2 fs-5"></i>
                                            <div class="small text-muted">
                                                This utility clones <strong>table structures</strong> and <strong>triggers</strong> only. Business data and records will NOT be copied.
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="text-center pt-2">
                                        <button type="submit" class="btn btn-primary rounded-pill px-5 shadow-sm btn-lg block-on-click">
                                            <i class="ti ti-copy mr-1"></i> Start Cloning Process
                                        </button>
                                        <div id="loader-msg" class="mt-3 small text-primary font-weight-bold" style="display:none;">
                                            <i class="ti ti-loader-2 rotate-anim mr-2"></i> Initializing Clone... This may take a moment.
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

<style>
    .font-weight-600 { font-weight: 600; }
    .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .btn-xs { padding: 4px 12px; font-size: 11px; }
    .bg-primary-transparent { background-color: rgba(78, 115, 223, 0.05); }
    .input-group-text { border-color: #dee2e6; }
    .form-control::placeholder { color: #9ca3af; font-size: 0.9rem; }
    .rotate-anim { animation: spin 1.5s linear infinite; }
    @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    .btn-lg { font-size: 1rem; font-weight: 600; }
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form Validation
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                } else {
                    // Show loader on successful validation
                    const btn = form.querySelector('.block-on-click');
                    if(btn) {
                        btn.disabled = true;
                        btn.innerHTML = '<i class="ti ti-loader-2 rotate-anim mr-1"></i> Cloning...';
                        document.getElementById('loader-msg').style.display = 'block';
                    }
                }
                form.classList.add('was-validated');
            }, false);
        });
    });
</script>
@endpush
@endsection
