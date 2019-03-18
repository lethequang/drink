<div class="panel-box">
    <!-- Panel Header / Title -->
    <div class="panel-header">
        <h3 class="panel-title">Tin nổi bật</h3>
    </div>
    <!-- Panel Body -->
    <div class="panel-body">
        <!-- Recent Property -->
        <ul class="recent-property">
            <!-- Property List Item -->
        @foreach($assets_hot as $item)
            <li>
                <div class="property-image"><img style="background: url('{{$item['image_url'].$item['image']}}') center center no-repeat; padding-bottom: 100%; height: 0;"
                                                 src="/html/assets/images/transparent.png" alt="Property One"></div>
                <div class="property-content">
                    <a href="{{\App\Helpers\Block::get_link_asset($item)}}">{{$item['name']}}</a>
                    <span class="property-price">{{$item['price']}}</span>
                    <ul class="property-footer">
                        <li class="item-wide"><span class="fi flaticon-wide"></span> {{empty($item['acreage'])?'Không xác định':$item['acreage']}}</li>
                    </ul>
                </div>
            </li>
        @endforeach
        </ul>
    </div>
</div>