@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
        <span class="text-capitalize">{{ $crud->entity_name_plural }}</span>
        <small>{{ trans('backpack::crud.add').' '.$crud->entity_name }}.</small>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
	    <li class="active">{{ trans('backpack::crud.add') }}</li>
	  </ol>
	</section>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">{{ trans('backpack::crud.add_a_new') }} {{ $crud->entity_name }}</h3>
				</div>
				<!-- form start -->
				<form method="post"
					  action="{{ url($crud->route) }}"
					  @if ($crud->hasUploadFields('create'))
					  enctype="multipart/form-data"
						@endif
				>
					<div class="box-body">

						{!! csrf_field() !!}

						<div class="col-md-8 col-md-offset-2">
							@include('crud::inc.grouped_errors')

							<!-- load the view from the application if it exists, otherwise load the one in the package -->
							@if(view()->exists('vendor.backpack.crud.form_content'))
								@include('vendor.backpack.crud.form_content', [ 'fields' => $crud->getFields('create'), 'action' => 'create' ])
							@else
								@include('crud::form_content', [ 'fields' => $crud->getFields('create'), 'action' => 'create' ])
							@endif
						</div>
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<div class="col-md-12">
						<div class="col-md-4 col-md-offset-2">
							<!-- Default box -->
							@if ($crud->hasAccess('list'))
								<a href="{{ url($crud->route) }}" class="hidden-print"><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a><br><br>
							@endif
						</div>
						<div class="col-md-4 text-right">
							@include('crud::inc.form_save_buttons')
						</div>
						</div>
					</div>
					<!-- /.box-footer -->
				</form>
			</div>
			<!-- Default box -->
		</div>
	</div>
@endsection
