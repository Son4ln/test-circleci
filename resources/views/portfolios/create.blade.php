@extends('layouts.ample')

@section('content-header')
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
	<h4 class="page-title">@lang('portfolios.create.title')</h4>
</div>
@endsection

@section('content')
<div class="white-box">
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
<div id="l-flag-mov"></div>
<form id='portfolioform' class='form-horizontal' method='post'
	enctype="multipart/form-data"
	action="{{ url('portfolios') }}">
	{{ csrf_field() }}
	<div id="temp"></div>
	<div class="form-group" style="margin-top: 20px;">
	<label class="col-md-3 control-label ">@lang('portfolios.create.media') <span class="label label-warning-new">@lang('portfolios.required')</span></label>
	<div class="col-md-6">
		<input type="file" id="file_selection" style="display: none" accept="image/*,video/*">
		<label for="file_selection" class="qq-upload-button background-05287b">@lang('portfolios.create.select')</label>
		<p class="help-block margin-0">@lang('portfolios.create.validation')</p>
		<div id="file-error" style="color: #f00"></div>
		<input type="text" class="hidden" name="url" value="{{ old('url') }}">
		<input type="text" class="hidden" name="thumb_path" value="{{ old('thumb_path') }}">
		<input type="text" class="hidden" name="mime" value="{{ old('mime') }}">
		<input type="text" name="validation" class="hidden" required>
		<video src="" id="preview" width="250" controls class="hidden" autoplay>
		</video>
		<div id="thumnail" style="">
		<img src="" id="thumbnail-preview" style="max-width: 250px">
		</div>
		<div class="control hidden">
		<button class="btn btn-success" id="recreate" type="button">@lang('portfolios.create.create_thumbnail')</button>
		<input type="file" id="hidden_file" class="hidden" accept="image/*">
		<label for="hidden_file" class="btn btn-info">@lang('portfolios.create.upload_thumbnail')</label>
		</div>
	</div>
	</div>
	{{-- <div class="form-group">
	<label class="col-md-3 control-label">サムネイル</label>
	<div class="col-md-6">
		<input type="file" name="image" accept="image/*">
	</div>
	</div> --}}
	<div class="form-group">
	<label class="col-md-3 control-label">@lang('portfolios.create.title_field') <span class="label label-warning-new">@lang('portfolios.required')</span></label>
	<div class="col-md-6">
		<input type='text' name='title' class='form-control' value="{{ old('title') }}" required>
	</div>
	</div>

	<div class="form-group">
	<label class="col-md-3 control-label  "><span class="font-size-1em portfolios-create-margin">@lang('portfolios.create.video_style')</span> <span class="label label-warning-new">@lang('portfolios.required')</span></label>
	<div class="col-md-6">
		@foreach(config('const.project_movie_style', []) as $index => $type)
		{!! Form::checkbox('styles[]', $index, null, [
			'class' => 'input-checkbox ',
			'id' => 'style-'.$index,
			'data-parsley-multiple' => 'style',
			'data-parsley-errors-container' => '#style-error',
			'required' => '',
			'data-parsley-error-message' => __('portfolios.style_error')]) !!}
		<label for="{{ 'style-'.$index }}" class="label-checkbox creator-checked-margin"> {{ $type }}</label>
		@endforeach
		<div id="style-error">

		</div>
	</div>
	</div>

	<div class="form-group">
	<label class="col-md-3 control-label  "><span class="font-size-1em portfolios-create-margin">@lang('portfolios.create.video_type')</span> <span class="label label-warning-new">@lang('portfolios.required')</span></label>
	<div class="col-md-6">
		@foreach(config('const.project_movie_type', []) as $index => $type)
		{!! Form::checkbox('types[]', $index, null, [
			'class' => 'input-checkbox creator-checked-margin',
			'id' => 'type-'.$index,
			'data-parsley-multiple' => 'type',
			'required' => '',
			'data-parsley-errors-container' => '#type-error',
			'data-parsley-error-message' => __('portfolios.type_error')
		]) !!}
		<label for="{{ 'type-'.$index }}" class="label-checkbox creator-checked-margin"> {{ $type }}</label>
		@endforeach
		<div id="type-error"></div>
	</div>
	</div>

	<div class="form-group">
	<label class="col-md-3 control-label">@lang('portfolios.create.budget')</label>
	<div class="col-md-6">
		<div id="slider" data-value="{{ old('amount') ? old('amount') : 0 }}"></div>
		<br>@lang('portfolios.create.budget_text')
	</div>
	</div>
	<div class="form-group">
	<label class="col-md-3 control-label">@lang('portfolios.create.scope')</label>
	<div class="col-md-6">
		<select name="scope" class="form-control">
		<option value="0" <?php echo e(old('scope') == 0 ? "selected" : ''); ?>>@lang('portfolios.scope.public')</option>
		<option value="1" <?php echo e(old('scope') == 1 ? "selected" : ''); ?>>@lang('portfolios.scope.crluo')</option>
		</select>
	</div>
	</div>
	<div class="form-group">
	<label class="col-md-3 control-label">@lang('portfolios.create.comment')</label>
	<div class="col-md-6">
		<textarea name='comment'
		class='form-control'
		style='margin: 1rem 0;'>{{ old('comment') }}</textarea>
	</div>
	</div>
	<div class="form-group">
	<div class="col-md-6 col-md-offset-3">
		<div>@lang('portfolios.create.warning_text')</div>
		<button id='portfolio-edit-btn'
		class='btn btn-warning pull-left background-229393 margin-top-5px'
		data-loading-text="登録中">@lang('portfolios.create.submit')</button>
	</div>
	</div>
	<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
	<input type="hidden" name="amount" value="{{ old('amount') ? old('amount') : 0 }}">
