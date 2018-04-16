<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'documents';

    /**
     * Run the migrations.
     * @table documents
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('title');
            $table->unsignedTinyInteger('genre');
            $table->string('mime');
            $table->unsignedBigInteger('filesize');
            $table->text('originalfilename');
            $table->text('filename');
            $table->unsignedBigInteger('price');
            $table->unsignedSmallInteger('days');
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
