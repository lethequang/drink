@extends('layouts.frontend')

@section('title') Tìm kiếm @stop

@section('content')
    <section id="page-builder" class="page-section">
        <!-- HERO IMAGE WITH SEARCH FORM -->
        <div class="row tpb-row" style="background-image: url(/html/assets/images/home_hero_image_default.jpg); padding-top: 44px; padding-bottom: 68px; margin: 0; background-size: cover; background-position: center;">
            <div class="tpb tpb-property_simple_search col-md-12">
                <div class="container">
                    <?=\App\Helpers\Block::form_search();?>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== Banner ====== -->
    <div class="banner-n margin-t">
        <a href="#"><img src="/html/assets/images/banner-980x90.jpg" alt=""></a>
    </div>

    <section id="property-search-result" class="archive-property">
        <!-- ====== PAGE CONTENT ====== -->
        <div class="page-section">
            <div class="container">
                <div class="panel filter-panel">
                    <div class="panel-body">
                        <h4 class="filter-title pull-left">Tìm được {{$assets->count()}} tin</h4>
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

                <div class="property-list archive-flex archive-with-footer">
                    <div class="row">
                    @foreach($assets as $item)
                        <div class="col-md-3 col-sm-6">
                            <!-- Property Item -->
                            <?=\App\Helpers\Block::property_item_content($item); ?>
                        </div>
                    @endforeach
                    </div>
                </div>

                {{ $assets->links('frontend/pagination/pagination') }}
            </div>
        </div>
    </section>

    <!-- ====== Banner ====== -->
    <div class="banner-n margin-b">
        <a href="#"><img src="/html/assets/images/banner-980x90.jpg" alt=""></a>
    </div>
@stop

@section('after_script')
    <script type='text/javascript'>
        $(document).ready(function () {
        });
    </script>
@stop