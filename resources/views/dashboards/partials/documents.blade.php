@php
$label = [0=>'', 1=>'社外営業参考資料','弊社資料','実写','実写＆アニメ','アニメーション'];
@endphp

<style>

.form-horizontal .control-label {
text-align: right;
}

.bcolor {
background-color: rgb(37,167,173);
}

.error {
color: #f00;
}

.jumbotron-extend {
position: relative;
height: 2vh;
min-height: 20px;
}

.testimo-kt {
background:url(../images/bbb.jpg)no-repeat 0px -185px;
background-size: cover;
min-height: 20px;
padding: 3em 0em;
text-align: center;
}

.card {
width: 250px;
background: #fff;
border-radius: 5px;
box-shadow: 0 2px 5px #ccc;
}
.card-img {
border-radius: 5px 5px 0 0;
max-width: 100%;
height: auto;
}
.card-content {
padding: 20px;
}
.card-title {
font-size: 20px;
margin-bottom: 20px;
text-align: center;
color: #333;
}
.card-text {
color: #777;
font-size: 14px;
line-height: .7;
}
.card-link {
text-align: center;
border-top: 1px solid #eee;
padding: 0px;
}

.card-link button{
text-decoration: none;
margin: 10px ;
}

.card-link a {
text-decoration: none;
color: #0bd;
margin: 0 5px;
}
.card-link a:hover {
color: #0090aa;
}

</style>

<section>
<div class="container">
	<div class="row">
	<div><br /><br />
		<a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample" style="font-size:1.1em;">
		&nbsp;&nbsp;&nbsp;新規登録&nbsp;&nbsp;&nbsp;
		</a>
		<div class="collapse {{count($errors->all())?'in':''}}" id="collapseExample">
		<div class="beauty-grid">
			<div class="text-center page-header"><br>
			<h1 style="font-size:2em; line-height:1em;" class="mor-h1-color">『&nbsp;データ登録フォーム&nbsp;』</h1>
			<p style="font-size:1.2em; line-height:1em;">使い方わからない場合は辻まで</p>
			</div>
			<form class="form-horizontal" method="post" action="/documents" enctype="multipart/form-data">
			{{ csrf_field() }}
			<div class="form-group"><br>
				<label class="col-sm-5 control-label"><p>ジャンル <span class="label label-warning">必須</span></p></label>
				<div class="btn-group col-sm-4" data-toggle="buttons">
				<p class="help-block"><small>↓ドキュメントファイルの場合↓</small></p>
				@foreach ($label as $key => $val)
					@if($key==3)
					<br><br><p class="help-block"><small>↓動画ファイルの場合↓</small></p>
					@endif
					<label class="btn btn-default {{ old('genre') == $key ? 'active': '' }}">
					<input type="radio" name='genre' value="{{$key}}"><small>{{$val}}</small>
					</label>
				@endforeach
				@if($errors->has('genre'))
					<div class="clearfix"></div>
					<p class="error">{{$errors->first('genre')}}</p>
				@endif
				</div>
				<div class="col-sm-3"></div>
			</div>

			<div class="form-group">
				<label class="col-sm-5 control-label">分かりやすい（日本語可能）でタイトル入力 <span class="label label-warning">必須</span></label>
				<div class="col-sm-4">
				<input class="form-control" type="text" name="title"
				value="{{ old('title') }}"/>
				@if($errors->has('title'))
					<p class="error">{{$errors->first('title')}}</p>
				@endif
				</div>
				<div class="col-sm-3"></div>
			</div>

			<div class="form-group">
				<label class="col-sm-5 control-label">動画の場合はコチラも記入「制作金額」 <span class="label label-warning">必須</span></label>
				<div class="col-sm-4">
				<p class="help-block"><small>↓絶対半角で入れて。一万円単位でいれて。<br />（例、850000）↓</small></p>
				<input class="form-control" type="text" name="price"
				value="{{ old('price') }}"/>
				@if($errors->has('price'))
					<p class="error">{{$errors->first('price')}}</p>
				@endif
				</div>
				<div class="col-sm-3"></div>
			</div>

			<div class="form-group">
				<label class="col-sm-5 control-label">動画の場合はコチラも記入「納期・制作日数」 <span class="label label-warning">必須</span></label>
				<div class="col-sm-4">
				<p class="help-block"><small>↓絶対半角で入れて。日単位でいれて。<br />（例、25）↓</small></p>
				<input class="form-control"type="text" name="days"
				value="{{ old('days') }}"/>
				@if($errors->has('days'))
					<p class="error">{{$errors->first('days')}}</p>
				@endif
				</div>
				<div class="col-sm-3"></div>
			</div>


			<br /><br />
			<input id="lefile" type="file" name='uploadfile' style="display:none">
			<div class="input-group col-sm-offset-4 col-sm-4">
				<input type="text" id="photoCover" class="form-control" placeholder="select file...">
				<span class="input-group-btn"><button type="button" class="btn btn-info" onclick="$('input&#91;id=lefile&#93;').click();">ファイルの選択</button></span>
			</div>
			@if($errors->has('uploadfile'))
				<p class="error text-center">{{$errors->first('uploadfile')}}</p>
			@endif
			<p class="help-block col-sm-offset-5 col-sm-4">〇〇MBまでのファイルをアップロードできるよ！</p>

			<script>
			$('input[id=lefile]').change(function() {
				$('#photoCover').val($(this).val());
			});
			</script>
			<br /><br /><br />
			<div class="form-group">
				<div class="col-sm-2"></div>
				<div class="col-sm-8">
				<div class="text-center" style="color:#e68523; font-size:.9em;">↑該当ファイルをUPしてください↑<p>確認が済んだら登録ボタンを押してください</p>
					<button class="btn btn-warning" type="submit" style="margin-top:1.5em;margin-right:1.5em;padding-right:2em;padding-left:2em;">登録</button><hr>
				</div>
				</div>
				<div class="col-sm-2"></div>
			</div>
			</form>
		</div>
		</div>
	</div>
	</div>
