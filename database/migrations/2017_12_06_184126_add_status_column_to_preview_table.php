<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusColumnToPreviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('creativeroom_previews', function (Blueprint $table) {
            $table->unsignedSmallInteger('state')->default(0)->comment('状態 0:仕事, 1:完了');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('creativeroom_previews', function (Blueprint $table) {
            $table->dropColumn('state');
        });
    }
}
