<?php
$link = \App\Helpers\Block::get_link_article($item);
?>
<div class="property-item">
    <div class="img-box">
        <a href="{{ $link }}" class="img-box__image"><img
                    style="background: url({{ $item['image_url'].$item['image'] }}) center center no-repeat; padding-bottom: 62%; height: 0;"
                    src="/html/assets/images/transparent.png" alt="" class="img-responsive"></a>
    </div>
    <div class="property-content">
        <a href="{{ $link }}" class="property-title">{!! $item['name'] !!}</a>
    </div>
</div>