<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    "confirmed"            => ":attribute 確認が異なっています。",
    'date'                 => 'The :attribute is not a valid date.',
    "date_format"          => ":attribute は以下の形式で入力してください :format。",
    'different'            => 'The :attribute and :other must be different.',
    "digits"               => ":attribute は :digits 桁で入力してください。",
    "digits_between"       => ":attribute は :min 〜 :max 桁の間で入力してください。",
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    "email"                => ":attribute メールアドレスが不正です。",
    'exists'               => 'The selected :attribute is invalid.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    "integer"              => ":attribute は0〜9の半角数字で入力してください。",
    'ip'                   => 'The :attribute must be a valid IP address.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        "file"    => ":attribute のファイルサイズは :max KByte以内としてください。",
        "string"  => ":attribute は :max 文字以内で入力してください。",
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    "mimes"                => ":attribute は次のファイル形式としてください。 ファイル形式: :values。",
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute は :min　以上でご指定ください。',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        "string"  => ":attribute は :min 文字以上で入力してください。",
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    "numeric"              => ":attribute は数字で入力してください。",
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'The :attribute format is invalid.',
    "required"             => ":attribute の入力は必須となります。",
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => ':attribute の入力は必須となります。',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    "unique"               => ":attribute は、既に利用されています。",
    'uploaded'             => 'The :attribute failed to upload.',
   // 'url'                  => 'The :attribute format is invalid.',
    'url'                  => 'ホームページURLを正しく入力してください。',
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
        'email' => [
            'activated_user_unique' => ':attribute は、既に利用されています。'
        ],
        'old_password' => [
            'old_password' => 'パスワードが一致しません!'
        ],
        'business_url' => [
            'url' => '法人URLを正しくご入力ください'
        ],
        'target_product' => [
            'required' => 'ターゲットプロダクトの入力は必須となります。'
        ],
        'point' => [
            'required' => 'ポイントの入力は必須となります'
        ],
        'business_type' => [
            'required' => 'ビジネスタイプの入力は必須となります'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'name' => '名前',
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'ruby' => 'よみがな',
        'tel' => '電話番号',
        'zip' => '郵便番号',
        'address' => '住所',
        'birth' => '誕生日',
        'nickname' => '表示名',
        'catchphrase' => 'キャッチフレーズ',
        'comment' => 'コメント',
        'equipment' => '使用機材',
        'career' => '経歴',
        'record' => '実績',
        'bank' => '銀行名',
        'branch' => '支店名',
        'account_no' => '口座番号',
        'holder' => '口座名義',
        'holder_ruby' => '口座名義カナ',
        'company' => '会社名',
        'department' => '部署名',
        'photo' => '写真',
        'background' => '背景',
        'title' => 'タイトル',
        'image' => 'ファイル',

        'opportunity' => '動画作成の動機',
        'target' => 'ターゲット',
        'detail' => '詳細',
        'purpose' => '目的',
        'element' => '要素',
        'sample1' => 'サンプル動画1URL',
        'sample1_explain' => 'サンプル動画1説明',
        'sample2' => 'サンプル動画2URL',
        'sample2_explain' => 'サンプル動画2説明',
        'sample3' => 'サンプル動画3URL',
        'sample3_explain' => 'サンプル動画3説明',
        'deliver' => '納品',
        'bgm' => 'BGM',
        'nalation' => 'ナレーション',
        'cast' => 'キャスト',
        'location' => 'ロケ地',
        'supply' => '提供素材',
        'restriction' => '制約',
        'schedule' => '制作スケジュール',
        'other' => 'その他',
        'deliver_form' => '納品形式',
        'attach' => '添付ファイル',

        'end_date' => '終了日',
        'price' => '金額',

        'preview' => 'プレビュー',
        'old_email' => '現在のメール',
        'email_confirmation' => '確認',

        'amount' => '金額',
        'paid_at' => '支払い日時',

        'part_of_work' => '依頼すること',
        'client_arrange' => 'お客様が手配すること',
    ],

];
