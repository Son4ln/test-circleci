<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProposalsTable extends Migration
{
    /**
     * @var string
     */
    protected $table = 'proposals';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_id');
            $table->unsignedInteger('user_id');
            $table->unsignedTinyInteger('kind')->nullable()->default(null);
            $table->unsignedTinyInteger('offer')->nullable()->default(null);
            $table->date('end_date')->nullable()->default(null);
            $table->unsignedInteger('price');
            $table->unsignedInteger('price2')->nullable()->default(null);
            $table->unsignedInteger('price3')->nullable()->default(null);
            $table->text('attachments')->nullable();

            $table->index(["project_id"], 'proposals_project_id_index');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('project_id')->references('id')->on('projects')
                ->onDelete('cascade');

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
        Schema::dropIfExists($this->table);
    }
}
