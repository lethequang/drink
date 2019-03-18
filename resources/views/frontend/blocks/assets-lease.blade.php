<div class="section-header header-column">
    <h2 class="section-title"><a href="{{route('fe.asset.lease')}}" title="">Nhà đất cho thuê</a> <a class="btn-more" href="{{route('fe.asset.lease')}}">Xem thêm <i
                    class="fa fa-angle-double-right" aria-hidden="true"></i></a></h2>
</div>
<div id="product-house" class="row">
@foreach($assets_lease as $item)
    <div class="col-md-3 col-sm-6">
        <?=\App\Helpers\Block::property_item_content($item); ?>
    </div>
@endforeach
</div>