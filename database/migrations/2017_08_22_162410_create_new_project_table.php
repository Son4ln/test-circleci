<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewProjectTable extends Migration
{
    /**
     * @var string
     */
    protected $table = 'projects';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->engine = 'InnoDB';

            // Common
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->string('title');
            $table->tinyInteger('is_prime')->default(0);
            $table->smallInteger('status')->default(0)
                ->comment('0:非公開　10:公開 20:提案選定中 30:提案決定済み 40:作業中 50:支払い処理中　60:終了');
            $table->timestamp('start_at')->comment('募集開始日');
            $table->integer('aspect')->comment('画面の比率');
            $table->text('aspect_text')->nullable()->comment('画面の比率補足');
            $table->string('point')->comment('動画のポイント');
            $table->text('describe')->nullable()->comment('発注概要');

            // For project
            $table->tinyInteger('is_certcreator')->default(0)->comment('認定クリエイター限定か？');
            $table->string('real_or_anime')->nullbale()->comment('動画のスタイル');
            $table->string('type_of_movie')->nullbale()->comment('動画のタイプ');
            $table->integer('price_min')->unsigned()->comment('予算下限');
            $table->integer('price_max')->unsigned()->comment('予算上限');
            $table->tinyInteger('is_price_undecided')->default(0)->comment('価格が未定か？');
            $table->string('part_of_work')->nullable()->comment('どのパートの仕事を依頼するか？');
            $table->string('client_arrange')->nullable()->comment('顧客が手配出来るもの');
            $table->text('client_arrange_text')->nullable()->comment('顧客が手配出来るもの備考');
            $table->integer('place_pref')->unsigned()->nullable()->comment('撮影場所（県選択）');
            $table->tinyInteger('is_place_pref_undecided')->default(0)->comment('撮影場所未定チェック');

            // For PrimeProject
            $table->smallInteger('business_type')->unsigned()->comment('業種');
            $table->string('purpose')->coment('目的');
            $table->timestamp('duedate_at')->nullable()->comment('締め切り日時');

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
