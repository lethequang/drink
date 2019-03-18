@extends('layouts.admin')

@section('content')
    <style>
        .chosen-container-single .chosen-single abbr {
            top: 12px !important;
        }
    </style>
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
        <div id="danger_div" class="alert alert-danger alert-dismissible" style="display: none;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Thông báo!</h4>
            <span id="danger_msg"></span>
        </div>
    </section>
    <!-- Main content -->
    <section class="content" style="padding-top: 0px;">
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
                                {!! Form::select('status_filter', $status, 'is_active', [
                                    'id' => 'status_filter',
                                    'class' => 'custom_filter',
                                    'data-placeholder' => '--- Trạng thái ---']) !!}
                            </div>
                            <div class="col-sm-3">
                                {!! Form::select('code_filter', $product_codes, null, [
                                    'id' => 'code_filter',
                                    'class' => 'custom_filter',
                                    'data-placeholder' => '--- Mã sản phẩm ---']) !!}
                            </div>
                            <div class="col-sm-3">
                                {!! Form::select('is_home_filter', $status_home, null, [
                                    'id' => 'is_home_filter',
                                    'class' => 'custom_filter',
                                    'data-placeholder' => '--- Hiển thị trang chủ ---']) !!}
                            </div>
                            <div class="col-sm-1">
                                <button id="reset-page" class="btn btn-default" type="button" name="refresh" title="Reset"><i class="fa fa-refresh" aria-hidden="true"></i> Làm lại</button>
                            </div>
                        </div>
                        <div id="table-toolbar">
                            <a href="<?=route($controllerName.'.create')?>" class="btn btn-success" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> Thêm {{ $title }}</span></a>
                            <a href="<?=route('product.import')?>" class="btn btn-info"><i class="fa fa-list-alt"></i> Import sản phẩm</a>
                            <button id="demo-active-row" class="btn btn-success" disabled><i class="fa fa-check"></i> Kích hoạt</button>
                            <button id="demo-inactive-row" class="btn btn-warning" disabled><i class="fa fa-times"></i> Ngừng kích hoạt</button>
                            <button id="demo-delete-row" class="btn btn-danger" disabled><i class="fa fa-trash-o"></i> Xóa</button>
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
                                <th data-field="name" data-sortable="true">Tên sản phẩm</th>
                                <th data-field="code" data-sortable="true">Mã sản phẩm</th>
                                <th data-field="price" data-sortable="true">Đơn giá</th>
                                <th data-field="amount" data-sortable="true">Số lượng</th>
                                <th data-field="order" data-sortable="true">Ưu tiên</th>
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

    <link rel="stylesheet" href="/html-admin/plugins/chosen/chosen.min.css" rel="stylesheet">
    <script src="/html-admin/plugins/chosen/chosen.jquery.min.js"></script>

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
            return editBtn.join(' ');
        }

        function queryParams(params) {
            params.status = $('#status_filter').val();
            params.code = $('#code_filter').val();
            params.is_home = $('#is_home_filter').val();
            return params;
        }

        function formatImage(value, row, index) {
            if (!value) {
                value = '/images/no-image.jpeg';
            }
            var url = '<img src="' + value +'" width="300" onerror="this.src=\'/images/no-image.jpeg\';">';

            return url;
        }

        function formatStatus(value, row, index) {

            if(value == 0)
            {
                return '<span class="label label-sm label-success">Đang kích hoạt</span>'
            }
            else
            {
                return '<span class="label label-sm label-warning">Không kích hoạt</span>';
            }
        }

        //---------------------------------

        $('#status_filter').change(function() {
            var status = $(this).val();
            if(status === 'is_active')
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

        //---------------------------------
        function activeItems(items, e) {
            if (e) e.preventDefault();
            {{--malert('Bạn có thật sự muốn kích hoạt {{$title}} này không?', 'Xác nhận kích hoạt {{$title}}', null, function () {--}}
                var url = '{{ url("/panel-kht/product/ajax-active") }}';
                var data = {
                    '_token': '{{ csrf_token() }}',
                    'ids': items
                };

                console.log(items);
                $.post(url, data).done(function(data){
                    $('#demo-custom-toolbar').bootstrapTable('refresh');
                    $('#demo-active-row').prop('disabled', true);
                    $('#demo-inactive-row').prop('disabled', true);
                    $('#demo-delete-row').prop('disabled', true);
                    if(data.rs == 1)
                    {
                        $('#success_msg').html(data.msg);
                        $('#success_div').css("display", "block");
                        $(window).scrollTop(0);
                    }
                    else
                    {
                        $('#error_msg').html(data.msg);
                        $("#error_div").css("display", "block");
                        $(window).scrollTop(0);
                    }
                });
//            });
        }

        //---------------------------------
        function inactiveItems(items, e) {
            if (e) e.preventDefault();
            {{--malert('Bạn có thật sự muốn ngừng kích hoạt {{$title}} này không?', 'Xác nhận ngừng kích hoạt {{$title}}', null, function () {--}}
                var url = '{{ url("/panel-kht/product/ajax-inactive") }}';
                var data = {
                    '_token': '{{ csrf_token() }}',
                    'ids': items
                };

                console.log(items);
                $.post(url, data).done(function(data){
                    $('#demo-custom-toolbar').bootstrapTable('refresh');
                    $('#demo-active-row').prop('disabled', true);
                    $('#demo-inactive-row').prop('disabled', true);
                    $('#demo-delete-row').prop('disabled', true);
                    if(data.rs == 1)
                    {
                        $('#error_msg').html(data.msg);
                        $("#error_div").show();
                        $(window).scrollTop(0);
                    }
                });
//            });
        }

        //---------------------------------
        function deleteItems(items, e) {
            if (e) e.preventDefault();
            malert('Bạn có thật sự muốn xoá {{$title}} này không?', 'Xác nhận xoá {{$title}}', null, function () {
                var url = '{{ url("/panel-kht/product/ajax-delete") }}';
                var data = {
                    '_token': '{{ csrf_token() }}',
                    'ids': items
                };

                console.log(items);
                $.post(url, data).done(function(data){
                    $('#demo-custom-toolbar').bootstrapTable('refresh');
                    $('#demo-active-row').prop('disabled', true);
                    $('#demo-inactive-row').prop('disabled', true);
                    $('#demo-delete-row').prop('disabled', true);
                    if(data.rs == 1)
                    {
                        $('#danger_msg').html(data.msg);
                        $('#danger_div').show();
                        $(window).scrollTop(0);
                    }
                });
            }, 'alert-danger');
        }

        $(document).ready(function() {
            @if (session('msg'))
                notifyMsg('{{ session('msg') }}');
            @endif

            var status = $('#status_filter').val();
            if(status === 'is_active')
            {
                $('#demo-active-row').hide();
                $('#demo-inactive-row').show();
            }
            else
            {
                $('#demo-active-row').show();
                $('#demo-inactive-row').hide();
            }

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
                                }, null, 'alert-danger');
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

            //-------------------------------

            var $active = $('#demo-active-row');

            $table.on('check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table', function () {
                $active.prop('disabled', !$table.bootstrapTable('getSelections').length);
            }).on('load-success.bs.table', function () {
                var tooltip = $('.add-tooltip');
                if (tooltip.length)tooltip.tooltip();
            });

            $active.click(function () {
                var ids = $.map($table.bootstrapTable('getSelections'), function (row) {
                    return row.id;
                });
                activeItems(ids);
            });

            //-------------------------------

            var $inactive = $('#demo-inactive-row');

            $table.on('check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table', function () {
                $inactive.prop('disabled', !$table.bootstrapTable('getSelections').length);
            }).on('load-success.bs.table', function () {
                var tooltip = $('.add-tooltip');
                if (tooltip.length)tooltip.tooltip();
            });

            $inactive.click(function () {
                var ids = $.map($table.bootstrapTable('getSelections'), function (row) {
                    return row.id;
                });
                inactiveItems(ids);
            });

            //------------------------------------

            var $delete = $('#demo-delete-row');

            $table.on('check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table', function () {
                $delete.prop('disabled', !$table.bootstrapTable('getSelections').length);
            }).on('load-success.bs.table', function () {
                var tooltip = $('.add-tooltip');
                if (tooltip.length)tooltip.tooltip();
            });

            $delete.click(function () {
                var ids = $.map($table.bootstrapTable('getSelections'), function (row) {
                    return row.id;
                });
                deleteItems(ids);
            });


            // select_filter
            $('.custom_filter').chosen({width:'100%', allow_single_deselect: true});
            $('.custom_filter').on('change', function(evt, params) {
                $table.bootstrapTable('refresh');
            });
        });

    </script>
@endsection