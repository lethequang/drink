<?php
$ver_js = \App\Helpers\General::get_version_js();
$ver_css = \App\Helpers\General::get_version_css();
$settings = \App\Helpers\General::get_settings();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <link rel="shortcut icon" type='image/x-icon' href="<?=@$settings['favicon_ico']['value']?>">

    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>@if(isset($title)){{$title.' :: '.config('app.name')}} @else @yield('title', 'Trang chủ'){{' :: '.config('app.name')}}@endif</title>

    <meta name="viewport" content="initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <meta property="og:title" content="@yield('og_title', config('app.name'))"/>
    <meta property="og:url" content="@yield('og_url', url()->current())"/>
    <meta property="og:type" content="article"/>
    <meta property="og:locale" content="vi_VN" />
    <meta property="og:image" content="@yield('og_image', asset('uploads/logo.png'))"/>
    <meta property="og:description" content="@yield('og_description', '')"/>
    <meta name="keywords" content="@yield('og_keywords', '')"/>
    <meta name="description" content="@yield('og_description', '')"/>
    <link rel="stylesheet" type="text/css" href="/html/assets/css/style-v2.css?v=<?=$ver_css?>">
    <link rel="stylesheet" type="text/css" href="/css/fe-customs-v2.css?v=<?=$ver_css?>">
    <link rel="stylesheet" type="text/css" href="/html/assets/css/slick-cus.css?v=<?=$ver_css?>">

    @yield('after_styles')

    <?php \App\Helpers\General::get_scripts_include('head'); ?>
</head>

<body class="header-1 page-header-1">
    @include('includes.frontend.header')

    @yield('content')

    @include('includes.frontend.footer')

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="/html/assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/html/assets/js/moment.min.js"></script>
    <script type="text/javascript" src="/html/assets/js/jquery.daterangepicker.min.js"></script>
    <script type="text/javascript" src="/html/assets/js/slick.min.js"></script>
    <script type="text/javascript" src="/html/assets/js/ion.rangeSlider.min.js"></script>
    <script type="text/javascript" src="/html/assets/js/apps.min.js?v={{$ver_js}}"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <script type="text/javascript" src="/js/numeral.min.js"></script>
    <script type="text/javascript" src="/js/function.js"></script>

    @yield('after_scripts')

    <?php \App\Helpers\General::get_scripts_include('body'); ?>
</body>
</html>
