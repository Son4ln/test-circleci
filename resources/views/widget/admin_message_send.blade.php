<style>
    fieldset > ul {
        list-style:none;
    }
    fieldset > ul > li > label{
        width: 10rem;
    }
</style>
    <div class="page-header">
        他のユーザーにメッセージをおくれます
    </div><!-- /.page-header -->
    <form class='form-horizontal'>

    <fieldset id='sendmesform'>
    <input type=hidden name='send_user_id' value='{{Auth::id()}}'>
    <ul>
    <li><label>メッセージ種別</lable>
        <select name='kind' class='form-control input-sm'>
        @foreach (['1' => 'メッセージ', '2' => 'お知らせ'] as $key => $val)
            <option value="{{$key}}" {{  Request::input('kind') == $key ? 'selected' : '' }}>{{$val}}</option>
        @endforeach
        </select>
    </li>
    <li><label>送信元</lable>
        <select name='send_user_id' class='form-control input-sm'>
        @foreach ($userlist as $key => $val)
            <option value="{{$key}}" {{  Request::input('send_user_id') == $key ? 'selected' : '' }}>{{$val}}</option>
        @endforeach
        </select>
    </li>
    <li><label>宛先</lable>
        <select name='user_id' class='form-control input-sm'>
        @foreach ($userlist as $key => $val)
            <option value="{{$key}}" {{  Request::input('user_id') == $key ? 'selected' : '' }}>{{$val}}</option>
        @endforeach
        </select>
    </li>
    <li><label>タイトル</lable>
    <input type='text' class='form-control' name='title' value='{{Request::input('title')}}'>
    </li>
    <li>
    <textarea class='form-control' name='message' style='margin: 1rem 0;'></textarea>
    <li>
        <button id='sendmesformsubmit' class='btn btn-warning  pull-right' data-loading-text="送信中">送信</button>
    </li>
    </ul>
    </fieldset>
    </form>
    <div id='error'>
    </div>
<script>
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
