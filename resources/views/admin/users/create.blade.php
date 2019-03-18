@extends('layouts.admin')
<?php
$action_name = isset($action) ? 'Thông tin của bạn' : (isset($id) ? 'Cập nhật' : 'Thêm mới');
?>
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <span class="text-capitalize">{{ $title }}</span>
            <small><?=$action_name?> <span>{{ isset($action) ?'':$title }}</span>.</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/">Trang chủ</a></li>
            <li><a href="<?=route($controllerName.'.index')?>" class="text-capitalize">{{ ucfirst($title) }}</a></li>
            <li class="active"><?=$action_name?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?=$action_name?> {{isset($action)?'':$title}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?php
                    $link = isset($id) ? route($controllerName.'.update', ['id' => $id]) : route($controllerName.'.index');
                    if (isset($action) && $action=='profile') {
                        $link = '';
                    }
                    ?>
                    <form id="frm-add" method="post" action="<?=$link?>" class="form-horizontal">
                        <div class="box-body">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="form-field-1">
                                        Họ tên <span class="required"></span>
                                    </label>
                                    <div class="col-sm-9">
                                        {!! Form::text("fullname", @$object['fullname'], ['class' => 'form-control']) !!}
                                        <label id="fullname-error" class="error" for="fullname">{!! $errors->first("fullname") !!}</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="form-field-1">
                                        Email <span class="required"></span>
                                    </label>
                                    <?php
                                    $attr = ['class' => 'form-control'];
                                    if (isset($id)) $attr['readonly'] = true;
                                    ?>
                                    <div class="col-sm-9">
                                        {!! Form::email("email", @$object['email'], $attr) !!}
                                        <label id="email-error" class="error" for="email">{!! $errors->first("email") !!}</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <label class="col-sm-6 control-label" for="form-field-1">
                                                Giới tính
                                            </label>
                                            <div class="col-sm-6">
                                                {!! Form::select("gender", \App\Helpers\General::getOptionGender(), @$object['gender'], ['class' => 'form-control' , "id" => "gender"]) !!}
                                                <span class="help-block has-error">{!! $errors->first("gender") !!}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <label class="col-sm-5 control-label" for="form-field-1">
                                                Ngày sinh
                                            </label>
                                            <div class="col-sm-7">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    {!! Form::text("birthdate", @$object['birthdate'], ['class' => 'form-control' , "id" => "birthdate", "autocomplete"=>"off"]) !!}
                                                </div>
                                            </div>
                                            <span class="help-block has-error">{!! $errors->first("birthdate") !!}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="form-field-1">
                                        Số điện thoại
                                    </label>
                                    <div class="col-sm-9">
                                        {!! Form::text("phone", @$object['phone'], ['class' => 'form-control' , "id" => "phone"]) !!}
                                        <span class="help-block has-error">{!! $errors->first("birthdate") !!}</span>
                                    </div>
                                </div>
                                 <div class="col-sm-12">
                                <div class="form-group" style="margin-left: 18px;">
                                    <label class="control-label" for="form-field-1" style="margin-bottom: 10px;">
                                        <strong>Trạng thái</strong>
                                    </label>
                                    <div>
                                        <label class="radio-inline">
                                            <input type="radio" name="status" id="status1"
                                                   value="1" <?=!isset($object['status']) || @$object['status'] == '1' ? 'checked' : ''?>>
                                            Kích hoạt
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="status" id="status2"
                                                   value="0" <?=@$object['status'] == '0' ? 'checked' : ''?>> Không
                                            kích
                                            hoạt
                                        </label>
                                    </div>
                                </div>
                            </div>

                            </div>
                            <div class="col-sm-6">
                                @if (!isset($id))
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="form-field-1">
                                            Mật khẩu <span class="required"></span>
                                        </label>
                                        <div class="col-sm-9">
                                            <input type="password" name="password" id="password" class="form-control">
                                            <label id="password-error" class="error" for="password">{!! $errors->first("password") !!}</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="form-field-1">
                                            Xác nhận mật khẩu <span class="required"></span>
                                        </label>
                                        <div class="col-sm-9">
                                            <input type="password" name="password_confirm" id="password_confirm" class="form-control">
                                            <label id="password_confirm-error" class="error" for="password_confirm">{!! $errors->first("password_confirm") !!}</label>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="form-field-1"> <strong>Hình
                                            Avatar</strong>
                                    </label>
                                    <div class="col-sm-9 btn-file">
                                        <div class="fileupload-new thumbnail"
                                             style="width: 140px; height: 150px; margin-bottom: 3px;">
                                            <?php
                                            if (strlen ( old ( 'avatar' ) ) == 1) :
                                                $path = old ( 'avatar' );
                                            else :
                                                $path = @$object ['avatar'];
                                            endif;
                                            ?>
                                            <img id="preview-file-upload" class="preview-file-upload"
                                                 style="width: 130px; height: 140px;" src="{!! $path !!}">
                                        </div>

                                        {!! Form::text("avatar", @$object['avatar'], ['id' =>
                                            'avatar', 'class' => 'form-control']) !!}

                                        <div class="p-l-file">
                                            <a href="#" data-target="avatar"
                                               class="iframe-btn browse-image" type="button"> <i
                                                        class="fa fa-paperclip"></i>&nbsp;&nbsp;Chọn hình
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                            <div class="col-sm-6">
                                <a href='{!! route($controllerName.'.index') !!}' class="btn btn-success btn-labeled fa fa-arrow-left pull-left"> Danh sách {{ $title }}</a>
                            </div>
                            <div class="col-sm-6 text-right">
                                <button class="btn btn-primary btn-labeled fa fa-save"> Lưu lại</button>
                                <button type="reset" class="btn btn-default btn-labeled fa fa-refresh"> Làm lại</button>
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

@section('before_styles')
    <link href="/html/plugins/treeselect/css/jquery.bootstrap.treeselect.css" rel="stylesheet">
    <style>
        .select-department .dropdown-toggle {
            width: 100%;
        }
    </style>
@endsection

@section('after_scripts')
    <script src="/html/plugins/treeselect/js/jquery.bootstrap.treeselect.js"></script>

    <script type="text/javascript" src="/html/plugins/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="/html/plugins/ckfinder/ckfinder.js?v=2019011622"></script>
    <script type="text/javascript" src="/html/plugins/ckeditor/adapters/jquery.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            init_select2('.select2');
            init_datepicker("#birthdate");

            @if($message=json_decode(session('message'), 1))
            show_pnotify("{!! $message['title'] !!}", "{!! $message['text'] !!}", "{!! $message['type'] !!}");
            @endif

            add_rule_phone_number();

            $('#frm-add').validate({
                ignore: ".ignore",
                rules: {
                    name: "required",
                    email: {
                        required: true,
                        email: true
                    },
                    phone:{
                        minlength: 10,
                        maxlength: 11,
                        rgphone: true,
                    },

            @if (!isset($id))
                    password: "required",
                    password_confirm: {
                        equalTo: "#password"
                    }
            @endif
                },
                messages: {
                    name: "Nhập tên {{ $title }}",
                    'email':{
                        required:'Vui lòng nhập email',
                        email:'Email không đúng định dạng'
                    },
                    'phone': {
                        minlength: "Số điện thoại tối thiểu 10 số",
                        maxlength: "Số điện thoại tối đa 11 số",
                    },
                    password: "Nhập mật khẩu",
                    password_confirm: "Mật khẩu không trùng khớp",
                },
                submitHandler: function(form) {
                    ajax_loading(true);
                    $.ajax({
                      method: "<?= isset($id)?'PUT':'POST'?>",

                        url: $(form).attr('action'),
                        dataType: 'json',
                        data: $(form).serializeArray()
                    })
                        .done(function (res) {
                            ajax_loading(false);
                            malert(res.msg, null, function () {
                                if (res.rs) {
                                    @if (isset($action)) {
                                        location.reload();
                                    @else
                                        location.href='<?=route($controllerName.'.index')?>';
                                    @endif
                                } else {
                                    if (res.errors) {
                                        $.each(res.errors, function (key, msg) {
                                            $('#'+key+'-error').html(msg).show();
                                        });
                                    }
                                }
                            });
                        })
                        .fail(function (res) {
                            ajax_loading(false);
                            if (res.status == 403) {
                                malert('Bạn không có quyền thực hiện tính năng này. Vui lòng liên hệ Admin!');
                            } else {
                                res = res.responseJSON;
                                if (res.errors) {
                                    $.each(res.errors, function (key, msg) {
                                        $('#'+key+'-error').html(msg).show();
                                    });
                                }
                            }
                        });
                    return false;
                }
            });
        });
    </script>
@endsection
