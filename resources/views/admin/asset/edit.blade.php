@extends('layouts.admin')
<?php
//$isNew = sset($object['id']) ? false: true;
$action_title = isset($object['id']) ? 'Cập nhật' : 'Thêm mới';
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
                      action="<?= isset($object['id']) ? route($controllerName . '.update', ['id' => $object['id']]) : route($controllerName . '.index'); ?>">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?= $action_title; ?> {{$title}}</h3>
                        </div>
                        <!-- form start -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" for="form-field-1">
                                            Tên sản phẩm <span class="required"></span>
                                        </label>
                                        <div class="col-sm-8">
                                            {!! Form::text("name", @$object['name'], ['class' => 'form-control']) !!}
                                            <label id="name-error" class="error"
                                                   for="name">{!! $errors->first("name") !!}</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" for="form-field-1">
                                            Tỉnh/thành phố
                                        </label>
                                        <div class="col-sm-3">
                                            {!! Form::select("province_id", [], null,
                                                ['id' => 'province_id', 'class' => 'form-control select2 province_id ',
                                                'data-destination' => '#district_id', 'data-id' => @$object['province_id'],
                                                'data-placeholder' => 'Chọn tỉnh/thành phố']) !!}
                                            <label id="province_id-error" class="error"
                                                   for="province_id">{!! $errors->first("province_id") !!}</label>
                                        </div>

                                        <label class="col-sm-2 control-label" for="form-field-1">
                                            Quận/huyện
                                        </label>
                                        <div class="col-sm-3">
                                            <select class="form-control select2" id="district_id" name="district_id"
                                                    data-id="{{@$object['district_id']}}" data-destination="#ward_id"
                                                    data-placeholder="Chọn Quận / Huyện"></select>
                                            <label id="district_id-error" class="error"
                                                   for="district_id">{!! $errors->first("district_id") !!}</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" for="form-field-1">
                                            Phường\xã
                                        </label>
                                        <div class="col-sm-3" id="loadWardId">
                                            <select class="form-control select2" id="ward_id" name="ward_id"
                                                    data-id="{{@$object['ward_id']}}" data-placeholder="Chọn Phường/Xã">
                                            </select>
                                            <label id="ward_id-error" class="error"
                                                   for="ward_id">{!! $errors->first("ward_id") !!}</label>
                                        </div>

                                        <label class="col-sm-2 control-label" for="form-field-1">
                                            Ưu tiên
                                        </label>
                                        <div class="col-sm-3">
                                            {!! Form::select("position", $orderOptions, @$object['position'], ['id' => 'position','class' => 'form-control select2','data-placeholder' => '--- Chọn thứ tự ---']) !!}
                                            <label id="order-error" class="error"
                                                   for="position">{!! $errors->first("position") !!}</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" for="form-field-1">
                                            Trạng thái
                                        </label>
                                        <div class="col-sm-8">
                                            <label class="radio-inline">
                                                <input type="radio" name="status" id="status1"
                                                       value="1" <?= !isset($object['status']) || @$object['status'] == '1' ? 'checked' : ''; ?>>
                                                Kích hoạt
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="status" id="status2"
                                                       value="0" <?= @$object['status'] == '0' ? 'checked' : ''; ?>>
                                                Không
                                                kích hoạt
                                            </label>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" for="form-field-1">
                                            Nổi bật
                                        </label>
                                        <div class="col-sm-8">
                                            <label class="radio-inline">
                                                <input type="radio" name="is_hot" id="is_hot1"
                                                       value="1" <?= !isset($object['is_hot']) || @$object['is_hot'] == '1' ? 'checked' : ''; ?>>
                                                Kích hoạt
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="is_hot" id="is_hot2"
                                                       value="0" <?= @$object['is_hot'] == '0' ? 'checked' : ''; ?>>
                                                Không
                                                kích hoạt
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" for="form-field-1">
                                            Giá
                                        </label>
                                        <div class="col-sm-3">
                                            {!! Form::text("price", @$object['price'], ['class' => 'form-control']) !!}
                                            <label id="price-error" class="error"
                                                   for="price">{!! $errors->first("price") !!}</label>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" for="form-field-1">
                                            Loại sản phẩm
                                        </label>
                                        <div class="col-sm-5">
                                            {!! Form::select('asset_category_id', $category, @$object['asset_category_id'], [
                                                    'id' => 'category',
                                                    'class' => 'form-control select2',
                                                    'data-placeholder' => '--- Chọn loại sản phẩm ---']) !!}

                                            <label id="asset_category_id-error" class="error"
                                                   for="asset_category_id">{!! $errors->first("asset_category_id") !!}</label>


                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" for="form-field-1"> <strong>Hình ảnh
                                                chính </strong>
                                        </label>
                                        <div class="col-sm-8 btn-file">
                                            <div class="fileupload-new thumbnail"
                                                 style="width: 140px; height: 150px; margin-bottom: 3px;">
                                                <?php
                                                if (strlen(old('image')) == 1) {
                                                    $path = old('image');
                                                } else {
                                                    $path = $object['image'] ?? '/images/no-image.jpeg';
                                                }
                                                ?>
                                                <img id="preview-file-upload" class="preview-file-upload"
                                                     style="width: 130px; height: 140px;"
                                                     src="{!! @$object['image_url'].$path !!}">
                                            </div>

                                            {!! Form::text("image", $path, ['id' => 'image', 'class' => 'form-control', 'data-url' => '#image_url']) !!}
                                            {!! Form::hidden("image_url", @$object['image_url'], ['id' => 'image_url']) !!}

                                            <div class="p-l-file">
                                                <a href="#" data-target="image"
                                                   class="iframe-btn browse-image" type="button"> <i
                                                            class="fa fa-paperclip"></i>&nbsp;&nbsp;Chọn hình
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-sm-6 control-label" for="form-field-1"> <strong>Hình ảnh
                                                phụ</strong>
                                        </label>
                                        <div class="col-sm-6 btn-file">
                                            <span class="btn btn-success fileinput-button">
                                            <i class="glyphicon glyphicon-plus"></i>
                                            <span>Chọn tập tin...</span>
                                                <!-- The file input field used as target for the file upload widget -->
                                                <input id="fileupload" type="file" name="files[]" multiple>
                                            </span>
                                            <div id="files" class="files" style="float: right;max-width: 450px;"></div>
                                            <div style="clear: both;"></div>
                                            <!-- The global progress bar -->
                                            <div id="progress" class="progress" style="margin-top: 10px;">
                                                <div class="progress-bar progress-bar-success"></div>
                                            </div>
                                            <input id="file" type="hidden" name="file" value="">
                                            <label id="file-error" class="error" for="file"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8 list-images"></div>
                            </div>


                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="form-field-1">
                                            Chọn ngày đăng bán
                                        </label>

                                        <div class="col-sm-3" id="demo-dp-range">
                                            <div class="input-daterange input-group" id="datepicker">
                                                <input id="created_time_from" type="text" class="form-control"
                                                       name="date_public"
                                                       value="<?= isset($object['id']) ? @$object['date_public'] : '' ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{--<div class="row">--}}
                                {{--<div class="col-sm-12">--}}
                                    {{--<div class="form-group">--}}
                                        {{--<label class="col-sm-2 control-label" for="form-field-1">--}}
                                            {{--Thuộc tính sản phẩm--}}
                                        {{--</label>--}}
                                        {{--<div class="col-sm-4">--}}
                                            {{--{!! Form::select('feature_id', $assetFeature, null, [--}}
                                                    {{--'id' => 'feature_id',--}}
                                                    {{--'class' => 'form-control select2',--}}
                                                    {{--'data-placeholder' => '--- Chọn thuộc tính sản phẩm ---']) !!}--}}

                                            {{--<label id="feature_id-error" class="error"--}}
                                                   {{--for="feature_id">{!! $errors->first("feature_id") !!}</label>--}}


                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="form-group">--}}
                                        {{--<label class="col-sm-2 control-label" for="form-field-1">--}}
                                            {{--Giá trị thuộc tính--}}
                                        {{--</label>--}}
                                        {{--<div class="col-sm-3" id="loadVariantId">--}}
                                            {{--<select class="form-control select2" id="variant_id">--}}
                                            {{--</select>--}}
                                            {{--<label id="variant_id-error" class="error"--}}
                                                   {{--for="variant_id">{!! $errors->first("variant_id") !!}</label>--}}
                                        {{--</div>--}}
                                        {{--<a id="addAssetFeatureVariant" href="" class="btn btn-primary"><i--}}
                                                    {{--class="fa fa-plus" aria-hidden="true"></i> Chọn thêm</a>--}}
                                    {{--</div>--}}

                                    {{--<div id="fromto">--}}

                                        {{--<div class="form-group">--}}
                                            {{--<label class="col-sm-2 control-label" for="form-field-1">--}}
                                                {{--Giá trị khác--}}
                                            {{--</label>--}}
                                            {{--<div class="col-sm-2">--}}
                                                {{--{!! Form::text("from", null, ['id' => 'from', 'class' => 'form-control', 'placeholder'=>'Giá trị từ'])--}}
                                                {{--!!}--}}
                                                {{--<label id="from-error" class="error" for="from">{!! $errors->first("from")--}}
                                                {{--!!}</label>--}}
                                            {{--</div>--}}


                                            {{--<div class="col-sm-2">--}}
                                                {{--{!! Form::text("to", null, ['id' => 'to', 'class' => 'form-control', 'placeholder'=>'Giá trị đến'])--}}
                                                {{--!!}--}}
                                                {{--<label id="to-error" class="error" for="to">{!! $errors->first("to")--}}
                                                {{--!!}</label>--}}
                                            {{--</div>--}}

                                        {{--</div>--}}

                                    {{--</div>--}}

                                    {{--<div class="form-group">--}}
                                        {{--<label class="col-sm-2 control-label" for="form-field-1">--}}
                                        {{--</label>--}}
                                        {{--<div class="col-sm-10">--}}
                                            {{--<div class="appendFeature">--}}
                                                {{--<table class="table" id="tableItem">--}}
                                                    {{--<thead>--}}
                                                    {{--<th>Tên thuộc tính</th>--}}
                                                    {{--<th>Giá trị thuộc tính</th>--}}
                                                    {{--<th>Hoạt động</th>--}}
                                                    {{--</thead>--}}
                                                    {{--<tbody></tbody>--}}
                                                {{--</table>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="form-field-1">
                                            Mô tả ngắn về sản phẩm
                                        </label>
                                        <div class="col-sm-10">
                                            {!! Form::textarea("description", @$object['description'],
                                            ['id'=>'description', 'class' => 'form-control', 'cols'=>"20", 'rows'=>"4"]) !!}
                                            <label id="description-error" class="error"
                                                   for="description">{!! $errors->first("description") !!}</label>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="form-field-1">
                                            Nội dung sản phẩm
                                        </label>
                                        <div class="col-sm-10">
                                            {!! Form::textarea("content", @$object['content'], ['id'=>'content', 'class' => 'form-control ckeditor']) !!}
                                            <label id="content-error" class="error"
                                                   for="content">{!! $errors->first("content") !!}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type="hidden" name="id" value="<?= @$object['id']; ?>">
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                            <div class="row">
                                <div class="col-sm-3">
                                    <a href='{!! route($controllerName.'.index') !!}'
                                       class="btn btn-success btn-labeled fa fa-arrow-left pull-left"> Danh
                                        sách {{ $title }}</a>
                                </div>
                                <div class="col-sm-9 text-right">
                                    <button class="btn btn-primary btn-labeled fa fa-save"> Lưu lại</button>
                                    <button type="reset" class="btn btn-default btn-labeled fa fa-refresh"> Làm lại
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                </form>
            </div>
            <!-- Default box -->
        </div>
    </section>
    <!-- /.content -->
@endsection
@section('after_styles')
    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
    <link rel="stylesheet" href="/html/plugins/jQuery-File-Upload/css/jquery.fileupload.css">
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
    <script type="text/javascript" src="/html-admin/plugins/ckeditor/adapters/jquery.js"></script>
    <script type="text/javascript" src="/html-admin/plugins/ckeditor/config.js?v=2019011622"></script>
    <!--Bootstrap Datepicker [ OPTIONAL ]-->
    <link href="{{ asset('assets/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">
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
            // $('#fromto').css('display', 'none');
            // $('#feature_id').change(function () {
            //     var feature_id = $('#feature_id').val();
            //     var url = '/panel-kht/asset-feature-variant/ajax-disable-feature/' + feature_id;
            //     $.get(url).done(function (data) {
            //         // console.log(data);
            //
            //         if (data.is_range == 1) {
            //             $('#fromto').css('display', 'block');
            //         } else {
            //             $('#fromto').css('display', 'none');
            //         }
            //     });
            //
            // });
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

            // $('#feature_id').on('change', function () {
            //     loadAssetVariant();
            // });

            $('#type').on('change', function () {
                loadAssetCategory();
            });

            // $('#addAssetFeatureVariant').on('click', function (e) {
            //     e.preventDefault();
            //     addAssetFeatureVariant();
            // });

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
                        method: "<?= isset($object['id']) ? 'PUT' : 'POST'; ?>",
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

//         function addAssetFeatureVariant() {
//             var from = $('#from').val();
//             var to = $('#to').val();
//             var AssetFeaature = $('#feature_id').val();
//             var data = $('#feature_id').select2('data')
//
//             ftext = (data[0].text);
//
//             if (from != "" && to != "") {
//                 var data2 = {
//                     from: from,
//                     to: to,
//                     _token: $('input[name ="_token"]').val()
//                 };
//                 $.post({
//                     url: "/panel-kht/asset-feature-variant/ajax-create/" + from + "/" + to + "/" + AssetFeaature, data2, success: function (result) {
//                         // console.log(result);
//                         add_feature_variant(AssetFeaature, ftext, result['id'], result['name']);
//                     }});
//
//             }
//             else {
//                 var AssetFeaatureVariantName = $('#variant_id').text();
//                 var AssetFeaatureName = $('#feature_id').text();
//                 var data = $('#feature_id').select2('data')
// // console.log(data);
//                 ftext = (data[0].text);
//                 // console.log(ftext);
//
//                 var data2 = $('#variant_id').select2('data')
//
//                 ftext2 = (data2[0].text);
//                 // console.log(ftext2);
//
//                 var AssetFeaatureVariant = $('#variant_id').val();
//                 // console.log(AssetFeaatureVariant);
//                 var AssetFeaature = $('#feature_id').val();
//
//                 var AssetFeaatureVariantName = $('#variant_id').text();
//                 // console.log(AssetFeaatureVariant);
//
//                 var flat = false;
//                 $('#tableItem > tbody  > tr').each(function () {
//                     var id = $(this).find('td input[name="variant_id[]"]').val();
//                     if (AssetFeaatureVariant == id) {
//                         flat = true;
//                     }
//                 });
//                 if (AssetFeaatureVariant && !flat) {
//                     add_feature_variant(AssetFeaature, ftext, AssetFeaatureVariant, ftext2);
//                 }
//             }
//
//
//         }

        // function add_feature_variant(feature_id, feature_name, variant_id, variant_name, id) {
        //     var tmp = 'fv_' + feature_id + '_' + variant_id;
        //
        //     if ($('#' + tmp).attr('id') == tmp) return;
        //
        //     id = id || 0;
        //     var item = $.now();
        //     $('#tableItem tbody').append('<tr id="' + tmp + '">\
        //             <td>' + feature_name + '<input name="fvv[' + item + '][feature_id]" type="hidden" value="' + feature_id + '"/></td>\
        //             <td>' + variant_name + '<input name="fvv[' + item + '][variant_id]" type="hidden" value="' + variant_id + '"/></td>\
        //             <td><a href="#" class="add-tooltip btn btn-danger btn-xs btn-delete-fvv" data-toggle="tooltip" \
        //                 data-original-title="Xóa giá trị thuộc tính"><i class="fa fa-trash-o"></i> Xóa</a></td></tr>');
        // }

        {{--@if (isset($variants) && is_array($variants))--}}
        {{--@foreach($variants as $variant)--}}
        {{--add_feature_variant('{{$variant['feature_id']}}', '{{@$assetFeature[$variant['feature_id']]}}',--}}
            {{--'{{$variant['variant_id']}}', '{{$variant['variant_name']}}');--}}
        {{--@endforeach--}}
        {{--@endif--}}

        $('body').on('click', '.btn-delete-fvv', function (e) {
            e.preventDefault();
            $(this).closest('tr').remove();
        });

        function loadAssetCategory() {
            var valId = $('#type').val();
            // console.log(valId);

            var data = {
                id: valId,
                _token: $('input[name ="_token"]').val()
            };
            $.post({
                url: "/panel-kht/asset/loadAssetCategory/" + valId, data, success: function (result) {
                    // console.log(result);
                    var data = $.map(result, function (obj) {
                        obj.id = obj.id;
                        obj.text = obj.name;
                        return obj;
                    });
                    // console.log(data);
                    $('#category').html('');
                    $("#category").select2({
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


        // function loadAssetVariant() {
        //     var valId = $('#feature_id').val();
        //     // console.log(valId);
        //
        //     var data = {
        //         id: valId,
        //         _token: $('input[name ="_token"]').val()
        //     };
        //     $.post({
        //         url: "/panel-kht/asset/loadAssetFeatureVariant/" + valId, data, success: function (result) {
        //             // console.log(result);
        //             var data = $.map(result, function (obj) {
        //                 obj.id = obj.id;
        //                 obj.text = obj.name;
        //                 return obj;
        //             });
        //             // console.log(data);
        //             $('#variant_id').html('');
        //             $("#variant_id").select2({
        //                 data: data
        //             });
        //             /* var options = '';
        //                 for(var i=0;i<result.length;i++){
        //                     options += '<option value="'+result[i].district_id+'">'+result[i].name+'</option>';
        //                 }
        //                 console.log(options);
        //                 $("#loadDistrict").html('<select class="form-control select2" id="">'+options+'</select>');*/
        //
        //         }
        //     });
        // }
    </script>
@endsection
