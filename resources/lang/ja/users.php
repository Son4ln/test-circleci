<?php

return [
    'list' => [
        'title' => 'ユーザー権限設定',
        'user_type' => 'ユーザー種別',
        'enabled' => '有効・無効',
        'name' => '名称/メール',
        'search' => '検索',
        'table' => [
            'id' => 'ID',
            'role' => '権限・状態',
            'name' => '名前',
            'mail' => 'メール&電話番号',
            'date' => '登録日時',
            'action' => '操作'
        ],
        'state' => [
            'enabled' => '有効会員',
            'disabled' => '退会済み'
        ],
        'activated' => 'クリエイター承認する',
        'edit' => '編　　集',
        'mail' => 'メール　',
        'permission' => '権限付与',
        'prop' => 'プロフ　',
        'payment' => '支払い',
        'reword' => '報　酬',
        'create' => '新規登録'
    ],

    'fields' => [
        // Account
        'account' => 'アカウント情報',
        'type' => '種別',
        'enabled' => '有効',
        'name' => '名前',
        'alt_name' => 'お名前',
        'name_help' => '法人の場合は担当者名、個人利用の方は個人名をご記入ください',
        'alt_name_help' => '希望登録区分でチーム及び制作会社を選択した方は、チーム名を入力の上、担当者様のお名前を入力してください<br>
  なお、チーム名等は後から変更可能です',
        'mail' => 'メール',
        'password' => 'パスワード',
        're_password' => 'パスワード確認',
        'password_warning' => '8文字以上でお願いいたします',
        'ruby' => 'よみがな',
        'tel' => '電話番号',
        'tel_help' => '半角数字ハイフン無し (例 0312341234)',
        'zip' => '郵便番号',
        'zip_help' => '半角数字ハイフン無し (例 1510001)',
        'address' => '住所',
        'image' => '写真',
        'background' => '背景',
        'created' => '作成日時',
        'activated' => 'アクティベーション日時',
        'activated_text' => '「この値を設定する事で、アクティベーション完了＝ログインが可能になります」',

        // Client
        'client' => 'クライアント',
        'company_name' => '会社名',
        'alt_company_name' => '会社名（法人のみ）',
        'department' => '部署',
        'alt_department' => '部署名（法人のみ）',
        'homepage' => 'ホームページ',
        'homepage_help' => '',

        // Creator
        'creator' => 'クリエイター',
        'group' => '登録区分',
        'catchphrase' => 'キャッチフレーズ',
        'catchphrase_text' => 'プロフィールに「光の魔術師　クルオ太郎」といった感じでキャッチフレーズをつける事ができます
光の魔術師、質感職人など・・',
        'team' => 'チーム名',
        'skill' => 'スキル',
        'base' => '対応エリア',
        'career' => '経歴',
        'career_placeholder' => '例：
    クルオ大学　映像学科卒業後に番組制作会社vivitoへ入社。
    「ＯＸ物語」「クイズＯＸ」などの番組ディレクターとして活動
    2015年よりフリーランスとして独立し、様々な映像制作に携わる。
    主な作品としては、ＯＸ商事オリジナルコンテンツ　「孤高のvivito」、国民的アイドルＯＯの
    ミュージックビデオ等を担当。得意ジャンルは、スピード感ある描写表現。
    ライター、ラインプロデューサー、助監督、撮影、編集を担当しています。など・・',
        'sex' => '性別',
        'sex_help' => '登録区分がチーム及び制作会社の場合は該当なしにチェックお願いします',
        'birth' => '誕生日',
        'record' => '実績',
        'record_placeholder' => '例：
    https://www.youtube.com/watch?v=77_SrpiVIG8
    ディレクターで参加　脚本担当　カメラマンとして参加など・・
    登録希望区分がチーム、制作会社の場合は「チームで制作」等　記入してください
    ',
        'record_text' => '関わった作品の実績や受賞歴などあれば記入してください。',
        'record_help' => 'ホームページや動画共有サイトなど、自身の作品を確認できるＵＲＬを貼りつけてください<br>
  補足説明がある場合はあわせて記入お願いします',
        'motive' => '登録しようと思ったキッカケ',
        'alt_motive' => 'クルオに登録しようと思ったキッ<br/>カケを教えてください',
        'knew' => 'クルオを何で知りましたか？',
        'knew_sales' => 'よろしければ担当者の名前をお聞かせください',
        'knew_other' => 'その他',
        'rules_accept' => '上記規約に同意します',
        'nda_accept' => 'NDAに同意します',

        // Bank
        'bank' => '口座情報',
        'bank_name' => '銀行名',
        'branch' => '支店名',
        'account_kind' => '口座種別',
        'account_no' => '口座番号',
        'holder' => '口座名義',
        'holder_ruby' => '口座名義カナ',
        'facebook_connect' => 'Facebook連携',
        'connect' => '解除する',

        'submit' => '更新',
        'creator_submit' => '変更',
    ],

    'create_title' => 'ユーザーを追加する',
    'edit_title' => 'ユーザーを追加する',
    'edit_submit' => '更新',
    'profile_submit' => '基本情報を変更する',
    'client_submit' => 'クライアント情報を変更する',
    'creator_submit' => 'クリエイター情報を変更する',

    'tabs' => [
        'basic' => '基本情報',
        'account' => 'アカウント',
        'bank' => '口座情報',
        'client' => 'クライアント',
        'creator' => 'クリエイター'
    ],

    'profile_title' => 'プロフィール',
    'profile_link' => '公開プロフィールを確認する',
    'show_title' => 'ユーザー情報の変更',

    'account' => [
        //Mail
        'change_mail' => 'メールアドレスの変更',
        'current_mail' => '現在のメールアドレス',
        'new_mail' => '新メールアドレス',
        'retype_mail' => '新メールアドレス（確認)',
        'change_mail_submit' => '変更する',

        //Password
        'change_password' => 'パスワードの変更',
        'current_password' => '現在のパスワード',
        'password' => '新パスワード',
        'retype_password' => '新パスワード(確認)',
        'change_mail_submit' => '変更する',

        //Facebook
        'facebook_connect' => 'Facebook連携',
        'connect_button' => '連携する',
        'disconnect_button' => '解除する',
        'facebook_name' => '連携中のアカウント名： :name',

        'confirm_text' => 'Are you sure?'
    ],

    'upgrade' => [
        'client_title' => 'クライアント更新',
        'client_alert' => 'クライアント機能をご利用には、クライアント情報の追加登録が必要になります。',
        'client_submit' => '更新',

        'creator_title' => 'クリエイター更新',
        'creator_alert_1' => 'クリエイター機能をご利用には、クリエイター情報の追加登録が必要になります。クリエイター情報には審査があり、ご入力頂いた内容を元に審査を行います。',
        'creator_alert_2' => '仕事発注時の判断にもなりますので、過去のご経歴等、出来るだけ正確にご入力ください。',
        'name_help_1' => '希望登録区分でチーム及び制作会社を選択した方は、チーム名を入力の上、担当者様のお名前を入力してください',
        'name_help_2' => 'なお、チーム名等は後から変更可能です',
        'vivito' => 'vivito',
        'creator_submit' => '更新',

        'register_client_success' => 'クライアント登録が完了しました。クライアント向け機能が利用可能になりました。'
    ],
    'new_password' => [
        'error' => '８文字以上で入力してください。入力文字は英字と数字です。'
    ]
];
