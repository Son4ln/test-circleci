
  <div class="page-header">
      ユーザーにメールをおくれます
  </div>

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>エラー</strong>入力にいくつかの問題が有ります。<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form id='adminmailform' class='form-horizontal' method='post' action='/ajax/mail/send'>
{{ csrf_field() }}
<div class="form-group">
    <label class="col-md-3 control-label">メール送信</label>
    <div class="col-md-6">
      <div>
        <label class="radio-inline">
          <input type='radio' name='mail' class='ui-mail-target' value='2' >
          全員に送信
        </label>
        <label class="radio-inline">
          <input type='radio' name='mail' class='ui-mail-target' value='3' >
          選択スキルのみ
        </label>
        <script>
        (function($){
          if(!$('.ui-mail-target:checked').val()){
            $('.ui-mail-target-default').attr('checked', 'checked');
          }
          if( $('.ui-mail-target:checked').val() != 3 ) {
            $('.ui-mail-skill').attr('disabled', true);
          }
          $('.ui-mail-target').click(function(){
            if ($(this).val() == 3){
              $('.ui-mail-skill').attr('disabled', false);
              $('.ui-mail-skill').parent('label').removeClass('disabled');
            }else{
              $('.ui-mail-skill').attr('disabled', true);
              $('.ui-mail-skill').parent('label').addClass('disabled');
            }
          });
        })(jQuery);
        </script>
      </div>
      <div>
        <label class="control-label">スキル</label>
        <div class="">
          <span>&nbsp;&nbsp;</span>
        @foreach (Config::get('const.skill') as $key => $value)
          <label class="checkbox-inline">
          <input type='checkbox' name='skill[]' class='ui-mail-skill' value='{{$key}}' >
          {{ $value }}
          </label>
        @endforeach
        </div>
      </div>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">タイトル</label>
    <div class="col-md-6">
        <input type='text' class='form-control ui-mail-title' name='title' value='[crluo] クルオからのお知らせ'>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">送信メール内容</label>
    <div class="col-md-6">
      <textarea name='mailtext' class='form-control ui-mail-text'></textarea>
    </div>
</div>
<div class="form-group">
    <div class="col-md-6 col-md-offset-3">
      <button id='compe-edit-btn' class='btn btn-warning pull-left ui-submit' data-loading-text="送信中">送信</button>
    </div>
</div>
</form>


<script>
    (function($){
        /* update dialog*/
        $('#adminmailform').crluoModalFormSubmit({dest:'#admin_mail_send' , after: function(){
            console.log('length:', $('div.alert').length)
          if($('div.alert').length == 0){
            $('textarea[name=mailtext]', '#adminmailform').val("");            
          }
        }});
    })(jQuery);

</script>


