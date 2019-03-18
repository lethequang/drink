<?php
$link = \App\Helpers\Block::get_link_asset($item);
$link_category = \App\Helpers\Block::get_link_asset_category($item);
?>
<!-- Property Item Tall -->
<div class="property-item">
    <div class="property-header">
        <a href="{{$link_category}}" class="item-category">{{@$item['asset_category_name']}}</a>
        <a href="{{$link}}" class="item-title">{{$item['name']}}</a>
        <div class="item-price">{{$item['price']}}</div>
    </div>
    <figure class="item-img" style="background-image: url('{{$item['image_url'].$item['image']}}');">
        <a href="{{$link}}"></a>
    </figure>
</div>