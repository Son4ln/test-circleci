<?php

return [
	'creator_list' => [
		'title' => 'プロジェクト一覧',
		'recruiting' => '募集中',
		'ended' => '募集終了',
		'no_item' => '現在プロジェクトは登録されておりません',
		'edit' => 'プロジェクト編集'
	],

	'list' => [
		'create_project_link' => '仕事を依頼する',
		'budget'=>'予算',
		'delivered_at'=>'納品日',
		'duedate_at'=>'納品日',
		'expired_at'=>'募集期間',
		'delivered_at_null'  =>  '未定',
	],

	'client_list' => [
		'title' => 'プロジェクト'
	],

	'show' => [
		// Client panel
		'title' => '仕事',
		'client_info' => 'クライアントの情報',
		'company_name' => '会社名',
		'department' => '部署名',
		'client_name' => 'お名前',
		'home_page' => 'ホームページ',

		'self' => 'セルフコンペ',
		'prime' => 'C-Operation',
		'cert' => '認定クリエイター',

		// Prime
		'business' => '依頼者の情報',
		'prime_purpose' => '動画の目的',
		'target' => '動画の全体内容',
		'describe' => '視聴者に伝えたい事と、動画詳細',
		'keywords' => 'キーワード',
		'moviesec' => '動画の尺想定',
		'scale' => '動画のアスペクト比',
		'reference' => '参考用会社案内・商品資料',
		'standard' => 'クリエイティブの基準になる動画',
		'material' => '作業用素材',
		'similar_video' => '動画のイメージ',


		//Project panel
		'project_title' => '仕事詳細情報',
		'video_style' => '動画のスタイル',
		'video_type' => '動画のタイプ',
		'to_ask' => '依頼すること',
		'picture' => '撮影場所',
		'budget' => '予算',
		'delivered_at' => '納品日',
		'delivered_at_null'  =>  '未定',
		'expired_at' => '募集期限',
		'part_of_work' => '依頼すること',
		'arrange' => 'お客様が手配すること',
		'about' => '動画について',
		'attachments' => '参考ファイル',
		'project_cancel' => 'キャンセル',

		//Credit panel
		'credit_title' => 'プロジェクト登録のデポジットお支払 :budget 万円',
		'credit_number' => 'クレジットカード番号',
		'security_code' => 'セキュリティコード',
		'expiration_month' => '有効期限(月)',
		'expiration_year' => '有効期限(年)',
		'coupon_code' => 'Coupon Code',
		'change_status' => 'ステータス変更',
		'payment_submit' => '支払う',
		'errors' => [
			'incorrect_number' => "クレジットカード番号が違います。",
			'invalid_number' =>  "有効なクレジットカード番号ではありません。",
			'invalid_expiry_month' => "カードの有効期限が無効です。",
			'invalid_expiry_year' => "カードの有効期限が無効です。",
			'invalid_cvc' => "カードのセキュリティコードが無効です。",
			'expired_card' => "カードの有効期限が切れています。",
			'incorrect_cvc' => "カードのセキュリティコードが正しくありません。",
			'incorrect_zip' => "カードの郵便番号の検証に失敗しました。",
			'card_declined' => "カードが拒否されました。",
			'missing' => "請求されている顧客にはカードがありません。",
			'processing_error' => "カードの処理中にエラーが発生しました。",
			'rate_limit' =>  "APIへのヒット数が急激に増加したため、エラーが発生しました。 一貫してこのエラーが発生している場合はお知らせください。"
		],

		// Proposal panel
		'proposal_title' => '提案',
		//'proposal_budget' => '提案金額 (税抜き 円)',
		'proposal_budget' => '提案金額 (税抜き)',
		/* 'budget_description' => 'ご提案金額から,
下記のクルオ利用手数料がかかります。
セルフコンペの場合、10%
認定コンペの場合15%
PM制の場合35%
ご不明点がございましたら、
お問い合わせをください。', */
		// 'budget_description' => 'ご提案金額から、下記のクルオ利用手数料がかかります。</br>
		// ・セルフコンペの場合、<span class="color-60bfb3 l-bold">10%</span></br>
		// ・認定コンペの場合<span class="color-60bfb3 l-bold">15%</span></br>
		// ・PM制の場合<span class="color-60bfb3 l-bold">35%</span></br>
		// ご不明点がございましたら、お問い合わせをください。',
		'budget_description' => 'ご提案金額から、下記のクルオ利用手数料がかかります。<br/><p style="padding-top: 10px;">ご不明点がございましたら、お問い合わせをください。</p>',	
		'sumary' => '提案概要',
		'proposal_attachments' => '参考ファイル',
		'proposal_submit' => '提案する',

		// Creator info
		'creator_title' => '採択したクリエイター',
		'creator_name' => '名前',
		'proposal_amount' => '提案金額',
		'creator_message' => 'メッセージ履歴',
		'creator_room' => 'Project',
		'detail' => 'Detail',

		//Finish project panel
		'project_finish_title' => '仕事を検収',
		'project_budget' => 'クライアントから提示された最終総額',
		'invoice_to' => '請求書宛名',
		'project_finish_submit' => '検収完了',
		'c_operation_creator_acceptance' => '検収を依頼する',
		'checking_text' => '検収申請を受付ました。 <br> 事務局で確認し次第、請求書がダウンロード出来ます。',

		// Creator acceptance form
		'request_title' => '検収を依頼する',
		'creator_amount' => '検収依頼総額',
		'creator_amount_text' => '検収依頼済みの総額 :amount 円',
		'request_submit' => '検収を依頼する',
		'request_submit_2' => '検収依頼総額を変更',

		// Invoice download
		'invoice' => '請求書',
		'download' => 'ダウンロード',

		'status_update' => 'ステータス変更',

		'proposal_list' => '提案一覧',
		'estimate' => '最新見積もり総額:',
		'prime_proposals' => 'クルオアド方式動画の選択',
		'proposal_limit' => '今月選択可能な提案',
		'proposals_remain' => '残り :number 件',
		'choose_proposal' => 'この提案を選択',
		'select_proposal' => '決定する'
	],

	'create' => [
		'title' => '仕事を依頼',
		'alert_1' => '<strong style="font-size: 18px;">3</strong>つの依頼形式が選べます。',
		'alert_2' => '認定クリエイター',
		'alert_3' => 'とは：所定の研修プログラムを修了した上で、仕事の進め方、コミュニケーション能力、納品物の品質など、
				当社の基準をクリアし、かつ面接を通過した信頼のおける上位<strong class="color-60bfb3">20%</strong>のクリエイターのことです。',
		'name' => '名称',
		'self_compe' => 'セルフコンペ',
		'cert_creator' => '認定クリエイター※募集',
		'pm' => 'PM制',

		'characeristic' => '特徴',
		'characeristic_1' => '品質より量産重視の方',
		'characeristic_2' => 'リーズナブル',
		'characeristic_3' => '全面サポートで、手間なし',

		'deposit' => 'デポジット',
		'deposit_1' => '<strong>5<strong>万',
		'deposit_2' => '<strong>10</strong>万',
		'deposit_3' => '全て見積もり',

		'budget' => '予算幅',
		'budget_1' => '<strong>1〜500<strong>万円',
		'budget_2' => '<strong>10〜500</strong>万円',
		'budget_3' => '<strong>19</strong>万円以上',

		'overview' => '概要',
		'overview_1' => '当社規定のフォーマットにお客様が情報入力することでオリエンシートが生成されます。
						<br><strong>3000</strong>人以上のクリエイターに募集をかけることができます。',
		'overview_2' => '当社規定のフォーマットにお客様が情報入力することでオリエンシートが生成されます。
						<br><strong>100</strong>人以上の認定クリエイターに募集をかけることができます。',
		'overview_3' => '初回の相談は無料です。プロによる企画〜運用まで、お客様に寄り添ったサポートになります。
						どのような目的でどういった動画を制作するか、また製作リソースの調達までトータルの支援です。
						<br>複数パターンや、キャストの入れ違いパターン。キャンペーンの設計など',

		'case' => '案件例',
		'case_1' => 'コーポレートムービー',
		'case_2' => 'ブランディング',
		'case_3' => 'web CM',

		'person' => 'こんな方に',
		'person_1' => '・ある程度製作物のイメージをもっている方',
		'person_2' => '・ある程度製作物のイメージを持っている方
						<br>・予算に余裕のある方',
		'person_3' => '・初めてで何もわからない人
						<br>・手厚いサポートが受けたい人',

		'selected' => '選択',

		'style_title' => '1. どんな動画を作りたいですか？【<span class="mor-require-color">必須</span>】',
		'style_description' => '※検討中であれば複数選択してください。',
		'style' => '動画のスタイル',
		'type' => '動画のタイプ',
		'another_type' => 'その他',

		'budget_title' => '2. ご予算はお決まりですか？【<span class="mor-require-color">必須</span>】',
		'budget_alert' => 'ご予算を設定する前に、最上部にて「セルフコンペまたは認定クリエイター」を選択ください',
		'budget_determined' => '予算未定',
		'medium_scale' => '中規模プロジェクト',
		'small_project' => '小規模プロジェクト',
		'request_project' => '作業依頼',

		'ask' => [
			'title' => '3. 何を依頼しますか？【<span class="mor-require-color">必須</span>】',
			'all'   => '全て',
			'planing' => '企画<br>(ストーリーボード)',
			'shooting' => '撮影',
			'edit' => '編集',
			'animation' => 'アニメーション',
			'motion' => 'モーショングラフィック<br>(高度なアニメーション)',
		],

		'arrange' => [
			'title' => '4. お客様にて手配できるものはありますか？【<span class="mor-require-color">必須</span>】',
			'material' => '会社・商品素材(ロゴ、資料、写真など)',
			'produce' => 'ディレクション<br>プロデュース',
			'actor' => '演者・モデル',
			'location' => 'ロケーション(撮影場所)',
			'make_up' => 'ヘアメイク',
			'stylist' => 'スタイリスト'
		],

		'expiration_error' => '明日から30日後の間に値を入力してください！',

		'location_title' => '5. 撮影場所【<span class="mor-require-color">必須</span>】',
		'location_placeholder' => 'ex.) 東京、大阪、北海道...',

		'video' => [
			'title' => '6. あなたの動画について教えてください【<span class="mor-require-color">必須</span>】',
			'heading' => '目的、動画の狙い',
			'placeholder_1' => 'ex.) 企業の認知度up, 販促,エンゲージの獲得,KPIなどを記載',
			'placeholder_2' => '想定視聴者　ex.) F１・M１層に向けて。20~40代の女性。ペルソナ像など

動画の印象　ex.) 洗練された都会っぽい印象など

掲載先　ex.) SNSフィード。HP掲載。AD出稿。サイネージ。

イメージ近い動画のリンク　ex.) https://www.youtube.com/watch?v=...

