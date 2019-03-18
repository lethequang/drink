@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <span class="text-capitalize">{{ $title }}</span>
            <small>Cào tin <span>{{ $title }}</span>.</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/">Trang chủ</a></li>
            <li><a href="<?=route($controllerName . '.index')?>" class="text-capitalize">{{ ucfirst($title) }}</a></li>
            <li class="active">Lấy tin</li>
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
                    <form id="frm-add" method="post" action="<?=route('article.crawler')?>"
                          class="form-horizontal">
                        <div class="box-body">
                            <div class="col-sm-2">
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="form-field-1">
                                        link cần lọc bài <span class="required"></span>
                                    </label>
                                    <div class="col-sm-7">
                                        {!! Form::text("link_tag", null, ['class' => 'form-control']) !!}
                                        <label id="link_tag-error" class="error"
                                               for="link_tag">{!! $errors->first("link_tag") !!}</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="form-field-1">
                                        Thẻ lấy từng bài <span class="required"></span>
                                    </label>
                                    <div class="col-sm-7">
                                        {!! Form::text("post_tag", null, ['class' => 'form-control']) !!}
                                        <label id="post_tag-error" class="error"
                                               for="post_tag">{!! $errors->first("post_tag") !!}</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="form-field-1">
                                        url image <span class="required"></span>
                                    </label>
                                    <div class="col-sm-7">
                                        {!! Form::text("url_tag", null, ['class' => 'form-control']) !!}
                                        <label id="url_tag-error" class="error"
                                               for="url_tag">{!! $errors->first("url_tag") !!}</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="form-field-1">
                                        Thẻ lấy hình đại diện <span class="required"></span>
                                    </label>
                                    <div class="col-sm-7">
                                        {!! Form::text("avatar_tag", null, ['class' => 'form-control']) !!}
                                        <label id="department-error" class="error"
                                               for="department">{!! $errors->first("department") !!}</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="form-field-1">
                                        Thẻ lấy tiêu đề bài viết <span class="required"></span>
                                    </label>
                                    <div class="col-sm-7">
                                        {!! Form::text("title_tag", null, ['class' => 'form-control']) !!}
                                        <label id="title_tag-error" class="error"
                                               for="title_tag">{!! $errors->first("title_tag") !!}</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="form-field-1">
                                        Thẻ lấy mô tả ngắn <span class="required"></span>
                                    </label>
                                    <div class="col-sm-7">
                                        {!! Form::text("description_tag", null, ['class' => 'form-control']) !!}
                                        <label id="description_tag-error" class="error"
                                               for="description_tag">{!! $errors->first("description_tag") !!}</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="form-field-1">
                                        Thẻ lấy nội dung <span class="required"></span>
                                    </label>
                                    <div class="col-sm-7">
                                        {!! Form::text("content_tag", null, ['class' => 'form-control']) !!}
                                        <label id="content_tag-error" class="error"
                                               for="content_tag">{!! $errors->first("content_tag") !!}</label>
                                    </div>
                                </div>



                                {{--<div class="form-group">--}}
                                    {{--<div class="col-sm-9">--}}
                                        {{--<button class="btn btn-primary" id="downloadSynchronized"><i--}}
                                                    {{--class="fa fa-copy"></i>--}}
                                            {{--Đồng bộ--}}
                                            {{--ngay--}}
                                        {{--</button>--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                            </div>
                            <div class="col-sm-2">
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type="hidden" name="id" value="<?=@$object['id']?>">
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                            <div class="row">
                                <div class="col-sm-3">
                                    <a href='{!! route($controllerName.'.index') !!}'
                                       class="btn btn-success btn-labeled fa fa-arrow-left pull-left"> Danh
                                        sách {{ $title }}</a>
                                </div>
                                <div class="col-sm-9 text-right">
                                    <button class="btn btn-primary btn-labeled fa fa-save"> Lấy tin </button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"
            type="text/javascript"></script>
    <script src="{{ asset('js/function.js') }}"></script>
    <script src="{{ asset('js/numeral.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/bower_components/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/bower_components/moment/min/moment.min.js') }}"></script>
    <script src="/html-admin/plugins/ckeditor/ckeditor.js"></script>
    <script src="/html-admin/plugins/ckfinder/ckfinder.js?v=2019011622"></script>
    <script type="text/javascript" src="/html-admin/plugins/ckeditor/adapters/jquery.js"></script>
    <script type="text/javascript" src="/html-admin/plugins/ckeditor/config.js"></script>


    <script type="text/javascript">
        $(document).ready(function () {
            $('#frm-add').validate({
                ignore: ".ignore",
                rules: {
                    link_tag: "required",
                    post_tag: "required",
                    url_tag: "required",
                    avatar_tag: "required",
                    title_tag: "required",
                    description_tag: "required",
                    content_tag: "required",
                },
                messages: {
                    link_tag: "Vui lòng nhập tên",
                    post_tag: "Vui lòng nhập tên",
                    url_tag: "Vui lòng nhập tên",
                    avatar_tag:"Vui lòng nhập tên",
                    title_tag: "Vui lòng nhập tên",
                    description_tag: "Vui lòng nhập tên",
                    content_tag: "Vui lòng nhập tên",
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
                                    location.href = '<?=route($controllerName . '.lits' . '.craw')?>';
                                }
                            });
                        })
                        .fail(function (res) {
                            ajax_loading(false);
                            if (res.status == 403) {
                                malert('Bạn không có quyền thực hiện tính năng này. Vui lòng liên hệ Admin!');
                            }
                            if (res.status == 500) {
                                malert('Thông tin nhập chưa chính xác');
                            }
                        });
                    return false;
                }
            });

            init_select2('.select2');
        });
    </script>
    <script type="text/javascript">

        $(document).ready(function () {
            $('#downloadSynchronized').click(function () {
                var url = '{!! url("/panel-kht/crawler") !!}';
                window.location = url;
            });

        });


    </script>
@endsection
