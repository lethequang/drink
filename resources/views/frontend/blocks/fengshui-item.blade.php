<?php
$link = \App\Helpers\Block::get_link_article($item);
?>
@if ($class=='item-left')
<div class="testimony-item {{$class}}">
    <div class="row">
        <div class="col-md-3">
            <div class="testimony-profile">
                <a href="{{ $link }}" class="img-box__image">
                    <img style="background: url('{{$item['image_url'].$item['image']}}') center center no-repeat; padding-bottom: 100%; height: 0;"
                         src="/html/assets/images/transparent.png" alt="" class="img-responsive"></a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="testimony-text">
                <h5><a href="{{ $link }}" title="">{!!$item['name']!!}</a></h5>
                <p>{!! $item['description'] !!}</p>
            </div>
        </div>
    </div>
</div>
@else
<div class="testimony-item {{$class}}">
    <div class="row">
        <div class="col-md-3 col-md-push-6 col-md-offset-3">
            <div class="testimony-profile">
                <a href="{{ $link }}" class="img-box__image">
                    <img style="background: url('{{$item['image_url'].$item['image']}}') center center no-repeat; padding-bottom: 100%; height: 0;"
                         src="/html/assets/images/transparent.png" alt="" class="img-responsive"></a>
            </div>
        </div>
        <div class="col-md-6 col-md-pull-3">
            <div class="testimony-text">
                <h5><a href="{{ $link }}" title="">{!! $item['name'] !!}</a></h5>
                <p>{!! $item['description'] !!}</p>
            </div>
        </div>
    </div>
</div>
@endif