<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortfoliosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'portfolios';

    /**
     * Run the migrations.
     * @table portfolios
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->string('title')->nullable()->default(null);
            $table->unsignedInteger('disp');
            $table->string('mime')->nullable()->default(null);
            $table->string('url')->nullable()->default(null);
            $table->unsignedTinyInteger('category1')->nullable()->default(null);
            $table->unsignedTinyInteger('category2')->nullable()->default(null);
            $table->unsignedTinyInteger('category3')->nullable()->default(null);
            $table->unsignedTinyInteger('category4')->nullable()->default(null);
            $table->unsignedTinyInteger('publish')->nullable()->default(null);
            $table->text('comment')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->set_schema_table);
    }
}
