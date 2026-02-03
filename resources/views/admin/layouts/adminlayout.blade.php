<html dir="@if( Config::get('app.locale') == 'ar'){{'rtl'}}@endif">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  @if(!config('database.connections.saleprosaas_landlord'))
  <link rel="icon" type="image/png" href="{{url('logo/taxbridge.png')}}" />
  <title>{{ config('app.name', 'TaxBridge') }}</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="all,follow">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Bootstrap CSS-->
  <link rel="stylesheet" href="<?php echo env('ASSETS_PATH') . '/bootstrap/css/bootstrap.min.css' ?>" type="text/css">
  <link rel="preload" href="<?php echo env('ASSETS_PATH') . '/bootstrap-toggle/css/bootstrap-toggle.min.css' ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link href="<?php echo env('ASSETS_PATH') . '/bootstrap-toggle/css/bootstrap-toggle.min.css' ?>" rel="stylesheet">
  </noscript>
  <link rel="preload" href="<?php echo env('ASSETS_PATH') . '/bootstrap/css/bootstrap-datepicker.min.css' ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <link rel="preload" href="<?php echo env('ASSETS_PATH') . '/jquery-timepicker/jquery.timepicker.min.css' ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link href="<?php echo env('ASSETS_PATH') . '/jquery-timepicker/jquery.timepicker.min.css' ?>" rel="stylesheet">
  </noscript>
  <link rel="preload" href="<?php echo env('ASSETS_PATH') . '/bootstrap/css/awesome-bootstrap-checkbox.css' ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link href="<?php echo env('ASSETS_PATH') . '/bootstrap/css/awesome-bootstrap-checkbox.css' ?>" rel="stylesheet">
  </noscript>
  <link rel="preload" href="<?php echo env('ASSETS_PATH') . '/bootstrap/css/bootstrap-select.min.css' ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link href="<?php echo env('ASSETS_PATH') . '/bootstrap/css/bootstrap-select.min.css' ?>" rel="stylesheet">
  </noscript>
  <!-- Font Awesome CSS-->
  <link rel="preload" href="<?php echo env('ASSETS_PATH') . '/font-awesome/css/font-awesome.min.css' ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link href="<?php echo env('ASSETS_PATH') . '/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">
  </noscript>
  <!-- Drip icon font-->
  <link rel="preload" href="<?php echo env('ASSETS_PATH') . '/dripicons/webfont.css' ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link href="<?php echo env('ASSETS_PATH') . '/dripicons/webfont.css' ?>" rel="stylesheet">
  </noscript>
  <!-- Tabler Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
  <!-- jQuery Circle-->
  <link rel="preload" href="<?php echo env('ASSETS_PATH') . '/css/grasp_mobile_progress_circle-1.0.0.min.css' ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link href="<?php echo env('ASSETS_PATH') . '/css/grasp_mobile_progress_circle-1.0.0.min.css' ?>" rel="stylesheet">
  </noscript>
  <!-- Custom Scrollbar-->
  <link rel="preload" href="<?php echo env('ASSETS_PATH') . '/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css' ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link href="<?php echo env('ASSETS_PATH') . '/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css' ?>" rel="stylesheet">
  </noscript>
  @if(Route::current()->getName() != '/')
  <!-- date range stylesheet-->
  <link rel="preload" href="<?php echo env('ASSETS_PATH') . '/daterange/css/daterangepicker.min.css' ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link href="<?php echo env('ASSETS_PATH') . '/daterange/css/daterangepicker.min.css' ?>" rel="stylesheet">
  </noscript>
  <!-- table sorter stylesheet-->
  <link rel="preload" href="<?php echo env('ASSETS_PATH') . '/datatable/dataTables.bootstrap4.min.css' ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link href="<?php echo env('ASSETS_PATH') . '/datatable/dataTables.bootstrap4.min.css' ?>" rel="stylesheet">
  </noscript>
  <link rel="preload" href="https://cdn.datatables.net/fixedheader/3.1.6/css/fixedHeader.bootstrap.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link href="https://cdn.datatables.net/fixedheader/3.1.6/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
  </noscript>
  <link rel="preload" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css" rel="stylesheet">
  </noscript>
  @endif
  <link rel="stylesheet" href="<?php echo env('ASSETS_PATH') . '/css/style.default.css' ?>" id="theme-stylesheet" type="text/css">
  <link rel="stylesheet" href="<?php echo env('ASSETS_PATH') . '/css/dropzone.css' ?>">
  <!-- Custom stylesheet - for your changes-->
  <link rel="stylesheet" href="<?php echo env('ASSETS_PATH') . '/css/custom-default.css' ?>" type="text/css" id="custom-style">
  @if( Config::get('app.locale') == 'ar')
  <!-- RTL css -->
  <link rel="stylesheet" href="<?php echo env('ASSETS_PATH') . '/bootstrap/css/bootstrap-rtl.min.css' ?>" type="text/css">
  <link rel="stylesheet" href="<?php echo env('ASSETS_PATH') . '/css/custom-rtl.css' ?>" type="text/css" id="custom-style">
  @endif
  @endif
  <!-- Google fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,100..900&display=swap" rel="stylesheet">
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/jquery/jquery.min.js' ?>"></script>
  @stack('css')
  <!-- Custom CSS removed -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</head>
