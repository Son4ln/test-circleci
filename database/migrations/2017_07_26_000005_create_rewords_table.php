<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRewordsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'rewords';

    /**
     * Run the migrations.
     * @table rewords
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_id');
            $table->unsignedTinyInteger('kind')->nullable()->default(null);
            $table->unsignedTinyInteger('enabled')->nullable()->default(null);
            $table->unsignedTinyInteger('status')->nullable()->default(null);
            $table->unsignedBigInteger('bill_user_id');
            $table->unsignedBigInteger('reword_user_id');
            $table->unsignedInteger('bill');
            $table->unsignedInteger('reword');
            $table->date('bill_date')->nullable()->default(null);
            $table->date('reword_date')->nullable()->default(null);
            $table->string('comment')->nullable()->default(null);

            $table->index(["project_id"], 'rewords_project_id_index');
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
