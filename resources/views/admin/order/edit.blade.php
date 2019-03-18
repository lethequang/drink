@extends('layouts.admin')
<?php
//$isNew = sset($objectOder['id']) ? false: true;
$action_title = isset($objectOder['id']) ? 'Cập nhật' : 'Thêm mới';
?>
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <span class="text-capitalize">{{ $title }}</span>
            <small><?= $action_title; ?> <span>{{ $title }}</span>.</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/">Trang chủ</a></li>
            <li><a href="<?= route($controllerName . '.index'); ?>" class="text-capitalize">{{ ucfirst($title) }}</a>
            </li>
            <li class="active"><?= $action_title; ?></li>
        </ol>
        <br>
        <div id="error_div" class="alert alert-warning alert-dismissible" style="display: none;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-warning"></i> Thông báo!</h4>
            <span id="error_msg"></span>
        </div>
        <div id="success_div" class="alert alert-success alert-dismissible" style="display: none;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Thông báo!</h4>
            <span id="success_msg"></span>
        </div>
    </section>

    <!-- Main content -->
    <section class="content" style="padding-top: 0px;">
        <div class="row">
            <div class="col-md-12">
                <form id="frm-add" method="post" class="form-horizontal"
                      action="<?= isset($objectOder['id']) ? route($controllerName . '.update', ['id' => $objectOder['id']]) : route($controllerName . '.index'); ?>">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?= $action_title; ?> {{$title}}</h3>
                        </div>
                        <!-- form start -->

                        <div class="box-body">
                            <div class="row docs-premium-template">

                                <div class="col-md-6">
                                    <div class="box box-primary">

                                        <div class="box-header">
                                            <h3 class="box-title">Thông tin giao hàng</h3>
                                        </div>

                                        <div class="box-body">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" for="form-field-1">
                                                    Khách hàng
                                                </label>
                                                <div class="col-sm-8">
                                                    {!! Form::select("customer_id", $customer, @$objectOder['customer'], ['id' => 'customer','class' => 'form-control select2','data-placeholder' => '--- Chọn khách hàng ---']) !!}
                                                    <label id="customer-error" class="error"
                                                           for="customer">{!! $errors->first("customer") !!}</label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" for="form-field-1">
                                                    Người gửi <span class="required"></span>
                                                </label>
                                                <div class="col-sm-8">
                                                    {!! Form::text("name_customer_from", @$objectOder['name_customer_from'], ['id' => 'name_customer_from','class' => 'form-control']) !!}
                                                    <label id="name_customer_from-error" class="error"
                                                           for="name_customer_from">{!! $errors->first("name_customer_from") !!}</label>
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" for="form-field-1">
                                                    Giới tính
                                                </label>
                                                <div class="col-sm-5">
                                                    {!! Form::select("gender_from", $orderGender, @$objectOder['gender_from'], ['id' => 'gender_from','class' => 'form-control select2','data-placeholder' => '--- Chọn giới tính ---']) !!}
                                                    <label id="gender_from-error" class="error"
                                                           for="gender_from">{!! $errors->first("gender_from") !!}</label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" for="form-field-1">
                                                    Điện thoại <span class="required"></span>
                                                </label>
                                                <div class="col-sm-8">
                                                    {!! Form::text("phone_from", @$objectOder['phone_from'], ['id' => 'phone_from', 'class' => 'form-control']) !!}
                                                    <label id="phone_from-error" class="error"
                                                           for="phone_from">{!! $errors->first("phone_from") !!}</label>
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" for="form-field-1">
                                                    Email <span class="required"></span>
                                                </label>
                                                <div class="col-sm-8">
                                                    {!! Form::text("email_from", @$objectOder['email_from'], ['id' => 'email_from', 'class' => 'form-control']) !!}
                                                    <label id="email_from-error" class="error"
                                                           for="email_from">{!! $errors->first("email_from") !!}</label>
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" for="form-field-1">
                                                    Địa chỉ giao hàng <span class="required"></span>
                                                </label>
                                                <div class="col-sm-8">
                                                    {!! Form::text("address_from", @$objectOder['address_from'], ['id' => 'address_from','class' => 'form-control']) !!}
                                                    <label id="address_from-error" class="error"
                                                           for="address_from">{!! $errors->first("address_from") !!}</label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="box box-success">

                                        <div class="box-header">
                                            <h3 class="box-title">Thông tin nhận hàng</h3>
                                        </div>

                                        <div class="box-body">

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" for="form-field-1">
                                                    Người nhận <span class="required"></span>
                                                </label>
                                                <div class="col-sm-8">
                                                    {!! Form::text("name_customer_to", @$objectOder['name_customer_to'], ['class' => 'form-control']) !!}
                                                    <label id="name_customer_to-error" class="error"
                                                           for="name_customer_to">{!! $errors->first("name_customer_to") !!}</label>
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" for="form-field-1">
                                                    Giới tính
                                                </label>
                                                <div class="col-sm-5">
                                                    {!! Form::select("gender_to", $orderGender, @$objectOder['gender_to'], ['id' => 'gender_to','class' => 'form-control select2','data-placeholder' => '--- Chọn giới tính ---']) !!}
                                                    <label id="gender_to-error" class="error"
                                                           for="gender_to">{!! $errors->first("gender_to") !!}</label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" for="form-field-1">
                                                    Điện thoại <span class="required"></span>
                                                </label>
                                                <div class="col-sm-8">
                                                    {!! Form::text("phone_to", @$objectOder['phone_to'], ['class' => 'form-control']) !!}
                                                    <label id="phone_to-error" class="error"
                                                           for="phone_to">{!! $errors->first("phone_to") !!}</label>
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" for="form-field-1">
                                                    Email <span class="required"></span>
                                                </label>
                                                <div class="col-sm-8">
                                                    {!! Form::text("email_to", @$objectOder['email_to'], ['class' => 'form-control']) !!}
                                                    <label id="email_to-error" class="error"
                                                           for="email_to">{!! $errors->first("email_to") !!}</label>
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" for="form-field-1">
                                                    Địa chỉ nhận hàng <span class="required"></span>
                                                </label>
                                                <div class="col-sm-8">
                                                    {!! Form::text("address_to", @$objectOder['address_to'], ['class' => 'form-control']) !!}
                                                    <label id="address_to-error" class="error"
                                                           for="address_to">{!! $errors->first("address_to") !!}</label>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box box-info">

                                        <div class="box-header">
                                            <h3 class="box-title">Thông tin sản phẩm </h3>
                                        </div>

                                        <div class="box-body">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="form-field-1">
                                                    Loại sản phẩm
                                                </label>
                                                <div class="col-sm-6">
                                                    {!! Form::select('asset_category_id', $category, @$objectOder['asset_category_id'], [
                                                            'id' => 'asset_category_id',
                                                            'class' => 'form-control select2',
                                                            'data-placeholder' => '--- Chọn loại sản phẩm ---']) !!}

                                                    <label id="asset_category_id-error" class="error"
                                                           for="asset_category_id">{!! $errors->first("asset_category_id") !!}</label>

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="form-field-1">
                                                    Tên sản phẩm
                                                </label>
                                                <div class="col-sm-6">
                                                    {{--{!! Form::select('asset_id', $asset_id, @$objectOderOder['asset_id'], [--}}
                                                            {{--'id' => 'asset_id',--}}
                                                            {{--'class' => 'form-control select2',--}}
                                                            {{--'data-placeholder' => '--- Chọn  sản phẩm ---']) !!}--}}

                                                    {{--<select class="form-control" id="asset_id" name="asset_id">--}}
                                                        {{--<option selected="selected" value="all">Chọn sản phẩm</option>--}}
                                                    {{--</select>--}}
                                                    <input id="asset_id_auto" class="form-control" placeholder="Chọn sản phẩm">

                                                    <label id="asset_id-error" class="error"
                                                           for="asset_id">{!! $errors->first("asset_id") !!}</label>

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="form-field-1">
                                                    Mô tả sản phẩm
                                                </label>
                                                <div class="col-sm-6">
                                                    {!! Form::textarea("description_asset", @$objectOder['description_asset'],
                                                    ['id'=>'description_asset', 'class' => 'form-control', 'cols'=>"20", 'rows'=>"4"]) !!}
                                                    <label id="description_asset-error" class="error"
                                                           for="description_asset">{!! $errors->first("description_asset") !!}</label>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="form-field-1">
                                                    Thuộc tính sản phẩm
                                                </label>
                                                <div class="col-sm-6">
                                                    {!! Form::select('feature_id', $assetFeature, null, [
                                                    'id' => 'feature_id',
                                                    'class' => 'form-control select2',
                                                    'data-placeholder' => '--- Chọn thuộc tính sản phẩm ---']) !!}

                                                    <label id="feature_id-error" class="error"
                                                           for="feature_id">{!! $errors->first("feature_id") !!}</label>


                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="form-field-1">
                                                    Giá trị thuộc tính
                                                </label>
                                                <div class="col-sm-6" id="loadVariantId">
                                                    <select class="form-control select2" id="variant_id">
                                                    </select>
                                                    <label id="variant_id-error" class="error"
                                                           for="variant_id">{!! $errors->first("variant_id") !!}</label>
                                                </div>
                                                <a id="addAssetFeatureVariant" href="" class="btn btn-primary"><i
                                                            class="fa fa-plus" aria-hidden="true"></i> Chọn thêm</a>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="form-field-1">
                                                </label>
                                                <div class="col-sm-10">
                                                    <div class="appendFeature">
                                                        <table class="table" id="tableItem">
                                                            <thead>
                                                            <th>Tên thuộc tính</th>
                                                            <th>Giá trị thuộc tính</th>
                                                            <th>Giá</th>
                                                            <th>Hoạt động</th>
                                                            </thead>
                                                            <tbody></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="form-field-1">
                                                    Giá 1 sản phẩm:
                                                </label>
                                                <div class="col-sm-6" id="price">

                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="form-field-1">
                                                    Số lượng
                                                </label>
                                                <div class="col-sm-6">
                                                    {!! Form::select("number", $orderOptions, @$objectOder['number'], ['id' => 'number','class' => 'form-control select2','data-placeholder' => '--- Chọn số lượng ---']) !!}
                                                    <label id="number-error" class="error"
                                                           for="number">{!! $errors->first("number") !!}</label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" for="form-field-1">
                                                    Tổng tiền 1 sản phẩm:
                                                </label>
                                                <div class="col-sm-8" id="total">

                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-8 pull-right" id="add">
                                                    <a id="addAsset" href="" class="btn btn-primary"><i
                                                                class="fa fa-plus" aria-hidden="true"></i> Chọn thêm</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box box-info">

                                            <div class="box-header">
                                                <h3 class="box-title"> Danh sách chọn mua</h3>
                                            </div>

                                            <div class="box-body">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="form-field-1">
                                                    </label>
                                                    <div class="col-sm-12">
                                                        <div class="appendFeature">
                                                            <table class="table" id="tableAsset">
                                                                <thead>
                                                                <th>Tên sản phẩm</th>
                                                                <th>Số lượng</th>
                                                                <th>Thành tiền</th>
                                                                <th>Hoạt động</th>
                                                                </thead>
                                                                <tbody></tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label pull-left" for="form-field-1">
                                                        Tổng hóa đơn:
                                                    </label>
                                                    <div class="col-sm-8" id="total_order" name="total">

                                                    </div>

                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="form-field-1">
                                            Chú thích
                                        </label>
                                        <div class="col-sm-10">
                                            {!! Form::textarea("comment", @$objectOder['comment'],
                                            ['id'=>'comment', 'class' => 'form-control', 'cols'=>"20", 'rows'=>"4"]) !!}
                                            <label id="comment-error" class="error"
                                                   for="comment">{!! $errors->first("comment") !!}</label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                    </div>
                </form>
            </div>
        </div>
    </section>


    <!-- /.content -->
