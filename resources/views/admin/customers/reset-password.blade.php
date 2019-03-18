@extends('layouts.admin')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <span class="text-capitalize">{{ $title }}</span>
            <small>Tạo lại mật khẩu.</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/">Trang chủ</a></li>
            <li><a href="<?=route($controllerName.'.index')?>" class="text-capitalize">{{ ucfirst($title) }}</a></li>
            <li class="active">Tạo lại mật khẩu</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tạo lại mật khẩu</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form id="frm-add" method="post" action="" class="form-horizontal">
                        <div class="box-body">
                            <div class="col-sm-6 col-sm-offset-3">
                                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                <input type="hidden" name="user_id" value="{!! $id !!}">
                                <div class="form-group">
                                    <label for="form-field-3" class="col-sm-4" style="text-align:right">
                                        Nhập mật khẩu <span class="symbol required"></span>
                                    </label>
                                    <div class="col-sm-8">
                                        <div class="lang">
                                            <?php
                                            if (strlen ( old ( 'password_new' ) )) :
                                                $password_new = old ( 'password_new' );
                                            else:
                                                $password_new = '';
                                            endif;
                                            ?>
                                            <input type="password" name="password_new" id="password_new" value="{!! $password_new !!}" class="form-control">
                                            <label class="error">{!! $errors->first("password_new") !!}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="form-field-3" class="col-sm-4" style="text-align:right">
                                        Nhập lại mật khẩu <span class="symbol required"></span>
                                    </label>
                                    <div class="col-sm-8">
                                        <div class="lang">
                                            <?php
                                            if (strlen ( old ( 'password_confirm' ) )) :
                                                $password_confirm = old ( 'password_confirm' );
                                            else:
                                                $password_confirm = '';
                                            endif;
                                            ?>
                                            <input type="password" name="password_confirm" value="{!! $password_confirm !!}" class="form-control">
                                            <label class="error">{!! $errors->first("password_confirm") !!}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                            <div class="col-sm-3 col-sm-offset-3">
                                <a href='{!! route($controllerName.'.index') !!}' class="btn btn-success btn-labeled fa fa-arrow-left pull-left"> Danh sách {{ $title }}</a>
                            </div>
                            <div class="col-sm-3 text-right">
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
            $('#frm-add').validate({
                ignore: ".ignore",
                rules: {
                    password_new: "required",
                    password_confirm: {
                        equalTo: "#password_new"
                    }
                },
                messages: {
                    password_new: "Nhập mật khẩu mới",
                    password_confirm: "Mật khẩu không trùng khớp",
                },
                submitHandler: function(form) {
                    ajax_loading(true);
                    form.submit();
                }
            });
        });
    </script>
@endsection