@extends('backend.layout.loginlayout')

@section('content')
<form class="app-form needs-validation" novalidate method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <div class="row">
        <div class="col-12">
            <div class="mb-5 text-center text-lg-start">
                <div class="d-flex justify-content-center align-items-center my-2">
                    <img src="{{ asset('logo/tax-bridgePOS-logo.svg') }}" alt="Logo" class="dark-logo">
                </div>
                <h4 class="text-center mt-3">Reset Password</h4>
                <p class="text-center text-muted">Create a new password for your account.</p>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email" required class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ $email ?? old('email') }}" placeholder="Enter Your Email" autofocus>
                @if ($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>
        </div>
        
        <div class="col-12 mt-2">
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" name="password" required class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Enter New Password">
                @if ($errors->has('password'))
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="col-12 mt-2">
            <div class="mb-3">
                <label for="password-confirm" class="form-label">Confirm Password</label>
                <input id="password-confirm" type="password" name="password_confirmation" required class="form-control" placeholder="Confirm New Password">
            </div>
        </div>

        <div class="col-12 mt-2">
            <div class="mb-3">
                <button type="submit" role="button" class="btn btn-primary w-100">Reset Password</button>
            </div>
        </div>
        <div class="col-12 text-center">
            <a href="{{ route('login') }}" class="link-primary">Back to Login</a>
        </div>
    </div>
</form>
@endsection
