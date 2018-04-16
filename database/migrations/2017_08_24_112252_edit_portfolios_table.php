<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditPortfoliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropColumn(
                'disp',
                'category1',
                'category2',
                'category3',
                'category4',
                'publish'
            );
            $table->string('thumb_path')->after('url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->unsignedInteger('disp');
            $table->unsignedTinyInteger('category1')->nullable()->default(null);
            $table->unsignedTinyInteger('category2')->nullable()->default(null);
            $table->unsignedTinyInteger('category3')->nullable()->default(null);
            $table->unsignedTinyInteger('category4')->nullable()->default(null);
            $table->unsignedTinyInteger('publish')->nullable()->default(null);
            $table->dropColumn('thumb_path');
        });
    }
}
