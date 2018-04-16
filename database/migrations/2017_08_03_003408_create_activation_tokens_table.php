<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivationTokensTable extends Migration
{
    /**
     * @var string
     */
    protected $table = 'activation_tokens';

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->table = config('auth.activates.table');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('email');
            $table->string('token');
            $table->timestamps();
            $table->index(["email"], 'activation_tokens_email_index');
            $table->index(["token"], 'activation_tokens_token_index');
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
