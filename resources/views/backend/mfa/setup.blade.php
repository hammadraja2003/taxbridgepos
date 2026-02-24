@extends('backend.layout.main')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fa fa-shield-alt"></i> Two-Factor Authentication</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($twoFactorEnabled)
                        <div class="alert alert-success">
                            <i class="fa fa-check-circle"></i> Two-factor authentication is currently <strong>enabled</strong> for your account.
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Recovery Codes</h5>
                                        <p class="card-text">View or regenerate your recovery codes.</p>
                                        <a href="{{ route('mfa.recovery-codes') }}" class="btn btn-info">
                                            <i class="fa fa-key"></i> View Recovery Codes
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Disable 2FA</h5>
                                        <p class="card-text">Turn off two-factor authentication.</p>
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#disableModal">
                                            <i class="fa fa-times-circle"></i> Disable 2FA
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fa fa-exclamation-triangle"></i> Two-factor authentication is currently <strong>disabled</strong> for your account.
                        </div>

                        <div class="mt-4">
                            <h5>Why enable Two-Factor Authentication?</h5>
                            <ul>
                                <li>Adds an extra layer of security to your account</li>
                                <li>Protects against unauthorized access even if your password is compromised</li>
                                <li>Works with Google Authenticator, Microsoft Authenticator, or any TOTP app</li>
                            </ul>

                            <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#enableModal">
                                <i class="fa fa-shield-alt"></i> Enable Two-Factor Authentication
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enable 2FA Modal -->
<div class="modal fade" id="enableModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('mfa.enable') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Enable Two-Factor Authentication</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Please confirm your password to continue.</p>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required autofocus>
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Continue</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Disable 2FA Modal -->
<div class="modal fade" id="disableModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('mfa.disable') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Disable Two-Factor Authentication</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <strong>Warning!</strong> Disabling 2FA will make your account less secure.
                    </div>
                    <p>Please confirm your password to continue.</p>
                    <div class="form-group">
                        <label for="disable_password">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="disable_password" name="password" required>
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Disable 2FA</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    @if($errors->has('password'))
        @if(old('_token') && request()->route()->getName() === 'mfa.enable')
            $('#enableModal').modal('show');
        @elseif(old('_token') && request()->route()->getName() === 'mfa.disable')
            $('#disableModal').modal('show');
        @endif
    @endif
</script>
@endpush
@endsection