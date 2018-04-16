<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'users';

    /**
     * Run the migrations.
     * @table users
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->tinyInteger('enabled')->nullable()->default('0');
            $table->unsignedTinyInteger('searched')->nullable()->default('0');
            $table->string('name');
            $table->string('team')->nullable()->default(null);
            $table->string('email');
            $table->string('password', 60);
            $table->unsignedTinyInteger('kind')->default('0');
            $table->string('ruby')->nullable()->default(null);
            $table->string('tel', 12)->nullable()->default(null);
            $table->string('zip', 7)->nullable()->default(null);
            $table->string('address')->nullable()->default(null);
            $table->unsignedTinyInteger('group')->default('1');
            $table->unsignedTinyInteger('sex')->nullable()->default(null);
            $table->date('birth')->nullable()->default(null);
            $table->string('nickname', 20)->nullable()->default(null);
            $table->string('catchphrase')->nullable()->default(null);
            $table->tinyInteger('impossible')->nullable()->default('0');
            $table->text('comment')->nullable()->default(null);
            $table->text('equipment')->nullable()->default(null);
            $table->unsignedTinyInteger('base')->nullable()->default(null);
            $table->text('career')->nullable()->default(null);
            $table->text('record')->nullable()->default(null);
            $table->string('bank', 30)->nullable()->default(null);
            $table->string('branch', 30)->nullable()->default(null);
            $table->unsignedTinyInteger('account_kind')->nullable()->default(null);
            $table->string('account_no', 8)->nullable()->default(null);
            $table->string('holder')->nullable()->default(null);
            $table->string('holder_ruby')->nullable()->default(null);
            $table->string('company')->nullable()->default(null);
            $table->string('department')->nullable()->default(null);
            $table->string('motive')->nullable()->default(null);
            $table->string('knew')->nullable()->default(null)->comment('aaa');
            $table->rememberToken();
            $table->text('memo')->nullable()->default(null);

            $table->unique(["email"], 'users_email_unique');
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
