<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersReplaceUserKindFields extends Migration
{
    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table, function (Blueprint $table) {
            // New columns
            $table->unsignedTinyInteger('is_creator')->default(0)->comment('クリエイターか？');
            $table->unsignedTinyInteger('is_certcreator')->default(0)->comment('認定クリエイターか？');
            $table->unsignedTinyInteger('is_client')->default(0)->comment('クライアントか？');
            $table->unsignedTinyInteger('is_adclient')->default(0)->comment('クルオAdのクライアントか？');
            $table->unsignedTinyInteger('is_admin')->default(0)->comment('管理者か？');

            // Drop columns
            $table->dropColumn('kind');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->table, function (Blueprint $table) {
            // Rollback columns
            $table->unsignedTinyInteger('kind')->default('0');

            // Drop columns
            $table->dropColumn('is_admin');
            $table->dropColumn('is_adclient');
            $table->dropColumn('is_client');
            $table->dropColumn('is_certcreator');
            $table->dropColumn('is_creator');
        });
    }
}
