@extends('layouts.admin')

<?php
$action_name = isset($object) ? 'Chỉnh sử' : 'Thêm mới';
?>

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <span class="text-capitalize">{{ $title }}</span>
            <small><?=$action_name?> <span>{{ $title }}</span>.</small>
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
                        <h3 class="box-title"><?=$action_name?> {{$title}}</h3>
                    </div>
                    <div class="box-body">
                    <form role="form" class="form-horizontal" method="post">
                        <div class="panel">
                            <div class="panel-body">
                                <div class="tab-content">
                                    <div class="form-group">
                                        <label for="fullname">
                                            Tên vai trò
                                        </label>
                                        {!! Form::text("name", null, ['class' => 'form-control', 'required']) !!}
                                        <span class="help-block has-error">{!! $errors->first("name") !!}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="form-field-1">
                                            Quyền
                                        </label>
                                        <table class="table table-bordered default">
                                                <thead>
                                                    <tr class="header_table">
                                                        <td>Nhóm</td>
                                                        <td>Lợi ích</td>
                                                        <td>Cho phép</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($parentPermissions as $item)
                                                    <?php
                                                    $count = count($group_permissions[$item['id']]);
                                                    $ac = $count ? array_shift($group_permissions[$item['id']]) : false;
                                                    ?>
                                                    <tr>
                                                        <td class="group-permission" rowspan="{{$count}}">
                                                            {{ $item['name'] }}<br/>
                                                        </td>
                                                        @if ($ac)
                                                            <td>{{ $ac['name'] }}</td>
                                                            <td><input type="checkbox" name="permissions[]" id="permission-{{ $ac['id'] }}"
                                                                       value="{{ $ac['id'] }}" class="flat" /></td>
                                                        @else
                                                            <td></td>
                                                            <td></td>
                                                        @endif
                                                    </tr>

                                                    @if(isset($group_permissions[$item['id']]))
                                                        @foreach($group_permissions[$item['id']] as $ac)
                                                            <tr>
                                                                <td>{{ $ac['name'] }}</td>
                                                                <td><input type="checkbox" name="permissions[]" id="permission-{{ $ac['id'] }}"
                                                                           value="{{ $ac['id'] }}" class="flat" /></td>
                                                            </tr>
                                                        @endforeach
                                                    @endif

                                                @endforeach
                                                </tbody>
                                            </table>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer text-right">
                                <a href='{!! route("roles.index") !!}' class="btn btn-success btn-labeled fa fa-arrow-left pull-left"> Danh sách vai trò</a>
                                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                <button class="btn btn-primary btn-labeled fa fa-save"> Lưu lại</button>
                                <button type="reset" class="btn btn-default btn-labeled fa fa-refresh"> Làm lại</button>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('after_scripts')
    <style>
        .group-permission {
            vertical-align: middle !important;
            font-weight: 700;
        }
    </style>
    <!-- iCheck -->
    <link href="/html/plugins/iCheck/flat/green.css" rel="stylesheet">
    <script src="/html/plugins/iCheck/icheck.min.js"></script>
    <script type="text/javascript">

        $(document).ready(function() {
            $('input.flat').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            });
        });

    </script>
@endsection