<div class="panel  panel-default">
  <div class="panel-body">
    @for ($i = count($messages)-1; $i >= 0; $i--)
    <?php
      $message = $messages[$i];
      
      //pr( $message );
    ?>
    <div class="media">
      <div class="media-left text-center">
        @if($message->send_user_id != Auth::id())
          <a href="/creators/{{$message->send_user_id}}">
            <img class='img-circle user-icon' src="{{ @@createUrlAvatar($message->photo) }}" onerror="this.src='/images/user.png'">
          </a>
          <small>{{$message->name}}</small>
        @else
        <div style='width:100px'></div>
        @endif
      </div>
      <div class="media-body">
        <div class='{{$message->send_user_id == Auth::id() ? 'alert alert-info text-right' : 'well text-left'}}'
              style='margin-bottom:0px;'>
          {!!nl2br($message->message)!!}
        </div>
        <small class='text-info text-right'><p>{{$message->created_at->format('n/j G:i ')}}</p></small>
      </div>
      <div class="media-right text-center">
        @if($message->send_user_id == Auth::id())
          <a href="/creators/{{$message->send_user_id}}">
            <img class='img-circle user-icon' src="{{@@auth()->user()->photoThumbnailUrl}}" onerror="this.src='/images/user.png'">
          </a>
          <small>{{$message->name}}</small>
        @else
         <div style='width:100px'></div>
        @endif

      </div>
    </div>
    @endfor
    {!! $messages->render() !!}
  </div>
  <div class='panel-footer'>
        <form id='sendchatform' class='form-virtical'>
        {{ csrf_field() }}
        <input type='hidden' name='send_user_id' value='{{Auth::id()}}'>
        <input type='hidden' name='kind' value='1'>
        <input type='hidden' name='user_id' value='{{$id}}'>
        <div class="form-group">
          <textarea name='message' class='form-control' style='margin: 1rem 0;' rows='2'></textarea>
        </div>
        <div class="form-group">
          <button id='sendchatformsubmit' class='btn btn-warning' data-loading-text="送信中">@lang('chat.send')</button>
        </div>
      </form>
  </div>
</div>

<script>
$(document).ready(function() {
  $('#user-chat-list').crluoPagenationNonForm({dest: '#user-chat-list', user_id:"{{$id}}"});
});
$(function() {
  var flag = 0;
  $(window).scroll(function(ev) {
    var $window = $(ev.currentTarget),
    height = $window.height(),
    scrollTop = $window.scrollTop(),
    documentHeight = $(document).height();
    if (documentHeight === height + scrollTop) {
      // 一番下だよ
      //alert('一番下だよ');
      //$('a[rel="next"]').val();
    }
    if (0 === scrollTop) {
      //$('a[rel="prev"]').click();
    }
  });
});

/* update dialog */
$('#sendchatformsubmit').click(function (e){
  e.preventDefault();
  var $btn = $(this).button('loading');
  var $div = $('#loading').fadeIn();
  var $data = new FormData($('#sendchatform').get()[0]);
  $.ajax({
    url: "/ajax/message/sendchat",
    data: $data,
    type: "post",
    processData: false,
    contentType: false,
    dataType : "html",
    success: function( data ) {
      //$('input[name=title]', '#sendchatform').val("");
      $('textarea[name=message]', '#sendchatform').val("");
      $('#user-chat-list').html(data);
    },
    error: function( xhr, status ) {
      console.log( xhr.responseText);
      $('div#error').html(xhr.responseText);
    },
    complete: function( xhr, status ) {
      $btn.button('reset');
      $div.fadeOut();
    }
  });
});
</script>
