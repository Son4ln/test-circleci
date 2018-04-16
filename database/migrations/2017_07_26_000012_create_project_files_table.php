<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectFilesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'project_files';

    /**
     * Run the migrations.
     * @table project_files
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedTinyInteger('kind')->default('1');
            $table->unsignedBigInteger('creativeroom_id');
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->string('mime');
            $table->string('path');
            $table->string('thumb_path')->nullable();
            $table->timestamps();
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
