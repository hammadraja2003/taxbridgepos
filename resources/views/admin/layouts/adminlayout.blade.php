<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <link rel="icon" type="image/png" href="{{ asset('logo/favicon.ico') }}" />
  <title>{{ config('app.name', 'TaxBridgePOS') }}</title>
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

  <link rel="stylesheet" href="<?php echo env('ASSETS_PATH') . '/css/style.default.css' ?>" id="theme-stylesheet" type="text/css">
  <link rel="stylesheet" href="<?php echo env('ASSETS_PATH') . '/css/dropzone.css' ?>">

  <link rel="icon" type="image/png" href="{{ asset('logo/favicon.ico') }}" />
  <title>{{ config('app.name', 'TaxBridgePOS') }}</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="all,follow">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Bootstrap CSS-->
  <link rel="stylesheet" href="<?php echo asset('../../vendor/bootstrap/css/bootstrap.min.css') ?>" type="text/css">
  <link rel="preload" href="<?php echo asset('../../vendor/bootstrap-toggle/css/bootstrap-toggle.min.css') ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link href="<?php echo asset('../../vendor/bootstrap-toggle/css/bootstrap-toggle.min.css') ?>" rel="stylesheet">
  </noscript>
  <link rel="preload" href="<?php echo asset('../../vendor/bootstrap/css/bootstrap-datepicker.min.css') ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link href="<?php echo asset('../../vendor/bootstrap/css/bootstrap-datepicker.min.css') ?>" rel="stylesheet">
  </noscript>
  <link rel="preload" href="<?php echo asset('../../vendor/jquery-timepicker/jquery.timepicker.min.css') ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link href="<?php echo asset('../../vendor/jquery-timepicker/jquery.timepicker.min.css') ?>" rel="stylesheet">
  </noscript>
  <link rel="preload" href="<?php echo asset('../../vendor/bootstrap/css/awesome-bootstrap-checkbox.css') ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link href="<?php echo asset('../../vendor/bootstrap/css/awesome-bootstrap-checkbox.css') ?>" rel="stylesheet">
  </noscript>
  <link rel="preload" href="<?php echo asset('../../vendor/bootstrap/css/bootstrap-select.min.css') ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link href="<?php echo asset('../../vendor/bootstrap/css/bootstrap-select.min.css') ?>" rel="stylesheet">
  </noscript>
  <!-- Font Awesome CSS-->
  <link rel="preload" href="<?php echo asset('../../vendor/font-awesome/css/font-awesome.min.css') ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link href="<?php echo asset('../../vendor/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet">
  </noscript>
  <!-- Drip icon font-->
  <link rel="preload" href="<?php echo asset('../../vendor/dripicons/webfont.css') ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link href="<?php echo asset('../../vendor/dripicons/webfont.css') ?>" rel="stylesheet">
  </noscript>

  <!-- jQuery Circle-->
  <link rel="preload" href="<?php echo asset('../../css/grasp_mobile_progress_circle-1.0.0.min.css') ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link href="<?php echo asset('../../css/grasp_mobile_progress_circle-1.0.0.min.css') ?>" rel="stylesheet">
  </noscript>
  <!-- Custom Scrollbar-->
  <link rel="preload" href="<?php echo asset('../../vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css') ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link href="<?php echo asset('../../vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css') ?>" rel="stylesheet">
  </noscript>

  <!-- date range stylesheet-->
  <link rel="preload" href="<?php echo asset('../../vendor/daterange/css/daterangepicker.min.css') ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link href="<?php echo asset('../../vendor/daterange/css/daterangepicker.min.css') ?>" rel="stylesheet">
  </noscript>
  <!-- table sorter stylesheet-->
  <link rel="preload" href="<?php echo asset('../../vendor/datatable/dataTables.bootstrap4.min.css') ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link href="<?php echo asset('../../vendor/datatable/dataTables.bootstrap4.min.css') ?>" rel="stylesheet">
  </noscript>
  <link rel="preload" href="https://cdn.datatables.net/fixedheader/3.1.6/css/fixedHeader.bootstrap.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link href="https://cdn.datatables.net/fixedheader/3.1.6/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
  </noscript>
  <link rel="preload" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css" rel="stylesheet">
  </noscript>


  <link rel="stylesheet" href="<?php echo asset('../../css/style.default.css') ?>" id="theme-stylesheet" type="text/css">
  <link rel="stylesheet" href="<?php echo asset('../../css/dropzone.css') ?>">
 
  @stack('css')
</head>
<body>
    <div class="app-wrapper">
        <div class="loader-wrapper">
            <div class="app-loader">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        @include('admin.partials.navbar')
        <div class="app-content">
            @include('admin.partials.header')
            <main>
                @include('admin.partials.errors')
                @yield('content')
            </main>
        </div>
        <div class="go-top">
            <span class="progress-value">
                <i class="ti ti-arrow-up"></i>
            </span>
        </div>
        @include('admin.partials.footer')
    </div>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/jquery/jquery.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/jquery/jquery-ui.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/jquery/bootstrap-datepicker.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/jquery/jquery.timepicker.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/popper.js/umd/popper.min.js' ?>">
  </script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/bootstrap/js/bootstrap.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/bootstrap-toggle/js/bootstrap-toggle.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/bootstrap/js/bootstrap-select.min.js' ?>"></script>


  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/js/grasp_mobile_progress_circle-1.0.0.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/jquery.cookie/jquery.cookie.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/chart.js/Chart.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/js/charts-custom.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/jquery-validation/jquery.validate.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js' ?>"></script>

  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . 'js/front.js' ?>"></script>

  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/daterange/js/moment.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/daterange/js/knockout-3.4.2.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/daterange/js/daterangepicker.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/tinymce/js/tinymce/tinymce.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/js/dropzone.js' ?>"></script>


  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/datatable/pdfmake_arabic.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/datatable/vfs_fonts_arabic.js' ?>"></script>

  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/datatable/pdfmake.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo env('ASSETS_PATH') . '/datatable/vfs_fonts.js' ?>"></script>

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

  <script type="text/javascript" src="<?php echo asset('../../vendor/jquery/jquery.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo asset('../../vendor/jquery/jquery-ui.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo asset('../../vendor/jquery/bootstrap-datepicker.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo asset('../../vendor/jquery/jquery.timepicker.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo asset('../../vendor/popper.js/umd/popper.min.js') ?>">
  </script>
  <script type="text/javascript" src="<?php echo asset('../../vendor/bootstrap/js/bootstrap.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo asset('../../vendor/bootstrap-toggle/js/bootstrap-toggle.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo asset('../../vendor/bootstrap/js/bootstrap-select.min.js') ?>"></script>

  <script type="text/javascript" src="<?php echo asset('../../js/grasp_mobile_progress_circle-1.0.0.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo asset('../../vendor/jquery.cookie/jquery.cookie.js') ?>"></script>
  <script type="text/javascript" src="<?php echo asset('../../vendor/chart.js/Chart.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo asset('../../js/charts-custom.js') ?>"></script>
  <script type="text/javascript" src="<?php echo asset('../../vendor/jquery-validation/jquery.validate.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo asset('../../vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo asset('../../js/front_rtl.js') ?>"></script>

  <script type="text/javascript" src="<?php echo asset('../../js/front.js') ?>"></script>


  <script type="text/javascript" src="<?php echo asset('../../vendor/datatable/pdfmake_arabic.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo asset('../../vendor/datatable/vfs_fonts_arabic.js') ?>"></script>

  <script type="text/javascript" src="<?php echo asset('../../vendor/datatable/pdfmake.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo asset('../../vendor/datatable/vfs_fonts.js') ?>"></script>

  <script type="text/javascript" src="<?php echo asset('../../vendor/datatable/jquery.dataTables.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo asset('../../vendor/datatable/dataTables.bootstrap4.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo asset('../../vendor/datatable/dataTables.buttons.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo asset('../../vendor/datatable/jszip.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo asset('../../vendor/datatable/buttons.bootstrap4.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo asset('../../vendor/datatable/buttons.colVis.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo asset('../../vendor/datatable/buttons.html5.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo asset('../../vendor/datatable/buttons.printnew.js') ?>"></script>

  <script type="text/javascript" src="<?php echo asset('../../vendor/datatable/sum().js') ?>"></script>
  <script type="text/javascript" src="<?php echo asset('../../vendor/datatable/dataTables.checkboxes.min.js') ?>"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>

  <script type="text/javascript" src="{{ asset('js/barcode-qrcode-scanner_plugin.js') }}"></script>
</body>
</html>
