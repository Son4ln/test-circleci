<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFilesColumnToCreativeroomMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('creativeroom_messages', function (Blueprint $table) {
            $table->text('files')->nullable();
            $table->text('message')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('creativeroom_messages', function (Blueprint $table) {
            $table->dropColumn('files');
            $table->text('message')->change();
        });
    }
}
