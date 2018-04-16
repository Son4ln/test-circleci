<?php

return [
    'projects' => [
        'create_title' => 'プロジェクトを作成する',
        'edit_title' => 'プロジェクトを編集する',
        'fields' => [
            'video_style' => '動画のスタイル',
            'video_style_error' => '動画のスタイルは、１つ以上選択をしてください',
            'video_type' => '動画のタイプ',
            'video_type_error' => '動画のタイプは、１つ以上選択をしてください',
            'budget' => 'ご予算',
            'work' => '依頼',
            'work_error' => '依頼は、１つ以上選択をしてください',
            'arrange' => '手配できるもの',
            'arrange_error' => '手配できるものは、１つ以上選択をしてください',
            'another' => 'その他',
            'place' => '撮影場所',
            'place_placeholder' => 'ex.) 東京、大阪、北海道...',
            'point' => '動画の狙い',
            'point_placeholder' => 'ex.) 企業の認知度up, 販促,エンゲージの獲得,KPIなどを記載',
            'decribe_placeholder' => '想定視聴者　ex.) F１・M１層に向けて。20~40代の女性。ペルソナ像など

    動画の印象　ex.) 洗練された都会っぽい印象など

    掲載先　ex.) SNSフィード。HP掲載。AD出稿。サイネージ。

    イメージ近い動画のリンク　ex.) https://www.youtube.com/watch?v=...

    詳細・その他　ex.) クリスマスといえばコカコーラのCM、みたいに季節とマッチさせたい',
            'image' => 'イメージ画像',
            'attachments' => '添付ファイル',
            'project_name' => 'プロジェクトの名前',
            'duedate' => '納品日',
            'undecided' => '未定・相談したい',
            'state' => '状態',
            'upper' => 'Upper',
            'lower' => 'Lower'
        ],

        'create_submit' => '確定する',
        'edit_submit' => '確定する'
    ],

    'project_states' => [
        'title' => '仕事の状態の変更',
        'back' => '戻る',
        'project_name' => 'プロジェク名',
        'amount' => '検収依頼総額',
        'price' => '予算',
        'state' => '状態',
        'alert' => 'デポジットを支払わず公開をしたい場合、登録済みの状態から、上のボタンで公開に変更をしてください。<br>
  メールは送信されません。',
        'button' => '予算と状態を変更する',
        'button_1' => '公開に設定し、発注したクライアントと クリエイター全員にメールを送る （送信予定のクリエイター数：:count 人）',
        'button_2' => '内容・金額を確認したので、クライアントに検収依頼をする',
        'confirm' => 'クリエイターに公開し、メールをクリエイターに送信します。よろしいですか？',
        'yes' => 'はい',
        'no' => 'いいえ'
    ],

    'rooms' => [
        'list' => [
            'title' => 'Project管理',
            'name'  => 'Project名',
            'member' => '参加メンバー',
            'action' => '操作',
            'detail' => '表 示'
        ],
        'show' => [
            'all_user' => '-- To all users --',
            'messages' => 'プロジェクトメッセージ',
            'crluo_messages' => 'クルオに相談',
            'preview' => 'プレビュー',
            'delivery' => '納品',
            'member' => 'メンバー',
            'config' => '設定',

            //
            'preview_mode' => 'プレビューモード',
            'compare_mode' => '２つのプレビューファイルを比較する',

            // Message box
            'messages_title' => 'プロジェクトメッセージ',
            'message_submit' => '送信',
            'sending' => 'Sending...',
        ]
    ],

    'messages' => [
        'header' => 'メッセージ',
        'debug' => '他のユーザーにメッセージをおくれます',
        'sender' => '送信元',
        'receiver' => '宛先',
        'title' => 'タイトル',
        'readed' => '既読',
        'message_submit' => '送信'
    ],

    'mails' => [
        'header' => 'ユーザーにメールをおくれます',
        'object' => 'メール送信',
        'all' => '全員に送信',
        'skill_only' => '選択スキルのみ',
        'skill' => 'スキル',
        'title' => 'タイトル',
        'title_text' => '[crluo] クルオからのお知らせ',
        'content' => '送信メール内容',
        'submit' => '送信'
    ],

    'payments' => [
        'list' => [
            'create' => '新規作成',
            'edit' => '編集'
        ],

        'fields' => [
            'project_name' => 'プロジェクト',
            'title' => 'タイトル',
            'amount' => '金額',
            'state' => '状況',
            'date' => '支払い日時',
        ],

        'create' => [
            'title' => '支払い',
            'submit' => '作成',
        ],

        'edit' => [
            'title' => '支払い',
            'submit' => '更新'
        ],
    ],

    'rewords' => [
        'list' => [
            'title' => '報酬管理',
            'create' => '新規作成',
            'edit' => '編集'
        ],

        'create' => [
            'title' => '報酬管理',
            'submit' => '作成'
        ],

        'edit' => [
            'title' => '報酬管理',
            'submit' => '更新'
        ],

        'fields' => [
            'project_name' => 'プロジェクト',
            'amount' => '金額',
            'date' => '日付',
        ]
    ],

    'c_operation' => [
        'title' => ' STRIPEへ遷移',
        'user_name' => 'User name',
        'email' => 'Email',
        'end_at' => 'End at',
        'created_at' => 'Created at',
        'cancel' => 'Cancel',
        'confirm_cancel' => 'Are you sure?'
    ]
];
