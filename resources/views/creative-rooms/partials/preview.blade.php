<div class="room-title">
<a href="{{ route('creative-rooms.index') }}">@lang('creative_rooms.show.project_list')</a> / @lang('creative_rooms.show.preview_title') <br>
参加メンバー
@include('creative-rooms.partials.users_image', ['users' => $room->roomUsers])
</div>
<input type="hidden" id="captionType" value="rect">
<div class="panel-body ui-preview-list" data-remote="{{ url('/files/upload/preview') }}"
style='overflow-x:auto; overflow-y:hidden; width:100%; white-space:nowrap;'>
@include('widget.messages.preview_list', ['files' => $previewFiles])
</div>
<div class="compare col-md-12">
<button type="button" class="btn btn-default btn-lg storage" id="movie-1"><img src="../images/c-base/add_video.png" alt=""><br/>@lang('creative_rooms.show.video_1')</button>
{{-- <div id="preview_upload_1" class="block-inline  uploader-not-display"></div> --}}
<button type="button" class="btn btn-default btn-lg storage" id="movie-2"><img src="../images/c-base/add_video.png" alt=""><br/>@lang('creative_rooms.show.video_2')</button>
{{-- <div id="preview_upload_2" class="block-inline  uploader-not-display"></div> --}}
<button type="button" class="btn btn-primary btn-lg mege_btn" id="compare" data-toggle="modal"><img src="../images/c-base/mege_video.png" alt=""><br/>
	@lang('creative_rooms.show.compare')
</button>
</div>
<!-- <div class="col-md-4 p-update-bg"></div> -->
<div id="pv-container" class="col-md-8">
<video id='pv-video' width='100%' autobuffer autoplay></video>
<svg id='pv-caption' xmlns="http://www.w3.org/2000/svg"></svg>
<svg id='pv-draw' xmlns="http://www.w3.org/2000/svg"></svg>
<div style="position: relative; z-index: 2003">
	<div id="progress"
	class="progress ui-progress-time"
	role=button
	style="overflow: visible">
	<div id="pv-pgss" class="progress-bar progress-bar-info" style="height: 20px"></div>
</div>
<div id='pv-controller-controll'>
	<button class='btn ui-player-rect' data-toggle="tooltip" data-placement="top" title="線で囲みコメントを入力"><span class="glyphicon glyphicon-screenshot" aria-hidden="true"></span></button>
	<button class='btn ui-player-text' data-toggle="tooltip" data-placement="top" title="コメントを入力"><span class='' aria-hidden="true"><strong>T</strong></span></button>
	<div class='pull-right'>
	<span class='ui-prev-time'></span>
	<button class='btn' id="restart"><span class="glyphicon glyphicon-fast-backward" aria-hidden="true"></span></button>
	<button class='btn' id="prev"><span class="glyphicon glyphicon-step-backward" aria-hidden="true"></span></button>
	<button class='btn ui-player-play'><span class="glyphicon glyphicon-play" aria-hidden="true"></span></button>
	<button class='btn' id="next"><span class="glyphicon glyphicon-step-forward" aria-hidden="true"></span></button>
	<button class='btn ui-player-mute'><span class="glyphicon glyphicon-volume-off"></span></button>
	</div>
</div>
<div>
	<span class=''>　</span>
	<span class='ui-prev-title'></span>
	<br>
	<br>
</div>
<!--center>コメントリスト</center-->
</div>
<div id='pv-text'>
	<div class='ui-prev-input'>
	<div class='form-group' >
		<label>@lang('creative_rooms.show.time')</label>
		<select class=''>
		<option value=3>3</option>
		<option value=5 selected="true">5</option>
		<option value=10>10</option>
		</select>
	</div>
	<div class='form-group' >
		<label>@lang('creative_rooms.show.comment')</label>
		<input type='text' class='form-control'>
	</div>
	<div class='form-group'>
		<button class='btn btn-default' data-kind='cancel'>@lang('creative_rooms.show.cancel')</button>
		<button class='btn btn-success' data-kind='decide'>@lang('creative_rooms.show.ok')</button>
	</div>
	</div>
</div>
</div>

<div class="col-md-4">
<div class="row">
	<div class="task-title">
	<h4>@lang('creative_rooms.show.tasks')</h4>
	</div>
	<div class="tasks" id="pv-list">
	</div>
	<div class="text-center" style="margin-top: 15px">
	<button type="button" class="btn btn-primary btn-lg tab-toggle btn_pre" data-target="#delivery">
		@lang('creative_rooms.show.delivery_list')
	</button>
	</div>
</div>

</div>
{{-- <script type="text/javascript">
$(document).ready(function(){
	$('#preview_upload_2,#preview_upload_1').find('h3 span').attr('class','').addClass('fa fa-file-video-o');
});
</script> --}}
