@extends('layouts.admin')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <span class="text-capitalize">{{ $title }}</span>
        <small>Thêm mới <span>{{ $title }}</span>.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/">Trang chủ</a></li>
        <li><a href="<?=route($controllerName.'.index')?>" class="text-capitalize">{{ ucfirst($title) }}</a></li>
        <li class="active">Thêm mới</li>
    </ol>
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
                <form id="frm-add" method="post" action="<?=route($controllerName.'.index')?>" class="form-horizontal">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="form-field-1">
                                        Tên thuộc tính <span class="required"></span>
                                    </label>


                                    <div class="col-sm-8">
                                        {!! Form::select("feature_id", $assetFeature, null,
                                         ['id' => 'feature_id',
                                        'class' => 'form-control select2',
                                        'data-placeholder' => '--- Chọn thuộc tính ---']) !!}
                                      
                                        <label id="feature_id-error" class="error" for="feature_id">{!!
                                            $errors->first("feature_id") !!}</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="form-field-1">
                                        Tên giá trị thuộc tính
                                    </label>
                                    <div class="col-sm-9">
                                        {!! Form::text("name", null, ['class' => 'form-control']) !!}
                                        <label id="name-error" class="error" for="name">{!! $errors->first("name") !!}</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="form-field-1">
                                        Mô tả
                                    </label>
                                    <div class="col-sm-9">
                                        {!! Form::textarea("description", null, ['class' => 'form-control']) !!}
                                        <label id="description-error" class="error" for="description">{!!
                                            $errors->first("description") !!}</label>
                                    </div>
                                </div>
                                <div id="fromto">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label " for="form-field-1">
                                            Giá trị từ
                                        </label>
                                        <div class="col-sm-9">
                                            {!! Form::text("from", null, ['id' => 'from', 'class' => 'form-control'])
                                            !!}
                                            <label id="from-error" class="error" for="from">{!! $errors->first("from")
                                                !!}</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label " for="form-field-1">
                                            Giá trị đến
                                        </label>
                                        <div class="col-sm-9">
                                            {!! Form::text("to", null, ['id' => 'to','class' => 'form-control' ]) !!}
                                            <label id="to-error" class="error" for="to">{!! $errors->first("to") !!}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="form-field-1">
                                        Trạng thái
                                    </label>
                                    <div class="col-sm-4">
                                        <label class="radio-inline">
                                            <input type="radio" name="status" id="status1" value="1" checked> Kích hoạt
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="status" id="status2" value="0"> Không kích hoạt
                                        </label>
                                    </div>
                                    <label class="col-sm-3 control-label" for="form-field-1">
                                        Ưu tiên <span class="required"></span>
                                    </label>
                                    <div class="col-sm-2">
                                        {!! Form::select("position", $orderOptions, null, ['id' => 'position','class'
                                        => 'form-control select2','data-placeholder' => '--- Chọn thứ tự ---']) !!}
                                        <label id="position-error" class="error" for="order">{!!
                                            $errors->first("position") !!}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-5">

                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <div class="row">
                            <div class="col-sm-3">
                                <a href='{!! route($controllerName.'.index') !!}' class="btn btn-success btn-labeled fa fa-arrow-left pull-left">
                                    Danh sách {{ $title }}</a>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js" type="text/javascript"></script>
<script src="{{ asset('js/function.js') }}"></script>
<script src="{{ asset('js/numeral.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/bower_components/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('/html-admin/plugins/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('/html-admin/plugins/ckfinder/ckfinder.js?v=2019011622') }}"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#fromto').css('display','none');

        $('#feature_id').change(function () {
            var feature_id = $('#feature_id').val();
            var url = '/panel-kht/promotion-feature-variant/ajax-disable-feature/' + feature_id;
            $.get(url).done(function (data) {
                console.log(data);

                if (data.is_range == 1) {
                    $('#fromto').css('display', 'block');
                } else {
                    $('#fromto').css('display', 'none');
                }
            });

        });

       $('#frm-add').validate({
                ignore: ".ignore",
                rules: {
                    feature_id: "required",
                    name: "required",
//                    address: "required",
                },
                messages: {
                    name: "Vui lòng nhập tên {{ $title }}",
                    feature_id: "Vui lòng nhập thuôc tính",
                },

            submitHandler: function (form) {
                ajax_loading(true);
                $.ajax({
                        method: "POST",
                        url: $(form).attr('action'),
                        dataType: 'json',
                        data: $(form).serializeArray()
                    })
                    .done(function (res) {
                        console.log(res);
                        ajax_loading(false);
                        malert(res.msg, null, function () {
                            if (res.rs) {
                                location.href = '<?=route($controllerName.'.index')?>';
                            }
                        });
                    })
                    .fail(function (res) {
                        ajax_loading(false);
                        if (res.status == 403) {
                            malert(
                                'Bạn không có quyền thực hiện tính năng này. Vui lòng liên hệ Admin!'
                            );
                        }
                    });
                return false;
            }
        });

        init_select2('.select2');
    });
</script>
@endsection