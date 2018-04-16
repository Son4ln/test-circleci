<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEstimateColumnToProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedInteger('estimate')->nullable()->comment('最新見積もり総額');
            $table->string('request_other')->nullable()->comment('他にリクエストする');
            $table->string('info_files', 1000)->nullable()->comment('情報ファイル');
            $table->string('standard_files', 1000)->nullable()->comment('標準ファイル');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['estimate', 'request_other', 'info_files', 'standard_files']);
        });
    }
}
