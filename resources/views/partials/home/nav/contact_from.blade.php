<button type="button" class="btn btn-primary btn-lg contactBtn" data-toggle="modal" data-target="#contactModal">
		お問い合わせはコチラ
	</button>

<!-- モーダル・ダイアログ -->
<div class="modal fade" id="contactModal" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span>×</span></button>
				<h4 class="modal-title">お問い合わせ</h4>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group js-checkHover">
						<label for="Requirements">ご用件</label><span class="required">必須</span>
						<p class="help-block"><small>↓下記より選択してください↓</small></p>
						<label class="btn btn-default"><input type="radio" name="新規案件のご相談・お見積もり" value="新規案件のご相談・お見積もり"><small>新規案件のご相談・お見積もり</small></label>
						<label class="btn btn-default"><input type="radio" name="ご質問" value="ご質問"><small>ご質問</small></label>
						<label class="btn btn-default"><input type="radio" name="クリエイターについて" value="クリエイターについて"><small>クリエイターについて</small></label>
						<label class="btn btn-default"><input type="radio" name="その他" value="その他"><small>その他</small></label>
					</div>
					<div class="form-group">
						<label for="Affiliation">企業名・団体名</label>
						<input type="text" class="form-control" id="Affiliation" placeholder="企業名・団体名いを入力して下さい。">
					</div>
					<div class="form-group">
						<label for="Affiliation">担当者お名前</label><span class="required">必須</span>
						<input type="text" class="form-control" id="Affiliation" placeholder="担当者のお名前を入力して下さい。">
					</div>
					<div class="form-group">
						<label for="InputEmail">メール・アドレス</label><span class="required">必須</span>
						<input type="email" class="form-control" id="InputEmail" placeholder="メール・アドレスを入力して下さい。">
					</div>
					<p class="help-block"><small>↓上記と同じアドレスをご記入ください↓</small></p>
					<div class="form-group">
						<label for="InputEmail">メール・アドレス</label>
						<input type="email" class="form-control" id="InputEmail" placeholder="メール・アドレスを入力して下さい。">
					</div>
					<div class="form-group">
						<label for="InputEmail">お電話番号</label>
						<input type="tel" class="form-control" id="InputEmail" placeholder="お電話番号を入力して下さい。">
					</div>

					<div class="form-group">
						<label for="InputTextarea">内容</label><span class="required">必須</span>
						<textarea class="form-control" id="InputTextarea" placeholder="内容を入力して下さい。"></textarea>
					</div>

					<button type="submit" class="btn btn-default">送信</button>
				</form>
			</div>

		</div>
	</div>
</div>
<!-- /END CONTACT BOX -->
