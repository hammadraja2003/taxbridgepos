@extends('backend.layout.loginlayout')

@section('content')
<form class="app-form needs-validation" novalidate method="POST" action="{{ route('mfa.verify.post') }}" id="mfa-verify-form">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="mb-4 text-center">
                <div class="d-flex justify-content-center align-items-center my-3">
                    <img src="{{ env('PUB_PATH') . '/logo/LOGO-SalesBridge-01.png' }}" alt="Logo" class="dark-logo" style="width: 100% !important; height: auto !important;">
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="text-center mb-4">
                <div class="mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10 p-3 mb-3" style="width: 70px; height: 70px;">
                        <i class="fa fa-shield-alt fa-2x text-primary"></i>
                    </div>
                </div>
                <h4 class="mb-2">Two-Factor Authentication</h4>
                <p class="text-muted mb-0">Enter the 6-digit code from your authenticator app</p>
            </div>
        </div>

        <div class="col-12">
            <div class="mb-3">
                <label for="code" class="form-label">Verification Code</label>
                <input type="text" 
                       class="form-control form-control-lg text-center @error('code') is-invalid @enderror" 
                       id="code" 
                       name="code" 
                       maxlength="10" 
                       placeholder="000000"
                       style="font-size: 28px; letter-spacing: 8px; font-family: 'Courier New', monospace; font-weight: bold;"
                       required 
                       autofocus>
                @error('code')
                    <div class="invalid-feedback d-block text-center">
                        <i class="fa fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
                <small class="form-text text-muted text-center d-block mt-2">
                    <i class="fa fa-info-circle"></i> Or enter a 10-character recovery code
                </small>
            </div>
        </div>

        <div class="col-12 mt-3">
            <div class="mb-3">
                <button type="submit" class="btn btn-primary w-100 btn-lg">
                    <i class="fa fa-check-circle"></i> Verify & Continue
                </button>
            </div>
        </div>

        <div class="col-12">
            <div class="text-center">
                <hr class="my-3">
                <a href="{{ route('logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="text-decoration-none text-muted">
                    <i class="fa fa-arrow-left"></i> Back to Login
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>

        <!-- Help Section -->
        <div class="col-12 mt-4">
            <div class="alert alert-info border-0 shadow-sm">
                <div class="d-flex align-items-start">
                    <i class="fa fa-lightbulb-o fa-lg me-2 mt-1"></i>
                    <div>
                        <strong>Need Help?</strong>
                        <ul class="mb-0 mt-2 small">
                            <li>Open your authenticator app (Google/Microsoft Authenticator)</li>
                            <li>Find the 6-digit code for {{ config('app.name') }}</li>
                            <li>Enter the code above and click Verify</li>
                            <li>Lost your phone? Use a recovery code instead</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<style>
    /* Custom styling for 2FA page */
    #code {
        background: linear-gradient(to bottom, #f8f9fa 0%, #ffffff 100%);
        border: 2px solid #dee2e6;
        transition: all 0.3s ease;
    }
    
    #code:focus {
        border-color: #0fbc66;
        box-shadow: 0 0 0 0.2rem rgba(15, 188, 102, 0.25);
        background: #ffffff;
    }

    .bg-primary.bg-opacity-10 {
        background-color: rgba(15, 188, 102, 0.1) !important;
    }

    .alert-info {
        background-color: #e7f3ff;
        color: #004085;
    }

    /* Pulse animation for shield icon */
    @keyframes pulse {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
        100% {
            transform: scale(1);
        }
    }

    .fa-shield-alt {
        animation: pulse 2s infinite;
    }

    /* Loading state for button */
    .btn-primary:active {
        transform: scale(0.98);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const codeInput = document.getElementById('code');
        const form = document.getElementById('mfa-verify-form');
        
        // Auto-submit when code is complete
        codeInput.addEventListener('input', function(e) {
            // Remove non-alphanumeric characters and convert to uppercase
            this.value = this.value.replace(/[^0-9A-Z]/gi, '').toUpperCase();
            
            // Auto-submit when 6 digits or 10 characters entered
            if (this.value.length === 6 || this.value.length === 10) {
                // Add a small delay for better UX
                setTimeout(function() {
                    form.submit();
                }, 300);
            }
        });

        // Prevent form submission if code is not valid length
        form.addEventListener('submit', function(e) {
            const codeLength = codeInput.value.length;
            if (codeLength !== 6 && codeLength !== 10) {
                e.preventDefault();
                codeInput.classList.add('is-invalid');
                
                // Create or update error message
                let errorDiv = codeInput.nextElementSibling;
                if (!errorDiv || !errorDiv.classList.contains('invalid-feedback')) {
                    errorDiv = document.createElement('div');
                    errorDiv.className = 'invalid-feedback d-block text-center';
                    codeInput.parentNode.insertBefore(errorDiv, codeInput.nextSibling);
                }
                errorDiv.innerHTML = '<i class="fa fa-exclamation-circle"></i> Please enter a valid 6-digit code or 10-character recovery code';
            }
        });

        // Remove error state on input
        codeInput.addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });

        // Focus on input when page loads
        codeInput.focus();
    });
</script>
@endsection