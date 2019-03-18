<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<?php
$ver_js = \App\Helpers\General::get_version_js();
$ver_css = \App\Helpers\General::get_version_css();
?>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @if (isset($title))
            {{ ucfirst($title).' :: '.config('app.name')}}
        @else
            @yield('title', 'Admin'){{' :: '.config('app.name')}}
        @endif
    </title>

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('/html-admin/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/html-admin/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('/html-admin/bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('/html-admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/html-admin/bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('/html-admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('/html-admin/bower_components/select2/dist/css/select2.min.css') }}">
    <!-- pnotify -->
    <link rel="stylesheet" href="{{ asset('/html-admin/plugins/pnotify/pnotify.custom.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/html-admin/dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('/html-admin/dist/css/skins/_all-skins.min.css') }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

    <!-- Favicons -->
    <link rel="icon" href="/favicon.ico?v=1">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js') }}"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js') }}"></script>
    <![endif]-->
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    @yield('before_styles')

    <link rel="stylesheet" href="{{ asset('css/customs-admin.css?v='.$ver_css) }}">

    @yield('after_styles')

    <script type="text/javascript">
        var _base_url = '{{url('/')}}';
        var _is_login = {{auth()->check() ? 'true' : 'false'}};
    </script>
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <!-- start wrapper -->
    <div class="wrapper">
        @include('includes.admin.header')

        @include('includes.admin.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        @include('includes.admin.footer')
    </div>
    <!-- end wrapper -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- jQuery 3 -->
    <script src="{{ asset('/html-admin/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('/html-admin/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/html-admin/bower_components/moment/min/moment-with-locales.min.js') }}"></script>
    <!-- DataTables -->
    <script src="{{ asset('/html-admin/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/html-admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('/html-admin/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/html-admin/bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js') }}"></script>
    <!-- bootstrap datepicker -->
    <script src="{{ asset('/html-admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('/html-admin/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    <!-- pnotify -->
    <script src="{{ asset('/html-admin/plugins/pnotify/pnotify.custom.min.js') }}"></script>

    <!-- SlimScroll -->
    <script src="{{ asset('/html-admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('/html-admin/bower_components/fastclick/lib/fastclick.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('/html-admin/dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('/html-admin/dist/js/demo.js') }}"></script>
    <!-- page script -->
    <script src="{{ asset('js/numeral.min.js') }}"></script>
    <script src="{{ asset('js/function.js?v='.$ver_js) }}"></script>

    <!-- page script -->
    <script type="text/javascript">
        // Ajax calls should always have the CSRF token attached to them, otherwise they won't work
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    @yield('after_scripts')
</body>

</html>