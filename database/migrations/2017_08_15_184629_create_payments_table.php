<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * @var string
     */
    protected $table = 'payments';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('Owner ID');
            $table->string('title')->comment('例：クルオAd月額入金、クルオバジェット入金');
            $table->integer('amount')->comment('入金額');
            $table->integer('status')->comment('1:支払い済み　100:返金済み');
            $table->timestamp('paid_at')->nullable()->comment('支払い日時');
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
