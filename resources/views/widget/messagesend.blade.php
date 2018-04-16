<style>
    fieldset > ul {
        list-style:none;
    }
    fieldset > ul > li > label{
        width: 10rem;
    }
</style>
<div class='container'>
    <div class="page-header">
        他のユーザーにメッセージをおくれます
    </div><!-- /.page-header -->
    <form class='form-horizontal' method='post'>
    <fieldset id='sendmesform'>
    <ul>
    <li><label>メッセージ種別</label>
        <select name='kind' class='form-control input-sm'>
        @foreach (['1' => 'メッセージ', '2' => 'お知らせ'] as $key => $val)
            <option value="{{$key}}" {{  Request::input('kind') == $key ? 'selected' : '' }}>{{$val}}</option>
        @endforeach
        </select>
    </li>
    <li><label>送信元</label>
        <select name='send_user_id' class='form-control input-sm'>
        @foreach ($userlist as $key => $val)
            <option value="{{$key}}" {{  Request::input('send_user_id') == $key ? 'selected' : '' }}>{{$val}}</option>
        @endforeach
        </select>
    <li><label>宛先</label>
        <select name='user_id' class='form-control input-sm'>
        @foreach ($userlist as $key => $val)
            <option value="{{$key}}" {{  Request::input('user_id') == $key ? 'selected' : '' }}>{{$val}}</option>
        @endforeach
        </select>
    <li><label>タイトル</label>
        <input type='text' name='title' class='form-control' value=''></input>
    <li>
        <textarea name='message' class='form-control' style='margin: 1rem 0;'></textarea>
    </li>
    <li>
        <button id='sendmesformsubmit' class='btn btn-warning pull-left' data-loading-text="送信中">送信</button>
    </li>
    </ul>
    </fieldset>
    </form>
    <div id='error'>
    </div>
</div>
<script>
    $.ajaxSetup(
    {
        headers:
        {
            'X-CSRF-Token': $('input[name="_token"]').val()
        }
    });
    /* update dialog */
    $('#sendmesformsubmit').click(function (){
        var $btn = $(this).button('loading');
        var $div = $('#loading').fadeIn();
        //$.ajaxSetup({ async: false });
        $.ajax({
        url: "/ajax/send",
        data: $('#sendmesform').serializeArray(),
        type: "post",
        dataType : "html",
        success: function( data ) {
            $('input[name=title]', '#sendmesform').val("");
            $('textarea[name=message]', '#sendmesform').val("");
        },
        error: function( xhr, status ) {
            console.log( xhr);
            $('div#error').html(xhr.responseText);
        },
        complete: function( xhr, status ) {
            $btn.button('reset');
            $div.fadeOut();
        }
        });
        //$.ajaxSetup({ async: true });
    });
</script>
