@extends('layouts.frontend')

@section('title') {{ $articles->name }} @stop

@section('og_title'){{ $articles->name }}@stop
@section('og_description'){{strip_tags($articles->description) }}@stop
@section('og_image'){{ $articles->image_url . $articles->image }}@stop
@section('og_url')<?php echo URL::current(); ?>@stop
<?php
$banners = \App\Helpers\General::getBannersByPage('new');
if ($articles->article_category_id == 1)
{
    $breadcrumb_name = 'Tin tức';
}
else
{
    $breadcrumb_name = 'Phong thủy';
}
$breadcrumb_link = \App\Helpers\Block::get_breadcrumb_link($articles->article_category_id);
?>
@section('content')
    <!-- ====== SINGLE PROPERTY PAGE HEADER ====== -->
    <section class="page-header">
        <div class="container">
            <h1 class="page-header-title">{{$breadcrumb_name}}</h1>
            <ul class="breadcrumb">
                <li><a href="/">Trang chủ</a></li>
                <li><a href="{{$breadcrumb_link}}">{{$breadcrumb_name}}</a></li>
            </ul>
        </div>
    </section>

    <!-- ====== SINGLE POST / BLOG CONTENT ====== -->
    <section class="page-section">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <!-- Content -->
                    <div id="content">
                        <!-- Post Entries-->
                        <article class="post">
                            <h2 class="post-title"><a href="#">{!! $articles->name!!}</a></h2>
                            <figure class="post-image"><a href="#"><img src="{{ $articles->image}}" alt=""></a></figure>
                            <div class="post-entries">
                               
                                <blockquote>
                                    <p>{!! $articles->description !!}</p>
                                    <footer></footer>
                                </blockquote>
                                {!! $articles->content !!}
                                <div class="widget">
                                    <div class="share-box">
                                        <h4>Share:</h4>
                                        <ul class="share-box-list">
                                            <li>
                                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo URL::current(); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600'); return false;" class="facebook">
                                                    <i class="fa fa-facebook"></i>
                                                    <i class="fa fa-facebook"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="http://twitter.com/share" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600'); return false;" class="twitter">
                                                    <i class="fa fa-twitter"></i>
                                                    <i class="fa fa-twitter"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="https://plus.google.com/share?url=<?php echo URL::current(); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600'); return false;" class="google">
                                                    <i class="fa fa-google"></i>
                                                    <i class="fa fa-google"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <nav class="navigation post-navigation" role="navigation">
                            <h2 class="screen-reader-text">Trở về</h2>
                            <div class="nav-links">
                                @if ($articlePrevious != null)
                                <div class="nav-previous">
                                    <a href="{{ url('tin-tuc/' .$articlePrevious->path()) }}" rel="prev"><span class="nav-post-title">Trờ về</span><span
                                                class="nav-post-name">{{  $articlePrevious->name }}</span></a>
                                </div>
                                @endif

                                @if ($articleNext != null)        
                                <div class="nav-next">
                                    <a href="{{ url('tin-tuc/' .$articleNext->path()) }}" rel="prev"><span class="nav-post-title">Tiếp theo</span><span
                                    class="nav-post-name">{{ $articleNext->name }}</span></a>
                                </div>
                                @endif
                        
                            </div>
                        </nav>
                        <div class="related-post widget panel-box">
                            <!-- Related Post Title -->
                            <div class="panel-header">
                                <h3 class="panel-title">Tin liên quan</h3>
                            </div>
                            <!-- Related Post List -->
                            <div class="panel-body">
                                <ul class="post-list">
                                    @foreach($postRandom as $post)
                                    <li>
                                        <a class="post-image" href="{{ url('tin-tuc/' .$post->path()) }}"><img
                                        src="{{ $post->image }}"
                                                    style="background-image: url({{ $post->image }});  padding-bottom: 56.25%; height: 0; background-size: cover; background-position: center;"
                                                    alt="Image"></a>
                                        <div class="post-content">
                                        <a href="{{ url('tin-tuc/' .$post->path()) }}" class="post-title">{{ $post->name }}</a>
                                        <span class="post-date">{{ $post->updated_at }}</span>
                                        </div>
                                    </li>
                                    @endforeach
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <!-- Sidebar -->
                    <div id="sidebar">
                        <!-- widget section Search -->
                        <div class="widget widget_search">
                            <div class="panel-box">
                                <form role="search" method="get" class="search-form" action="#">
                                    <label>
                                        <span class="screen-reader-text">Tìm kiếm:</span>
                                        <input type="search" class="search-field" placeholder="Tìm kiếm …" value=""
                                               name="s">
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
                                                <a href="{{ url('tin-tuc/' .$ishot->path()) }}">{!! $ishot->name !!}</a>
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
                                    <ul class="post-listb">
                                    @foreach($iscommons as $iscommon)
                                        <!-- Post List Item -->
                                            <li>
                                                <div class="post-image"><img
                                                            style="background: url({{ $iscommon->image }}) center center no-repeat; padding-bottom: 100%; height: 0;"
                                                            src="{{ $iscommon->image }}" alt="#"></div>
                                                <div class="post-content">
                                                    <span class="post-date">{!! $iscommon->updated_at !!}</span>
                                                    <a href="{{ url('tin-tuc/' .$iscommon->path()) }}" class="post-title">{!! $iscommon->name !!}</a>
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

@section('after_scripts')
    <script type='text/javascript'>
        $(document).ready(function () {
            active_menu('{{$breadcrumb_link}}');
        });
    </script>
@stop