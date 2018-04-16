@extends('layouts.ample')

@section('content-header')
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
	<h4 class="page-title">@lang('creative_rooms.show.title'):</small> {{ mb_strimwidth($room->title, 0, 50, "...") }}</h4>
</div>
@endsection

@section('content')
<div class="white-box">
	<input type="hidden" id="user_id" value="{{ Auth::user()->id }}">
	<form class="hidden" method="post" id="file_upload">
	<input type="hidden" name="creativeroom_id" id="creativeroom_id" value="{{ $room->id }}">
	<input type="hidden" name="title">
	<input type="hidden" name="mime">
	<input type="hidden" name="path">
	<input type="hidden" name="thumb_path">
	<input type="hidden" name="kind">
	<div id="message_file_upload" class="hidden"></div>
	</form>
	<div class="nav-tabs-custom">
	<ul class="nav nav-tabs" role="tablist">
		<li class="active"><a data-toggle="tab" href="#work-message">@lang('admin.rooms.show.messages')</a></li>
		<li><a data-toggle="tab" href="#work-default">@lang('admin.rooms.show.crluo_messages')</a></li>
		<li><a data-toggle="tab" href="#work-preview">@lang('admin.rooms.show.preview')</a></li>
		<li><a data-toggle="tab" href="#work-deliver">@lang('admin.rooms.show.delivery')</a></li>
		@if ($room->isManager() || auth()->user()->isAdmin())
		<li><a data-toggle="tab" href="#member">@lang('admin.rooms.show.member')</a></li>
		<li><a data-toggle="tab" href="#config">@lang('admin.rooms.show.config')</a></li>
		@endif
	</ul>
	<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane clearfix active" id="work-message">
		<div class="col-md-9 col-sm-9 ui-project-message">
			@include('widget.work_message')
		</div>
		<div class="col-md-3 col-sm-3 ui-project-file">
			<div class="panel">
			<div class="panel-body">
				<small>{!! nl2br($room->desc) !!}</small>
			</div>
			</div>
			@include('widget.work_file')
		</div>
		</div>
		<div class="tab-pane clearfix" id="work-default">
		<div class="col-md-12 col-sm-12 ui-project-info">
			@include('admin.rooms.crluo_messages')
		</div>
		</div>
		<div class="tab-pane clearfix" id="work-preview">
		<div class="col-md-12 col-sm-12 ui-project-preview">
			@include('widget.work_preview')
		</div>
		</div>
		<div class="tab-pane clearfix" id="work-deliver">
		<div class="col-md-12 col-sm-12 ui-project-deliver">
			@include('widget.work_deliver')
		</div>
		</div>
		<div class="tab-pane clearfix" id="member">
		<div class="col-md-12 col-sm-12 ui-member">
			@include('widget.messages.member')
		</div>
		</div>
		<div class="tab-pane clearfix" id="config">
		<div class="col-md-12 col-sm-12 ui-config">
			@include('widget.messages.config')
		</div>
		<video src="" id="video" autoplay height="200" width="300" style="display: none"></video>
		</div>
	</div>
	</div>
</div>

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
@endsection

@push('scripts')
@include('templates.fine_uploader')
<script type="text/javascript" src="{{ asset('js/s3.fine-uploader.min.js') }}"></script>
<script type="text/javascript">
	var bucketName = '{{ config('filesystems.disks.s3.bucket') }}';
	var region = '{{ config('filesystems.disks.s3.region') }}'
	var accessKey = '{{ config('filesystems.disks.s3.client_key') }}'
	var messages = {
	upload_limit: '@lang('flash_messages.rooms.file_limit')',
	member_limit: '@lang('flash_messages.rooms.member_limit')',
	size_limit: '@lang('flash_messages.rooms.member_limit')',
	confirm_delete: '@lang('flash_messages.rooms.confirm_delete')'
	}
</script>
<script type="text/javascript" src="{{ asset('js/s3.uploader.js?v='.VERSION_CSS_JS) }}"></script>
<script type="text/javascript" src="{{ asset('js/room.js?v='.VERSION_CSS_JS) }}"></script>
<script type="text/javascript" src="{{ asset('js/custom.js?v='.VERSION_CSS_JS) }}"></script>
<script type="text/javascript">
	$(document).ready(function () {
	$.listenMessages('room.{{ $room->id }}');
	$.listenCrluoMessages('room.{{ $room->id }}.{{ Auth::id() }}');
	});
</script>
@endpush

@push('styles')
{{ Html::style('css/room.css') }}
@endpush
