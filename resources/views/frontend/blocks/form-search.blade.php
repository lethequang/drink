<?php
$params = request()->all();
$assets_prices = \App\Helpers\General::get_assets_prices();
?>
<!-- Tabmenu Container / Default Bootstrap Structure -->
<div class="search-tabmenu">
    <!-- Tabmenu Navigation -->
    <ul class="nav nav-tabs" role="tablist">
        <li {!! !isset($params['type']) || $params['type']=='lease'?'class="active"':'' !!}>
            <a href="#for-sale" role="tab" data-toggle="tab"><i class="fi flaticon-sale"></i> Nhà đất cho thuê</a></li>
        <li {!! @$params['type']=='buy'?'class="active"':'' !!}>
            <a href="#for-rent" role="tab" data-toggle="tab"><i class="fi flaticon-rent"></i> Nhà đất cần thuê</a></li>
    </ul>
    <!-- Tabmenu Body / Content -->
    <div class="tab-content">
        <!-- Tabmenu Content 1 / Property For SALE -->
        <div role="tabpanel" class="tab-pane {!! !isset($params['type']) || $params['type']=='lease'?'active':'' !!}" id="for-sale">
            <form action="{{route('fe.search.index')}}" id="frm-sale-search" method="get">
                <input name="type" type="hidden" value="lease">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="sale-location">Thành Phố</label>
                            <select name="province" class="form-control province_has_asset change" id="sale-location" data-id="{{@$params['province']}}"
                                    data-destination="#frm-sale-search .district" data-asset="1" data-placeholder="Chọn Tỉnh / Thành Phố">
                                <option>Chọn Tỉnh / Thành Phố</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="sale-district">Quận/Huyện</label>
                            <select name="district" class="form-control district change" data-id="{{@$params['district']}}"
                                    data-destination="#frm-sale-search .ward" data-asset="1" id="sale-district" data-placeholder="Chọn Quận Huyện">
                                <option>Chọn Quận Huyện</option>
                            </select>
                        </div>
                        <?php
                        $assets_categories = \App\Helpers\General::get_assets_categories('lease');
            
                        $assetFeatures = \App\Helpers\General::get_assets_feature();
                        ?>
                        <div class="col-md-4 form-group">
                            <label for="sale-type">Loại Nhà Cho Thuê</label>
                            {!! Form::select("cid", ['' => 'Chọn Loại Nhà Cho Thuê']+$assets_categories, @$params['cid'],
                            ['class' => 'form-control', "data-placeholder" => "Chọn Loại Nhà Cho Thuê"]) !!}
                        </div>
                    </div>

                    <div class="collapse" id="collapseExample">
                        <div class="row">
                            <div class="col-md-2 col-xs-6 form-group">
                                <label for="sale-ward">Phường/Xã</label>
                                <select class="form-control ward" id="sale-ward" name="ward" data-id="{{@$params['ward']}}"
                                        data-placeholder="Chọn Phường/Xã">
                                    <option>Chọn Phường/Xã</option>
                                </select>
                            </div>
                            @foreach($assetFeatures as $key => $assetFeature)
                            <div class="col-md-2 col-xs-6 form-group">
                                <label>{{ $assetFeature -> name }} </label>
                                <select name= "fv[{{ $assetFeature -> id }}]" class="form-control">
                                    <option value=" ">Vui lòng chọn</option>
                                   @for($x = 0; $x < $assetFeature->assetFeatureVariant()->count(); $x++)

                                    <option value="{{ $assetFeature->assetFeatureVariant[$x]->id }}">{{ $assetFeature->assetFeatureVariant[$x]->name }}</option>
                                   @endfor
                                </select>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="sale-range-feet">Diện tích (m2)</label>
                            <div class="range-box">
                                <input id="sale-range-feet" type="text" data-from="{{@$params['acreage_from']}}" data-to="{{@$params['acreage_to']}}">
                                <input name="acreage_from" id="acreage_from" type="hidden" value="{{@$params['acreage_from']}}">
                                <input name="acreage_to" id="acreage_to" type="hidden" value="{{@$params['acreage_to']}}">
                            </div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="sale-range-price">Giá (VNĐ)</label>
                            {!! Form::select("price", ['' => 'Chọn Giá']+$assets_prices, @$params['price'],
                            ['class' => 'form-control', "data-placeholder" => "Chọn Giá"]) !!}
                        </div>
                        <div class="col-md-3 form-group">
                            <button class="btn btn-primary pull-right btn-submit" type="submit"><i
                                        class="fa fa-search"></i> Tìm Kiếm
                            </button>
                        </div>
                        <div class="col-md-1 form-group">
                            <a title="Nâng cao" class="btn pull-right btn-submit" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-cogs" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div role="tabpanel" class="tab-pane {!! @$params['type']=='buy'?'active':'' !!}" id="for-rent">
            <form action="{{route('fe.search.index')}}" id="frm-rent-search" method="get">
                <input name="type" type="hidden" value="buy">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="sale-location">Thành Phố</label>
                            <select name="province"  class="form-control province_has_asset change" id="rent-location" data-id="{{@$params['province']}}"
                                    data-destination="#frm-rent-search .district" data-asset="1" data-placeholder="Chọn Tỉnh / Thành Phố">
                                <option>Chọn Thành Phố</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="sale-district">Quận/Huyện</label>
                            <select class="form-control district change" name="district" data-id="{{@$params['district']}}"
                                    data-destination="#frm-rent-search .ward" id="rent-district" data-placeholder="Chọn Quận Huyện">
                                <option>Chọn Quận Huyện</option>
                            </select>
                        </div>
                        <?php
                        $assets_categories = \App\Helpers\General::get_assets_categories('buy');
                        ?>
                        <div class="col-md-4 form-group">
                            <label for="sale-type">Loại Nhà Cần Thuê</label>
                            {!! Form::select("cid", ['' => 'Chọn Loại Nhà Cần Thuê']+$assets_categories, @$params['cid'],
                                    ['class' => 'form-control', "data-placeholder" => "Chọn Loại Nhà Cần Thuê"]) !!}
                        </div>
                    </div>

                    <div class="collapse" id="collapseExample1">
                        <div class="row">
                            <div class="col-md-2 col-xs-6 form-group">
                                <label for="rent-ward">Phường/Xã</label>
                                <select class="form-control ward" id="rent-ward" name="ward" data-id="{{@$params['ward']}}"
                                        data-placeholder="Chọn Phường/Xã">
                                    <option>Chọn Phường/Xã</option>
                                </select>
                            </div>
                            @foreach($assetFeatures as $key => $assetFeature)
                            <div class="col-md-2 col-xs-6 form-group">
                                <label>{{ $assetFeature -> name }} </label>
                                <select name= "fv[{{ $assetFeature -> id }}]" class="form-control">
                                    <option value=" ">Vui lòng chọn</option>
                                   @for($x = 0; $x < $assetFeature->assetFeatureVariant()->count(); $x++)

                                    <option value="{{ $assetFeature->assetFeatureVariant[$x]->id }}">{{ $assetFeature->assetFeatureVariant[$x]->name }}</option>
                                   @endfor
                                </select>
                            </div>
                            @endforeach
                            {{-- <div class="col-md-2 col-xs-6 form-group">
                                <label>Nhà xe</label>
                                <select class="form-control">
                                    <option>Không</option>
                                    <option>Có</option>
                                </select>
                            </div>
                            <div class="col-md-2 col-xs-6 form-group">
                                <label>Hẻm xe hơi</label>
                                <select class="form-control">
                                    <option>Không</option>
                                    <option>Có</option>
                                </select>
                            </div>
                            <div class="col-md-2 col-xs-6 form-group">
                                <label>Số tầng</label>
                                <select class="form-control">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>> 4</option>
                                </select>
                            </div>
                            <div class="col-md-2 col-xs-6 form-group">
                                <label>Toilet</label>
                                <select class="form-control">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>> 4</option>
                                </select>
                            </div>
                            <div class="col-md-2 col-xs-6 form-group">
                                <label>Số phòng ngủ</label>
                                <select class="form-control">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>> 4</option>
                                </select>
                            </div> --}}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="sale-range-feet">Diện tích (m2)</label>
                            <div class="range-box">
                                <input id="sale-range-feet-1" type="text" data-from="{{@$params['acreage_from']}}" data-to="{{@$params['acreage_to']}}">
                                <input name="acreage_from" id="acreage_from1" type="hidden" value="{{@$params['acreage_from']}}">
                                <input name="acreage_to" id="acreage_to1" type="hidden" value="{{@$params['acreage_to']}}">
                            </div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="sale-range-price">Giá (VNĐ)</label>
                            {!! Form::select("price", ['' => 'Chọn Giá']+$assets_prices, @$params['price'],
                            ['class' => 'form-control', "data-placeholder" => "Chọn Giá"]) !!}
                        </div>
                        <div class="col-md-3 form-group">
                            <button class="btn btn-primary pull-right btn-submit" type="submit"><i
                                        class="fa fa-search"></i> Tìm Kiếm
                            </button>
                        </div>
                        <div class="col-md-1 form-group">
                            <a title="Nâng cao" class="btn pull-right btn-submit" role="button" data-toggle="collapse" href="#collapseExample1" aria-expanded="false" aria-controls="collapseExample1"><i class="fa fa-cogs" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>