<div class="alert alert-info alert-dismissable">
  <i class="fa fa-info"></i>
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  @lang('messages.rooms.alert_1')<br>
  @lang('messages.rooms.alert_2')
</div>
<div class='panel panel-default' id="messages_box">
  <div id="custom_drop_zone" style="display: none">
  </div>
  <div class='panel-heading'>
    <h4>@lang('admin.rooms.show.messages_title')
      <span class="pull-right hidden loading-text">
        <i class="fa fa-refresh fa-spin fa-fw"></i><span class="sr-only">Loading...</span>
      </span>
    </h4>
    {{-- <span roll='button' class="glyphicon glyphicon-refresh pull-right ui-load-message" ></span> --}}
  </div>
  <div class="panel-body message-dialog" id="messages">
      @include('widget.messages.messages')
  </div>

  <div class="panel-heading">
    <form id='sendmesform' class='form-virtical' method='post' action='/messages/send'>
    {{ csrf_field() }}
    {{-- <input type='hidden' name='user_id' value='{{Auth::id()}}'>
    <input type='hidden' name='creativeroom_id' value='{{$room->id}}'>
    <input type='hidden' name='kind' value='1'> --}}
    <div class="form-group">
        <textarea id="input_message" class='form-control' style='margin: 1rem 0;' rows='3'></textarea>
        <div id="message_files"></div>
    </div>
    <div class="form-group">
        <button id='admin-user-search-btn' class='btn btn-warning ui-submit' data-loading-text="送信中">@lang('admin.rooms.show.message_submit')</button>
        <span class="sending hidden" style="font-size: 0.8em">@lang('admin.rooms.show.sending')</span>
    </div>
    </form>
  </div>
  <div id="chat_uploader" class="hidden"></div>
</div>
