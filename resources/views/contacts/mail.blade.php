@extends('layouts.ample')

@section('content')
<style>

.form-horizontal .control-label {
	text-align: right;
}

.bcolor {
	background-color: rgb(37,167,173);
}

.jumbotron-extend {
	position: relative;
	height: 2vh;
	min-height: 20px;
}

.testimo-kt {
	background-size: cover;
	min-height: 20px;
	padding: 3em 0em;
	text-align: center;
}

.testiom-main {
	text-align: center;
}

.page-header {
	text-align: center;
}

.help-block strong {
	color: #f00;
}
</style>

<div class="beauty-grid">


	<div class="testimo">
		<div class="container-flued">
			<div class="testiom-main wow" data-wow-delay="0.1s">
				<ul class="rslides" id="slider2">

					<div class="fitness-top wow" data-wow-delay="0.1s">
						<div class="text-center page-header"><br>
							<h1 style="font-size:2em; line-height:1em;" class="mor-h1-color">『&nbsp;Contact&nbsp;』</h1>
							<p style="font-size:1.2em; line-height:1em;">お気軽にお問合せください</p>
						</div>
						<br><br>
						<p style="font-size:1.8em; line-height:1.5em;">// &nbsp;&nbsp;<span class="glyphicon glyphicon-earphone"></span> 03-6383-4725 &nbsp;&nbsp;//</p>
						<p style="font-size:1em;">（ 営業受付時間　11:00 ~ 20:00 ）</p>
						<p style="font-size:1em; line-height:1.5em;">お電話でも、お気軽にご相談ください</p>
					</div>
				</ul>
			</div>
		</div>
	</div>

	<br>
	<br>
	<div class="container">
		<div class="row">
			<form class="form-horizontal" method="post" action="{{ url('contacts/preview') }}">
				{{ csrf_field() }}
				<div class="form-group"><br>
					<label class="col-sm-5 control-label"><p>お問合せ用件 <span class="label label-warning">必須</span></p></label>
					<div class="btn-group col-sm-4" data-toggle="buttons">
						<p class="help-block"><small>↓下記より選択してください↓</small></p>
						<label class="btn btn-default {{old('content')=='新規案件のご相談'?'active':''}}">
							<input type="radio" name="content" value="新規案件のご相談">
							<small>新規案件のご相談・お見積もり</small>
						</label>
						<label class="btn btn-default {{old('content')=='ご質問'?'active':''}}">
							<input type="radio" name="content" value="ご質問" {{old('content')=='ご質問'?'checked':''}}>
							<small>ご質問</small>
						</label>
						<label class="btn btn-default {{old('content')=='クリエイターについて'?'active':''}}">
							<input type="radio" name="content" value="クリエイターについて" {{old('content')=='クリエイターについて'?'checked':''}}>
							<small>クリエイターについて</small>
						</label>
						<label class="btn btn-default {{old('content')=='その他'?'active':''}}">
							<input type="radio" name="content" value="その他" {{old('content')=='その他'?'checked':''}}>
							<small>その他</small>
						</label>
						<div class="clearfix"></div>
						@if ($errors->has('content'))
							<div class="help-block">
								<strong>{{ $errors->first('content') }}</strong>
							</div>
						@endif
					</div>
					<div class="col-sm-3"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-5 control-label">企業名・団体名</label>
					<div class="col-sm-4">
						<input class="form-control" type="text"
							name="corporate_name"
							value="{{ old('corporate_name') }}"/>
						@if ($errors->has('corporate_name'))
							<span class="help-block">
								<strong>{{ $errors->first('corporate_name') }}</strong>
							</span>
						@endif
					</div>
					<div class="col-sm-3"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-5 control-label">ご担当者お名前 <span class="label label-warning">必須</span></label>
					<div class="col-sm-4">
						<input class="form-control"type="text" name="name" value="{{ old('name') }}"/>
						@if ($errors->has('name'))
							<span class="help-block">
								<strong>{{ $errors->first('name') }}</strong>
							</span>
						@endif
					</div>
					<div class="col-sm-3"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-5 control-label">Mail（半角）<span class="label label-warning">必須</span></label>
					<div class="col-sm-4">
						<input class="form-control"type="text" name="email" value="{{ old('email') }}"/>
						@if ($errors->has('email'))
							<span class="help-block">
								<strong>{{ $errors->first('email') }}</strong>
							</span>
						@endif
						<p class="help-block"><small>↓上記と同じアドレスをご記入ください↓</small></p>
						<input class="form-control"type="text" name="email_confirmation" value="{{ old('email_confirmation') }}"/>
					</div>
					<div class="col-sm-3"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-5 control-label">お電話番号</label>
					<div class="col-sm-4">
						<input class="form-control"type="text" name="tel" value="{{ old('tel') }}"/>
						@if ($errors->has('tel'))
							<span class="help-block">
								<strong>{{ $errors->first('tel') }}</strong>
							</span>
						@endif
					</div>
					<div class="col-sm-3"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-5 control-label">内容 <span class="label label-warning">必須</span></label>
					<div class="col-sm-4">
						<textarea class="form-control" rows="8" name="text" style="vertical-align:middle;">{{ old('text') }}</textarea>
						<br />
						@if ($errors->has('text'))
							<span class="help-block">
								<strong>{{ $errors->first('text') }}</strong>
							</span>
						@endif
					</div>
					<div class="col-sm-3"></div>
				</div>
				<div class="form-group">
					<div class="col-sm-2"></div>
					<div class="col-sm-8">
						<div class="text-center" style="color:#e68523; font-size:.9em;">入力内容に間違いはございませんか？<p>確認が済んだら送信ボタンを押してください</p>
							<button class="btn btn-warning" type="submit" style="margin-top:1.5em;margin-right:1.5em;padding-right:2em;padding-left:2em;">送信</button>
						</div>
					</div>
					<div class="col-sm-2"></div>
				</div>
				<div class="fitness-top wow slideInLeft" data-wow-delay="0.1s">
					<div class="page-header">
						<div style="color:#e68523; font-size:1em; line-height:1em;">↓　「お見積もり」をお急ぎの方は下記情報もお知らせください　↓</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">動画の内容</label>
					<div class="col-sm-5">
						<textarea  class="form-control" rows="8" name="video_content" style="vertical-align:middle;" placeholder="簡単に動画の内容をご記入ください" >
							{{ old('video_content') }}
						</textarea>
						@if ($errors->has('video_content'))
							<span class="help-block">
								<strong>{{ $errors->first('video_content') }}</strong>
							</span>
						@endif
					</div>
					<div class="col-sm-3"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">動画の制作本数</label>
					<div class="col-sm-5">
						<input class="form-control"type="text" name="video_number" value="{{ old('video_number') }}"/>
						@if ($errors->has('video_number'))
							<span class="help-block">
								<strong>{{ $errors->first('video_number') }}</strong>
							</span>
						@endif
					</div>
					<div class="col-sm-3"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">映像の尺</label>
					<div class="col-sm-5">
						<input class="form-control"type="text" name="video_length"
							placeholder="例）何分など"  value="{{ old('video_length') }}"/>
						@if ($errors->has('video_length'))
							<span class="help-block">
								<strong>{{ $errors->first('video_length') }}</strong>
							</span>
						@endif
					</div>
					<div class="col-sm-3"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">ご希望納期</label>
					<div class="col-sm-5">
						<input class="form-control" type="text" name="deliver_date"
							placeholder="例）○月中旬目処など"
							value="{{ old('deliver_date') }}"/>
						@if ($errors->has('deliver_date'))
							<span class="help-block">
								<strong>{{ $errors->first('deliver_date') }}</strong>
							</span>
						@endif
					</div>
					<div class="col-sm-3"></div>
				</div>

				<div class="form-group">
					<label class="col-sm-4 control-label">BGMの希望</label>
					<div class="btn-group col-sm-5" data-toggle="buttons">
						<label class="btn btn-default {{old('bgm')=='あり'?'active':''}}">
							<input type="radio" name="bgm" value="あり">あり
						</label>
						<label class="btn btn-default {{old('bgm')=='なし'?'active':''}}">
							<input type="radio" name="bgm" value="なし">なし
						</label>
					</div>
					<div class="col-sm-3"></div>
				</div>

				<div class="form-group">
					<label class="col-sm-4 control-label">ナレーションの希望</label>
					<div class="btn-group col-sm-5" data-toggle="buttons">
						<label class="btn btn-default {{old('sub')=='あり'?'active':''}}">
							<input type="radio" name="sub" value="あり">あり
						</label>
						<label class="btn btn-default {{old('sub')=='なし'?'active':''}}">
							<input type="radio" name="sub" value="なし">なし
						</label>
					</div>
					<div class="col-sm-3"></div>
				</div>

				<div class="form-group">
					<label class="col-sm-4 control-label">納品形式</label>
					<div class="col-sm-5">
						<input class="form-control" type="text" name="format"
							placeholder="例）動画データとDVDへプレス(3枚)"
							value="{{ old('format') }}"/>
					</div>
					<div class="col-sm-3"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">キャスト人数</label>
					<div class="col-sm-5">
						<input class="form-control" type="text" name="castor"
							placeholder="出演する場合何名位か、不要の場合は0"
							value="{{ old('castor') }}"/>
					</div>
					<div class="col-sm-3"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">ロケ地の想定</label>
					<div class="col-sm-5">
						<input class="form-control" type="text" name="location"
							placeholder="例）既存の店舗、US西海岸風のロケーションなど"
							value="{{ old('location') }}"/>
					</div>
					<div class="col-sm-3"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">提供いただける素材</label>
					<div class="col-sm-5">
						<input class="form-control" type="text" name="docs"
							placeholder="例）商品の画像・ロゴなど"
							value="{{ old('docs') }}"/>
					</div>
					<div class="col-sm-3"></div>
				</div>
				<hr>

				<div class="form-group">
					<div class="col-sm-2"></div>
					<div class="col-sm-8">
						<div class="text-center" style="color:#e68523; font-size:.9em;">入力内容に間違いはございませんか？<p>確認が済んだら送信ボタンを押してください</p>
							<button class="btn btn-warning" type="submit" style="margin-top:1.5em;margin-right:1.5em;padding-right:2em;padding-left:2em;">送信</button>
						</div>
					</div>

					<div class="col-sm-2"></div>
				</div>
			</form>
		</div>
	</div>
</div>
</div>
@endsection
