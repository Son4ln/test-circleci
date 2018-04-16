<?php

return [
    'payments' => [
        'store_success' => '追加された',
        'update_success' => '追加された',
        'delete_success' => 'Deleted。'
    ],

    'admin_projects' => [
        'store_success' => 'プロジェクトの登録を完了しました！',
        'store_error' => 'プロジェクトの失敗を作成する',

        'update_success' => 'プロジェクト登録情報の変更が完了いたしました。',
        'update_error' => 'プロジェクトの失敗を更新する'
    ],

    'rewords' => [
        'store_success' => '成功！',
        'update_success' => '追加された'
    ],

    'broadcast' => [
        'send_success' => 'システムは数分で :count 人のユーザーにメールを送信します',
        'send_warning' => 'あなたの条件に一致するユーザーはいません'
    ],

    'rooms' => [
        'store_success' => 'C-BaseにProjectが作成されました!',
        'alt_store_success' => 'C-Base Projectが作成されました!',

        'update_success' => 'C-Base Project :project_nameが更新されました',
        'destroy_success' => 'C-Base Project :project_nameが削除されました!',
        'destroy_success_update' => 'C-Base Project :project_nameが削除されました',
        'accept_warning' => 'あなたはすでにこのクリエイティブな部屋にいます!',
        'accept_success' => 'C-Base :name に参加申請しました！管理者が承認すると、このC-Baseへ参加出来ます。',

        'room_limit' => '作成出来るC-Baseの上限に達しました。クルオ運営にお問い合わせください。',
        'file_limit' => '同じC-Baseにアップロード出来る上限に達しました。上限は100ファイルです。古いファイルを削除してください。',
        'member_limit' => '同じC-Baseに参加できる上限に達しました。参加できる上限人数は10人までです。',
        'size_limit' => '転送可能なファイルサイズの上限を超えております。上限は5GBです。ファイルサイズが5GB以上になる場合は、ファイルを分割することを検討してください。',
        'not_enough' => '二つのエリアに動画をドラッグしてください',
        'confirm_delete' => '本当に削除しますか？',
        'update_error' => 'エラーが発生しました。再度お試しください',
    ],

    'notifications' => [
        'store_success' => 'より成功した',
    ],

    'portfolios' => [
        'store_success' => '登録完了しました',
        'update_success' => '登録完了しました',
        'change_scope_success' => 'Changed!'
    ],

    'prime_projects' => [
        'store_success' => 'Saved。',
        'save_job_error' => 'Save job error',
        'delete_job_error' => 'Delete job error',
        'register_c_operation' => 'クルオPrimeをはじめるには、Prime登録が必要になります。'
    ],

    'projects' => [
        'store_success' => 'プロジェクトの登録を完了しました！',
        'store_error' => 'プロジェクトの失敗を作成する',

        'update_success' => 'プロジェクト登録情報の変更が完了いたしました。',
        'update_error' => 'プロジェクトの失敗を更新する',

        'pay_success' => '支払いを完了しました。',
        'pay_error' => '支払い処理に失敗しました',

        'cancel_success' => 'プロジェクトがキャンセルされました',

        'fixed_price_success' => '検収依頼を受け付けました!管理者での確認が取れ次第、請求書をダウンロード頂けます',

        'finish_success' => '検収を受け付けました!',

        'change_status_success' => ':status に変更をしました',

        'project_estimate' => '更新に成功しました',
        'client_acceptance_success' => 'Success!',
        'creator_acceptance_success' => 'Success!',
        'admin_acceptance_success' => 'Success!'
    ],

    'project_states' => [
        'update_success' => 'ステータスが更新されました',
        'accept_success' => 'ステータスが更新されました'
    ],

    'proposals' => [
        'store_success' => '提案が完了しました',
        'accept_success' => '成功！',
        'c_success_operation' => '成功！'
    ],

    'subscriptions' => [
        'status' => 'You are now subscribed to :planId plan.'
    ],

    'user_management' => [
        'store_success' => '変更を完了しました',
        'update_success' => '変更を完了しました'
    ],

    'users' => [
        'change_password_success' => '変更を完了しました',
        'update_success' => '変更を完了しました',
        'change_email_success' => '更新に成功しました'
    ],

    'facebook_connect' => [
        'error' => 'パスワードとメールを設定した後でのみ切断できます',
        'success' => 'Facebook連携を解除しました'
    ]

];