<body class="@if(Route::current()->getName() == 'sale.pos') pos-page @endif" onload="myFunction()">
  <div id="loader"></div>
  <!-- Side Navbar -->
  <div class="page">
    <!-- navbar-->
    <nav class="side-navbar shrink d-print-none">
    <span class="brand-big">
      <a href="{{route('admin.admin_dashboard')}}">
        <img src="{{url('logo/tax-bridgePOS-logo.svg')}}" alt="TaxBridge" style="height: 50px;">
        {{-- <h1 class="d-inline">{{ config('app.name', 'TaxBridge') }}</h1> --}}
      </a>
    </span>
    @include('admin.layouts.sidebar')
  </nav>
@if(Route::current()->getName() != 'sale.pos')
    <header class="container-fluid app-header">
      <nav class="navbar">
        <a id="toggle-btn" href="#" class="menu-btn"><i class="fa fa-bars"> </i></a>

        <div class="d-flex align-items-center gap-3 mb-3">
          <h5 class="mb-0 fw-semibold">
            {{-- {{ $business_config->db_name ?? '—' }} --}}
          </h5>
      </div>

        <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
          <li class="nav-item d-none d-lg-block"><a id="btnFullscreen" data-toggle="tooltip" title="{{ __('Full Screen') }}"><i class="dripicons-expand"></i></a></li>
            <li class="nav-item">
              <a rel="nofollow" data-toggle="tooltip" class="nav-link dropdown-item"><i class="dripicons-user"></i> <span>{{ucfirst(Auth::user()->name)}}</span> <i class="fa fa-angle-down"></i>
              </a>
              <ul class="right-sidebar">
                <li>
                  <a href="{{route('user.profile', ['id' => Auth::id()])}}"><i class="dripicons-user"></i> {{ __('Profile') }}</a>
                </li>
                <li>
                  <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="dripicons-power"></i>{{ __('logout') }}</a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                  </form>
                </li>
              </ul>
            </li>
        </ul>
      </nav>
    </header>
    @endif
    <div style="display:none;background: #f8f9fa;"  id="content" class="animate-bottom">
      <div class="container-fluid pt-3">
        @if (session('success') || session('message'))
            <div class="alert alert-success alert-dismissible border-0 shadow-xs fade show mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="ti ti-circle-check-filled mr-2 fs-5"></i>
                    <div>{{ session('success') ?? session('message') }}</div>
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session('error') || $errors->any())
            <div class="alert alert-danger alert-dismissible border-0 shadow-xs fade show mb-4" role="alert">
                <div class="d-flex align-items-start">
                    <i class="ti ti-circle-x-filled mr-2 fs-5 mt-1"></i>
                    <div>
                        <ul class="mb-0 list-unstyled">
                            @if(session('error')) <li>{{ session('error') }}</li> @endif
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
      </div>
      @yield('content')
    </div>
  </div>
  <footer class="main-footer">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <p>
              &copy; {{ date('Y') }} <strong>Secured by</strong> 
              <a href="https://secureism.com/" target="_blank" class="external">
                  Secureism
              </a>. 
              All rights reserved.  | V {{env('VERSION') }}
          </p>
        </div>
         <div class="col-sm-6">
          <p>
              <a href="https://secureism.com/privacy-policy" target="_blank" class="external">
                  Privacy Policy
              </a>
              <a href="https://taxbridge.pk/terms-of-use/" target="_blank" class="external">
                  Terms & Conditions
              </a>
          </p>
        </div>
      </div>
    </div>
  </footer>
  @if(!config('database.connections.saleprosaas_landlord'))
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/jquery/jquery.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/jquery/jquery-ui.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/jquery/bootstrap-datepicker.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/jquery/jquery.timepicker.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/popper.js/umd/popper.min.js' ?>">
  </script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/bootstrap/js/bootstrap.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/bootstrap-toggle/js/bootstrap-toggle.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/bootstrap/js/bootstrap-select.min.js' ?>"></script>
  @if(Route::current()->getName() == 'sale.pos')
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/keyboard/js/jquery.keyboard.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/keyboard/js/jquery.keyboard.extension-autocomplete.js' ?>"></script>
  @endif
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/js/grasp_mobile_progress_circle-1.0.0.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/jquery.cookie/jquery.cookie.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/chart.js/Chart.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/js/charts-custom.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/jquery-validation/jquery.validate.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js' ?>"></script>
  @if( Config::get('app.locale') == 'ar')
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/js/front_rtl.js' ?>"></script>
  @else
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/js/front.js' ?>"></script>
  @endif

  @if(Route::current()->getName() != '/')
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/daterange/js/moment.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/daterange/js/knockout-3.4.2.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/daterange/js/daterangepicker.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/tinymce/js/tinymce/tinymce.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/js/dropzone.js' ?>"></script>

  <!-- table sorter js-->
  @if( Config::get('app.locale') == 'ar')
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/datatable/pdfmake_arabic.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/datatable/vfs_fonts_arabic.js' ?>"></script>
  @else
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/datatable/pdfmake.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/datatable/vfs_fonts.js' ?>"></script>
  @endif
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/datatable/jquery.dataTables.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/datatable/dataTables.bootstrap4.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/datatable/dataTables.buttons.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/datatable/jszip.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/datatable/buttons.bootstrap4.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/datatable/buttons.colVis.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/datatable/buttons.html5.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/datatable/buttons.printnew.js' ?>"></script>

  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/datatable/sum().js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/datatable/dataTables.checkboxes.min.js' ?>"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
  @endif

  @endif
  @stack('scripts')

  <script type="text/javascript">
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    var theme = "default.css";
    if (theme == 'dark.css') {
      $('body').addClass('dark-mode');
      $('#switch-theme i').addClass('dripicons-brightness-low');
    } else {
      $('body').removeClass('dark-mode');
      $('#switch-theme i').addClass('dripicons-brightness-max');
    }
    $('#switch-theme').click(function() {
      if (theme == 'light') {
        theme = 'dark';
        var url = <?php echo json_encode(route('switchTheme', 'dark')); ?>;
        $('body').addClass('dark-mode');
        $('#switch-theme i').addClass('dripicons-brightness-low');
      } else {
        theme = 'light';
        var url = <?php echo json_encode(route('switchTheme', 'light')); ?>;
        $('body').removeClass('dark-mode');
        $('#switch-theme i').addClass('dripicons-brightness-max');
      }

      $.get(url, function(data) {
        console.log('theme changed to ' + theme);
      });
    });

    if ($(window).outerWidth() > 1199) {
      $('nav.side-navbar').removeClass('shrink');
    }

    function myFunction() {
      setTimeout(showPage, 100);
    }

    function showPage() {
      document.getElementById("loader").style.display = "none";
      document.getElementById("content").style.display = "block";
    }

    $("div.alert").delay(4000);

    function confirmDelete() {
      if (confirm("Are you sure want to delete?")) {
        return true;
      }
      return false;
    }

    // Modals and report handlers removed
    $('.date').datepicker({
      format: "dd-mm-yyyy",
      autoclose: true,
      todayHighlight: true
    });

    $('.selectpicker').selectpicker({
      style: 'btn-link',
    });

      // Automatically activate sidebar menu based on current URL
      $(document).ready(function() {
          var currentUrl = window.location.href;
          var validLinks = [];

          $('nav.side-navbar a').each(function() {
              var linkUrl = $(this).attr('href');
              // precise match or matching path
              if (linkUrl && linkUrl !== '#' && (linkUrl === currentUrl || (currentUrl.startsWith(linkUrl) && linkUrl !== '{{url("/dashboard")}}' && linkUrl !== '/'))) {
                  validLinks.push({
                      element: $(this),
                      length: linkUrl.length
                  });
              }
          });

          // Sort by length descending to find the most specific match
          validLinks.sort(function(a, b) {
              return b.length - a.length;
          });

          if (validLinks.length > 0) {
              var activeLink = validLinks[0].element;
              
              // Add active class to the link's parent li
              activeLink.parent().addClass('active');

              // If it's a submenu item
              if (activeLink.closest('ul').hasClass('collapse')) {
                  // Expand the parent ul
                  activeLink.closest('ul').addClass('show');
                  // Mark the parent dropdown as active and expanded
                  activeLink.closest('ul').siblings('a').attr('aria-expanded', 'true');
              }
          }
      });
    </script>
   
</body>

</html>
