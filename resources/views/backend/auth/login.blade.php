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
    <link rel="stylesheet" href="<?php echo asset('vendor/bootstrap/css/bootstrap.min.css') ?>" type="text/css">
    <link rel="preload" href="<?php echo asset('vendor/font-awesome/css/font-awesome.min.css') ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="<?php echo asset('vendor/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet"></noscript>
    <link rel="stylesheet" href="<?php echo asset('css/auth.css') ?>" id="theme-stylesheet" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,100..900&display=swap" rel="stylesheet">

    <style>
      body {
    font-size: var(--font-size);
    font-family: Poppins, sans-serif;
    color: var(--font-color);
}
.btn {
    padding: 7px 25px;
    font-size: var(--btn-font-size);
    border-radius: 5px;
}
::selection {
    background: rgba(var(--primary), 1);
    color: var(--white);
}
.w-100 {
    width: 100% !important;
}
.btn-primary {
    background-color: #0fbc66;
    border: 1px solid #0fbc66;
}
.image-contentbox {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    /* background-color: rgba(var(--primary), 0.1); */
}
.form-container {
    min-height: 100vh;
    height: 100%;
    padding: calc(16px + 32 * (100vw - 300px) / 1620);
    display: flex;
    align-items: center;
    justify-content: center;
}
:root {
    --primary-gradient: linear-gradient(
        50deg,
        rgba(var(--primary), 1) 30%,
        rgba(var(--success), 1) 50%,
        rgba(var(--primary), 1) 100%
    );
    --secondary-gradient: linear-gradient(
        50deg,
        rgba(var(--primary), 1) 30%,
        rgba(var(--danger), 1) 50%,
        rgba(var(--primary), 1) 100%
    );
    --dark-gradient: linear-gradient(
        50deg,
        rgba(var(--primary), 1) 30%,
        rgba(var(--dark), 1) 50%,
        rgba(var(--primary), 1) 100%
    );
    --body-bg-gradient: linear-gradient(
        50deg,
        rgba(var(--primary), 0.08) 30%,
        rgba(var(--success), 0.08) 50%,
        rgba(var(--primary), 0.08) 100%
    );
}
:root {
    --font-color: #15264b;
    --font-title-color: #1c3264;
    --body-color: #f9f9f9;
    --bodybg-color: #f5f6fa;
    --font-secondary-color: #22242c;
    --font-light-color: #a0a0b0;
    --grid_color: rgba(144, 164, 246, 0.21);
    --border_color: rgba(0, 0, 0, 0.21);
    --primary: 5, 100, 100;
    --secondary: 116, 120, 141;
    --success: 15, 180, 80;
    --danger: 234, 86, 89;
    --warning: 250, 193, 15;
    --info: 60, 145, 243;
    --light: 172, 184, 200;
    --dark: 35, 25, 40;
    --border_color: #ebedf0;
    --bs-dropdown-link-active-color: rgba(var(--primary), 1);
    --bs-dropdown-link-active-bg: rgba(var(--primary), 0.2);
    --facebook: 59, 89, 152;
    --twitter: 85, 172, 238;
    --pinterest: 189, 8, 28;
    --linkedin: 0, 119, 181;
    --reddit: 255, 69, 0;
    --whatsapp: 67, 216, 84;
    --gmail: 234, 67, 53;
    --telegram: 0, 64, 93;
    --youtube: 205, 32, 31;
    --vimeo: 26, 183, 234;
    --behance: 23, 105, 255;
    --github: 0, 64, 93;
    --skype: 0, 175, 240;
    --snapchat: 255, 250, 55;
    --box-shadow: 0 0.2rem 1.2rem var(--light-gray);
    --hover-shadow: 0 0.5rem 2rem var(--light-gray);
    --app-transition: all 0.3s ease;
    --light-gray: #eeeeee;
    --white: #ffffff;
    --p-line-height: 1.6;
    --link-color: var(--primary-color);
    --font-size: 14px;
    --p-font-size: 14px;
    --h1-font-size: 2.5rem;
    --h2-font-size: 2rem;
    --h3-font-size: 1.75rem;
    --h4-font-size: 1.25rem;
    --h5-font-size: 1.125rem;
    --h6-font-size: 1rem;
    --btn-font-size: 15px;
    --bs-border-radius: 0.5rem;
    --bs-accordion-inner-border-radius: 0.5rem;
}
.text-secureism {
    color: #0fbc66;
}
footer .d-flex.flex-column {
    display: flex !important;
    flex-direction: row !important;
    flex-wrap: nowrap;
    align-items: center;
    justify-content: space-between;
    padding: 0px 20px;
}
footer.text-center .small.mt-1 {
    margin: 0px !important;
    color: #000 !important;
}

footer.text-center .small.mt-1 .text-primary {
    color: #056464 !important;
}
.privacypolicy h1.mb-4.text-center {
    color: #146c43;
    font-weight: 600;
    margin: 5px !important;
}

.image-contentbox {
    background-color: #5579a4;
}
.img-fluid {
    filter: drop-shadow(2px 4px 6px black);
}

.required::after {
    content: " *";
    color: red;
}

@media (min-width: 1200px) {
    .card-body {
        min-height: 520px;
        /* adjust karein apne content ke hisaab se */
    }
}

@media (min-width: 1200px) {
    .card {
        min-height: 620px;
    }
}

.step-nav .nav-link {
    background: #fff;
    border: 1px solid #1d61d8;
    border-radius: 8px;
    padding: 20px 15px;
    font-weight: 500;
    color: #495057;
    transition: all 0.3s ease;
    text-align: left;
}

.step-nav .nav-link .icon-circle {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: #f1f3f5;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    color: #1d61d8;
}

.step-nav .nav-link.active {
    background: #1d61d8;
    color: #fff;
    border-color: #1d61d8;
}

.step-nav .nav-link.active .icon-circle {
    background: #fff;
    color: #1d61d8;
}

.step-nav .nav-link:hover:not(.active) {
    background: #e9f2ff;
    border-color: #1d61d8;
    color: #1d61d8;
}

      </style>

  </head>
  <body>
    <!-- <div class="page login-page">
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
    </div> -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-7 col-xl-8 d-none d-lg-block p-0">
                <div class="image-contentbox">
                    <img src="{{ asset('logo/01.png') }}" class="img-fluid" alt="">
                </div>
            </div>
            <div class="col-lg-5 col-xl-4 p-0 bg-white">
                <div class="form-container">
                    <form class="app-form needs-validation" novalidate method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-5 text-center text-lg-start">
                                    <div class="d-flex justify-content-center align-items-center my-2">
                                        <img src="{{ asset('logo/tax-bridgePOS-logo.svg') }}"  alt="Logo" class="dark-logo">

                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Email</label>
                                    <input class="form-control" required type="email" placeholder="Enter Your Email"
                                        name="name" value="{{ old('name') }}" autofocus autocomplete="name" />
                                    <div class="invalid-feedback">
                                        Please enter your email.
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <a href="{{ route('password.request') }}" class="link-primary float-end">Forgot Password?</a>
                                    <div class="input-group">
                                        <input type="password" name="password" required class="form-control"
                                            placeholder="Enter Your Password" id="password">
                                        <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                            <i class="ti ti-eye"></i>
                                        </span>
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter your password.
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif
                        <div class="col-12 mt-2">
                            <div class="mb-3">
                                <button type="submit" role="button" class="btn btn-primary w-100">Sign In</button>
                            </div>
                        </div>
                         <div class="row">
              <div class="col-md-12 text-center">
                <div class="" style="font-size:11px;color:#666;margin-bottom:15px">Login as</div>
                <button data-page="back_admin" data-env=".env" class="btn btn-sm btn-success demo-btn">Admin</button>
                <button data-page="back_staff" data-env=".env" class="btn btn-sm btn-info demo-btn">Staff</button>
                <button data-page="back_customer" data-env=".env" class="btn btn-sm btn-dark demo-btn">Customer</button>
              </div>
            </div>
                </div>
                </form>
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
  </body>
</html>
<script type="text/javascript" src="<?php echo asset('vendor/jquery/jquery.min.js') ?>"></script>

<script>

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
