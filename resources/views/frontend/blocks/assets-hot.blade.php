<!-- Section Title -->
<div class="section-header">
    <h2 class="section-title">Tin nổi bật
        <a class="btn-more" href="{{route('fe.asset.hot')}}">Xem thêm <i class="fa fa-angle-double-right" aria-hidden="true"></i></a></h2>
</div>
<!-- Section Content -->
<div class="row">
    <div class="col-md-4 col-sm-6">
        <?=\App\Helpers\Block::property_item(@$assets_hot[0])?>
    </div>

    <div class="col-md-4 col-md-push-4 col-sm-6">
        <?=\App\Helpers\Block::property_item(@$assets_hot[3])?>
    </div>
    <div class="col-md-4 col-md-pull-4">
        <!-- Property Item Short / Multiple Row Item -->
        <div class="multiple-item">
            <div class="row">
                <div class="col-md-12 col-sm-6">
                    <?=\App\Helpers\Block::property_item(@$assets_hot[1])?>
                </div>
                <div class="col-md-12 col-sm-6">
                    <?=\App\Helpers\Block::property_item(@$assets_hot[2])?>
                </div>
            </div>
        </div>
    </div>
</div>