</form>
</div>

<div id="progress_screen" style="display: none">
<div class="white-boxs">
	<p id="progress_text">@lang('portfolios.validating')</p>
	<div class="progress">
	<div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar"
	aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
	</div>
	</div>
</div>
</div>

<canvas id="canvas" class="hidden">
@endsection

@push('scripts')
{{ Html::script('adminlte/plugins/jquery-ui/jquery-ui.min.js') }}
@include('templates.portfolio_upload')
<script src="{{ asset('adminlte/plugins/parsley/parsley.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/parsley/i18n/ja.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/s3.fine-uploader.min.js') }}"></script>
<script type="text/javascript">
	var messages = {
	upload_limit: '@lang('flash_messages.rooms.file_limit')',
	member_limit: '@lang('flash_messages.rooms.member_limit')',
	size_limit: '@lang('flash_messages.rooms.member_limit')'
	}
	var bucketName = '{{ config('filesystems.disks.s3.bucket') }}';
	var region = '{{ config('filesystems.disks.s3.region') }}'
	var accessKey = '{{ config('filesystems.disks.s3.client_key') }}'
</script>
<script type="text/javascript" src="{{ asset('js/s3.uploader.js?v='.VERSION_CSS_JS) }}"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#portfolioform').parsley();
	$("#slider").slider({
	animate: true,
	value: $('#slider').data('value'),
	min: 0,
	max: 200,
	step: 1,
	slide: function(event, ui) {
		$('input[name="amount"]').val(ui.value)
		$('#slider span').html('<label><span class="glyphicon glyphicon-chevron-left"></span> '+ui.value+' <span class="glyphicon glyphicon-chevron-right"></span></label>');
	}
	});
	$('#slider span').html('<label><span class="glyphicon glyphicon-chevron-left"></span> ' + $('#slider').data('value') + ' <span class="glyphicon glyphicon-chevron-right"></span></label>');
})
</script>
@endpush

@push('styles')
{{ Html::style('adminlte/plugins/jquery-ui/themes/smoothness/jquery-ui.min.css') }}
<style media="screen">
.input-checkbox {
display: none;
}

.label-checkbox {
display: inline-block;
color: #333;
border: 1px solid #ccc;
transition: 0.2s all ease;
font-size: 0.7em;
border-radius: 5px;
padding: 5px 5px 3px 5px;
cursor: pointer;
}

.input-checkbox:checked + .label-checkbox {
background: #60bfb3;
border: 1px solid #60bfb3;
color: #fff;
}
.ui-state-default, .ui-widget-content .ui-state-default {
    background: #60bfb3  !important;
}
.qq-upload-button {
width: 300px;
border-radius: 5px;
background-color: #3498db;
padding: 7px 15px;
text-align: center;
border: 0;
color: #fff;
}
.ui-widget-content {
border: 1px solid #bdc3c7;
background: #e1e1e1;
color: #222222;
margin-top: 15px;
}

.ui-slider .ui-slider-handle {
position: absolute;
z-index: 2;
width: 5.2em;
height: 2.2em;
cursor: default;
text-align: center;
line-height: 30px;
color: #FFFFFF;
font-size: 15px;
}

.ui-slider .ui-slider-handle .glyphicon {
color: #FFFFFF;
margin: 0 3px;
font-size: 11px;
opacity: 0.5;
}

.ui-corner-all {
border-radius: 20px;
}

.ui-slider-horizontal {
height: auto;
}

.ui-slider-horizontal .ui-slider-handle {
top: -1.2em;
}

.ui-state-default,
.ui-widget-content .ui-state-default {
border: 1px solid #f9f9f9;
background: #05287b;
}

.ui-slider-horizontal .ui-slider-handle {
margin-left: -0.5em;
}

.ui-slider .ui-slider-handle {
cursor: pointer;
}

.ui-slider a,
.ui-slider a:focus {
cursor: pointer;
outline: none;
}

#progress_screen {
background-color: rgba(0, 0, 0, 0.5);
position: fixed;
top: 0; right: 0; bottom: 0; left: 0;
z-index: 100;
}

.white-boxs {
width: 90%;
margin-left: 50%;
margin-top: 200px;
transform: translateX(-50%);
background-color: #fff;
padding: 15px;
}

@media(min-width: 992px) {
.white-boxs {
	width: 700px;
}
}

.qq-drop-processing, .qq-upload-list,
.qq-prompt-dialog-selector, .qq-upload-button-selector {
display: none;
}

.parsley-error .label-checkbox {
border-color: #f00;
color: #f00;
}
.alert-success{
	background: #229393 !important;
	border-color: #229393  !important;
}
</style>
@endpush
