<?php $prefix = Config::get('const.user_path') ?>
@if (!Request::ajax())
    <br>
    <form id='adminmessageform' class='form-horizontal' method='post' action='/admin/message/list'>
    <div class="form-group">
        <label class="col-md-2 control-label">kind</label>
        <div class="col-md-4">
        
        <select name='kind' class='form-control input-sm'>
        @foreach (['1' => 'メッセージ', '2' => 'お知らせ'] as $key => $val)
            <option value="{{$key}}" {{  Request::input('kind') == $key ? 'selected' : '' }}>{{$val}}</option>
        @endforeach
        </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">既読</label>
        <div class="col-md-4">
        <select name='readed' class='form-control input-sm'>
        @foreach (['' => '-', '0' => '未読', '1' => '既読'] as $key => $val)
            <option value="{{$key}}" {{  Request::input('readed') == $key ? 'selected' : '' }}>{{$val}}</option>
        @endforeach
        </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">send_user_id</label>
        <div class="col-md-4">
        <select name='send_user_id' class='form-control input-sm'>
        @foreach ($userlist as $key => $val)
            <option value="{{$key}}" {{  Request::input('send_user_id') == $key ? 'selected' : '' }}>{{$val}}</option>
        @endforeach
        </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">宛先</label>
        <div class="col-md-4">
        <select name='user_id' class='form-control input-sm'>
        @foreach ($userlist as $key => $val)
            <option value="{{$key}}" {{  Request::input('user_id') == $key ? 'selected' : '' }}>{{$val}}</option>
        @endforeach
        </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">タイトル</label>
        <div class="col-md-4">
        <input type='text' name='title' value='{{Request::input('title')}}'>
        </div>
    </div>
    </form>
    <div id="admin-message-list">
@endif
@if (isset($messages))
    {!! $messages->render() !!}
    @foreach ($messages as $message)
        <div class="panel panel-default">
              <div class="panel-heading">
                <h5 class="panel-title">
                {{$message->created_at->format('n/j G:i ')}}{{$message->title}}
                @if ($message->readed)
                    <span type="button" class="btn btn-xs  btn-link  glyphicon glyphicon-ok pull-right" disabled="disabled"></span>
                @else
                    <span type="button" onclick="$.crluo.messageReaded($(this))"
                       class="btn btn-xs btn-link  glyphicon glyphicon glyphicon-eye-open pull-right" data-messageid="{{$message->user_id . ',' . $message->kind . ',' . $message->created_at}}"></span>
                @endif
                </h5>
              </div>
              <div class="panel-body">
                <div class="media">
                    <div class="media-left">
                        <a href="/profile/{{$message->send_user_id}}" target="_blank">
                            <img class='img-circle user-icon-small' src={{"/$prefix/{$message->send_user_id}/photo.png"}} onerror="this.src='/images/user.png'">
                        </a>
                        {!!$message->kind != 2 ? "<br><h6>$message->sendername</h6>" : ""!!}
                    </div>
                    <div class="media-body">
                            {!!nl2br($message->message)!!}
                    </div>
                  </div>
              </div>
        </div>
    @endforeach
    <script>
      $('#adminmessageform').crluoPagenation({dest: '#admin-message-list'});
    </script>
@endif
@if (!Request::ajax())
    </div>
<script>
(function($){
  $('#adminmessageform').crluoFormInputSearch({dest: '#admin-message-list'});
  // init
  //$('input[name="title"]','#adminmessageform').change();
})(jQuery);
</script>
@endif