</div>
</section>

<!-- サンプル -->
<form id='formSearchDoc' method='post' action='/documents/filter'>
{{ csrf_field() }}
@foreach($label as $key => $val)
	<label class="checkbox">
	@if (old('genre') && is_array(old('genre')))
		<input type="checkbox" name="genre[]" value="{{$key}}" {{ in_array($key, old('genre')) ? 'checked=true' : '' }}>
	@else
		<input type="checkbox" name="genre[]" value="{{$key}}">
	@endif
	{{ $val }}
	</input>
</label>
@endforeach
<select name="order">
<option value="updated_at" {{ old('order') == 'updated_at' ? 'selected':'' }}>更新日</option>
<option value="price" {{ old('order') == 'price' ? 'selected':'' }}>価格</option>
<option value="days" {{ old('order') == 'days' ? 'selected':'' }}>制作日数</option>
<option value="genre" {{ old('order') == 'genre' ? 'selected':'' }}>ジャンル</option>
<option value="filesize" {{ old('order') == 'filesize' ? 'selected':'' }}>ファイルサイズ</option>
</select>
</form>

<!-- TODO: ここに登録済み一覧を表示しちゃいまう
もちろんループして処理しますよ
そしてファイルのリンク用URLはよく考えてね
-->
<div class="container">
<div style="width: 100%">
	{{ $documents->render() }}
</div>
<div class="row isopanel" id="document-list">
	@include('dashboards.partials.documents_list')
</div>
</div>
<div class="modal fade" id="modalPreviewWindow" tabindex="-1" role="dialog" aria-labelledby="modalPreviewLabel" aria-hidden="true" h=0 w=0>
<div class="modal-dialog "  style="width:90%">
	<div class="modal-content" style="color:#f0f0f0; background-color:#000;">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff;"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title"></h4>
	</div>
	<div class="modal-body text-center">
		<iframe width="560" height="315" src="" frameborder="0" allowfullscreen></iframe>
	</div>
	<div class="modal-footer">
		<div class="portfolio-detail "> </div>
	</div>
	</div>
</div>
</div>
<style>
video.preview {
width:90%;
max-width:90%;
height:auto;
}
img.preview {
max-width:90%;
height:auto;
}
.ui-portfolio-detail {
color:#bbbbbb;
text-align:left;
padding: 5px;
padding-left:20px;padding-right:20px;display:none;
}
</style>
<script src="/js/jquery.isotope.js" type="text/javascript"></script>
<script>
var container = $('.isopanel');
container.isotope({
filter: '*',
animationOptions: {
	duration: 250,
	easing: 'linear',
	queue: false
}
});
/* modal dialog */
$('img[data-toggle="modal"]').click(function (){
if ($(this).attr('data-mime').match(/video/)) {
	var video = document.createElement("video");
	video.src = $(this).attr('data-procname');
	video.poster = $(this).attr('src');
	video.controls = true;
	video.autoplay = true;
	video.loop = true;
	$(video).addClass("preview");
	$('div.modal-body', '#modalPreviewWindow').html(video);
} else {
	var img = document.createElement("img");
	img.src = $(this).attr('data-procname');
	$(img).addClass("preview");
	$('div.modal-body', '#modalPreviewWindow').html(img);
}
$('.modal-title', '#modalPreviewWindow').html($(this).siblings('.ui-portfolio-detail').children('.media-heading').html());
$('.portfolio-detail', '#modalPreviewWindow').html($(this).siblings('.ui-portfolio-detail').children('.portfolio-detail').html());
});

$('#modalPreviewWindow').on('shown.bs.modal', function (e) {
$('.modal-backdrop').css("opacity",1);
})
$('#modalPreviewWindow').on('hidden.bs.modal', function (e) {
$('div.modal-body', '#modalPreviewWindow').html('');
$('div.portfolio-detail', '#modalPreviewWindow').html('');
})
</script>
