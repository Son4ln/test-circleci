@extends('layouts.ample')

@section('content-header')
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
	<h4 class="page-title">@lang('users.upgrade.client_title')</h4>
</div>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
		<div class="panel-body">
			<div class="alert alert-dismissable background-60bfb3 text-white">
			<button class="close" data-dismiss="alert" aria-label="close">&times;</button>
			@lang('users.upgrade.client_alert')
			</div>
			@if (count($errors) > 0)
			<div class="alert alert-danger">
				<strong>@lang('ui.has_error')</strong>@lang('ui.has_error_text')<br><br>
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
				</ul>
			</div>
			@endif

			<form class="form-horizontal form-upgrade-client" role="form" method="POST" action="{{ url('/profile/client') }}">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			<div class="form-group">
				<label class="col-md-3 control-label">@lang('users.fields.alt_name') <span class="label label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
				<div class="col-md-6">
				<input type="text" class="form-control" name="name" value="{{ old('name') }}">
				<p class="help-block text-black">@lang('users.fields.name_help')</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label">@lang('users.fields.ruby') <span class="label label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
				<div class="col-md-6">
				<input type="text" class="form-control" name="ruby" value="{{ old('ruby') }}">
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label">@lang('users.fields.alt_company_name')</label>
				<div class="col-md-6">
				<input type="text" class="form-control" name="company" value="{{ old('company') }}">
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label">@lang('users.fields.alt_department')</label>
				<div class="col-md-6">
				<input type="text" class="form-control" name="department" value="{{ old('department') }}">
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label">@lang('users.fields.homepage') <span class="label label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
				<div class="col-md-6">
				<input type="text" class="form-control" name="homepage" value="{{ old('homepage') }}">
				<p class="help-block text-black">@lang('users.fields.homepage_help')</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label">@lang('users.fields.tel') <span class="label label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
				<div class="col-md-6">
				<input type="text" class="form-control" name="tel" value="{{ old('tel') }}">
				<p class="help-block text-black">@lang('users.fields.tel_help')</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label">@lang('users.fields.zip') <span class="label label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
				<div class="col-md-6">
				<input type="text" class="form-control" name="zip" value="{{ old('zip') }}">
				<p class="help-block text-black">@lang('users.fields.zip_help')</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label">@lang('users.fields.address') <span class="label label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
				<div class="col-md-6">
				<input type="text" class="form-control" name="address" value="{{ old('address') }}">
				</div>
			</div>


			<div class="form-group row">
				<div class="col-md-6 col-md-offset-2">
					<button type="submit" class="btn background-60bfb3 client-upgrade-btn">
					@lang('users.upgrade.client_submit')
					</button>
				</div>
			</div>
			</form>
		</div>
		</div>
	</div>
	</div>
</div>
@endsection