@endsection
@section('after_styles')
    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
    <link rel="stylesheet"
          href="/html/plugins/jQuery-File-Upload/css/jquery.fileupload.css">
    <style>
        .list-images img {
            width: 130px;
            height: 100px;
        }

        .list-images .image-item {
            float: left;
            position: relative;
            margin: 5px 10px;
        }

        .list-images .image-item .close {
            font-size: 30px;
            position: absolute;
            right: -8px;
            top: -15px;
        }

        #cke_description {
            margin-top: -1px;
        }

        .thumbnail-asset {
            width: 60px;
            height: 60px;
            display: inline-block;
            margin-right: 5px;
        }
    </style>
@endsection
@section('after_scripts')
    <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
    <script src="/html/plugins/jQuery-File-Upload/js/vendor/jquery.ui.widget.js"></script>
    <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
    <script src="/html/plugins/jQuery-File-Upload/js/jquery.iframe-transport.js"></script>
    <!-- The basic File Upload plugin -->
    <script src="/html/plugins/jQuery-File-Upload/js/jquery.fileupload.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"
            type="text/javascript"></script>
    <script src="/html-admin/plugins/ckeditor/ckeditor.js"></script>
    <script src="/html-admin/plugins/ckfinder/ckfinder.js?v=2019011622"></script>
    <script src="/html-admin/plugins/ckfinder/config.js?v=2019011622"></script>
    <script type="text/javascript"
            src="/html-admin/plugins/ckeditor/adapters/jquery.js"></script>
    <script type="text/javascript"
            src="/html-admin/plugins/ckeditor/config.js?v=2019011622"></script>

    <script type="text/javascript" src="{{ asset('assets/plugins/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.js') }}"></script>

    <!--Bootstrap Datepicker [ OPTIONAL ]-->
    <link href="{{ asset('assets/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/plugins/EasyAutocomplete-1.3.5/easy-autocomplete.themes.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/EasyAutocomplete-1.3.5/easy-autocomplete.css') }}" rel="stylesheet">


    <script>
        $('#demo-dp-range .input-daterange').datepicker({
            format: "yyyy-mm-dd",
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        });
    </script>

    <script type="text/javascript">
        $(function () {
            'use strict';
            // Change this to the location of your server-side upload handler:
            var url = '<?=route('upload-images')?>';
            $('#fileupload').fileupload({
                url: url,
                dataType: 'json',
                done: function (e, data) {
                    $.each(data.result.files, function (index, file) {
                        add_image(file.name);
                    });
                },
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#progress .progress-bar').css(
                        'width',
                        progress + '%'
                    );
                }
            }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
        });

        $(document).ready(function () {

            $('#feature_id').change(function () {
                var feature_id = $('#feature_id').val();
                var url = '/panel-kht/asset-feature-variant/ajax-disable-feature/' + feature_id;
                $.get(url).done(function (data) {
                    // console.log(data);

                    if (data.is_range == 1) {
                        $('#fromto').css('display', 'block');
                    } else {
                        $('#fromto').css('display', 'none');
                    }
                });

            });
            $('#feature_id').on('change', function () {
                loadAssetVariant();
            });
            $('#addAssetFeatureVariant').on('click', function (e) {
                e.preventDefault();
                addAssetFeatureVariant();


            });
            @if (session()->has('error'))
                @if (session('error'))
                    $('#error_msg').html('{{session('message')}}');
                    $('#error_div').show();
                @else
                    $('#success_msg').html('{{session('message')}}');
                    $('#success_div').show();
                @endif
            @endif

            $('.btn-add-image').on('click', function () {
                add_image($('#image_file').val());
            });

            get_provinces('#province_id', 0);
            $('#province_id').on('change', function () {
                get_districts_by_province($(this));
            });
            $('#district_id').on('change', function () {
                get_wards_by_district($(this));
            });

            $('#feature_id').on('change', function () {
                loadAssetVariant();
            });
            $('#customer').on('change', function () {
                loadInfoCustomer();
            });

            /*$('#asset_category_id').on('change', function () {
                loadAsset();

                // loadPrice();
                // loadAssetCategory();
            });*/
            $('#asset_id').on('change', function () {
                loadDescription();
                loadPrice();
                // loadAssetCategory();
            });
            $('#number').on('change', function () {
                loadTotal();
                // loadAssetCategory();
            });

            $('#addAsset').on('click', function (e) {
                e.preventDefault();
                addAsset();
                loadTotalOrder();
            });

            @if(isset($product_images))
            @foreach($product_images as $id => $image)
            add_image('<?= $image; ?>', '<?= $id; ?>');
            @endforeach
            @endif

            $(document).on('click', '.image-item .close', function () {
                $('.list-images').append('<input type="hidden" name="product_images[delete][]" value="' + $(this).attr('data-id') + '">');
                $(this).closest('.image-item').remove();
            });

            $('#frm-add').validate({
                ignore: ".ignore",
                rules: {
                    name: "required",
                    asset_category_id: "required",
                },
                messages: {
                    name: "Nhập tên sản phẩm",
                    asset_category_id: "Chọn loại sản phẩm",
                },
                submitHandler: function (form) {
                    ajax_loading(true);
                    for (instance in CKEDITOR.instances) {
                        CKEDITOR.instances[instance].updateElement();
                    }
                    var data = $(form).serializeArray();
                    $.ajax({
                        method: "<?= isset($objectOder['id']) ? 'PUT' : 'POST'; ?>",
                        url: $(form).attr('action'),
                        dataType: 'json',
                        data: data
                    })
                        .done(function (res) {
                            ajax_loading(false);
                            if (res.rs == 1) {
                                if (res.link_edit) {
                                    location.href = res.link_edit;
                                }
                                else {
                                    $('#success_msg').html(res.msg);
                                    $('#success_div').css("display", "block");
                                    $(window).scrollTop(0);
                                }
                            }
                            else {
                                $('#error_msg').html(res.msg);
                                $("#error_div").css("display", "block");
                                $(window).scrollTop(0);
                            }
                        })
                        .fail(function (res) {
                            // console.log(res);
                            ajax_loading(false);
                            if (res.status == 403) {
                                malert('Bạn không có quyền thực hiện tính năng này. Vui lòng liên hệ Admin!');
                            }
                            if (res.responseJSON.errors) {
                                $.each(res.responseJSON.errors, function (key, msg) {
                                    $('#' + key + '-error').html(msg).show();
                                });
                            }
                        });
                    return false;
                }
            });

            init_select2('.select2');
        });

        function add_image($image_location, id) {
            if (!$image_location) return false;
            id = id || 0;
            var item = $.now();
            $('.list-images').append('<div class="image-item">\n' +
                '<button type="button" class="close" data-id="' + id + '">&times;</button>' +
                '<img class="preview_image" src="' + $image_location + '">\n' +
                '<input type="hidden" name="product_images[' + item + '][id]" value="' + id + '">\n' +
                '<input type="hidden" name="product_images[' + item + '][image]" value="' + $image_location + '">\n' +
                '</div>');
        }

        function addAssetFeatureVariant() {

            var AssetFeaature = $('#feature_id').val();
            var data = $('#feature_id').select2('data');

            ftext = (data[0].text);

            var data2 = {
                _token: $('input[name ="_token"]').val()
            };
            $.post({
                url: "/panel-kht/asset-feature-variant/ajax-create/" + AssetFeaature,
                data2,
                success: function (result) {
                    // console.log(result);
                    add_feature_variant(AssetFeaature, ftext, result['id'], result['name']);
                }
            });


            var AssetFeaatureVariantName = $('#variant_id').text();
            var AssetFeaatureName = $('#feature_id').text();
            var data = $('#feature_id').select2('data');
// console.log(data);
            ftext = (data[0].text);
            // console.log(ftext);

            var data2 = $('#variant_id').select2('data');

            ftext2 = (data2[0].text);
            // console.log(ftext2);

            var AssetFeaatureVariant = $('#variant_id').val();
            // console.log(AssetFeaatureVariant);
            var AssetFeaature = $('#feature_id').val();

            var AssetFeaatureVariantName = $('#variant_id').text();
            // console.log(AssetFeaatureVariant);

            var flat = false;
            $('#tableItem > tbody  > tr').each(function () {
                var id = $(this).find('td input[name="variant_id[]"]').val();
                if (AssetFeaatureVariant == id) {
                    flat = true;
                }
            });
            if (AssetFeaatureVariant && !flat) {
                add_feature_variant(AssetFeaature, ftext, AssetFeaatureVariant, ftext2);
            }
        }

        function add_feature_variant(feature_id, feature_name, variant_id, variant_name, id) {
            var tmp = 'fv_' + feature_id + '_' + variant_id;

            var data2 = {
                _token: $('input[name ="_token"]').val()
            };
            $.post({
                url: "/panel-kht/asset-feature-variant/get-price/" + variant_id,
                data2,
                success: function (result) {
                    // console.log(result);
                    var priceVariant = result[0];
                    if ($('#' + tmp).attr('id') == tmp) return;

                    id = id || 0;
                    var item = $.now();
                    $('#tableItem tbody').append('<tr  id="' + tmp + '">\
                        <td>' + feature_name + '<input name="fvv[' + item + '][feature_id]" type="hidden" value="' + feature_id + '"/></td>\
                        <td>' + variant_name + '<input name="fvv[' + item + '][variant_id]" type="hidden" value="' + variant_id + '"/></td>\
                        <td>' + priceVariant + '<input name="fvv[' + item + '][variant_price]" type="hidden" value="' + priceVariant + '"/></td>\
                        <td><a href="#" class="add-tooltip btn btn-danger btn-xs btn-delete-fvv" data-toggle="tooltip" \
                            data-original-title="Xóa giá trị thuộc tính"><i class="fa fa-trash-o"></i> Xóa</a></td></tr>');

                }
            });


        }

        @if (isset($variants) && is_array($variants))
            @foreach($variants as $variant)
                add_feature_variant('{{$variant['feature_id']}}', '{{@$assetFeature[$variant['feature_id']]}}',
                '{{$variant['variant_id']}}', '{{$variant['variant_name']}}');
            @endforeach
        @endif

        $('body').on('click', '.btn-delete-fvv', function (e) {
            e.preventDefault();
            $(this).closest('tr').remove();
        });

        function addAsset() {
            // var AssetName = $('#asset_id').val();
            var data = $('#asset_id').select2('data');

            ftextAsset = (data[0].text);

            var data = $('#number').select2('data');
            ftextNumber = (data[0].text);


            var ftextTotal = $('#total').text();


            var AssetId = $('#asset_id').val();

            var NumberId = $('#number').val();


            var flat = false;
            $('#tableAsset > tbody  > tr').each(function () {
                var id = $(this).find('td input[name="asset_id[]"]').val();
                if (AssetId == id) {
                    flat = true;
                }
            });
            if (AssetId && !flat) {
                add_number(AssetId, ftextAsset, NumberId, ftextNumber, ftextTotal);
            }


        }

        function add_number(AssetId, ftextAsset, NumberId, ftextNumber, ftextTotal, id) {
            var tmp = 'as_' + AssetId + '_' + NumberId;

            if ($('#' + tmp).attr('id') == tmp) return;

            id = id || 0;
            var item = $.now();
            $('#tableAsset tbody').append('<tr id="' + tmp + '">\
                    <td>' + ftextAsset + '<input name="ass[' + item + '][AssetId]" type="hidden" value="' + AssetId + '"/></td>\
                    <td>' + ftextNumber + '<input name="ass[' + item + '][NumberId]" type="hidden" value="' + NumberId + '"/></td>\
                    <td>' + ftextTotal + '<input name="ass[' + item + '][ftextTotal]" type="hidden" value="' + total + '"/></td>\
                    <td><a href="#" class="add-tooltip btn btn-danger btn-xs btn-delete-asset" data-toggle="tooltip" \
                        data-original-title="Xóa sản phẩm"><i class="fa fa-trash-o"></i> Xóa</a></td></tr>');
        }

        @if (isset($variants) && is_array($variants))
            @foreach($variants as $variant)
            add_feature_variant('{{$variant['feature_id']}}', '{{@$assetFeature[$variant['feature_id']]}}',
                '{{$variant['variant_id']}}', '{{$variant['variant_name']}}');
            @endforeach
        @endif

        $('body').on('click', '.btn-delete-ass', function (e) {
            e.preventDefault();
            $(this).closest('tr').remove();
        });

        $('body').on('click', '.btn-delete-asset', function (e) {
            e.preventDefault();
            $(this).closest('tr').remove();
            subTotalOrder();
        });


		var options = {

			url: "/panel-kht/asset-ajax/load-all-asset",

			getValue: "name",

			list: {
				match: {
					enabled: true
				},
				maxNumberOfElements: 200
			},

			template: {
				type: "custom",
				method: function(value, item) {
					return "<span class=''><img class='thumbnail-asset' src='" + item.image_url + item.image + "' /></span>" + value;
				}
			},

		};

		$("#asset_id_auto").easyAutocomplete(options);

		$('#asset_category_id').change(function () {
            searchAsset();
		})

        function searchAsset() {
			var valId = $('#asset_category_id').val();
			var data = {
				id: valId,
				_token: $('input[name ="_token"]').val()
			};

			$.post({
				url: "/panel-kht/asset/loadAssetByAssetCategory/" + valId,
				data,
				success: function (result) {
					console.log(result);

					$('#asset_id').html('');

					var options = {

						getValue: "name",

						list: {
							match: {
								enabled: true
							},
							maxNumberOfElements: 200
						},

						template: {
							type: "custom",
							method: function(value, item) {
								return "<span class=''><img class='thumbnail-asset' src='" + item.image_url + item.image + "' /></span>" + value;
							}
						},

					};

					$("#asset_id_auto").easyAutocomplete(options);

					if (data.length == 0) {
						var divPrice = document.getElementById('price');

						divPrice.innerHTML = "";

						var divTotal = document.getElementById('total');

						divTotal.innerHTML = "";
					}
					else {
						$('#asset_id').val() == data[0].id;
						loadPrice();
					}
				}
        })

		$.ajax({
			url: "/panel-kht/asset-ajax/load-all-asset",
			success: function (result) {
				var data = $.map(result, function (obj) {
					//obj.id = obj.id;
					//obj.text = obj.name + obj.price;

					return "<img src='" + obj.image_url + obj.image + "'/>" + obj.name;
				});

				$('#asset_id').html('');
				$("#asset_id").select2({
                    data: data,
					formatResult: data,
					formatSelection: data,
					escapeMarkup: function(m) { return m; }
				});
			}
		});

        function loadAsset() {
            var valId = $('#asset_category_id').val();
            var data = {
                id: valId,
                _token: $('input[name ="_token"]').val()
            };

            $.post({
                url: "/panel-kht/asset/loadAssetByAssetCategory/" + valId,
                data,
                success: function (result) {
                    var data = $.map(result, function (obj) {
                        obj.id = obj.id;
                        obj.text = obj.name;
                        return obj;
                    });

                    $('#asset_id').html('');
                    $("#asset_id").select2({
                        data: data
                    });
                    if (data.length == 0) {
                        var divPrice = document.getElementById('price');

                        divPrice.innerHTML = "";

                        var divTotal = document.getElementById('total');

                        divTotal.innerHTML = "";
                    }
                    else {
                        $('#asset_id').val() == data[0].id;
                        loadPrice();
                    }
                }
            });

        }

        function loadPrice() {
            var valId = $('#asset_id').val();
            console.log(valId);

            var data = {
                id: valId,
                _token: $('input[name ="_token"]').val()
            };
            $.post({
                url: "/panel-kht/asset/loadPrice/" + valId,
                data,
                success: function (result) {
                    // console.log(result);
                    var data = $.map(result, function (obj) {
                        obj.id = obj.id;
                        obj.text = obj.name;
                        return obj;
                    });
                    console.log(data[0].price);


                    var div = document.getElementById('price');
                    div.innerHTML = data[0].price;

                    if (data.length !== 0) {
                        loadTotal();
                    }

                    /* var options = '';
                        for(var i=0;i<result.length;i++){
                            options += '<option value="'+result[i].district_id+'">'+result[i].name+'</option>';
                        }
                        console.log(options);
                        $("#loadDistrict").html('<select class="form-control select2" id="">'+options+'</select>');*/

                }
            });
        }

        function loadDescription() {
            var valId = $('#asset_id').val();
            console.log(valId);

            var data = {
                id: valId,
                _token: $('input[name ="_token"]').val()
            };
            $.post({
                url: "/panel-kht/asset/loadDescription/" + valId,
                data,
                success: function (result) {
                    // console.log(result);
                    var data = $.map(result, function (obj) {
                        obj.id = obj.id;
                        obj.text = obj.name;
                        return obj;
                    });
                    console.log(data[0].description);
                    var div = document.getElementById('description_asset');

                    div.innerHTML = data[0].description;

                    // if (data.length !== 0) {
                    //     loadTotal();
                    // }


                }
            });
        }

        function loadInfoCustomer() {
            var valId = $('#customer').val();
            // console.log(valId);

            var data = {
                id: valId,
                _token: $('input[name ="_token"]').val()
            };
            $.post({
                url: "/panel-kht/customers/loadInfoCustomer/" + valId,
                data,
                success: function (result) {
                    console.log(result);
                    var name_customer_from = document.getElementById("name_customer_from");
                    name_customer_from.value = result.fullname;

                    // var gender_from = document.getElementById("gender_from");
                    // gender_from.select2 = result.gender;
                    $("#gender_from").select2("val", "gender");
                    // $('#gender_from').val("gender").change();


                    var phone_from = document.getElementById("phone_from");
                    phone_from.value = result.phone;

                    var email_from = document.getElementById("email_from");
                    email_from.value = result.email;

                    var address_from = document.getElementById("address_from");
                    address_from.value = result.address;

                }
            });
        }

        function loadTotal() {
            var textAsset = $('#price').text();
            var number = $('#number').val();

            var div = document.getElementById('total');

            div.innerHTML = textAsset * number;
        }

        function loadTotalOrder() {
            var total = 0;
            $('#tableAsset > tbody  > tr').each(function () {
                // alert($(this).find('td').eq(1).text());
                var ftextTotal = $(this).find('td').eq(2).text();
                total += parseInt(ftextTotal);
                console.log(total);
                // var total = total +
            });
            var div = document.getElementById('total_order');

            div.innerHTML = total;


        }

        function subTotalOrder() {
            var total = $('#total_order').text();
            var sub = $('#total_order').text();
             var text = parseInt(total);


                console.log(ftextTotal);
                text -= parseInt(ftextTotal);
                console.log(total);
                // var total = total +

            var div = document.getElementById('total_order');

            div.innerHTML = total;


        }

        function loadAssetVariant() {
            var valId = $('#feature_id').val();
            // console.log(valId);

            var data = {
                id: valId,
                _token: $('input[name ="_token"]').val()
            };
            $.post({
                url: "/panel-kht/asset/loadAssetFeatureVariant/" + valId,
                data,
                success: function (result) {
                    // console.log(result);
                    var data = $.map(result, function (obj) {
                        obj.id = obj.id;
                        obj.text = obj.name;
                        return obj;
                    });
                    // console.log(data);
                    $('#variant_id').html('');
                    $("#variant_id").select2({
                        data: data
                    });
                    /* var options = '';
                        for(var i=0;i<result.length;i++){
                            options += '<option value="'+result[i].district_id+'">'+result[i].name+'</option>';
                        }
                        console.log(options);
                        $("#loadDistrict").html('<select class="form-control select2" id="">'+options+'</select>');*/

                }
            });
        }
    </script>
@endsection
