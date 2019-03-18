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
                        <div class="col-sm-12">
                            <div class="form-group">


                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" for="form-field-1">
                                            Vị trí <span class="required"></span>
                                        </label>
                                        <div class="col-sm-8">
                                            {!! Form::select("position_id", $banner_position, @$object['position_id'], ['id' => 'banner_position','class' => 'form-control select2','data-placeholder' => '--- Chọn thể loại ---']) !!}
                                            <label id="banner_position-error" class="error"
                                            for="position_id">{!! $errors->first("position_id") !!}</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" for="form-field-1">
                                            Ưu tiên
                                        </label>
                                        <div class="col-sm-3">
                                            {!! Form::select("ordering", $orderOptions, @$object['ordering'], ['id' => 'ordering','class' => 'form-control select2','data-placeholder' => '--- Chọn thứ tự ---']) !!}
                                            <label id="ordering-error" class="error"
                                            for="ordering">{!! $errors->first("ordering") !!}</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" for="form-field-1">
                                            Trạng thái
                                        </label>
                                        <div class="col-sm-8">
                                            <label class="radio-inline">
                                                <input type="radio" name="status" id="status1"
                                                value="1" <?=!isset($object['status']) || @$object['status'] == '1' ? 'checked' : ''?>>
                                                Kích hoạt
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="status" id="status2"
                                                value="0" <?=@$object['status'] == '0' ? 'checked' : ''?>> Không kích
                                                hoạt
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-sm-4 control-label" for="form-field-1">
                                        Tên banner <span class="required"></span>
                                    </label>
                                      <div class="col-sm-8">
                                        {!! Form::text("name", @$object['name'], ['class' => 'form-control']) !!}
                                        <label id="name-error" class="error"
                                        for="name">{!! $errors->first("name") !!}</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                   <label class="col-sm-4 control-label" for="form-field-1">
                                    Link <span class="required"></span>
                                </label>
                                <div class="col-sm-4">
                                    {!! Form::text("url", @$object['url'], ['class' => 'form-control']) !!}
                                    <label id="url-error" class="error"
                                    for="url">{!! $errors->first("url") !!}</label>
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
                                if (strlen(old('image_location')) == 1) {
                                    $path = old('image_location');
                                } else {
                                    $path = $object['image_location'] ?? '/images/no-image.jpeg';
                                }
                                ?>
                                <img id="preview-file-upload" class="preview-file-upload"
                                style="width: 130px; height: 140px;"
                                src="{!! @$object['image_url'].$path !!}">
                            </div>

                            {!! Form::text("image_location", $path, ['id' => 'image', 'class' => 'form-control', 'data-url' => '#image_url']) !!}
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
    </div>

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"
type="text/javascript"></script>
<script src="/html-admin/plugins/ckeditor/ckeditor.js"></script>
<script src="/html-admin/plugins/ckfinder/ckfinder.js?v=2019011622"></script>
<script type="text/javascript" src="/html-admin/plugins/ckeditor/adapters/jquery.js"></script>
<script type="text/javascript" src="/html-admin/plugins/ckeditor/config.js"></script>

<script type="text/javascript">

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

        $('.btn-add-image').on('click', function () {
            add_image($('#image_file').val());
        });

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
