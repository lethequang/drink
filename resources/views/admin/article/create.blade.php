@extends('layouts.admin')
<?php
$action_title = isset($object['id']) ? 'Cập nhật' : 'Thêm mới';
?>
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <span class="text-capitalize">{{ $title }}</span>
            <small><?=$action_title?> <span>{{ $title }}</span>.</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/">Trang chủ</a></li>
            <li><a href="<?=route($controllerName . '.index')?>" class="text-capitalize">{{ ucfirst($title) }}</a></li>
            <li class="active"><?=$action_title?></li>
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
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?=$action_title?> {{$title}}</h3>
                    </div>
                    <!-- form start -->
                    <form id="frm-add" method="post"
                          action="<?=isset($object['id']) ? route($controllerName . '.update', ['id' => $object['id']]) : route($controllerName . '.index')?>"
                    " class="form-horizontal">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="form-field-1">
                                        Tiêu đề bài viết <span class="required"></span>
                                    </label>
                                    <div class="col-sm-8">
                                        {!! Form::text("name", @$object['name'], ['class' => 'form-control']) !!}
                                        <label id="name-error" class="error"
                                               for="name">{!! $errors->first("name") !!}</label>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="form-field-1">
                                        Thể loại <span class="required"></span>
                                    </label>
                                    <div class="col-sm-8">
                                        {!! Form::select("article_category_id", $article_categories, @$object['article_category_id'], ['id' => 'article_category_id','class' => 'form-control select2','data-placeholder' => '--- Chọn thể loại ---']) !!}
                                        <label id="article_category_id-error" class="error"
                                               for="article_category_id">{!! $errors->first("article_category_id") !!}</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="form-field-1">
                                        Ưu tiên
                                    </label>
                                    <div class="col-sm-3">
                                        {!! Form::select("position", $orderOptions, @$object['order'], ['id' => 'order','class' => 'form-control select2','data-placeholder' => '--- Chọn thứ tự ---']) !!}
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
                                                   value="1" <?=!isset($object['status']) || @$object['status'] == '1' ?
                                            'checked' : ''?>>
                                            Kích hoạt
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="status" id="status2"
                                                   value="0" <?=@$object['status'] == '0' ? 'checked' : ''?>> Không kích
                                            hoạt
                                        </label>
                                    </div>

                                    <label class="col-sm-4 control-label" for="form-field-1">
                                        Nổi bật
                                    </label>
                                    <div class="col-sm-8">
                                        <label class="radio-inline">
                                            <input type="radio" name="is_hot" id="is_hot1"
                                                   value="1" <?=!isset($object['is_hot']) || @$object['is_hot'] == '1' ?
                                            'checked' : ''?>>
                                            Kích hoạt
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="is_hot" id="is_hot2"
                                                   value="0" <?=@$object['is_hot'] == '0' ? 'checked' : ''?>> Không kích
                                            hoạt
                                        </label>
                                    </div>

                                    <label class="col-sm-4 control-label" for="form-field-1">
                                        Phổ biến
                                    </label>
                                    <div class="col-sm-8">
                                        <label class="radio-inline">
                                            <input type="radio" name="is_common" id="is_common1"
                                                   value="1" <?=!isset($object['is_common']) || @$object['is_common'] ==
                                            '1' ? 'checked' : ''?>>
                                            Kích hoạt
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="is_common" id="is_common2"
                                                   value="0" <?=@$object['is_common'] == '0' ? 'checked' : ''?>> Không
                                            kích
                                            hoạt
                                        </label>
                                    </div>

                                </div>
                            </div>
                            <div class="col-sm-6">
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
                                    <label class="col-sm-6 control-label" for="form-field-1"> <strong>Hình ảnh phụ</strong>
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
                                        Mô tả ngắn
                                    </label>
                                    <div class="col-sm-10">
                                        {!! Form::textarea("description", @$object['description'],
                                        ['id'=>'description', 'class' => 'form-control', 'cols'=>"20", 'rows'=>"3"]) !!}
                                        <label id="description-error" class="error"
                                               for="description">{!! $errors->first("description") !!}</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="form-field-1">
                                        Nội dung bài viết
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
                        <input type="hidden" name="id" value="<?=@$object['id']?>">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <div class="row">
                            <div class="col-sm-3">
                                <a href='{!! route($controllerName.'.index') !!}'
                                   class="btn btn-success btn-labeled fa fa-arrow-left pull-left"> Danh
                                    sách {{ $title }}</a>
                            </div>
                            <div class="col-sm-9 text-right">
                                <button class="btn btn-primary btn-labeled fa fa-save"> Lưu lại</button>
                                <button type="reset" class="btn btn-default btn-labeled fa fa-refresh"> Làm lại</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-footer -->
                    </form>
                </div>
                <!-- Default box -->
            </div>
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
    <script type="text/javascript" src="/html-admin/plugins/ckeditor/adapters/jquery.js"></script>
    <script type="text/javascript" src="/html-admin/plugins/ckeditor/config.js"></script>

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

            @if (session()->has('error'))
            @if (session('error'))
            $('#error_msg').html('{{session('message')}}');
            $('#error_div').show();
            @else
            $('#success_msg').html('{{session('message')}}');
            $('#success_div').show();
            @endif
            @endif

            @if(isset($product_images))
            @foreach($product_images as $id => $image)
            add_image('<?=$image?>', '<?=$id?>');
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

                },
                messages: {
                    name: "Nhập tiêu đề bài viết",

                },
                submitHandler: function (form) {
                    ajax_loading(true);
                    for (instance in CKEDITOR.instances) {
                        CKEDITOR.instances[instance].updateElement();
                    }
                    var data = $(form).serializeArray();
                    $.ajax({
                        method: "<?=isset($object['id']) ? 'PUT' : 'POST'?>",
                        url: $(form).attr('action'),
                        dataType: 'json',
                        data: data
                    })
                        .done(function (res) {
                            ajax_loading(false);
                            if (res.rs == 1) {
                                if (res.link_edit) {
                                    location.href = res.link_edit;
                                } else {
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
                            console.log(res);
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
    </script>
@endsection
