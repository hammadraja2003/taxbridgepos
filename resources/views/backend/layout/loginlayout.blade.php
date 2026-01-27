<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name', 'TaxBridgePOS') }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <link rel="icon" href="{{ asset('logo/favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo env('ASSETS_PATH') . '/bootstrap/css/bootstrap.min.css'; ?>" type="text/css">
    <link rel="preload" href="<?php echo env('ASSETS_PATH') . '/font-awesome/css/font-awesome.min.css'; ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="<?php echo env('ASSETS_PATH') . '/font-awesome/css/font-awesome.min.css'; ?>" rel="stylesheet"></noscript>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/jquery/jquery.min.js'; ?>"></script>
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
        .image-contentbox {
            background-color: #5579a4;
        }
        .img-fluid {
            filter: drop-shadow(2px 4px 6px black);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-7 col-xl-8 d-none d-lg-block p-0">
                <div class="image-contentbox">
                    <img src="{{ asset('logo/01.png') }}" class="img-fluid" alt="">
                </div>
            </div>
            <div class="col-lg-5 col-xl-4 p-0 bg-white">
                <div class="form-container">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    
    <footer class="text-center py-2 border-top">
    <div class="d-flex flex-column align-items-center small text-muted">
        <span>
            &copy; {{ date('Y') }} <strong>Secured by</strong> 
            <a href="https://secureism.com/" target="_blank" class="text-decoration-none fw-semibold text-dark">
                SECUREISM
            </a>. 
            All rights reserved.
        </span>

        <div class="mt-1">
            <a href="https://secureism.com/privacy-policy" target="_blank" class="text-decoration-none text-primary me-2">
                Privacy Policy
            </a>
            <span class="text-muted">|</span>
            <a href="https://taxbridge.pk/terms-of-use/" target="_blank" class="text-decoration-none text-primary ms-2">
                Terms & Conditions
            </a>
        </div>
    </div>
</footer>
<script>
    $("div.alert").delay(4000).slideUp(800);

    //switch theme code
    var theme = <?php echo json_encode(isset($theme) ? $theme : ''); ?>;
    if(theme == 'dark') {
        $('body').addClass('dark-mode');
        $('#switch-theme i').addClass('dripicons-brightness-low');
    }
    else {
        $('body').removeClass('dark-mode');
        $('#switch-theme i').addClass('dripicons-brightness-max');
    }

    $('#togglePassword').click(function() {
        var passwordField = $("#password"); // Select password input
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

    // Material Inputs
    var materialInputs = $('input.input-material');
    materialInputs.filter(function() { return $(this).val() !== ""; }).siblings('.label-material').addClass('active');
    materialInputs.on('focus', function () {
        $(this).siblings('.label-material').addClass('active');
    });
    materialInputs.on('blur', function () {
        $(this).siblings('.label-material').removeClass('active');
        if ($(this).val() !== '') {
            $(this).siblings('.label-material').addClass('active');
        } else {
            $(this).siblings('.label-material').removeClass('active');
        }
    });
</script> 
@yield('scripts')
</body>
</html>
