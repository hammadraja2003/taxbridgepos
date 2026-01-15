@extends('backend.layout.loginlayout')

@section('content')
<form class="app-form needs-validation" novalidate method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="mb-5 text-center text-lg-start">
                <div class="d-flex justify-content-center align-items-center my-2">
                    <img src="{{ asset('logo/tax-bridgePOS-logo.svg') }}" alt="Logo" class="dark-logo">
                </div>
                <h4 class="text-center mt-3">Forgot Password?</h4>
                <p class="text-center text-muted">Enter your email to reset your password.</p>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email" required class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="Enter Your Email" autofocus>
                @if ($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>
        </div>
        
        @if(session()->has('status'))
            <div class="col-12">
                <div class="alert alert-success">
                    {{ session()->get('status') }}
                </div>
            </div>
        @endif

        <div class="col-12 mt-2">
            <div class="mb-3">
                <button type="submit" role="button" class="btn btn-primary w-100">Send Password Reset Link</button>
            </div>
        </div>
        <div class="col-12 text-center">
            <a href="{{ route('login') }}" class="link-primary">Back to Login</a>
        </div>
    </div>
</form>
@endsection
