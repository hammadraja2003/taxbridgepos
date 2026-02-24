@extends('backend.layout.main')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fa fa-qrcode"></i> Scan QR Code</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <h5>Step 1: Scan QR Code</h5>
                            <p>Scan this QR code with your authenticator app:</p>
                            <div class="qr-code-container mb-3">
                                {!! $qrCode !!}
                            </div>
                            <p class="text-muted small">
                                Use Google Authenticator, Microsoft Authenticator, or any TOTP app
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h5>Step 2: Enter Verification Code</h5>
                            <p>Enter the 6-digit code from your authenticator app:</p>
                            
                            <form method="POST" action="{{ route('mfa.confirm') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="code">Verification Code</label>
                                    <input type="text" 
                                           class="form-control form-control-lg text-center @error('code') is-invalid @enderror" 
                                           id="code" 
                                           name="code" 
                                           maxlength="6" 
                                           pattern="[0-9]{6}" 
                                           placeholder="000000"
                                           required 
                                           autofocus>
                                    @error('code')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fa fa-check"></i> Verify and Enable
                                </button>
                            </form>

                            <hr>
                            <div class="alert alert-info">
                                <strong>Manual Entry:</strong><br>
                                If you can't scan the QR code, enter this key manually:<br>
                                <code class="text-dark">{{ $secret }}</code>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .qr-code-container svg {
        max-width: 200px;
        height: auto;
    }
    #code {
        font-size: 24px;
        letter-spacing: 5px;
        font-family: monospace;
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-submit when 6 digits entered
    document.getElementById('code').addEventListener('input', function(e) {
        if (this.value.length === 6) {
            this.form.submit();
        }
    });
</script>
@endpush
@endsection