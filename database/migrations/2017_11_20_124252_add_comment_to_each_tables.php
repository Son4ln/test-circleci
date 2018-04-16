<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCommentToEachTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('creative_rooms', function (Blueprint $table) {
            $table->string('title')->comment('タイトル')->change();
            $table->unsignedInteger('user_id')->comment('ユーザーID')->change();
            $table->unsignedInteger('project_id')->nullable()->comment('プロジェクトID')->change();
            $table->string('invitation_token')->nullable()->comment('招待トークン')->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedSmallInteger('enabled')->nullable()->default('0')->comment('有効')->change();
            $table->unsignedSmallInteger('searched')->nullable()->default('0')->comment('検索された')->change();
            $table->string('name')->nullable()->default(null)->comment('名前')->change();
            $table->string('team')->nullable()->default(null)->comment('チーム')->change();
            $table->string('email')->comment('電子メール')->change();
            $table->string('password', 60)->comment('パスワード')->change();
            $table->unsignedSmallInteger('kind')->default('0')->comment('種類')->change();
            $table->string('ruby')->nullable()->default(null)->comment('よみがな')->change();
            $table->string('tel', 12)->nullable()->default(null)->comment('電話番号')->change();
            $table->string('zip', 7)->nullable()->default(null)->comment('郵便番号')->change();
            $table->string('address')->nullable()->default(null)->comment('住所')->change();
            $table->unsignedSmallInteger('group')->default('1')->comment('登録区分')->change();
            $table->unsignedSmallInteger('sex')->nullable()->default(null)->comment('性別')->change();
            $table->date('birth')->nullable()->default(null)->comment('誕生日')->change();
            $table->string('nickname', 20)->nullable()->default(null)->comment('表示名')->change();
            $table->string('catchphrase')->nullable()->default(null)->comment('キャッチフレーズ')->change();
            $table->unsignedSmallInteger('impossible')->nullable()->default('0')->comment('不可能')->change();
            $table->text('comment')->nullable()->default(null)->comment('コメント')->change();
            $table->text('equipment')->nullable()->default(null)->comment('装置')->change();
            $table->unsignedSmallInteger('base')->nullable()->default(null)->comment('対応エリア')->change();
            $table->text('career')->nullable()->default(null)->comment('経歴')->change();
            $table->text('record')->nullable()->default(null)->comment('実績')->change();
            $table->string('bank', 30)->nullable()->default(null)->comment('銀行名')->change();
            $table->string('branch', 30)->nullable()->default(null)->comment('支店名')->change();
            $table->unsignedSmallInteger('account_kind')->nullable()->default(null)->comment('口座種別')->change();
            $table->string('account_no', 8)->nullable()->default(null)->comment('口座番号')->change();
            $table->string('holder')->nullable()->default(null)->comment('口座名義')->change();
            $table->string('holder_ruby')->nullable()->default(null)->comment('口座名義カナ')->change();
            $table->string('company')->nullable()->default(null)->comment('会社名')->change();
            $table->string('department')->nullable()->default(null)->comment('部署')->change();
            $table->string('motive')->nullable()->default(null)->comment('登録しようと思ったキッカケ')->change();
            $table->string('knew', 1000)->nullable()->default(null)->comment('クルオを何で知りましたか？')->change();
            $table->unsignedSmallInteger('is_creator')->default(0)->comment('クリエイターか？')->change();
            $table->text('memo')->nullable()->default(null)->comment('覚え書き')->change();
            $table->string('photo')->nullable()->comment('写真')->change();
            $table->string('background')->nullable()->comment('背景')->change();
            // $table->timestamp('activated_at')->nullable()->comment('アクティベーション日時')->change();
            $table->string('facebook_id')->nullable()->comment('FacebookのID')->change();
            $table->string('facebook_token')->nullable()->comment('facebookトークン')->change();
            $table->string('homepage', 255)->nullable()->comment('ホームページ')->change();
            $table->string('knew_sales')->nullable()->comment('担当者の名前')->change();
            $table->string('knew_other')->nullable()->comment('その他')->change();
            $table->string('stripe_id')->nullable()->comment('ストライプID')->change();
            $table->string('card_brand')->nullable()->comment('カードブランド')->change();
            $table->string('card_last_four')->nullable()->comment('最後の4枚')->change();
            // $table->timestamp('trial_ends_at')->nullable()->comment('試用終了日')->change();
        });

        Schema::table('user_skills', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->comment('ユーザーID')->change();
            $table->unsignedSmallInteger('kind')->nullable()->default(null)->comment('スキルID')->change();
            $table->unsignedSmallInteger('level')->nullable()->default(null)->comment('不使用')->change();
            $table->text('comment')->nullable()->default(null)->comment('コメント')->change();
        });

        Schema::table('rewords', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->comment('プロジェクトID')->change();
            $table->unsignedSmallInteger('kind')->nullable()->default(null)->comment('種類')->change();
            // $table->unsignedSmallInteger('enabled')->nullable()->default(null);
            $table->unsignedSmallInteger('status')->nullable()->default(null)->comment('状態')->change();
            $table->unsignedBigInteger('bill_user_id')->comment('支払人')->change();
            $table->unsignedBigInteger('reword_user_id')->comment('お金の受領者')->change();
            $table->unsignedInteger('bill')->comment('金額')->change();
            $table->unsignedInteger('reword')->comment('金額')->change();
            $table->date('bill_date')->nullable()->default(null)->comment('支払日')->change();
            $table->date('reword_date')->nullable()->default(null)->comment('支払日')->change();
            $table->string('comment')->nullable()->default(null)->comment('コメント')->change();
        });

        Schema::table('project_files', function (Blueprint $table) {
            $table->unsignedSmallInteger('kind')->default('1')->comment('種類')->change();
            $table->unsignedBigInteger('creativeroom_id')->comment('ProjectID')->change();
            $table->unsignedBigInteger('user_id')->comment('ユーザーID')->change();
            $table->string('title')->comment('タイトル')->change();
            $table->string('mime')->comment('マイム')->change();
            $table->string('path', 1000)->comment('パス')->change();
            $table->string('thumb_path', 1000)->nullable()->comment('サムネイルパス')->change();
        });

        Schema::table('portfolios', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->comment('ユーザーID')->change();
            $table->string('title')->nullable()->default(null)->comment('タイトル')->change();
            // $table->unsignedInteger('disp');
            $table->string('mime')->nullable()->default(null)->comment('マイム')->change();
            $table->string('url')->nullable()->default(null)->comment('パス')->change();
            $table->text('comment')->nullable()->default(null)->comment('コメント')->change();
            $table->string('thumb_path')->after('url')->comment('サムネイルパス')->change();
            $table->integer('amount')->after('comment')->default(0)->comment('金額')->change();
            $table->unsignedSmallInteger('scope')->after('comment')->default(0)->comment('範囲')->change();
        });

        Schema::table('infos', function (Blueprint $table) {
            $table->unsignedSmallInteger('kind')->nullable()->default(null)->comment('種類')->change();
            $table->string('title')->nullable()->default(null)->comment('タイトル')->change();
            $table->text('message')->comment('メッセージ')->change();
        });

        Schema::table('portfolio_skills', function (Blueprint $table) {
            $table->unsignedInteger('id')->comment('ユーザーID')->change();
            $table->unsignedSmallInteger('kind')->nullable()->default(null)->comment('種類')->change();
        });

        Schema::table('tracking_jobs', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->comment('ユーザーID')->change();
            $table->string('ad_account_id')->comment('広告アカウントID')->change();
            $table->string('campaign_id')->comment('キャンペーンID')->change();
            $table->unsignedSmallInteger('condition_type')->comment('条件タイプ')->change();
            $table->decimal('condition_value', 11, 2)->comment('条件値')->change();
        });

        Schema::table('creativeroom_users', function (Blueprint $table) {
            $table->unsignedInteger('creativeroom_id')->comment('ProjectID')->change();
            $table->unsignedInteger('user_id')->comment('ユーザーID')->change();
            $table->unsignedSmallInteger('role')->default(1)->comment('役割')->change();
            $table->unsignedSmallInteger('state')->default(0)->comment('状態')->change();
        });

        Schema::table('creativeroom_messages', function (Blueprint $table) {
            $table->unsignedInteger('creativeroom_id')->comment('ProjectID')->change();
            $table->string('title')->nullable()->comment('タイトル')->change();
            $table->unsignedInteger('user_id')->comment('ユーザーID')->change();
            $table->unsignedSmallInteger('readed')->default(0)->comment('読んだ')->change();
            $table->unsignedSmallInteger('kind')->unsigned()->nullable()->comment('種類')->change();
            $table->text('message')->nullable()->comment('メッセージ')->change();
            $table->unsignedInteger('recipient_id')->default(0)->comment('受信者ID')->change();
            $table->unsignedInteger('is_public')->default(0)->comment('公開されています')->change();
            $table->text('files')->nullable()->comment('ファイル')->change();
        });

        Schema::table('creativeroom_previews', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->comment('ユーザーID')->change();
            $table->unsignedBigInteger('creativeroom_id')->comment('ProjectID')->change();
            $table->integer('file_id')->comment('ファイルID')->change();
            // $table->double('start')->comment('開始')->change();
            $table->unsignedSmallInteger('kind')->default(1)->comment('種類')->change();
            $table->text('title')->comment('タイトル')->change();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->integer('user_id')->comment('ユーザーID')->change();
            $table->string('title')->comment('例：クルオAd月額入金、クルオバジェット入金')->change();
            $table->integer('amount')->comment('入金額')->change();
            $table->integer('status')->comment('1:支払い済み　100:返金済み')->change();
            // $table->timestamp('paid_at')->nullable()->comment('支払い日時')->change();
            $table->unsignedInteger('project_id')->nullable()->comment('プロジェクトID')->change();
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->comment('ユーザーID')->change();
            $table->string('title')->comment('コメント')->change();
            $table->unsignedSmallInteger('is_prime')->default(0)->comment('プライム')->change();
            $table->smallInteger('status')->default(0)
                ->comment('10:登録済み 20:デポジット課金済み 30:公開 40:案件スタート 50:クルオ検収中　60:クライアント検収中 70:終了 999:キャンセル')
                ->change();
            // $table->timestamp('start_at')->nullable()->comment('募集開始日')->change();
            // $table->timestamp('duedate_at')->nullable()->comment('締め切り日時')->change();
            $table->string('point')->nullable()->comment('動画のポイント')->change();
            $table->text('describe')->nullable()->comment('発注概要')->change();

            // For project
            $table->unsignedSmallInteger('is_certcreator')->default(0)->comment('認定クリエイター限定か？')->change();
            $table->string('real_or_anime')->nullable()->comment('動画のスタイル')->change();
            $table->string('type_of_movie')->nullable()->comment('動画のタイプ')->change();
            $table->integer('price_min')->unsigned()->nullable()->comment('予算下限')->change();
            $table->integer('price_max')->unsigned()->nullable()->comment('予算上限')->change();
            $table->unsignedSmallInteger('is_price_undecided')->default(0)->comment('価格が未定か？')->change();
            $table->string('part_of_work')->nullable()->comment('どのパートの仕事を依頼するか？')->change();
            $table->string('client_arrange')->nullable()->comment('顧客が手配出来るもの')->change();
            $table->text('client_arrange_text')->nullable()->comment('顧客が手配出来るもの備考')->change();
            $table->text('place_pref')->unsigned()->nullable()->comment('撮影場所（県選択）')->change();
            $table->unsignedSmallInteger('is_place_pref_undecided')->default(0)->comment('撮影場所未定チェック')->change();

            // For PrimeProject
            $table->smallInteger('business_type')->unsigned()->nullable()->comment('業種')->change();
            $table->string('business_name')->nullable()->comment('法人名')->change();
            $table->string('business_url')->nullable()->comment('法人URL')->change();
            $table->string('purpose')->nullable()->coment('動画の目的')->change();
            $table->string('target_product')->nullable()->comment('○○○させるのは何ですか？')->change();
            $table->string('keyword1')->nullable()->comment('キーワード')->change();
            $table->string('keyword2')->nullable()->comment('キーワード')->change();
            $table->string('keyword3')->nullable()->comment('キーワード')->change();
            $table->integer('moviesec_min')->unsigned()->nullable()->comment('動画の尺想定下限')->change();
            $table->integer('moviesec_max')->unsigned()->nullable()->comment('動画の尺想定上限')->change();
            $table->integer('similar_video')->unsigned()->nullable()->comment('イメージに近い動画')->change();
            $table->integer('aspect')->nullable()->comment('画面の比率')->change();
            $table->text('aspect_text')->nullable()->comment('画面の比率補足')->change();
            $table->string('reference_url')->nullable()->comment('参考URL')->change();
            $table->string('standard_url')->nullable()->comment('基準となるURL')->change();
            $table->string('image', 500)->nullable()->comment('プロジェクトイメージ')->change();
            $table->string('invoice_to')->nullable()->comment('請求書へ')->change();
            $table->text('attachments')->nullable()->comment('添付ファイル')->change();
            // $table->timestamp('delivered_at')->nullable()->comment('配達')->change();
            // $table->timestamp('finished_at')->nullable()->comment('終わった')->change();
        });

        Schema::table('proposals', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->comment('プロジェクトID')->change();
            $table->unsignedInteger('user_id')->comment('ユーザーID')->change();
            $table->unsignedSmallInteger('kind')->nullable()->default(null)->comment('種類')->change();
            $table->unsignedSmallInteger('offer')->nullable()->default(null)->comment('提供')->change();
            $table->unsignedInteger('price')->comment('価格')->change();
            $table->unsignedInteger('price2')->nullable()->default(null)->comment('価格 2')->change();
            $table->unsignedInteger('price3')->nullable()->default(null)->comment('固定価格')->change();
            $table->text('attachments')->nullable()->comment('添付ファイル')->change();
            $table->text('text')->nullable()->comment('テキスト')->change();
            $table->unsignedInteger('room_id')->default(0)->comment('ProjectID')->change();
        });

        Schema::table('portfolio_types', function (Blueprint $table) {
            $table->integer('portfolio_id')->comment('ポートフォリオID')->change();
            $table->integer('type_id')->comment('タイプID')->change();
        });

        Schema::table('portfolio_styles', function (Blueprint $table) {
            $table->integer('portfolio_id')->comment('ポートフォリオID')->change();
            $table->integer('style_id')->comment('スタイルID')->change();
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->string('type')->comment('タイプ')->change();
            $table->text('data')->comment('データ')->change();
            // $table->timestamp('read_at')->nullable()->comment('読んで')->change();
        });
    }
}
