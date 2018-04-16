@extends('layouts.ample')
@section('content-header')
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
	<h4 class="page-title">@lang('projects.edit.title')</h4>
</div>
@endsection
@section('content')
<style>
	#project-form ul > li > label { width: auto; }
	#request_form .selected_message { padding-left:30px; font-size:larger; color:red; visibility:hidden; }
	#request_form input[type=radio]:checked+.selected_message { visibility: visible; }
	#preview_table th { width: 20% }
	#request_form_table tr td:last-child{ cursor: default;}
	.port-box {width: 250px; height: 125px; background-size: cover; margin: 0 auto 15px auto; border-radius: 5px; display: block; position: relative;}
	.port-box div{padding: 10px; background-color: rgba(0, 0, 0, 0.5); color: #fff; text-decoration: none; position: absolute; bottom: 0; width: 100%; text-align: center;}
</style>
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
	{!! Form::model($project, [
	'method' => 'PUT',
	'url' => route('projects.update', ['id' => $project->id]),
	'id' => 'project-form',
	'files' => true
]) !!}
{!! Form::hidden('is_prime', 0); !!}

{{-- 仕事を依頼・3つの依頼形式が選べます。 --}}
@include('projects.partials.create_step_0')

{{-- 仕事を依頼・1. どんな動画を作りたいですか？ --}}
@include('projects.partials.create_step_1')

{{-- 仕事を依頼・2.ご予算はお決まりですか？ --}}
@include('projects.partials.create_step_2')

{{-- 仕事を依頼・3.何を依頼しますか？ --}}
@include('projects.partials.create_step_3')

{{-- 仕事を依頼・4.お客様にて手配できるものはありますか？ --}}
@include('projects.partials.create_step_4')

{{-- 仕事を依頼・5.撮影場所 --}}
@include('projects.partials.create_step_5')

{{-- 仕事を依頼・6.あなたの動画について教えてください --}}
@include('projects.partials.create_step_6')

{{-- 仕事を依頼・7.制作の参考になる画像や資料などを添付してください。 --}}
@include('projects.partials.create_step_7')

{{-- 仕事を依頼・8.このプロジェクトの名前は何ですか？ --}}
@include('projects.partials.create_step_8')

{{-- 仕事を依頼・9.納品日を教えてください。 --}}
@include('projects.partials.create_step_9')

{{-- 仕事を依頼・10.あなたの依頼をまとめました --}}
@include('projects.partials.create_step_10')

{{-- 仕事を依頼・11.あなたの依頼をまとめました --}}
@include('projects.partials.create_step_11')

@include('projects.partials.create_step_12')
{{ Form::close() }}
</div>
@endsection

@push('scripts')
{{ Html::script('adminlte/plugins/jquery-ui/jquery-ui.min.js') }}
<script src="{{ asset('js/project_create.js?v='.VERSION_CSS_JS) }}"></script>
@endpush

@push('styles')
{{ Html::style('adminlte/plugins/jquery-ui/themes/smoothness/jquery-ui.min.css') }}
{{ Html::style('css/project.css') }}
@endpush
