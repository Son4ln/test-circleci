@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>エラー</strong>入力にいくつかの問題が有ります。<br><br>
        <ul>
            @foreach ($errors as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
{{-- <div class="alert alert-info alert-dismissable">
<i class="fa  fa-question"></i>
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<b>ポートフォリオがアップロード出来ない場合、下記をご確認ください 。</b> <br>
・容量は1GByte以下ですか？<br>
・ファイル形式は PNG / JPEG / MP3 / MP4(H.264) / WebM ですか？<br>
動画の推奨フォーマット　MP4 で H.264 および AAC<br>
・推奨ブラウザをご確認下さい。<br>
クルオでは Google Chrome / Safari / FireFox / Microsoft Edgeの最新版に対応しております。
</div> --}}

<form id='portfolioform' class='form-horizontal' method='post'  enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <div class="form-group">
        <label class="col-md-3 control-label">ビデオ</label>
        <div class="col-md-6">
            <input type="file" name="video" accept="video/*">
            <video src="{{ $portfolio->video }}" controls width="200">
            </video>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">サムネイル</label>
        <div class="col-md-6">
            <input type="file" name="image" accept="image/*">
            <img src="{{ $portfolio->thumb }}" alt="Video thumbnail" width="200">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">タイトル</label>
        <div class="col-md-6">
            <input type='text' name='title' class='form-control' value="{{ $portfolio->title }}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 control-label">スキル</label>
        <div class="col-md-6">
            @foreach (Config::get('const.skill') as $key => $value)
                <div class="checkbox-inline">
                    <label>
                        <input type='checkbox'
                        name='skill[]' {{in_array($key, $skills)?'checked':''}}
                        value="{{$key}}">{{$value}}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">コメント</label>
        <div class="col-md-6">
            <textarea name='comment'
            class='form-control'
            style='margin: 1rem 0;'>{{ $portfolio->comment }}</textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
            <button id='portfolio-edit-btn'
            class='btn btn-warning pull-left'
            data-loading-text="登録中">登録</button>
        </div>
    </div>
</form>

<script type="text/javascript">
$('#portfolioform').submit(function (e){
    e.preventDefault()
    var $btn = $(this).button('loading');
    var $div = $('#loading').fadeIn();
    //$.ajaxSetup({ async: false });
    var $data = new FormData($('#portfolioform').get(0));
    $.ajax({
        url: "/portfolios/" + {{ $portfolio->id }},
        data: $data,
        type: "POST",
        processData: false,
        contentType: false,
        dataType : "html",
        success: function( data ) {
            //$('div.modal-body').html(data);
            //$('#portfolio').parent().html(data);
            if (data != ''){
                $('div.modal-body').html(data);
            }else{
                $('#portfolios-list').html('');
                $('#portfolios-list').load('/portfolios/filter', {skill: []});
                $('#modalWindow').modal('hide')
            }
            $div.fadeOut();
        },
        error: function( xhr, status ) {
            console.log( xhr);
            $('#loading').html(xhr.responseText);
        },
        complete: function( xhr, status ) {
            $btn.button('reset');
        }
    });
    //$.ajaxSetup({ async: true });
});
</script>
