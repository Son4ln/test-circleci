<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('knew', 1000)->nullable()->change();
            $table->string('knew_sales')->nullable();
            $table->string('knew_other')->nullable();
            $table->dropColumn(['is_certcreator', 'is_client', 'is_adclient', 'is_admin']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedTinyInteger('is_certcreator')->default(0)->comment('認定クリエイターか？');
            $table->unsignedTinyInteger('is_client')->default(0)->comment('クライアントか？');
            $table->unsignedTinyInteger('is_adclient')->default(0)->comment('クルオAdのクライアントか？');
            $table->unsignedTinyInteger('is_admin')->default(0)->comment('管理者か？');
            $table->dropColumn(['knew_sales', 'knew_other']);
        });
    }
}
