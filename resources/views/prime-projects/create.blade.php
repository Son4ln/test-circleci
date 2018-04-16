@extends('layouts.ample')

@section('content-header')
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
	<h4 class="page-title">@lang('prime_projects.create.title')</h4>
</div>
@endsection

@section('content')
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

<div class="white-box">
	<!-- この位置をご編集ください -->
	{!! Form::model($project, [
	'url' => route('prime-projects.store'),
	'method' => 'POST',
	'id' => 'project-form',
	]) !!}
	@include('prime-projects.partials.step_1')
	@include('prime-projects.partials.step_2')
	@include('prime-projects.partials.step_3')
	@include('prime-projects.partials.step_4')
	@include('prime-projects.partials.step_5')
	@include('prime-projects.partials.step_6')
	@include('prime-projects.partials.step_7')
	@include('prime-projects.partials.step_8')
	@include('prime-projects.partials.step_9')
	@include('prime-projects.partials.step_10')
	@include('prime-projects.partials.step_11')
	@include('prime-projects.partials.step_12')
	@include('prime-projects.partials.step_13')
	{!! Form::close() !!}
	<!-- 編集終わり -->
</div>
@endsection

@push('styles')
{{ Html::style('adminlte/plugins/jquery-ui/themes/smoothness/jquery-ui.min.css') }}
{{ Html::style('css/project.css?v=10') }}
<style>
	ul.flexbox > li > label {
	width: auto;
	}

	.label-back-on {
	background-color: #f93 !important;
	}
</style>
@endpush

@push('scripts')
@include('templates.prime_project_upload')
<script type="text/javascript" src="{{ asset('js/s3.fine-uploader.min.js') }}"></script>
<script type="text/javascript">
	var bucketName = '{{ config('filesystems.disks.s3.bucket') }}';
	var region = '{{ config('filesystems.disks.s3.region') }}';
	var accessKey = '{{ config('filesystems.disks.s3.client_key') }}';
</script>
{{ Html::script('adminlte/plugins/jquery-ui/jquery-ui.min.js') }}
{{ Html::script('adminlte/plugins/jquery-ui/ui/i18n/datepicker-ja.js') }}
{{-- <script src="{{ asset('js/project_create.js?v='VERSION_CSS_JS) }}"></script> --}}
{{ Html::script('js/prime_projects.js?v='.VERSION_CSS_JS) }}
<script type="text/javascript">
	@php
	$date = \Carbon\Carbon::now();
	$date = $date->addDays(3);
	@endphp
	$('#expiration_date').datepicker('setDate', '{{ $date->format('Y/m/d') }}');

	$('#guide').dropFile({input: '#info'});
	$('#standard').dropFile({input: '#standard_files'});
	$('#attachments').dropFile({input: '#attachment_files'});
</script>
@endpush
