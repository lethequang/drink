@extends('layouts.frontend')

@section('title') Liên hệ @stop
<?php
$banners = \App\Helpers\General::getBannersByPage('contact');
?>
@section('content')
    <!-- ====== CONTACT PAGE HEADER ====== -->
    <section class="page-header">
        <div class="container">
            <h1 class="page-header-title">Liên hệ</h1>
            <ul class="breadcrumb">
                <li><a href="/">Trang chủ</a></li>
                <li class="active">Liên hệ</li>
            </ul>
        </div>
    </section>

    @if (isset($banners['top'][0]))
        <?php $banner = $banners['top'][0]; ?>
        <!-- ====== Banner ====== -->
        <div class="banner-n margin-t">
            <a href="{{$banner['url']}}"><img src="{{$banner['image_url'].$banner['image_location']}}" alt=""></a>
        </div>
    @endif

    <!-- ====== CONTACT PAGE CONTENT ====== -->
    <section class="page-section">
        <div class="container">
            <div id="content">
                <!-- Messages Form Section -->

                @if(session('message'))
                <div class="alert alert-success">
                    <strong>{{ session('message') }}</strong>
                </div>
            @endif
                <section class="section-row">
                    <div class="panel-box">
                        <div class="panel-header">
                            <h3 class="panel-title">Liên hệ chúng tôi</h3>
                        </div>
                        <div class="panel-body">
                        <form action="/lien-he" method="post">
                            @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <input type="text" name="name" class="form-control" placeholder="Tên">
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input name="email" type="email" class="form-control" placeholder="Email">
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <textarea name="content" id="messages" cols="30" rows="7" class="form-control" placeholder="Nội dung"></textarea>
                                    <span class="text-danger">{{ $errors->first('content') }}</span>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn-submit btn-primary btn" value="Gửi">
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>

    @if (isset($banners['bottom'][0]))
        <?php $banner = $banners['bottom'][0]; ?>
        <!-- ====== Banner ====== -->
        <div class="banner-n margin-b">
            <a href="{{$banner['url']}}"><img src="{{$banner['image_url'].$banner['image_location']}}" alt=""></a>
        </div>
    @endif
@stop

@section('after_script')
    <script type='text/javascript'>
        $(document).ready(function () {
        });
    </script>
@stop