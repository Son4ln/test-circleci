<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreativeroomMessagesTable extends Migration
{
    /**
     * @var string
     */
    protected $table = 'creativeroom_messages';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('creativeroom_id');
            $table->string('title')->nullable();
            $table->unsignedInteger('user_id');
            $table->tinyInteger('readed')->default(0);
            $table->tinyInteger('kind')->unsigned()->nullable();
            $table->text('message');
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
