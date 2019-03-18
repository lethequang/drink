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
                          <div class="row">
                            <div class="col-sm-3">
                                {!! Form::select('status', $status, '1', [
                                    'id' => 'status_filter',
                                    'class' => 'custom_filter',
                                    'data-placeholder' => '--- Trạng thái ---']) !!}
                            </div>

                            <div class="col-sm-1">
                                <button id="reset-page" class="btn btn-default" type="button" name="refresh" title="Reset">Làm lại</button>
                            </div>
                        </div>
                        <div id="table-toolbar">
                            <a href="<?=route($controllerName.'.create')?>" class="btn btn-success ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> Thêm {{ $title }}</span></a>

                        </div>
                        <table id="demo-custom-toolbar" class="table table-bordered table-striped table-hover" cellspacing="0"
                               data-toggle="table"
                               data-locale="vi-VN"
                               data-toolbar="#table-toolbar"
                               data-striped="true"
                               data-url="{!! route($controllerName.'.search') !!}"
                               data-search="true"
                               data-show-refresh="true"
                               data-show-toggle="false"
                               data-show-columns="true"
                               data-pagination="true"
                               data-side-pagination="server"
                               data-page-size="25"
                               data-query-params="queryParams"
                               data-cookie="true"
                               data-cookie-id-table="{{$controllerName}}-index"
                               data-cookie-expire="{!! config('params.bootstrapTable.extension.cookie.cookieExpire') !!}"
                        >
                            <thead>
                            <tr>
                                <th data-field="check_id" data-checkbox="true">ID</th>
                                <th data-field="fullname" data-sortable="true">Họ tên</th>
                                <th data-field="avatar" data-sortable="true" data-formatter="formatImage">Hình</th>
                                <th data-field="email" data-sortable="true">Email</th>
                                <th data-field="phone" data-sortable="true">Số điện thoại</th>
                                <th data-field="id" data-align="center" data-formatter="actionColumn">Chức năng</th>
                                <th data-field="status" data-sortable="true" data-formatter="formatStatus">Trạng thái</th>
                            </tr>
                            </thead>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

@section('before_styles')
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.12.1/bootstrap-table.min.css">
@endsection

@section('after_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
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
        $('#department_filter').val($.cookie("usersShowAll.bs.table.department_filter"));
        $('#reset-page').click(function (){
            $.removeCookie("usersShowAll.bs.table.department_filter");
            $.removeCookie("usersShowAll.bs.table.searchText");
            location.reload();
        });

        function actionColumn(value, row, index) {
            var tmp;
            var changePasswordBtn = [];

            <?php
            $hp = \App\Helpers\Auth::has_permission('users.show-reset-password', $user, $permissions);
            if ($hp) { ?>
                changePasswordBtn.push('<a href="{{ url("/{$controllerName}/reset-password") }}/' + value + '" ',
                'class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" data-original-title="Tạo lại mật khẩu">',
                '<i class="fa fa-key"></i></a>');
            <?php } ?>

            var editBtn = [];

            <?php
        $hp = \App\Helpers\Auth::has_permission('users.edit', $user, $permissions);
        if ($hp) { ?>
            tmp = '<?=route($controllerName.'.edit', ['id' => 'id'])?>';
            tmp = tmp.replace("/id/", "/"+value+"/");
            editBtn.push('<a href="' + tmp + '" ',
                'class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" data-original-title="Cập nhật">',
                '<i class="fa fa-pencil"></i></a>');
            <?php } ?>

                    <?php
            $hp = \App\Helpers\Auth::has_permission('users.destroy', $user, $permissions);
            if ($hp) { ?>
editBtn.push('<a href="{{ url("panel-kht/{$controllerName}") }}/' + value + '" ' +
                'class="add-tooltip btn btn-danger btn-xs btn-delete" data-toggle="tooltip" data-original-title="Xoá nhân sự">' +
                '<i class="fa fa-trash-o"></i></a>');
            <?php } ?>

                return [changePasswordBtn.join(' '), editBtn.join(' ')].join(' ');
        }

        function queryParams(params) {
               params.status = $('#status_filter').val();
            return params;
        }

          function formatStatus(value, row, index) {

            if(value == 1)
            {
                return '<span class="label label-sm label-success">Đang kích hoạt</span>'
            }
            else
            {
                return '<span class="label label-sm label-warning">Không kích hoạt</span>';
            }
        }

        function formatImage(value, row, index) {
            if (!value) {
                value = '/images/user.png';
            }
            var url = '<img src="' + value +'" height="100" width="100" onerror="this.src=\'/images/user.png\';">';

            return url;
        }

        function formatAbility(value, row, index) {
            if(!value)
                value = 0;
            return '<div style="width: 125px;text-align: center;"> <input value="' + value + '" type="hidden" class="cus_rating rating-input" data-min=0 data-max=5 data-step=0.5 data-size="xs" data-disabled="true"></div>';
        }

         $('#status_filter').change(function() {
            var status = $(this).val();
            if(status == '1')
            {
                $('#demo-active-row').hide();
                $('#demo-inactive-row').show();
            }
            else
            {
                $('#demo-active-row').show();
                $('#demo-inactive-row').hide();
            }
        });


        $(document).ready(function() {
            init_select2('.custom_filter');

            @if(isset($message) && $message)
            show_pnotify("{!! $message['title'] !!}", "{!! $message['text'] !!}", "{!! $message['type'] !!}");
            @endif

            var $table = $('#demo-custom-toolbar');

            $table.on('load-success.bs.table', function () {
                init_action();
            });

            $table.on( 'column-switch.bs.table', function () {
                init_action();
            });

            // select_filter
            $('.custom_filter').on('change', function(evt, params) {
                $.cookie("usersShowAll.bs.table.department_filter", $('#department_filter').val());
                $table.bootstrapTable('refresh');
            });
        });

        function init_action() {
            $('[data-toggle="tooltip"]').tooltip({
                container: 'body'
            });
            $('.btn-reset-sga').on('click', function (e) {
                e.preventDefault();
                var href = $(this).attr('href');
                malert('Bạn có thật sự muốn. ' + $(this).attr('data-original-title'), 'Xác nhận', null, function () {
                    location.href = href;
                });
                return false;
            });

            $('.btn-delete').on('click', function (e) {
                e.preventDefault();
                var obj = $(this);
                malert('Bạn có thật sự muốn xoá nhân sự này không?', 'Xác nhận xoá nhân sự', null, function () {
                    ajax_loading(true);

                    $.ajax({
                        method: "DELETE",
                        url: obj.attr('href'),
                        dataType: 'json'
                    })
                        .done(function( res ) {
                            ajax_loading(false);
                            malert(res.msg, null, function () {
                                if(res.rs) {
                                    obj.closest('tr').remove();
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
        }

    </script>
@endsection
