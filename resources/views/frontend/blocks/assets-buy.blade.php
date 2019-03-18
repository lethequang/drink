<div class="section-header header-column">
    <h2 class="section-title"><a href="{{route('fe.asset.buy')}}">Nhà đất cần thuê</a> <a class="btn-more" href="{{route('fe.asset.buy')}}">Xem thêm <i
                    class="fa fa-angle-double-right" aria-hidden="true"></i></a></h2>
</div>
<div id="product-buy" class="row">
@foreach($assets_buy as $item)
    <div class="col-md-3 col-sm-6">
        <?=\App\Helpers\Block::property_item_content($item); ?>
    </div>
@endforeach
</div>