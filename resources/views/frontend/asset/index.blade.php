@extends('layouts.frontend')
<?php
$types_titles = \App\Helpers\General::get_assets_types_titles();
$breadcrumb = [['link' => '#', 'name' => $types_titles[$type]]];
if ($type=='hot') {
    if (isset($params['type'])) $breadcrumb[] = ['link' => '#', 'name' => $types_titles[$params['type']]];
}
$banners = \App\Helpers\General::getBannersByPage('asset-'.($type??'hot'));
?>
@section('title') {{$types_titles[$type]}} @stop

@section('content')
    <!-- ====== PROPERTY ARCHIVE PAGE HEADER ====== -->
    <section class="page-header">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="/">Trang chủ</a></li>
                @foreach($breadcrumb as $i => $bc)
                    @if ($i+1 == count($breadcrumb))
                        <li class="active">{{$bc['name']}}</li>
                    @else
                        <li><a href="{{$bc['link']}}">{{$bc['name']}}</a></li>
                    @endif
                @endforeach
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

    <!-- ====== PROPERTY LIST CONTENT ====== -->
    <section class="page-section">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <!-- Content -->
                    <div id="content">
                        <div class="panel filter-panel">
                            <div class="panel-body">
                                <h4 class="filter-title pull-left">Sắp xếp theo</h4>
                                <form action="#" class="form-inline pull-right">
                                    <div class="form-group">
                                        <label>Sắp xếp:</label>
                                        <?php
                                        $sorts = \App\Helpers\General::get_assets_sort_options();
                                        ?>
                                        {!! Form::select("sort", ['' => 'Sắp xếp theo']+$sorts, @$_GET['sort'],
                                            ['class' => 'form-control sorting', "data-placeholder" => "Sắp xếp theo"]) !!}
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="row">
                            @foreach($assets as $item)
                                <div class="property-item property-archive  property-archive-top col-lg-12 col-md-6 col-sm-6">
                                    <?=\App\Helpers\Block::property_item_content($item, 'list'); ?>
                                </div>
                            @endforeach
                        </div>
                        <!-- Property List Pagination -->

                        {{ $assets->links('frontend/pagination/pagination') }}
                    </div>
                </div>
                <div class="col-md-4">
                    <!-- Sidebar -->
                    <div id="sidebar">
                        <!-- widget Booking -->
                        <!-- widget section Search Property -->
                        <div class="widget">
                            <!-- Search Tabmenu -->
                            @include('frontend.blocks.form-search-list')
                        </div>
                        <!-- widget section Contact Our Agent -->
                        <div class="widget">
                            <?=\App\Helpers\Block::show_contact_item();?>
                        </div>
                        <!-- widget section Recent Property-->
                        <div class="widget">
                            <?=\App\Helpers\Block::assets_hot_panel();?>
                        </div>

                        <div class="widget">

                        @if (isset($banners['right'][0]))
                            <?php $banner = $banners['right'][0]; ?>
                            <!-- ====== Banner ====== -->
                                <div class="panel-box panel-banner">
                                    <a href="{{$banner['url']}}"><img src="{{$banner['image_url'].$banner['image_location']}}" alt=""></a>
                                </div>
                        @endif
                            <!-- Panel Box -->
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

@section('after_script')
    <script type='text/javascript'>
        $(document).ready(function () {
        });
    </script>
@stop
