@extends('layouts.frontend')

@section('title') Phong thuỷ @stop
<?php
$banners = \App\Helpers\General::getBannersByPage('new');
?>
@section('content')
    <!-- ====== BLOG ARCHIVE PAGE HEADER ====== -->
    <section class="page-header">
        <div class="container">
            <h1 class="page-header-title">Phong thuỷ</h1>
            <ul class="breadcrumb">
                <li><a href="/">Trang chủ</a></li>
                <li class="active">Tin tức</li>
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

    <!-- ====== POST LIST ====== -->
    <section class="page-section">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <!-- Content -->
                    <div id="content">
                    @foreach($fengshuis as $article)

                        <!-- Post List -->
                            <article class="post">
                                <h2 class="post-title"><a
                                            href="{{ url('phong-thuy/' .$article->path()) }}">{!! $article->name !!}</a>
                                </h2>
                                <figure class="post-image"><a href="{{ url('phong-thuy/' .$article->path()) }}"><img
                                                style="background: url({{ $article->image }}) center center no-repeat; padding-bottom: 50%; height: 0;"
                                                src="{{ $article->image }}" alt="Post list 1"></a></figure>
                                <ul class="post-meta">
                                    <li class="post-author"><a href="#">{{ $article->updated_at }}</a></li>
                                </ul>
                                <p class="post-entries">{!! $article->description !!}</p>
                            </article>

                    @endforeach
                        <div class="pagination">
                            @if (!count($fengshuis)) <div class="pagination">Không tìm thấy tin tức</div> @endif
                            {{ $fengshuis->links('frontend/pagination/pagination') }}
                        </div>

                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-md-4">
                    <div id="sidebar">
                        <!-- widget section Search -->
                        <div class="widget widget_search">
                            <div class="panel-box">
                                <form role="search" method="get" class="search-form" action="">
                                    <label>
                                        <span class="screen-reader-text">Tìm kiếm:</span>
                                        <input type="search" class="search-field" placeholder="Tìm kiếm …" value="{{@$_GET['kw']}}" name="kw">
                                    </label>
                                    <input type="submit" class="search-submit" value="Search">
                                </form>
                            </div>
                        </div>
                        <!-- widget section Recent Post -->
                        <div class="widget widget_recent_entries">
                            <div class="panel-box">
                                <div class="panel-header">
                                    <h3 class="panel-title">Tin nổi bật</h3>
                                </div>
                                <div class="panel-body">
                                    <ul>
                                        @foreach($ishots as $ishot)
                                            <li>
                                                <a href="{{ url('phong-thuy/' .$ishot->path()) }}">{!! $ishot->name !!}</a>
                                                <span class="post-date">{!! $ishot->updated_at !!}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- widget section Popular Post -->

                        <div class="widget widget_popular_post">
                            <!-- Panel Box -->
                            <div class="panel-box">
                                <!-- Panel Header / Title -->
                                <div class="panel-header">
                                    <h3 class="panel-title">Tin phổ biến</h3>
                                </div>
                                <!-- Panel Body -->
                                <div class="panel-body">
                                    <!-- Post List -->
                                    <ul class="post-list">

                                        @foreach($iscommons as $iscommon)
                                            <li>
                                                <div class="post-image"><img
                                                            style="background: url({{ $iscommon->image }}) center center no-repeat; padding-bottom: 100%; height: 0;"
                                                            src="{{ $iscommon->image }}" alt="#"></div>
                                                <div class="post-content">
                                                    <span class="post-date">{{ $iscommon->updated_at }}</span>
                                                    <a href="{{ url('phong-thuy/' .$iscommon->path()) }}"
                                                       class="post-title">{!! $iscommon->name !!}</a>
                                                </div>
                                            </li>
                                            <!-- Post List Item -->
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="widget">

                            @if (isset($banners['right'][0]))
                            <?php $banner = $banners['right'][0]; ?>
                            <!-- ====== Banner ====== -->
                                <div class="panel-box panel-banner">
                                    <a href="{{$banner['url']}}"><img src="{{$banner['image_url'].$banner['image_location']}}" alt=""></a>
                                </div>
                            @endif

                        </div>

                    </div>
                </div>
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
<style>
    .pagination {
        display: inline-block;
    }
</style>
@section('after_script')
    <script type='text/javascript'>
        $(document).ready(function () {
        });
    </script>
@stop