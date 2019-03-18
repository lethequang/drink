<!-- Tabmenu Container / Default Bootstrap Structure -->
<?php
$params = request()->all();
$ac = \App\Helpers\General::get_controller_action();
$assets_prices = \App\Helpers\General::get_assets_prices();
?>
<div class="search-tabmenu">
    <!-- Tabmenu Navigation -->
    <ul class="nav nav-tabs" role="tablist">
        <li {!! !isset($params['type']) || $params['type']=='lease'?'class="active"':'' !!}>
            <a href="#for-sale" role="tab" data-toggle="tab"><i class="fi flaticon-sale"></i> Cho Thuê</a></li>
        <li {!! @$params['type']=='buy'?'class="active"':'' !!}>
            <a href="#for-rent" role="tab" data-toggle="tab"><i class="fi flaticon-rent"></i> Cần thuê</a></li>
    </ul>
    <div class="tab-content">
        <!-- Tab Content For Sale -->
        <div role="tabpanel" class="tab-pane {!! !isset($params['type']) || $params['type']=='lease'?'active':'' !!}" id="for-sale">
            <?php
            $link_search = isset($ac['as']) && $ac['as']=='fe.asset.hot' ? '' : \App\Helpers\Block::get_link_asset_category(['type'=>'lease']);
            ?>
            <form action="{{$link_search}}" id="frm-sale-search" method="get">
                <input name="type" type="hidden" value="lease">
                <div class="form-body">
                    <div class="form-group">
                        <label for="sale-location">Thành phố</label>
                        <select name="province" class="form-control province_has_asset change" id="sale-location" data-id="{{@$params['province']}}"
                                data-destination="#frm-sale-search .district" data-placeholder="Chọn Tỉnh / Thành Phố">
                            <option>Chọn Tỉnh / Thành Phố</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sale-district">Quận/huyện</label>
                        <select name="district" class="form-control district change" data-id="{{@$params['district']}}"
                                data-destination="#frm-sale-search .ward" data-asset="1" id="sale-district" data-placeholder="Chọn Quận Huyện">
                            <option>Chọn Quận Huyện</option>
                        </select>
                    </div>
                    <?php
                    $assets_categories = \App\Helpers\General::get_assets_categories('lease');
                    ?>
                    <div class="form-group">
                        <label for="sale-bathroom">Loại nhà</label>
                        {!! Form::select("cid", ['' => "Chọn Loại Nhà Cho Thuê"]+$assets_categories, @$params['cid'],
                            ['class' => 'form-control', "data-placeholder" => "Chọn Loại Nhà Cho Thuê"]) !!}
                    </div>
                    <div class="form-group">
                        <label for="sale-range-feet">Diện tích (m2)</label>
                        <div class="range-box">
                            <input id="sale-range-feet" type="text" data-from="{{@$params['acreage_from']}}" data-to="{{@$params['acreage_to']}}">
                            <input name="acreage_from" id="acreage_from" type="hidden" value="{{@$params['acreage_from']}}">
                            <input name="acreage_to" id="acreage_to" type="hidden" value="{{@$params['acreage_to']}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sale-range-price">Giá (VNĐ)</label>
                        {!! Form::select("price", ['' => 'Chọn Giá']+$assets_prices, @$params['price'],
                            ['class' => 'form-control', "data-placeholder" => "Chọn Giá"]) !!}
                    </div>
                    <?php
        
                    $assetFeatures = \App\Helpers\General::get_assets_feature();
                    ?>
                    <div class="collapse" id="collapseExample3">
                        <div class="row">
                                @foreach($assetFeatures as $key => $assetFeature)
                                <div class="col-xs-6 form-group">
                                    <label>{{ $assetFeature -> name }} </label>
                                    <select name= "fv[{{ $assetFeature -> id }}]" class="form-control">
                                        <option value=" ">Vui lòng chọn</option>
                                       @for($x = 0; $x < $assetFeature->assetFeatureVariant()->count(); $x++)
    
                                        <option value="{{ $assetFeature->assetFeatureVariant[$x]->id }}">{{ $assetFeature->assetFeatureVariant[$x]->name }}</option>
                                       @endfor
                                    </select>
                                </div>
                                @endforeach
                            {{-- <div class="col-xs-6 form-group">
                                <label for="sale-ward">Phường/Xã</label>
                                <select class="form-control ward" id="sale-ward" name="ward" data-id="{{@$params['ward']}}"
                                        data-placeholder="Chọn Phường/Xã">
                                    <option>Chọn Phường/Xã</option>
                                </select>
                            </div>
                            <div class="col-xs-6 form-group">
                                <label>Nhà xe</label>
                                <select class="form-control">
                                    <option>Không</option>
                                    <option>Có</option>
                                </select>
                            </div> --}}
                        </div>
                        
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary btn-submit" type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
                    </div>

                    <div>
                        <a title="Nâng cao" class="btn-advance" role="button" data-toggle="collapse" href="#collapseExample3" aria-expanded="false" aria-controls="collapseExample1">Tìm kiếm nâng cao</a>
                    </div>
                </div>
            </form>
        </div>
        <!-- Tab Content For Rent -->
        <div role="tabpanel" class="tab-pane {!! @$params['type']=='buy'?'active':'' !!}" id="for-rent">
            <?php
            $link_search = isset($ac['as']) && $ac['as']=='fe.asset.hot' ? '' : \App\Helpers\Block::get_link_asset_category(['type'=>'buy']);
            ?>
            <form action="{{$link_search}}" id="frm-rent-search" method="get">
                <input name="type" type="hidden" value="buy">
                <div class="form-body">
                    <div class="form-group">
                        <label for="sale-location">Thành phố</label>
                        <select class="form-control province_has_asset change" name="province" id="rent-location" data-asset="1" data-id="{{@$params['province']}}"
                                data-destination="#frm-rent-search .district" data-placeholder="Chọn Tỉnh / Thành Phố">
                            <option>Chọn Thành Phố</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="rent-district">Quận/huyện</label>
                        <select class="form-control district change" id="rent-district" name="district" data-id="{{@$params['district']}}"
                                data-destination="#frm-rent-search .ward" data-asset="1" data-placeholder="Chọn Quận Huyện">
                            <option>Chọn Quận Huyện</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <?php
                        $assets_categories = \App\Helpers\General::get_assets_categories('buy');
                        ?>
                        <label for="sale-bathroom">Loại nhà</label>
                        {!! Form::select("cid", ['' => "Chọn Loại Nhà Cần Thuê"]+$assets_categories, @$params['cid'],
                                        ['class' => 'form-control', "data-placeholder" => "Chọn Loại Nhà Cần Thuê"]) !!}
                    </div>
                    <div class="form-group">
                        <label for="sale-range-feet">Diện tích (m2)</label>
                        <div class="range-box">
                            <input id="sale-range-feet-1" type="text" data-from="{{@$params['acreage_from']}}" data-to="{{@$params['acreage_to']}}">
                            <input name="acreage_from" id="acreage_from1" type="hidden" value="{{@$params['acreage_from']}}">
                            <input name="acreage_to" id="acreage_to1" type="hidden" value="{{@$params['acreage_to']}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sale-range-price">Giá (VNĐ)</label>
                        {!! Form::select("price", ['' => 'Chọn Giá']+$assets_prices, @$params['price'],
                            ['class' => 'form-control', "data-placeholder" => "Chọn Giá"]) !!}
                    </div>

                    <div class="collapse" id="collapseExample4">
                        <div class="row">
                                @foreach($assetFeatures as $key => $assetFeature)
                                <div class="col-xs-6 form-group">
                                    <label>{{ $assetFeature -> name }} </label>
                                    <select name= "fv[{{ $assetFeature -> id }}]" class="form-control">
                                        <option value=" ">Vui lòng chọn</option>
                                       @for($x = 0; $x < $assetFeature->assetFeatureVariant()->count(); $x++)
    
                                        <option value="{{ $assetFeature->assetFeatureVariant[$x]->id }}">{{ $assetFeature->assetFeatureVariant[$x]->name }}</option>
                                       @endfor
                                    </select>
                                </div>
                                @endforeach
                            {{-- <div class="col-xs-6 form-group">
                                <label for="rent-ward">Phường/Xã</label>
                                <select class="form-control ward" id="rent-ward" name="ward" data-id="{{@$params['ward']}}"
                                        data-placeholder="Chọn Phường/Xã">
                                    <option>Chọn Phường/Xã</option>
                                </select>
                            </div>
                            <div class="col-xs-6 form-group">
                                <label>Nhà xe</label>
                                <select class="form-control">
                                    <option>Không</option>
                                    <option>Có</option>
                                </select>
                            </div> --}}
                        </div>
                        
                      
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary btn-submit" type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
                    </div>

                    <div>
                        <a title="Nâng cao" class="btn-advance" role="button" data-toggle="collapse" href="#collapseExample4" aria-expanded="false" aria-controls="collapseExample1">Tìm kiếm nâng cao</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>