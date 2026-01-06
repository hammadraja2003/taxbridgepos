<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name', 'TaxBridgePOS') }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <link rel="manifest" href="{{url('manifest.json')}}">
    <link rel="icon" href="{{ asset('logo/favicon.ico') }}" type="image/x-icon">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="<?php echo asset('vendor/bootstrap/css/bootstrap.min.css') ?>" type="text/css">
    <!-- Font Awesome CSS-->
    <link rel="preload" href="<?php echo asset('vendor/font-awesome/css/font-awesome.min.css') ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="<?php echo asset('vendor/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet"></noscript>
    <!-- login stylesheet-->
    <link rel="stylesheet" href="<?php echo asset('css/auth.css') ?>" id="theme-stylesheet" type="text/css">
    <!-- Google fonts - Roboto -->
    <link rel="preload" href="https://fonts.googleapis.com/css?family=Nunito:400,500,700" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="https://fonts.googleapis.com/css?family=Nunito:400,500,700" rel="stylesheet"></noscript>
    
  </head>
  <body>
    <div class="page login-page">
      <div class="container">
        <div class="form-outer text-center d-flex align-items-center">
          <div class="form-inner">
            <div class="logo">
                <img src="{{ asset('logo/tax-bridgePOS-logo.svg') }}" width="110">
            </div>
            @if(session()->has('delete_message'))
            <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('delete_message') }}</div>
            @endif
            @if(session()->has('message'))
              <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{!! session()->get('message') !!}</div>
            @endif
            @if(session()->has('not_permitted'))
              <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
            @endif

                <form method="POST" action="{{ route('password.email') }}" class="" id="login-form">
                    @csrf

                    <div class="form-group-material">
                        <input id="email" type="email" name="email" required class="input-material form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}">
                        <label for="login-username" class="label-material"> Email</label>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <!-- <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div> -->

                    <button type="submit" class="btn btn-primary"> Submit</button>
                </form>
            <!-- <p class="register-section">
              Do not have an account?
              <a href="{{url('register')}}" class="signup register-section">Register</a>
            </p> -->
          </div>
          <div class="copyrights text-center">
           <p>
                &copy; {{ date('Y') }} <strong>Developed By</strong> 
                <a href="https://taxbridge.pk/" target="_blank" class="external">
                    TaxBridge
                </a>. 
                All rights reserved.  | V {{env('VERSION') }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
