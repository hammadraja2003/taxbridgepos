@extends('backend.layout.loginlayout')

@section('content')
    <form class="app-form needs-validation" novalidate method="POST" action="{{ route('login') }}" id="login-form">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="mb-5 text-center text-lg-start">
                    <div class="d-flex justify-content-center align-items-center my-2">
                        <img src="{{ env('PUB_PATH') . '/logo/tax-bridgePOS-logo.svg' }}" alt="Logo" class="dark-logo">

                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="mb-3">
                    <label for="username" class="form-label">Email</label>
                    <input class="form-control" required type="email" placeholder="Enter Your Email" name="name"
                        value="{{ old('name') }}" autofocus autocomplete="name" />
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
                            <i class="fa fa-eye-slash"></i>
                        </span>
                    </div>
                    <div class="invalid-feedback">
                        Please enter your password.
                    </div>
                </div>
            </div>
        </div>
        @if(session()->has('delete_message'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session()->get('delete_message') }}
                <button type="button" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session()->get('error') }}
                <button type="button" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session()->has('not_permitted'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session()->get('not_permitted') }}
                <button type="button" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {!! session()->get('message') !!}
                <button type="button" data-bs-dismiss="alert"></button>
            </div>
        @endif
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
    </form>
@endsection
<script type="text/javascript" src="{{ env('ASSETS_PATH') . '/jquery/jquery.min.js' }}"></script>
<script>

    $("div.alert").delay(4000).slideUp(800);

    //switch theme code
    var theme = <?php echo json_encode($theme); ?>;
    if (theme == 'dark') {
        $('body').addClass('dark-mode');
        $('#switch-theme i').addClass('dripicons-brightness-low');
    }
    else {
        $('body').removeClass('dark-mode');
        $('#switch-theme i').addClass('dripicons-brightness-max');
    }

    $('#togglePassword').click(function () {
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

    $('.demo-btn').on('click', function (e) {
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
    $(document).ready(function () {
        $('#super_admin').on('click', function (e) {
            e.preventDefault();
            window.open("{{ route('admin.admin_login') }}", "_blank");
        });
    });

    // ------------------------------------------------------- //
    // Material Inputs
    // ------------------------------------------------------ //

    var materialInputs = $('input.input-material');

    // activate labels for prefilled values
    materialInputs.filter(function () { return $(this).val() !== ""; }).siblings('.label-material').addClass('active');

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