@extends('layouts.admin')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <span class="text-capitalize">{{ $title }}</span>
            <small>Import <span>{{ $title }}</span>.</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/">Trang chủ</a></li>
            <li><a href="<?=route($controllerName.'.index')?>" class="text-capitalize">{{ ucfirst($title) }}</a></li>
            <li class="active">Import</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Import {{$title}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form id="frm-add" method="post" action="<?=route($controllerName.'.import')?>">
                        <div class="box-body">
                            <div class="col-sm-3">
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Chọn tập tin sản phẩm để import</label> <label id="file-error" class="error" for="file"></label>
                                    <p class="text-aqua"><a target="_blank" href="<?=url('/templates/san-pham.xlsx')?>">Click vào đây để tải tập tin mẫu.</a></p>
                                    <div style="clear: both;"></div>
                                    <span class="btn btn-success fileinput-button">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        <span>Select files...</span>
                                        <!-- The file input field used as target for the file upload widget -->
                                        <input id="fileupload" type="file" name="files[]">
                                    </span>
                                    <div id="files" class="files" style="float: right;max-width: 450px;"></div>
                                    <div style="clear: both;"></div>
                                    <!-- The global progress bar -->
                                    <div id="progress" class="progress" style="margin-top: 10px;">
                                        <div class="progress-bar progress-bar-success"></div>
                                    </div>
                                    <input id="file" type="hidden" name="file" value="">
                                    <label id="file-error" class="error" for="file"></label>
                                </div>
                            </div>
                            <div class="col-sm-3">
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-3">
                                <a href='{!! route($controllerName.'.index') !!}' class="btn btn-success btn-labeled fa fa-arrow-left pull-left"> Danh sách {{ $title }}</a>
                            </div>
                            <div class="col-sm-3 text-right">
                                <button class="btn btn-primary btn-labeled fa fa-save"> Lưu lại</button>
                                <button type="reset" class="btn btn-default btn-labeled fa fa-refresh"> Làm lại</button>
                            </div>
                            <div class="col-sm-3">
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
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="/js/jQuery-File-Upload/css/jquery.fileupload.css">
@endsection

@section('after_scripts')
    <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
    <script src="/js/jQuery-File-Upload/js/vendor/jquery.ui.widget.js"></script>
    <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
    <script src="/js/jQuery-File-Upload/js/jquery.iframe-transport.js"></script>
    <!-- The basic File Upload plugin -->
    <script src="/js/jQuery-File-Upload/js/jquery.fileupload.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
            'use strict';
            // Change this to the location of your server-side upload handler:
            var url = '<?=route('upload')?>';
            $('#fileupload').fileupload({
                url: url,
                dataType: 'json',
                done: function (e, data) {
                    $.each(data.result.files, function (index, file) {
                        $('#file').val(file.name);
                        $('<p/>').text(file.name).appendTo('#files');
                    });
                },
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#progress .progress-bar').css(
                        'width',
                        progress + '%'
                    );
                }
            }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
        });

        $(document).ready(function() {
            $('#frm-add').validate({
                ignore: ".ignore",
                rules: {
                    file: "required"
                },
                messages: {
                    file: {
                        required: "Chọn tập tin dữ liệu giá để import",
                    },
                },
                submitHandler: function(form) {
                    ajax_loading(true);
                    $.ajax({
                        method: "POST",
                        url: $(form).attr('action'),
                        dataType: 'json',
                        data: $(form).serializeArray()
                    })
                        .done(function (res) {
                            ajax_loading(false);
                            malert(res.msg, null, function () {
                                if (res.rs) {
                                    location.href='<?=route('product.index')?>';
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