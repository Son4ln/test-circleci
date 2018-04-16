@if (Request::ajax())
  @include('flash::message')
@endif
<div style="margin-top: 30px"></div>
<div class="row">
  <div class="col-md-8 col-md-offset-1">
    {{ Form::model($room, [
      'method' => 'PUT',
      'class' => 'form-horizontal',
      'url' => url('creative-rooms/'.$room->id),
      'id' => 'room-config']) }}
      <div class="form-group">
        <label class="control-label col-md-2">@lang('creative_rooms.create.name')</label>
        <div class="col-md-10">
          {{ Form::text('title', null, ['class' => 'form-control']) }}
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-md-2">@lang('creative_rooms.create.description')</label>
        <div class="col-md-10">
          {{ Form::textarea('desc', null, ['class' => 'form-control']) }}
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-2"></label>
        <div class="col-md-10">
          <button class="btn btn-info">@lang('creative_rooms.show.config_submit')</button>
        </div>
      </div>
    {{ Form::close() }}
  </div>
</div>
