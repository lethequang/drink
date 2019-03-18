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
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Thêm mới {{$title}}</h3>
                </div>
                <!-- form start -->
                <form id="frm-add" method="post"
                action="<?=isset($object['id']) ? route($controllerName . '.update', ['id' => $object['id']]) : route($controllerName . '.index')?>" class="form-horizontal">
                <div class="box-body">
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="form-field-1">Tên mẫu</label>
                            <div class="col-sm-7">
                                {!! Form::text("name", @$object['name'], ['class' => 'form-control']) !!}
                                <label id="name-error" class="error" for="name">{!! $errors->first("name") !!}</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="form-field-1">
                                Link cần lọc bài <span class="required"></span>
                            </label>
                            <div class="col-sm-7">
                                {!! Form::text("link_tag", @$object['link_tag'], ['class' => 'form-control']) !!}
                                <label id="link_tag-error" class="error"
                                for="link_tag">{!! $errors->first("link_tag") !!}</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="form-field-1">
                                Thẻ lấy từng bài <span class="required"></span>
                            </label>
                            <div class="col-sm-7">
                                {!! Form::text("post_tag", @$object['post_tag'], ['class' => 'form-control']) !!}
                                <label id="post_tag-error" class="error"
                                for="post_tag">{!! $errors->first("post_tag") !!}</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="form-field-1">
                                url <span class="required"></span>
                            </label>
                            <div class="col-sm-7">
                                {!! Form::text("url_tag", @$object['url_tag'], ['class' => 'form-control']) !!}
                                <label id="url_tag-error" class="error"
                                for="url_tag">{!! $errors->first("url_tag") !!}</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="form-field-1">
                                Thẻ lấy hình đại diện <span class="required"></span>
                            </label>
                            <div class="col-sm-7">
                                {!! Form::text("avatar_tag", @$object['avatar_tag'], ['class' => 'form-control']) !!}
                                <label id="department-error" class="error"
                                for="department">{!! $errors->first("department") !!}</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="form-field-1">
                                Thẻ lấy tiêu đề bài viết <span class="required"></span>
                            </label>
                            <div class="col-sm-7">
                                {!! Form::text("title_tag", @$object['title_tag'], ['class' => 'form-control']) !!}
                                <label id="title_tag-error" class="error"
                                for="title_tag">{!! $errors->first("title_tag") !!}</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="form-field-1">
                                Thẻ lấy mô tả ngắn <span class="required"></span>
                            </label>
                            <div class="col-sm-7">
                                {!! Form::text("description_tag", @$object['description_tag'], ['class' => 'form-control']) !!}
                                <label id="description_tag-error" class="error"
                                for="description_tag">{!! $errors->first("description_tag") !!}</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="form-field-1">
                                Thẻ lấy nội dung <span class="required"></span>
                            </label>
                            <div class="col-sm-7">
                                {!! Form::text("content_tag", @$object['content_tag'], ['class' => 'form-control']) !!}
                                <label id="content_tag-error" class="error"
                                for="content_tag">{!! $errors->first("content_tag") !!}</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="form-field-1">
                               Loại tin
                            </label>
                            <div class="col-sm-7">
                                {!! Form::select('type', $type, @$object['type'], [
                                        'id' => 'type',
                                        'class' => 'form-control select2',
                                        'data-placeholder' => '--- Loại tin ---']) !!}

                                <label id="type-error" class="error"
                                       for="type">{!! $errors->first("type") !!}</label>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-2">
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
<link rel="stylesheet" href="{{ asset('vendor/adminlte/bower_components/select2/dist/css/select2.min.css') }}">
@endsection
@section('after_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"
type="text/javascript"></script>
<script src="{{ asset('js/function.js') }}"></script>
<script src="{{ asset('js/numeral.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/bower_components/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/bower_components/moment/min/moment.min.js') }}"></script>
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
        $('#frm-add').validate({
            ignore: ".ignore",
            rules: {
                link_tag: "required",
                post_tag: "required",
                url_tag: "required",
                avatar_tag: "required",
                title_tag: "required",
                description_tag: "required",
                content_tag: "required",
            },
            messages: {
                link_tag: "Vui lòng nhập tên",
                post_tag: "Vui lòng nhập tên",
                url_tag: "Vui lòng nhập tên",
                avatar_tag: "Vui lòng nhập tên",
                title_tag: "Vui lòng nhập tên",
                description_tag: "Vui lòng nhập tên",
                content_tag: "Vui lòng nhập tên",
            },
            submitHandler: function (form) {
                ajax_loading(true);
                $.ajax({
                    method: "<?=isset($object['id']) ? 'PUT' : 'POST'?>",
                    url: $(form).attr('action'),
                    dataType: 'json',
                    data: $(form).serializeArray()
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
</script>
<script type="text/javascript">

    $(document).ready(function () {
        $('#downloadSynchronized').click(function () {
            var url = '{!! url("/panel-kht/crawler") !!}';
            window.location = url;
        });

    });


</script>
@endsection
