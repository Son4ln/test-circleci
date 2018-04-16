<?php

return [
	'create' => [
		'title' => 'ポートフォリオ編集',
		'media' => '動画/画像',
		'select' => '登録する動画・画像を選択する',
		//'validation' => 'PNG / JPG / MP4 / WebM',
		'validation' => 'PNG / JPG / MP4 / WebM / MOV',
		'create_thumbnail' => 'プレビューの内容でサムネイルを作成する',
		'upload_thumbnail' => '独自のサムネイルをアップロードする',
		'title_field' => 'タイトル',
		'video_style' => '動画のスタイル',
		'video_type' => '動画のタイプ',
		'budget' => '概算金額(万円)',
		'budget_text' => '※金額が不明・非公開の場合、0円に設定してください',
		'scope' => '公開範囲',
		'comment' => 'コメント',
		'warning_text' => '動画のスタイル、動画のタイプをそれぞれ１件以上選択してから登録をしてください',
		'submit' => '登録',
	],

	'list' => [
		'no_item' => 'ポートフォリオが登録されておりません',//'ご指定の条件でポートフォリオが見つかりませんでした',
		'my_portfolio' => 'ポートフォリオ検索',
		'create_new' => '新規登録',

		'title' => 'ポートフォリオ検索',
		'title_update' => 'ポートフォリオ一覧',
		'amount' => '金額',
		'condition' => [
			'buget_30' => '30万円未満',
			'budget_3060' => '30～60万円',
			'budget_60100' => '60～100万円',
			'budget100' => '100万円以上',
			'public' => '非公開'
		],
		'style' => '動画のスタイル',
		'type' => '動画のタイプ',
		'expand' => 'その他のタイプを開く >>',
		'collapse' => '閉じる <<',
		'sort' => '並び順',
		'asc'  => '金額の低い順',
		'desc' => '金額の高い順',
		'empty' => 'ポートフォリオが登録されておりません'
	],

	'edit' => [
		'title' => 'ポートフォリオ編集',
		'submit' => '登録',
	],

	'show' => [
		'header' => 'ポートフォリオタイトル',
		'not_support' => 'To view this video please enable JavaScript, and consider upgrading to a web browser that',
		'not_support_2' => 'supports HTML5 video',
		'title' => 'タイトル:',
		'style' => '動画のスタイル:',
		'type' => '動画のタイプ:',
		'budget' => '参考金額：',
		'scope' => '公開範囲:',
		'change' => 'Change',
		'link' => '詳細プロフィールへ'
	],

	'required' => '必須',
	'validating' => 'Validating....',
	'style_error' => '動画のスタイルは、１つ以上選択をしてください',
	'type_error' => '動画のタイプは、１つ以上選択をしてください',
	'scope' => [
		'public' => '公開',
		'crluo' => '会員限定'
	]
];
