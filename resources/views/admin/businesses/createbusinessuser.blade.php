@extends('admin.layouts.adminlayout')

@section('content')
<div class="container-fluid">
    <div class="row ">
        <div class="col-lg-12 py-4">
            <!-- Header Section -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="font-weight-bold mb-1 text-dark">Add New Team Member</h4>
                    <p class="text-muted small mb-0">Create a new administrative user for this business.</p>
                </div>
                <button type="button" onclick="history.back()" class="btn btn-outline-secondary btn-xs rounded-pill px-3">
                    <i class="ti ti-arrow-left mr-1"></i> Back
                </button>
            </div>

            <div class="card shadow-sm border-0 overflow-hidden">
                <div class="card-body p-0">
                    <div class="bg-light px-4 py-3 border-bottom">
                        <h6 class="m-0 font-weight-bold text-dark"><i class="ti ti-user-plus mr-2 text-primary"></i>User Account Details</h6>
                    </div>
                    
                    <form class="app-form needs-validation p-4" novalidate action="{{ route('admin.businesses.register') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Hidden input for $id -->
                        <input type="hidden" name="id" value="{{ $id ?? '' }}">

                        <div class="row g-4">
                            <!-- Full Name -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Full Name <span class="text-danger">*</span></label>
                                <div class="input-group shadow-xs rounded">
                                    <span class="input-group-text bg-white border-right-0"><i class="ti ti-user text-muted"></i></span>
                                    <input type="text" name="name"
                                        class="form-control border-left-0 @error('name') is-invalid @enderror"
                                        value="{{ old('name', $user->name ?? '') }}" required
                                        placeholder="e.g. John Doe">
                                    <div class="invalid-feedback">
                                        @error('name') {{ $message }} @else Please enter a name. @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Email Address -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Email Address <span class="text-danger">*</span></label>
                                <div class="input-group shadow-xs rounded">
                                    <span class="input-group-text bg-white border-right-0"><i class="ti ti-mail text-muted"></i></span>
                                    <input type="email" name="email"
                                        class="form-control border-left-0 @error('email') is-invalid @enderror"
                                        value="{{ old('email', $user->email ?? '') }}" required
                                        placeholder="john@example.com">
                                    <div class="invalid-feedback">
                                        @error('email') {{ $message }} @else Please enter a valid email. @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Password <span class="text-danger">*</span></label>
                                <div class="input-group shadow-xs rounded">
                                    <span class="input-group-text bg-white border-right-0"><i class="ti ti-lock text-muted"></i></span>
                                    <input type="password" id="password" name="password"
                                        class="form-control border-left-0 border-right-0 @error('password') is-invalid @enderror"
                                        placeholder="Min. 8 characters" required>
                                    <span class="input-group-text bg-white border-left-0 toggle-password" data-target="password" style="cursor:pointer;">
                                        <i class="ti ti-eye"></i>
                                    </span>
                                    <div class="invalid-feedback">
                                        @error('password') {{ $message }} @else Please enter a password. @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold text-muted small text-uppercase">Confirm Password <span class="text-danger">*</span></label>
                                <div class="input-group shadow-xs rounded">
                                    <span class="input-group-text bg-white border-right-0"><i class="ti ti-lock-check text-muted"></i></span>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="form-control border-left-0 border-right-0" placeholder="Re-type password" required>
                                    <span class="input-group-text bg-white border-left-0 toggle-password" data-target="password_confirmation" style="cursor:pointer;">
                                        <i class="ti ti-eye"></i>
                                    </span>
                                    <div class="invalid-feedback">
                                        Passwords do not match.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 border-top pt-4 text-end">
                            <button type="reset" class="btn btn-light rounded-pill px-4 mr-2">Reset Form</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-5 shadow-sm">
                                <i class="ti ti-user-plus mr-1"></i> Create User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <p class="text-muted small">Need help? <a href="#" class="text-primary font-weight-bold">View User Management Guide</a></p>
            </div>
        </div>
    </div>
</div>

<style>
    .font-weight-600 { font-weight: 600; }
    .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .btn-xs { padding: 4px 12px; font-size: 11px; }
    .input-group-text { border-color: #dee2e6; }
    .form-control::placeholder { color: #9ca3af; font-size: 0.9rem; }
    .card-header { letter-spacing: 0.025em; }
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
                }
                form.classList.add('was-validated');
            }, false);
        });

        // Toggle Password Visibility
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = this.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.replace('ti-eye', 'ti-eye-off');
                } else {
                    input.type = 'password';
                    icon.classList.replace('ti-eye-off', 'ti-eye');
                }
            });
        });
    });
</script>
@endpush
@endsection
