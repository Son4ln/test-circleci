@extends('layouts.ample')

@section('content')
<div class="room-left hidden-sp">
	@php
	$project = $room->project;
	@endphp
	@if ($project)
	<h4><a href="{{ route('projects.show', ['id' => $project->id]) }}">@lang('creative_rooms.show.project_detail')</a></h4>
	@endif
	<div class="main_room_left">
	<label>@lang('creative_rooms.show.members_list')</label>
	<span class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">&nbsp;<i class="fa fa-cog text-muted"></i></a>
		@can ('update', $room)
		<ul class="dropdown-menu">
			<li><a href="#" data-loadcog="{{ $room->id }}">@lang('creative_rooms.member_cog')</a></li>
			<li><a href="#" data-editroom="{{ $room->id }}">@lang('creative_rooms.edit_room')</a></li>
			<li><a href="#" data-deleteroom="{{ $room->id }}">@lang('creative_rooms.delete_room')</a></li>
		</ul>
		@else
		<ul class="dropdown-menu">
			<li><a href="#" data-loadcog="{{ $room->id }}">@lang('creative_rooms.invatation_link')</a></li>
		</ul>
		@endcan
	</span>
	</div>
	<ul>
	@foreach ($room->roomUsers as $user)
		<li>{{ $user->name }}</li>
	@endforeach
	</ul>
</div>
<div class="room-right">
	<div style="margin: 0 -25px 0 -25px;">
		<div class="room-tabs">
			<div class="tab-item active tab-toggle" data-target="#chat">
			@lang('creative_rooms.show.chat_title')
			</div>
			<div class="tab-item tab-toggle" data-target="#preview">
			@lang('creative_rooms.show.preview_title')
			</div>
			<div class="clearfix"></div>
		</div>
		<div id="chat" class="tab-pane fadeInLeft animated">
			@include('creative-rooms.partials.messages')
		</div> <!-- #chat -->

		<div id="preview" class="tab-pane fadeInRight animated" style="display: none">
			@include('creative-rooms.partials.preview')
		</div>

		<div class="tab-pane" id="delivery" style="display: none">
			@include('creative-rooms.partials.delivery')
		</div>
	</div>
</div> <!-- .room-right -->
<div class="room-left1 hidden-pc">
	@php
	$project = $room->project;
	@endphp
	@if ($project)
	<h4><a href="{{ route('projects.show', ['id' => $project->id]) }}">@lang('creative_rooms.show.project_detail')</a></h4>
	@endif
	<div class="main_room_left">
	<label>@lang('creative_rooms.show.members_list')</label>
	<span class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">&nbsp;<i class="fa fa-cog text-muted"></i></a>
		@can ('update', $room)
		<ul class="dropdown-menu">
			<li><a href="#" data-loadcog="{{ $room->id }}">@lang('creative_rooms.member_cog')</a></li>
			<li><a href="#" data-editroom="{{ $room->id }}">@lang('creative_rooms.edit_room')</a></li>
			<li><a href="#" data-deleteroom="{{ $room->id }}">@lang('creative_rooms.delete_room')</a></li>
		</ul>
		@else
		<ul class="dropdown-menu">
			<li><a href="#" data-loadcog="{{ $room->id }}">@lang('creative_rooms.invatation_link')</a></li>
		</ul>
		@endcan
	</span>
	</div>
	<ul>
	@foreach ($room->roomUsers as $user)
		<li>{{ $user->name }}</li>
	@endforeach
	</ul>
</div>
<input type="hidden" id="user_id" value="{{ Auth::user()->id }}">
<form class="hidden" method="post" id="file_upload">
	<input type="hidden" name="creativeroom_id" id="creativeroom_id" value="{{ $room->id }}">
	<input type="hidden" name="title">
	<input type="hidden" name="mime">
	<input type="hidden" name="path">
	<input type="hidden" name="thumb_path">
	<input type="hidden" name="kind">
</form>
<div id="fade-screen"></div>
<div id="progress_screen" style="display: none">
		<div class="white-boxs">
		<p id="progress_text">@lang('messages.validating')</p>
		<div class="progress">
			<div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar"
			aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
			</div>
		</div>
		</div>
	</div>
@include('creative-rooms.partials.compare')
@include('creative-rooms.partials.modal')
@include('creative-rooms.partials.modal_normal')
@include('creative-rooms.partials.error_report')
<video src="" id="video" autoplay height="200" width="300" style="display: none"></video>
<canvas id="canvas" class="hidden"></canvas>

{{ Form::open([
	'url' => '#',
	'method' => 'DELETE',
	'id' => 'delete_room'
]) }}
{{ Form::close() }}
@endsection

@push('styles')
{{ Html::style('css/c-base.css?v='.VERSION_CSS_JS) }}
<style media="screen">
.bg-title {
	padding: 0;
	margin: 0;
}
/* .container-fluid {
	padding-left: 0;
	padding-right: 0;
} */
.footer {
	display: none;
}
#page-wrapper {
	padding-left: 241px !important;
}

@php
	$userAgent = request()->header('User-Agent');
@endphp
@if (stripos($userAgent, 'Edge') || (!stripos($userAgent, 'Chrome') && stripos($userAgent, 'Safari')))
	dialog button {
	display: none;
	}
@endif
</style>
@endpush

@push('scripts')

@include('templates.fine_uploader')
<script type="text/javascript" src="{{ asset('js/s3.fine-uploader.min.js') }}"></script>
<script type="text/javascript">
	var bucketName = '{{ config('filesystems.disks.s3.bucket') }}';
	var region = '{{ config('filesystems.disks.s3.region') }}';
	var accessKey = '{{ config('filesystems.disks.s3.client_key') }}';
	var messages = {
	upload_limit: '@lang('flash_messages.rooms.file_limit')',
	member_limit: '@lang('flash_messages.rooms.member_limit')',
	size_limit: '@lang('flash_messages.rooms.size_limit')',
	not_enough: '@lang('flash_messages.rooms.not_enough')',
	confirm_delete: '@lang('flash_messages.rooms.confirm_delete')'
	}
</script>
<script type="text/javascript" src="{{ asset('js/s3.uploader.js?v='.VERSION_CSS_JS) }}"></script>
<script type="text/javascript" src="{{ asset('js/room.js?v='.VERSION_CSS_JS) }}"></script>
<script type="text/javascript" src="{{ asset('js/custom.js?v='.VERSION_CSS_JS) }}"></script>
<script type="text/javascript">
	$(document).ready(function () {
	$tab = '#work-message';
	$.listenMessages('room.{{ $room->id }}');
	$.listenCrluoMessages('room.{{ $room->id }}.{{ Auth::id() }}');
	});
</script>

@endpush
