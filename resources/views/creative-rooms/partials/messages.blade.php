<div class="room-title">
<a href="{{ route('creative-rooms.index') }}">@lang('creative_rooms.show.project_list')</a> / @lang('creative_rooms.show.chat_title') <br>
参加メンバー
@include('creative-rooms.partials.users_image', ['users' => $room->roomUsers])
</div>
<div class="room-body" id="room-body">
<div class="chat-box">
	<div id="custom_drop_zone" style="display: none"></div>
	<div class="messages" id="messages">
	@include('creative-rooms.partials.message_list')
	</div>
	<form class="chat-composer" id="sendmesform" method="post" action="/messages/send">
	{{ csrf_field() }}
	<div class="composer">
		<button type="button" id="message_file_upload"><i class="fa fa-plus"></i></button>
		<textarea rows="1" placeholder="コメント入力" id="input_message"></textarea>
	</div>
	<div class="submit">
		<button id="admin-user-search-btn" name="button">@lang('creative_rooms.show.msg_submit')</button>
	</div>
	</form>
	<div id="chat_uploader"></div>
</div>
<div class="task" id="files_list">
	<div id="content-files_list">
		@include('creative-rooms.partials.message_files')
	</div>
	
</div>




</div> <!-- .room-body -->
