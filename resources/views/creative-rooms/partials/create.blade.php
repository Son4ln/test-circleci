@can ('create', \App\CreativeRoom::class)
{{ Form::open([
	'url' => route('creative-rooms.store'),
	'class' => 'form-horizontal',
	'method' => 'POST',
	'files' => true
])
}}
<div class="form-group">
	<label class="col-md-3 control-label font-bold">@lang('creative_rooms.show.pj_name')<span class="label label-danger">@lang('ui.required')</span></label>
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
	
<div class="form-group">
	<label class="col-md-3 control-label font-bold">@lang('creative_rooms.show.pj_thumbnail')</label>
	<div class="col-md-8">
	<label for="image" class="btn background-027e7f color-white">@lang('creative_rooms.show.select_thumbnail')</label>
	<span id="file_name"></span>
	<input type="file" name="thumbnail" id="image" accept="image/*" class="hidden">
	</div>
</div>

<div class="form-group text-center">
	<button type="submit" class="btn color-white background-027e7f">@lang('creative_rooms.show.pj_submit')</button>
	<button data-dismiss="modal" class="btn color-white background-027e7f" type="button">@lang('creative_rooms.show.pj_cancel')</button>
</div>
{{ Form::close() }}
@else
<div class="alert alert-danger">
	@lang('flash_messages.rooms.room_limit')
</div>
@endcan

