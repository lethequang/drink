<?php
$link = \App\Helpers\Block::get_link_asset($item);
$link_category = \App\Helpers\Block::get_link_asset_category($item);
$tmp = [];
if ($item['district_name']) $tmp[] = $item['district_name'];
if ($item['province_name']) $tmp[] = $item['province_name'];
$tmp = implode(", ", $tmp);
?>
<!-- Property Item Content -->
<div class="property-item">
    <div class="property-heading">
        <span class="item-price">{{$item['price']}}</span>
        <a href="{{$link}}" class="item-detail btn"><i class="fi flaticon-detail"></i></a>
    </div>
    <div class="img-box">
        <div class="property-label">
            <a href="{{$link_category}}" class="property-label__type">{{@$item['asset_category_name']}}</a>
        </div>
        <a href="{{$link}}" class="img-box__image"><img
                    style="background: url('{{$item['image_url'].$item['image']}}') center center no-repeat; padding-bottom: 56.25%; height: 0;"
                    src="/html/assets/images/transparent.png" alt="" class="img-responsive"></a>
    </div>
    <div class="property-content">
        <a href="{{$link}}" class="property-title">{{$item['name']}}</a>
        <div class="property-address">{{$tmp}}</div>
        <div class="property-footer">
            <div class="item-wide"><span class="fi flaticon-wide"></span> {{empty($item['acreage'])?'Không xác định':$item['acreage']}}</div>
            <div class="item-date"><span class="fi flaticon-clock"></span> {{\App\Helpers\General::output_date_public($item['date_public'], $item['created_at'])}}</div>
        </div>
    </div>
</div>