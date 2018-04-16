@if ($room->isManager())
<div class="alert alert-danger" id="message_limit" style="display: none">
</div>
<div class="member-list">
	<table class="table">
	<tr>
		<th class="border-none text-white font-bold" align="center">@lang('creative_rooms.show.members_list')</th>
		<th class="border-none text-white font-bold" align="center" style="text-align: center;">@lang('creative_rooms.show.member_status')</th>
		<th class="border-none text-white font-bold" align="center" style="text-align: center;">@lang('creative_rooms.show.member_action')</th>
	</tr>
	@forelse ($room->creativeroomUsers as $creativeroomUser)
		<tr>
		<td>{{ $creativeroomUser->user->name }}さん</td>
		<td align="center">
			@if ($creativeroomUser->isActive())
			@lang('creative_rooms.show.is_member')
			@else
			<button type="button" class="btn btn-info accept_user"
			data-id="{{ $creativeroomUser->id }}">@lang('creative_rooms.show.accept')</button>
			@endif
		</td>
		<td align="center">
			@if ($creativeroomUser->isMaster())
			マスター
			@else
			@can('removeUser', $room)
				<a class="btn btn-danger" id="delete_user" href="{{ route('rooms.remove-user', ['id' => $creativeroomUser->id]) }}">@lang('creative_rooms.show.remove_member')</a>
			@endcan
			@endif
		</td>
		</tr>
	@empty
		<td>@lang('creative_rooms.show.empty_member')</td>
	@endforelse
	</table>
</div>
<div class="pull-right">
	<label class="label label-danger">
	残り招待可能人数：<span id="room_users_count">{{  config('const.c_base_user_limit') - $room->room_users_count }}</span>人
	</label>
</div>
<div class="clearfix"></div>
<p></p>

@endif
<div class="invitation_link">
<div class="input-group" style="margin-bottom: 15px">
	<span class="input-group-btn">
	<button type="button" id="refresh_link" data-id="{{ $room->id }}" class="btn background-027e7f color-white">@lang('creative_rooms.show.get_link')</button>
	</span>
	<input class="form-control" id="invitation_link" style="color: #333" readonly value="{{ route('rooms.accept', ['id' => $room->id, 'token' => $room->invitation_token]) }}">
</div>
</div>

<div class='panel background-515151'>
<div class='panel-heading'><strong>@lang('creative_rooms.show.invitation_header')</strong></div>
<div class="panel-body">
	@lang('creative_rooms.show.invitation_alert_1')<br>
	@lang('creative_rooms.show.invitation_alert_2')
</div>
</div>
