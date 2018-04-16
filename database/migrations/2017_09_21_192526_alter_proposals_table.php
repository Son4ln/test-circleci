<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProposalsTable extends Migration
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
        Schema::table($this->table, function (Blueprint $table) {
            $table->dropColumn('end_date');
            $table->text('text')->nullable();
            $table->unsignedInteger('room_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->date('end_date')->nullable()->default(null);
            $table->dropColumn(['room_id', 'text']);
        });
    }
}
