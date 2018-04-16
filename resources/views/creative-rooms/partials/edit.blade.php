{{ Form::model($room, [
	'url' => route('creative-rooms.update', ['id' => $room->id]),
	'class' => 'form-horizontal',
	'method' => 'PUT',
	'files' => true
])
}}
<div class="form-group">
	<label class="col-md-3 control-label font-bold">@lang('creative_rooms.show.pj_name') <span class="label label-danger">@lang('ui.required')</span></label>
	<div class="col-md-8">
	{{ Form::text('title', null, ['class' => 'form-control background-515151']) }}
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label font-bold">@lang('creative_rooms.show.pj_desc') <span class="label label-danger">@lang('ui.required')</span></label>
	<div class="col-md-8">
	{{ Form::textarea('desc', null, ['class' => 'form-control background-515151', 'style' => 'padding: 6px 12px; overflow-x: hidden']) }}
	</div>
</div>

<div class="form-group popup-containt-img">
	<label class="col-md-3 control-label font-bold">@lang('creative_rooms.show.pj_thumbnail_edit')</label>
	<div class="col-md-8">
	<label for="image" class="btn background-027e7f font-bold color-white">@lang('creative_rooms.show.pj_thumbnail_button')</label>
	</br>
	<span id="file_name"></span>
	<p style="width: 400px; height: 300px"><img src="{{ $room->display_thumbnail }}" class="img-rounded" style="max-width: 100%;margin-top: 10px;"></p>
	<input type="file" name="thumbnail" id="image" accept="image/*" class="hidden">
	</div>
</div>

<div class="form-group text-center">
	<button type="submit" class="btn background-027e7f font-bold btn-lg color-white">@lang('creative_rooms.show.pj_submit')</button>
</div>
{{ Form::close() }}