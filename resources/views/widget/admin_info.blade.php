{{--<div class='panel-heading'>お知らせ</div>--}}
<div class="white-box">
  <div class='col-sm-4'>
    <label>@lang('notifications.creator')</label>
    <div class="list-group">
      @foreach ($creatorNotifications as $notification)
        @include('notifications.partials.notification_list_item', compact('notification'))
      @endforeach
    </div>
  </div>
  <div class='col-sm-4'>
    <label>@lang('notifications.client')</label>

    <div class="list-group ">
      @foreach ($clientNotifications as $notification)
        @include('notifications.partials.notification_list_item', compact('notification'))
      @endforeach
    </div>
  </div>
  <div class="col-sm-4">
    <label>@lang('notifications.member')</label>

    <div class="list-group ">
      @foreach ($memberNotifications as $notification)
        @include('notifications.partials.notification_list_item', compact('notification'))
      @endforeach
    </div>
  </div>
  <div class="clearfix"></div>
</div>
<div class="white-box">
  <form class='form-virtical' method="POST" action="{{url('/notifications')}}">
    {!! csrf_field() !!}
    <div class="form-group">
      <label class="radio-inline">
        <input type='radio' name='kind' value='1' checked=true>
        @lang('notifications.creator')
      </label>
      <label class="radio-inline">
        <input type='radio' name='kind' value='2'>
        @lang('notifications.client')
      </label>
      <label class="radio-inline">
        <input type='radio' name='kind' value='3'>
        @lang('notifications.member')
      </label>
    </div>
    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
      {{ Form::text('title', null, ['class' => 'form-control']) }}
      @if ($errors->has('title'))
        <span class="text-danger">{{ $errors->first('title') }}</span>
      @endif
    </div>
    <div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}">
      {{ Form::textarea('message', null, ['class' => 'form-control', 'style' => 'margin: 1rem 0', 'rows' => 3]) }}
      @if ($errors->has('message'))
        <span class="text-danger">{{ $errors->first('message') }}</span>
      @endif
    </div>
    <div class="form-group">
      <button class='btn btn-warning ui-submit' data-loading-text="送信中">@lang('notifications.send')</button>
    </div>
  </form>
</div>
<script>
$(function () {
  $('span.ui-del-info').click(function () {
    var self = $(this);
    $.ajax({
      url: self.data('target'),
      type: 'DELETE',
      success: function (result) {
        self.parents('.list-group-item').remove();
      }
    });
  });
});
</script>
