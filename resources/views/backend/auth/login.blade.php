<!DOCTYPE html>
<html  lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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

    <!-- Google fonts -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,100..900&display=swap" rel="stylesheet">

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
            <form method="POST" action="{{ route('login') }}" id="login-form">
              @csrf
              <div class="form-group-material">
                <input id="login-username" type="text" name="name" required class="input-material" value="">
                <label for="login-username" class="label-material">UserName</label>
                @if(session()->has('error'))
                    <p>
                        <strong>{{ session()->get('error') }}</strong>
                    </p>
                @endif
              </div>

              <div class="form-group-material">
                <input id="login-password" type="password" name="password" required class="input-material" value="">
                <label for="login-password" class="label-material">Password</label>
                <!-- Eye Icon -->
                <span id="togglePassword" class="position-absolute" style="right: 0; top: 50%; transform: translateY(-50%); cursor: pointer;">
                    <i class="fa fa-eye-slash"></i>
                </span>
                @if(session()->has('error'))
                    <p>
                        <strong>{{ session()->get('error') }}</strong>
                    </p>
                @endif
              </div>
              <button type="submit" class="btn btn-primary btn-block">LogIn</button>
            </form>

            <a href="{{ route('password.request') }}" class="forgot-pass">Forgot Password?</a>
            
            <!-- <p class="register-section">
              Do not have an account?
              <a href="{{url('register')}}" class="signup register-section">Register</a>
            </p> -->

            <div class="row">
              <div class="col-md-12 text-center">
                <div class="" style="font-size:11px;color:#666;margin-bottom:15px">Login as</div>
                <button data-page="back_admin" data-env=".env" class="btn btn-sm btn-success demo-btn">Admin</button>
                <button data-page="back_staff" data-env=".env" class="btn btn-sm btn-info demo-btn">Staff</button>
                <button data-page="back_customer" data-env=".env" class="btn btn-sm btn-dark demo-btn">Customer</button>
              </div>
            </div>
          </div>
      </div>
          <div class="copyrights text-center">
            <p>
                &copy; {{ date('Y') }} <strong>{{ __('Developed') }} {{ __('By') }}</strong> 
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
<script type="text/javascript" src="<?php echo asset('vendor/jquery/jquery.min.js') ?>"></script>

<script>
    // @if(config('database.connections.saleprosaas_landlord'))
    //     if(localStorage.getItem("message")) {
    //         alert(localStorage.getItem("message"));
    //         localStorage.removeItem("message");
    //     }
        numberOfUserAccount = <?php echo json_encode($numberOfUserAccount)?>;
        // $.ajax({
        //     type: 'GET',
        //     async: false,
        //     url: '{{route("package.fetchData", $general_setting->package_id)}}',
        //     success: function(data) {
        //         if(data['number_of_user_account'] > 0 && data['number_of_user_account'] <= numberOfUserAccount) {
        //             $(".register-section").addClass('d-none');
        //         }
        //     }
        // });
    // @endif

    $("div.alert").delay(4000).slideUp(800);

    //switch theme code
    var theme = <?php echo json_encode($theme); ?>;
    if(theme == 'dark') {
        $('body').addClass('dark-mode');
        $('#switch-theme i').addClass('dripicons-brightness-low');
    }
    else {
        $('body').removeClass('dark-mode');
        $('#switch-theme i').addClass('dripicons-brightness-max');
    }

    $('#togglePassword').click(function() {
        var passwordField = $("#login-password"); // Select password input
        var icon = $(this).find("i"); // Select eye icon inside #togglePassword

        if (passwordField.attr("type") === "password") {
            passwordField.attr("type", "text"); // Show password
            icon.removeClass("fa-eye-slash").addClass("fa-eye"); // Change icon
        } else {
            passwordField.attr("type", "password"); // Hide password
            icon.removeClass("fa-eye").addClass("fa-eye-slash"); // Change back icon
        }
    });

    function setEnvCookie(cookieValue) {
        var cookieName = "env_name";
        var expireDays = 1;

        var date = new Date();
        date.setTime(date.getTime() + (expireDays * 24 * 60 * 60 * 1000));
        var expires = "; expires=" + date.toUTCString();

        document.cookie = cookieName + "=" + cookieValue + expires + "; path=/";
    }

    $('.demo-btn').on('click', function(e) {
        e.preventDefault();
        setEnvCookie($(this).data('env'));
        if ($(this).data('env') == '.env.ecom' && $(this).data('page') == 'ecom_front') {
            window.open("{{ url('/') }}", "_blank");
        }
        else {
            if ($(this).data('page') == 'back_staff') {
                $("input[name='name']").focus().val('staff');
                $("input[name='password']").focus().val('staff');
            }
            else if ($(this).data('page') == 'back_customer') {
                $("input[name='name']").focus().val('james');
                $("input[name='password']").focus().val('james');
            }
            else {
                $("input[name='name']").focus().val('admin');
                $("input[name='password']").focus().val('admin');
            }
            let form = $('#login-form');
            form.attr('action', $(this).attr('href'));
            form.submit();
        }
    });

  // ------------------------------------------------------- //
    // Material Inputs
    // ------------------------------------------------------ //

    var materialInputs = $('input.input-material');

    // activate labels for prefilled values
    materialInputs.filter(function() { return $(this).val() !== ""; }).siblings('.label-material').addClass('active');

    // move label on focus
    materialInputs.on('focus', function () {
        $(this).siblings('.label-material').addClass('active');
    });

    // remove/keep label on blur
    materialInputs.on('blur', function () {
        $(this).siblings('.label-material').removeClass('active');

        if ($(this).val() !== '') {
            $(this).siblings('.label-material').addClass('active');
        } else {
            $(this).siblings('.label-material').removeClass('active');
        }
    });
</script>
