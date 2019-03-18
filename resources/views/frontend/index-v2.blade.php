@extends('layouts.frontend-v2')

@section('title') Trang chủ @stop

@section('content')
    <!-- ====== END HEADER ====== -->
    <section id="main-slider" class="page-section">
        <?=\App\Helpers\Block::slider()?>
    </section>

    <!-- ====== PAGE BUILDER TEMPLATE ====== -->
    <section id="page-builder" class="page-section">
        <!-- HERO IMAGE WITH SEARCH FORM -->
        <div class="row tpb-row"
             style="margin: 0; padding-top: 40px;">
            <div class="tpb tpb-property_simple_search col-md-12">
                <div class="container">
                    <?=\App\Helpers\Block::form_search();?>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== FEATURED PROPERTY SECTION ====== -->
    <section id="featured-property" class="page-section">
        <div class="container">
            <?=\App\Helpers\Block::assets_hot()?>
        </div>
    </section>

    <!-- ====== BEST OFFER SECTION ====== -->
    <section id="block-house" class="page-section">
        <div class="container">
            <!-- Section Header / Title with Column Slider Control / Add 'header-column' to use this style -->
            <?=\App\Helpers\Block::assets_lease(8)?>
        </div>
    </section>
    <!-- ====== BEST OFFER SECTION ====== -->
    <section id="block-land" class="page-section">
        <div class="container">
            <!-- Section Header / Title with Column Slider Control / Add 'header-column' to use this style -->
            <?=\App\Helpers\Block::assets_buy(8)?>
        </div>
    </section>

    <!-- ====== HOW TO BUY SECTION ====== -->
    <section id="block-news" class="page-section" style="background-image: url(/html/assets/images/main_default.jpg);">
        <div class="container">
            <!-- Section Header / Title with Column Content / Add 'header-column' to use this style -->
            <div class="section-header header-column">
                <!-- Header Title / Column 1 -->
                <h2 class="section-title"><a href="{{route('fe.article.index')}}" title="">Tin tức</a> <a class="btn-more" href="{{route('fe.article.index')}}">Xem thêm <i
                                class="fa fa-angle-double-right" aria-hidden="true"></i></a></h2>
            </div>
            <!-- Panel Wrapper for Panel Box Container -->
            <div class="panel-wrapper">
                <div id="product-house" class="row">
            @foreach ($articles as $key => $article)
                    <div class="col-md-3 col-sm-6">
                        <!-- Property Item -->
                        <?=\App\Helpers\Block::news_item($article)?>
                    </div>
            @endforeach
                </div>
            </div>
        </div>
    </section>
@stop

@section('after_script')
    <script type='text/javascript'>
        $(document).ready(function () {
        });
    </script>
@stop