<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'compes';

    /**
     * Run the migrations.
     * @table compes
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
            $table->unsignedTinyInteger('offer')->nullable()->default(null);
            $table->date('end_date')->nullable()->default(null);
            $table->unsignedInteger('price');
            $table->unsignedInteger('price2')->nullable()->default(null);
            $table->unsignedInteger('price3')->nullable()->default(null);

            $table->index(["project_id"], 'compes_project_id_index');
            $table->softDeletes();
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
