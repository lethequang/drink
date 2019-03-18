@extends('layouts.admin')

<?php
$user = \App\Helpers\Auth::getUserInfo();
$permissions = \App\Helpers\Auth::get_permissions($user);
?>

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <span class="text-capitalize">{{ $title }}</span>
            <small>Tất cả  <span>{{ $title }}</span> trong cơ sở dữ liệu.</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/">Trang chủ</a></li>
            <li><a href="<?=route($controllerName.'.index')?>" class="text-capitalize">{{ ucfirst($title) }}</a></li>
            <li class="active">Danh sách</li>
        </ol>
    </section>

    @if(Session::has('success-message'))
        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Thành công!</h4>
            {{ Session::get('success-message') }}
        </div>
    @elseif (Session::has('error-message'))
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Error!</h4>
            {{ Session::get('error-message') }}
        </div>
    @endif

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="row">
            <!-- THE ACTUAL CONTENT -->
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Danh sách {{$title}}</h3>
                        <div id="datatable_button_stack" class="pull-right text-right hidden-xs"></div>
                    </div>
                    <div class="box-body overflow-hidden">
                        <div id="table-toolbar">
                            <a href="{!! url("panel-kht/{$controllerName}/add") !!}" class="btn btn-primary btn-labeled fa fa-plus"> Thêm mới</a>
                        </div>
                        <table id="demo-custom-toolbar" class="demo-add-niftycheck" data-toggle="table"
                               data-locale="vi-VN"
                               data-toolbar="#table-toolbar"
                               data-url="{!! route('roles.search') !!}"
                               data-search="true"
                               data-show-refresh="true"
                               data-show-toggle="true"
                               data-show-columns="true"
                               data-pagination="true"
                               data-side-pagination="server"
                               data-page-size="25"
                               data-query-params="queryParams"
                               data-cookie="true"
                               data-cookie-id-table="departments-show-all"
                               data-cookie-expire="{!! config('params.bootstrapTable.extension.cookie.cookieExpire') !!}"
                        >
                            <thead>
                            <tr>
                                <th data-field="check_id" data-checkbox="true">ID</th>
                                <th data-field="name" data-sortable="true">Tên vai trò</th>
                                <th data-field="created_at" data-sortable="true">Ngày tạo</th>
                                <th data-field="id" data-align="center" data-formatter="actionColumn">Chức năng</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('after_scripts')
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.12.1/bootstrap-table.min.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.12.1/bootstrap-table.min.js"></script>
    <!-- Latest compiled and minified Locales -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.12.1/locale/bootstrap-table-vi-VN.min.js"></script>

    <style type="text/css">
        .bootstrap-select {
            margin: 0;
        }
    </style>

    <script type="text/javascript">

        $('#reset-page').click(function (){
            var url = window.location.href;
            window.location = url;
        });

        function actionColumn(value, row, index) {

            var editBtn = [];

            <?php
                $hp = \App\Helpers\Auth::has_permission('roles.detail', $user, $permissions);
                if ($hp) { ?>
            editBtn.push('<a href="{{ url("panel-kht/{$controllerName}") }}/detail/' + value + '" class="btn btn-xs btn-default" ' +
                'data-toggle="tooltip" title="" data-original-title="Phân quyền cho người dùng"><i class="fa fa-lock" aria-hidden="true"></i></a> ');
            <?php } ?>

<?php
                $hp = \App\Helpers\Auth::has_permission('roles.edit', $user, $permissions);
                if ($hp) { ?>
            editBtn.push('<a href="{{ url("panel-kht/{$controllerName}/edit") }}/' + value + '" ' +
                'data-toggle="tooltip" class="add-tooltip btn btn-info btn-xs" data-placement="top" data-original-title="Cập nhật vai trò">' +
                '<i class="fa fa-pencil"></i></a> ');
            <?php } ?>

<?php
                $hp = \App\Helpers\Auth::has_permission('roles.delete', $user, $permissions);
                if ($hp) { ?>
            editBtn.push('<a href="{{ url("panel-kht/{$controllerName}/delete") }}/' + value + '" ' +
                'class="add-tooltip btn btn-danger btn-xs btn-delete" data-toggle="tooltip" data-original-title="Xoá vai trò">' +
                '<i class="fa fa-trash-o"></i></a> ');
                <?php } ?>

            return editBtn.join(' ');
        }

        function queryParams(params) {
            return params;
        }

        $(document).ready(function() {
            @if(isset($message) && $message)
                show_pnotify("{!! $message['title'] !!}", "{!! $message['text'] !!}", "{!! $message['type'] !!}");
            @endif

            var $table = $('#demo-custom-toolbar');

            $table.on('load-success.bs.table', function () {
                $('[data-toggle="tooltip"]').tooltip({
                    container: 'body'
                });

                $('.btn-delete').on('click', function (e) {
                    e.preventDefault();
                    var url = $(this).attr('href');
                    malert('Bạn có thật sự muốn xoá vai trò này không?', 'Xác nhận xoá vai trò', null, function () {
                        ajax_loading(true);

                        $.ajax({
                            method: "DELETE",
                            url: url,
                            dataType: 'json'
                        })
                            .done(function( res ) {
                                ajax_loading(false);
                                malert(res.msg, null, function () {
                                    if(res.rs) {
                                        window.location.reload();
                                    }
                                });
                            })
                            .fail(function(res) {
                                ajax_loading(false);
                                if(res.status==403) {
                                    malert('Bạn không có quyền thực hiện tính năng này. Vui lòng liên hệ Admin!');
                                }
                            });
                    });
                    return false;
                });
            });
        });

    </script>
@endsection