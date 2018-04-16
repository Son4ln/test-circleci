<?php
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
?>
@extends('layouts.ample')


@section('content-header')
<div class="col-lg-6 col-md-4 col-sm-4 col-xs-12 slider_cb">
	<h1 class="page-title key_title">@lang('creative_rooms.list.title')</h1>
</div>
@endsection

@php
function isSafari()
{
	$header = request()->header('User-Agent');

	if (stripos($header, 'safari')) {
	if (!stripos($header, 'chrome')) {
		return true;
	}
	}

	return false;
}
@endphp

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
<div class="white-box row content_cb">
	<div class="space l-c-base isopanel">
	@foreach ($rooms as $room)
		<!-- Three columns of text below the carousel -->
		<div class="c-base-panel">
		<a class="panel-heading user-thumb-project" href="{{ route('creative-rooms.show', ['id' => $room->id]) }}"
		data-procname="{{ $room->id }}" title="{{ $room->title }}" target="_blank">
			<img class='user-thumb-project' src='{{ $room->display_thumbnail }}' onerror="this.src='data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=='"><img>

		</a>
		<label class="text-bold date_cb">{{ $room->updated_at->format('Y/m/d') }}</label>
		<div class="c-content">
			@can ('update', $room)
			<div class="status-bar {{ @@$room->getLabel() }}" data-cbase="{{ $room->id }}"></div>
			
			@else
			<div class="status-bar {{ @@$room->getLabel() }}"></div>
			
			@endcan
			<div class="">
				<img class="avatar1-back border-all-fff pull-left project-avatar" src="{{ $room->owner->photoThumbnailUrl }}" onerror="this.src='/images/user.png'">
			</div>
			<div class="item">
				<p class="item_name"><a href="{{ route('creative-rooms.show', ['id' => $room->id]) }}" title="{{ $room->title }}" target="_blank">
				{{ str_limit($room->title, 15) }}
				</a></p>
				<p class="item_user"><i class="fa fa-users text-muted"></i> <span class="">{{ $room->creativeroom_users_count }}</span></p>
			</div>
		<!--
			<label class="text-bold">{{ $room->updated_at->format('Y/m/d') }}</label><br>
			<a href="{{ route('creative-rooms.show', ['id' => $room->id]) }}" title="{{ $room->title }}" target="_blank">
			{{ str_limit($room->title, 15) }}
			</a><br>
			<i class="fa fa-users text-muted"></i> 
			<span class="text-red">{{ $room->creativeroom_users_count }}</span>
		-->
			@can ('update', $room)
			<span class="project-menu-icon dropdown">
				<div class="click-zone dropdown-toggle" data-toggle="dropdown"></div>
				<i class="fa fa-ellipsis-v"></i>
				<ul class="dropdown-menu dropdown-menu-right">
				<li><a href="#" data-loadcog="{{ $room->id }}">@lang('creative_rooms.member_cog')</a></li>
				<li><a href="#" data-editroom="{{ $room->id }}">@lang('creative_rooms.edit_room')</a></li>
				<li><a href="#" data-deleteroom="{{ $room->id }}">@lang('creative_rooms.delete_room')</a></li>
				</ul>
			</span>
			@else
			<span class="project-menu-icon dropdown">
				<div class="click-zone dropdown-toggle" data-toggle="dropdown"></div>
				<i class="fa fa-ellipsis-v"></i>
				<ul class="dropdown-menu dropdown-menu-right">
				<li><a href="#" data-loadcog="{{ $room->id }}">@lang('creative_rooms.invatation_link')</a></li>
				</ul>
			</span>
			@endcan
			<div class="clearfix"></div>
		</div>
		</div>
	@endforeach
	</div>

	{{ Form::open([
	'url' => '#',
	'method' => 'DELETE',
	'id' => 'delete_room'
	]) }}
	{{ Form::close() }}
	<div class="clearfix"></div>
	<a href="#" class="full-screen-button" id="c_base_create" role="button" data-toggle="modal" data-target="#project">
	<img src="../images/c-base/btn_add_pr.png">
	</a>
</div>
<div class="loader">
	<svg class="circular" viewBox="25 25 50 50">
	<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
	</svg>
</div>
@include('creative-rooms.partials.modal')
@include('creative-rooms.partials.modal_normal')

@endsection

@push('styles')
{{ Html::style('css/style.css') }}
<style>
	footer{
	background: #2f2f2f !important;
	}
	#page-wrapper{
	background: #515151 !important;
	}
</style>
@endpush

@if (isSafari())
@push('scripts')
	<script src="/js/jquery.isotope.js" type="text/javascript"></script>
	<script>
	$(document).ready(function () {

		var $container = $('.isopanel');
		$container.isotope({
		filter: '*',
		animationOptions: {
			duration: 250,
			easing: 'linear',
			queue: false
		}
		});
	});
	</script>
@endpush

@push('styles')
	<style media="screen">
	.iospanel {
		margin-right: -25px;
	}

	.c-base-panel {
		margin-right: 25px;
	}
	</style>
@endpush
@endif
