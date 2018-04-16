<div class="room-title has-cog">
<a href="{{ route('creative-rooms.index') }}">@lang('creative_rooms.show.project_list')</a> / <a href="javascript:void(0)" class="tab-toggle" data-target="#preview">@lang('creative_rooms.show.preview_title')</a> / @lang('creative_rooms.show.delivery_list') <br>
参加メンバー
@include('creative-rooms.partials.users_image', ['users' => $room->roomUsers])
<br>
<div class="big-cog">
	<div></div>
</div>

<button class="btn download-all-file background-05348b btn-list-koushin-border color-hover-white color-white {{ $deliverFiles->total() > 0 ? 'show' : 'hide' }}">ダウンロード</button>

</div>
<div class="ui-deliver-list">
@include('creative-rooms.partials.delivery_files', ['files' => $deliverFiles])
</div>
@if (!$room->isFinish() && $room->isManager())
{{ Form::open([
	'id' => 'finish',
	'url' => 'creative-rooms/update-label',
	'style' => 'padding: 15px'
]) }}
	{{ Form::hidden('label', 1) }}
	{{ Form::hidden('id', $room->id) }}
	<button class="btn background-027e7f" style="padding-left: 55px; padding-right: 55px; color: #fff;">
		@lang('creative_rooms.show.finish')
	</button>
{{ Form::close() }}
@endif

<script type="text/javascript">
$(document).ready(function() {
	$('#deliver_upload .ui-drag-text').text('納品ファイルをアップロード');
});
</script>
