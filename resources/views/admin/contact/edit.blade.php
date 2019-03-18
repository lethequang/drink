@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <span class="text-capitalize">{{ $title }}</span>
            <small>Chỉnh sửa <span>{{ $title }}</span>.</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/">Trang chủ</a></li>
            <li><a href="<?=route($controllerName.'.index')?>" class="text-capitalize">{{ ucfirst($title) }}</a></li>
            <li class="active">Chỉnh sửa</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Chỉnh sửa {{$title}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form id="frm-add" method="post" action="<?=isset($id) ? route($controllerName.'.update', ['id' => $id]) : route($controllerName.'.index')?>" class="form-horizontal">
                        <div class="box-body">
                            <div class="col-sm-2">
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="form-field-1">
                                        Tên <span class="required"></span>
                                    </label>
                                    <div class="col-sm-8">
                                        {!! Form::text("name", $object['name'], ['class' => 'form-control']) !!}
                                        <label id="name-error" class="error" for="name">{!! $errors->first("name") !!}</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="form-field-1">
                                        Email <span class="required"></span>
                                    </label>
                                    <div class="col-sm-8">
                                        {!! Form::text("email", $object['email'], ['class' => 'form-control']) !!}
                                        <label id="email-error" class="error" for="email">{!! $errors->first("email") !!}</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="form-field-1">
                                        Content <span class="required"></span>
                                    </label>
                                    <div class="col-sm-7">
                                        {!! Form::textarea("content", $object['content'], ['class' => 'form-control']) !!}
                                        <label id="content-error" class="error" for="content">{!! $errors->first("content") !!}</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="form-field-1">
                                        Trả lời <span class="required"></span>
                                    </label>
                                    <div class="col-sm-9">
                                        <label class="radio-inline">
                                            <input type="radio" name="reply" id="reply1" value="1" <?=$object['is_deleted']=='0'?'checked':''?>> Đã trả lời
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="reply" id="reply2" value="0" <?=$object['is_deleted']=='1'?'checked':''?>> Chưa trả lời
                                        </label>
                                    </div>
                                </div>


                            </div>
                            <div class="col-sm-2">
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                            <div class="row">
                                <div class="col-sm-2">
                                </div>
                                <div class="col-sm-4">
                                    <a href='{!! route($controllerName.'.index') !!}' class="btn btn-success btn-labeled fa fa-arrow-left pull-left"> Danh sách {{ $title }}</a>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <button class="btn btn-primary btn-labeled fa fa-save"> Lưu lại</button>
                                    <button type="reset" class="btn btn-default btn-labeled fa fa-refresh"> Làm lại</button>
                                </div>
                                <div class="col-sm-2">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js" type="text/javascript"></script>
    <script src="{{ asset('js/function.js') }}"></script>
    <script src="{{ asset('js/numeral.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/bower_components/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('/html-admin/plugins/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('/html-admin/plugins/ckfinder/ckfinder.js?v=2019011622') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#frm-add').validate({
                ignore: ".ignore",
                rules: {
                   name: "required",
                    email: {
                        required: true,
                        email: true,
                    },
                },
                messages: {
                    name: "Vui lòng nhập tên {{ $title }}",
                    email: "Vui lòng nhập địa chỉ email",
                },
                submitHandler: function(form) {
                    ajax_loading(true);
                    $.ajax({
                        method: "PUT",
                        url: $(form).attr('action'),
                        dataType: 'json',
                        data: $(form).serializeArray()
                    })
                        .done(function (res) {
                            ajax_loading(false);
                            malert(res.msg, null , function () {
                                if (res.rs) {
                                    location.href='<?=route($controllerName.'.index')?>';
                                }
                            });
                        })
                        .fail(function (res) {
                            ajax_loading(false);
                            if (res.status == 403) {
                                malert('Bạn không có quyền thực hiện tính năng này. Vui lòng liên hệ Admin!');
                            }
                        });
                    return false;
                }
            });

            init_select2('.select2');

        });
    </script>
@endsection