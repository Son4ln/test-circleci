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
  <div class="form-group">
    <label class="col-md-3 control-label">動画/画像</label>
    <div class="col-md-6">
      <input type="file" name="video" accept="video/*,image/*" id="video">
      <p class="help-block">PNG / JPG / MP4 / WebM</p>
      <video src="" id="preview" width="250" controls class="hidden" autoplay>
      </video>
      <div id="thumnail" style="margin-bottom: 10px;">
        <input type="file" name="thumb" class="hidden">
        <input type="hidden" name="image" value="">
        <img src="" id="thumbnail-preview" style="max-width: 250px">
      </div>
      <div class="control hidden">
        <button class="btn btn-success" type="button" onclick="capture()">Recreate thumbnail</button>
        <button class="btn btn-info" type="button" id="change-thumb">Upload another thumbnail</button>
      </div>
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-3 control-label">タイトル</label>
    <div class="col-md-6">
      <input type='text' name='title' class='form-control'>
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label">動画のスタイル</label>
    <div class="col-md-6">
      @foreach(config('const.project_movie_style', []) as $index => $type)
        <div class="checkbox-inline">
          <label>
            {!! Form::checkbox('styles[]', $index, null) !!} {{ $type }}
          </label>
        </div>
      @endforeach
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label">動画のタイプ</label>
    <div class="col-md-6">
      @foreach(config('const.project_movie_type', []) as $index => $type)
        <div class="checkbox-inline">
          <label>
            {!! Form::checkbox('types[]', $index, null) !!} {{ $type }}
          </label>
        </div>
      @endforeach
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label">概算金額</label>
    <div class="col-md-6">
      <div id="slider"></div>
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-3 control-label">公開範囲</label>
    <div class="col-md-6">
      <select name="scope" class="form-control">
        <option value="0">公開</option>
        <option value="1">会員限定</option>
      </select>
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label">コメント</label>
    <div class="col-md-6">
      <textarea name='comment'
      class='form-control'
      style='margin: 1rem 0;'></textarea>
    </div>
  </div>
  <div class="form-group">
    <div class="col-md-6 col-md-offset-3">
      <button id='portfolio-edit-btn'
      class='btn btn-warning pull-left'
      data-loading-text="登録中">登録</button>
    </div>
  </div>
  <input type="hidden" name="amount" value="0">
</form>

<script type="text/javascript">
$('#video').change(function(e) {
  var fileInput = document.getElementById('video')
  if (fileInput.files[0] && fileInput.files[0].type.match('video.*')) {
    $('#preview').removeClass('hidden')
    $('.control').removeClass('hidden')
    var fileUrl = window.URL.createObjectURL(fileInput.files[0])
    $("#preview").attr("src", fileUrl)

    $('#preview').on('timeupdate', function() {
      if (capture()) {
        $('#preview').off('timeupdate')
        $('#preview')[0].pause()
      }
    })
  } else {
    $('#preview').addClass('hidden')
    $('.control').addClass('hidden')
    var output = document.getElementById('thumbnail-preview');
    output.src = window.URL.createObjectURL(e.target.files[0])
  }
})

$('#change-thumb').click(function() {
  $('input[name="thumb"]').click()
})

$('input[name="thumb"]').change(function(e) {
  if (!e.target.files[0])
  return;
  var reader = new FileReader();
  reader.onload = function(){
    var output = document.getElementById('thumbnail-preview');
    output.src = reader.result;
  };
  reader.readAsDataURL(e.target.files[0])
  $('input[name="image"]').val('')
})

$("#slider").slider({
  animate: true,
  value: 0,
  min: 0,
  max: 200,
  step: 1,
  slide: function(event, ui) {
    $('input[name="amount"]').val(ui.value)
    $('#slider span').html('<label><span class="glyphicon glyphicon-chevron-left"></span> '+ui.value+' <span class="glyphicon glyphicon-chevron-right"></span></label>');
  }
});
$('#slider span').html('<label><span class="glyphicon glyphicon-chevron-left"></span> 0 <span class="glyphicon glyphicon-chevron-right"></span></label>');

$('#portfolioform').submit(function (e){
  e.preventDefault()
  var $btn = $(this).button('loading');
  var $div = $('#loading').fadeIn();
  //$.ajaxSetup({ async: false });
  var $data = new FormData($('#portfolioform').get(0));
  console.log($data)
  $.ajax({
    url: "/portfolios",
    data: $data,
    type: "post",
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

function capture() {
  var ratio = 2;
  var video = document.getElementById('preview')
  var canvas = document.createElement('canvas');
  canvas.width = $('#preview').width() * ratio;
  canvas.height = $('#preview').height() * ratio;
  var context = canvas.getContext('2d');

  context.drawImage(video, 0, 0, canvas.width, canvas.height);
  var dataURI = canvas.toDataURL('image/png')
  $('#thumbnail-preview').attr('src', dataURI)
  $('input[name="image"]').val($('#thumbnail-preview').prop('src'))
  $('input[name="thumb"]').val('')
  return dataURI.length > 10000
}
</script>
