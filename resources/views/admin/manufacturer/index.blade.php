@extends('layouts.admin')

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
                                <th data-field="name" data-sortable="true">Tên hãng sản xuất</th>
                                <th data-field="created_at" data-sortable="true">Ngày tạo</th>
                                <th data-field="is_deleted" data-sortable="true" data-formatter="formatStatus">Trạng thái</th>
                                <th data-field="id" data-align="center" data-formatter="actionColumn">Chức năng</th>
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
            var tmp = '';
            var editBtn = [];

            tmp = '<?=route($controllerName.'.edit', ['id' => 'id'])?>';
            tmp = tmp.replace("/id/", "/"+value+"/");
            editBtn.push(
                '<a href="' + tmp + '" ' +
                'class="add-tooltip btn btn-primary btn-xs" data-placement="top" data-original-title="Chỉnh sửa {{$title}}">' +
                '<i class="fa fa-edit"></i> Chỉnh sửa</a>');

            editBtn.push('<a href="<?=route($controllerName.'.index')?>/' + value + '" ' +
                'class="add-tooltip btn btn-danger btn-xs btn-delete" data-toggle="tooltip" data-original-title="Xóa {{$title}}">' +
                '<i class="fa fa-trash-o"></i> Xóa</a>');

            return editBtn.join(' ');
        }

        function queryParams(params) {
            return params;
        }

        function formatStatus(value, row, index) {

            if(value == 0)
            {
                return '<span class="label label-sm label-success">Đang hoạt động</span>'
            }
            else
            {
                return '<span class="label label-sm label-warning">Không hoạt động</span>';
            }
        }

        $(document).ready(function() {
            @if (session('msg'))
                notifyMsg('{{ session('msg') }}');
                    @endif

            var $table = $('#demo-custom-toolbar');

            $table.on('load-success.bs.table', function () {
                $('[data-toggle="tooltip"]').tooltip({
                    container: 'body'
                });
                $('.btn-delete').on('click', function (e) {
                    e.preventDefault();
                    var url = $(this).attr('href');
                    {{--malert('Bạn có thật sự muốn xoá {{$title}} này không?', 'Xác nhận xoá {{$title}}', null, function () {--}}
                        ajax_loading(true);

                        $.ajax({
                            method: "DELETE",
                            url: url,
                            dataType: 'json'
                        })
                            .done(function (res) {
                                ajax_loading(false);
                                malert_danger(res.msg, null, function () {
                                    if (res.rs) {
                                        window.location.reload();
                                    }
                                });
                            })
                            .fail(function (res) {
                                ajax_loading(false);
                                if (res.status == 403) {
                                    malert_warning('Bạn không có quyền thực hiện tính năng này. Vui lòng liên hệ Admin!');
                                }
                            });
//                    });
                    return false;
                });
            });
        });

    </script>
@endsection