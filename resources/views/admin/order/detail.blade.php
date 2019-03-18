@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <style>
        .chosen-container-single .chosen-single abbr {
            top: 12px !important;
        }
    </style>
    <section class="content-header">
        <h1>
            <span class="text-capitalize">{{ $title }}</span>
            <small>Chi tiết <span>{{ $title }}</span> trong cơ sở dữ liệu.</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/">Trang chủ</a></li>
            <li><a href="<?=route($controllerName . '.index')?>" class="text-capitalize">{{ ucfirst($title) }}</a></li>
            <li class="active">Chi tiết</li>
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
                        <h3 class="box-title">Chi tiết {{$title}}</h3>
                        <div id="datatable_button_stack" class="pull-right text-right hidden-xs"></div>
                    </div>
                    <div class="box-body overflow-hidden">
                        <div class="row">
                            <div class="col-sm-3">
                                {!! Form::select('status_filter', $status, '1',
                                [
                                    'id' => 'status_filter',
                                    'class' => 'custom_filter',
                                    'data-placeholder' => '--- Trạng thái đơn hàng ---']) !!}
                            </div>

                            <div class="col-sm-3">
                                {!! Form::select("asset_category_id", $assetCate, null,
                                          ['id' => 'asset_category_id', 'class' => 'custom_filter',

                                          'data-placeholder' => 'Chọn loại hình']) !!}
                            </div>


                            <div class="col-sm-1">
                                <button id="reset-page" class="btn btn-default" type="button" name="refresh"
                                        title="Reset"><i class="fa fa-refresh" aria-hidden="true"></i> Làm lại
                                </button>
                            </div>
                        </div>

                        <div class="header">
                            <h2 class="title">Xem đơn hàng
                                <span>#<?=$objectOder['id'] ? $objectOder['id'] : $objectOder['id'];?>
                                    -<?=$objectOder['created_at']?></span>
                            </h2>
                        </div>

                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#1" data-toggle="tab">Thông tin chung</a>
                            </li>
                            <li><a href="#2" data-toggle="tab">Lịch sử đơn hàng</a>
                            </li>
                            <li style="display: none;"><a href="#3" data-toggle="tab">Trạng thái giao hàng</a>
                            </li>
                        </ul>


                        <div class="tab-content ">
                            <!-- tab content 1 -->
                            <div class="tab-pane active" id="1">
                                <div class="top_content">
                                    <p> Đơn hàng
                                        <b>#<?=$objectOder['id'] ? $objectOder['id'] : $objectOder['id'];?></b>
                                        được đặt vào lúc <b><?=$objectOder['created_at']?></b></p>
                                    <p style="display: block;"><b>Trạm giao hàng:</b> <?=@$objectOder['from']?>
                                    </p>
                                    <p style="display: block;"><b>Trạm nhận hàng:</b> <?=@$objectOder['to']?></p>
                                </div>
                                <div class="main_content">
                                    <div class="col-md-7">
                                        <div class="box top_detail">


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
        $('#reset-page').click(function () {
            var url = window.location.href;
            window.location = url;
        });

        function actionColumn(value, row, index) {
            var tmp = '';
            var editBtn = [];

            tmp = '<?=route($controllerName . '.edit', ['id' => 'id'])?>';
            tmp = tmp.replace("/id/", "/" + value + "/");
            editBtn.push(
                '<a href="' + tmp + '" ' +
                'class="add-tooltip btn btn-primary btn-xs" data-placement="top" data-original-title="Chỉnh sửa {{$title}}">' +
                '<i class="fa fa-edit"></i> Chỉnh sửa</a>');

            editBtn.push('<a href="<?=route($controllerName . '.index')?>/' + value + '" ' +
                'class="add-tooltip btn btn-danger btn-xs btn-delete" data-toggle="tooltip" data-original-title="Xóa {{$title}}">' +
                '<i class="fa fa-trash-o"></i> Xóa</a>');

            editBtn.push('<a href="<?=route($controllerName . '.index')?>/' + value + '" ' +
                'class="add-tooltip btn btn-primary btn-xs btn-delete" data-toggle="tooltip" data-original-title="Xem chi tiết {{$title}}">' +
                '<i class="icon-view-fast"></i> Xem chi tiết</a>');

            return editBtn.join(' ');
        }

        function queryParams(params) {
            params.asset_category_id = $('#asset_category_id').val();
            params.province_id = $('#province_id').val();
            params.status = $('#status_filter').val();
            return params;
        }

        function formatImage(value, row, index) {
            if (!value) {
                value = '/images/no-image.jpeg';
            }
            var url = '<img src="' + value + '" width="300" onerror="this.src=\'/images/no-image.jpeg\';">';

            return url;
        }

        $('#status_filter').change(function () {
            var status = $(this).val();
            if (status == '1') {
                $('#demo-active-row').hide();
                $('#demo-rented-row').show();
                $('#demo-inactive-row').show();
            }
            if (status == '2') {
                $('#demo-active-row').show();
                $('#demo-rented-row').hide();
                $('#demo-inactive-row').show();
            }
            else {
                $('#demo-active-row').show();
                $('#demo-inactive-row').hide();
                $('#demo-rented-row').show();
            }
        });

        function formatStatus(value, row, index) {

            if (value == 1) {
                return '<span class="label label-sm label-success">Đang kích hoạt</span>'
            }
            if (value == 2) {
                return '<span class="label label-sm label-danger">Đã cho thuê</span>'
            }
            else {
                return '<span class="label label-sm label-warning">Không kích hoạt</span>';
            }
        }

        function activeItems(items, e) {
            if (e) e.preventDefault();
                    {{--malert('Bạn có thật sự muốn kích hoạt {{$title}} này không?', 'Xác nhận kích hoạt {{$title}}', null, function () {--}}
            var url = '{{ url("/panel-kht/asset/ajax-active") }}';
            var data = {
                '_token': '{{ csrf_token() }}',
                'ids': items
            };

            console.log(items);
            $.post(url, data).done(function (data) {
                $('#demo-custom-toolbar').bootstrapTable('refresh');
                $('#demo-active-row').prop('disabled', true);
                $('#demo-inactive-row').prop('disabled', true);
                $('#demo-delete-row').prop('disabled', true);
                if (data.rs == 1) {
                    $('#success_msg').html(data.msg);
                    $('#success_div').show();
                    $(window).scrollTop(0);
                }
                else {
                    $('#error_msg').html(data.msg);
                    $("#error_div").show();
                    $(window).scrollTop(0);
                }
            });
//            });
        }

        function rentedItems(items, e) {
            if (e) e.preventDefault();
                    {{--malert('Bạn có thật sự muốn kích hoạt {{$title}} này không?', 'Xác nhận kích hoạt {{$title}}', null, function () {--}}
            var url = '{{ url("/panel-kht/asset/ajax-rented") }}';
            var data = {
                '_token': '{{ csrf_token() }}',
                'ids': items
            };

            console.log(items);
            $.post(url, data).done(function (data) {
                $('#demo-custom-toolbar').bootstrapTable('refresh');
                $('#demo-active-row').prop('disabled', true);
                $('#demo-inactive-row').prop('disabled', true);
                $('#demo-delete-row').prop('disabled', true);
                $('#demo-rented-row').prop('disabled', true);
                if (data.rs == 1) {
                    $('#success_msg').html(data.msg);
                    $('#success_div').show();
                    $(window).scrollTop(0);
                }
                else {
                    $('#error_msg').html(data.msg);
                    $("#error_div").show();
                    $(window).scrollTop(0);
                }
            });
//            });
        }


        //---------------------------------
        function inactiveItems(items, e) {
            if (e) e.preventDefault();
                    {{--malert('Bạn có thật sự muốn ngừng kích hoạt {{$title}} này không?', 'Xác nhận ngừng kích hoạt {{$title}}', null, function () {--}}
            var url = '{{ url("/panel-kht/asset/ajax-inactive") }}';
            var data = {
                '_token': '{{ csrf_token() }}',
                'ids': items
            };

            console.log(items);
            $.post(url, data).done(function (data) {
                $('#demo-custom-toolbar').bootstrapTable('refresh');
                $('#demo-active-row').prop('disabled', true);
                $('#demo-inactive-row').prop('disabled', true);
                $('#demo-delete-row').prop('disabled', true);
                if (data.rs == 1) {
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
                var url = '{{ url("/panel-kht/asset/ajax-delete") }}';
                var data = {
                    '_token': '{{ csrf_token() }}',
                    'ids': items
                };

                console.log(items);
                $.post(url, data).done(function (data) {
                    $('#demo-custom-toolbar').bootstrapTable('refresh');
                    $('#demo-active-row').prop('disabled', true);
                    $('#demo-inactive-row').prop('disabled', true);
                    $('#demo-delete-row').prop('disabled', true);
                    if (data.rs == 1) {
                        $('#danger_msg').html(data.msg);
                        $('#danger_div').show();
                        $(window).scrollTop(0);
                    }
                });
            });
        }

        $(document).ready(function () {
            @if (session('msg'))
            notifyMsg('{{ session('msg') }}');
                    @endif

            var status = $('#status_filter').val();
            if (status == '1') {
                $('#demo-active-row').hide();
                $('#demo-inactive-row').show();
            }
            else {
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


            var $active = $('#demo-active-row');

            $table.on('check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table', function () {
                $active.prop('disabled', !$table.bootstrapTable('getSelections').length);
            }).on('load-success.bs.table', function () {
                var tooltip = $('.add-tooltip');
                if (tooltip.length) tooltip.tooltip();
            });

            $active.click(function () {
                var ids = $.map($table.bootstrapTable('getSelections'), function (row) {
                    return row.id;
                });
                activeItems(ids);
            });


            var $rented = $('#demo-rented-row');

            $table.on('check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table', function () {
                $rented.prop('disabled', !$table.bootstrapTable('getSelections').length);
            }).on('load-success.bs.table', function () {
                var tooltip = $('.add-tooltip');
                if (tooltip.length) tooltip.tooltip();
            });

            $rented.click(function () {
                var ids = $.map($table.bootstrapTable('getSelections'), function (row) {
                    return row.id;
                });
                rentedItems(ids);
            });
            //-------------------------------

            var $inactive = $('#demo-inactive-row');

            $table.on('check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table', function () {
                $inactive.prop('disabled', !$table.bootstrapTable('getSelections').length);
            }).on('load-success.bs.table', function () {
                var tooltip = $('.add-tooltip');
                if (tooltip.length) tooltip.tooltip();
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
                if (tooltip.length) tooltip.tooltip();
            });

            $delete.click(function () {
                var ids = $.map($table.bootstrapTable('getSelections'), function (row) {
                    return row.id;
                });
                deleteItems(ids);
            });


            // select_filter
            $('.custom_filter').chosen({width: '100%', allow_single_deselect: true});
            $('.custom_filter').on('change', function (evt, params) {
                $table.bootstrapTable('refresh');
            });


        });


    </script>
@endsection
