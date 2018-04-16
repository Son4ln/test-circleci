<?php $prefix = Config::get('const.user_path') ?>
<div class=''>
<form id='sendmesform' class='form-virtical' method='post'>
    {{ csrf_field() }}
    <input type='hidden' name='send_user_id' value='{{Auth::id()}}'>
    <input type='hidden' name='kind' value='1'>
    <input type='hidden' name='user_id' value='{{$id}}'>

    <div class="form-group">
        <img class='img-circle user-icon-small' src={{"/$prefix/$id/photo.png"}} onerror="this.src='/images/user.png'">&nbsp;{{$username}}&nbsp;さんへ
    </div>
    <div class="form-group">
        {{--!! Form::label('タイトル') !!--}}
        {{--!! Form::text('title') !!--}}
    </div>
    <div class="form-group">
        <textarea name='message' class='form-control' style='margin: 1rem 0;'></textarea>
    </div>
    <div class="form-group">
        <button id='sendmesformsubmit' class='btn btn-warning' data-loading-text="送信中">送信</button>
    </div>
</form>
</div>
<script>
    $('#sendmesform').submit(function(e){
        e.preventDefault()
    })

    /* update dialog */
    $('#sendmesformsubmit').click(function (){
        var $btn = $(this).button('loading');
        var $div = $('#loading').fadeIn();
        var $data = new FormData($('#sendmesform').get()[0]);
        //$.ajaxSetup({ async: false });
        $.ajax({
        url: "/messages",
        data: $data,
        type: "post",
        processData: false,
        contentType: false,
        dataType : "html",
        success: function( data ) {
            $('input[name=title]', '#sendmesform').val("");
            $('textarea[name=message]', '#sendmesform').val("");
            $('#modalWindow').modal('hide')
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