詳細・その他　ex.) クリスマスといえばコカコーラのCM、みたいに季節とマッチさせたい',

		],

		'attachments' => '7. 制作の参考になる画像や資料などを添付してください。',

		'project_title' => '8. このプロジェクトの名前は何ですか？【<span class="mor-require-color">必須</span>】',

		'duedate' => '9. 納品日を教えてください。【<span class="mor-require-color">必須</span>】',
		'undecided' => '未定・相談したい',

		'project_image' => '10. プロジェクトのイメージ画像を登録してください【<span class="mor-require-color">必須</span>】',
		//'project_image_alert' => '設定をされない場合、アカウント設定の背景画像が表示されます',
		'project_image_alert' => '登録しない場合、アカウント設定の背景画像が表示されます',
		'project_expiration' => '11.募集期間 【<span class="mor-require-color">必須</span>】',
		'project_expiration_update_l' => '11. 募集期間 【<span class="mor-require-color">必須</span>】',
		'sumary' => [
			'title' => '12. あなたの依頼をまとめました',
			'project_name' => 'プロジェクト名',
			'duedate' => '納品日',
			'request' => '依頼形式',
			'video_purpose' => '目的、動画の狙い',
			'video_style' => '動画のスタイル',
			'video_type' => '動画のタイプ',
			'budget' => '予算',
			'ask' => '依頼すること',
			'arrange' => 'お客様が手配すること',
			'location' => '撮影場所',
			'location_default' => '特に指定なし または カメラマンに相談',
			'video_description' => '動画について',
			'expiration' => '募集期限'
		],
		'create_submit' => '確定する',

		'portfolio_hint' => '参考ポートフォリオ',
		'portfolio_link' => 'ポートフォリオを参考にする'
	],

	'edit' => [
		'title' => '仕事を依頼'
	],

	'next' => '次へ',
	'another' => 'その他',
	'modal' => [
		'yes' => 'はい',
		'no'  => 'いいえ',
		'confirm_text' => '仕事を完了します。よろしいですか？',
		'proposal_confirm_text' => '「このクリエイターに仕事を依頼します。よろしいですか？」'
	],
	'url_payment_text' => '支払い一覧へ',
	'coperation_send_email_success' => 'メールを送りました。'
];
