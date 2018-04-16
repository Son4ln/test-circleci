<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'projects';

    /**
     * Run the migrations.
     * @table projects
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->unsignedTinyInteger('status')->nullable()->default(null);
            $table->unsignedTinyInteger('style')->nullable()->default(null);
            $table->date('delivery_date')->nullable()->default(null);
            $table->unsignedInteger('price')->nullable()->default(null);
            $table->unsignedTinyInteger('request_produce')->nullable()->default(null);
            $table->unsignedTinyInteger('request_plan')->nullable()->default(null);
            $table->unsignedTinyInteger('request_cast')->nullable()->default(null);
            $table->unsignedTinyInteger('request_make')->nullable()->default(null);
            $table->unsignedTinyInteger('request_style')->nullable()->default(null);
            $table->unsignedTinyInteger('request_location')->nullable()->default(null);
            $table->unsignedTinyInteger('request_deco')->nullable()->default(null);
            $table->unsignedTinyInteger('request_film')->nullable()->default(null);
            $table->unsignedTinyInteger('request_edit')->nullable()->default(null);
            $table->unsignedTinyInteger('request_nalater')->nullable()->default(null);
            $table->unsignedTinyInteger('request_nstudio')->nullable()->default(null);
            $table->unsignedTinyInteger('request_ma')->nullable()->default(null);
            $table->unsignedTinyInteger('request_bgm')->nullable()->default(null);
            $table->unsignedTinyInteger('request_cg')->nullable()->default(null);
            $table->unsignedTinyInteger('request_other')->nullable()->default(null);
            $table->unsignedTinyInteger('env_smartphone')->nullable()->default(null);
            $table->unsignedTinyInteger('env_tablet')->nullable()->default(null);
            $table->unsignedTinyInteger('env_pc')->nullable()->default(null);
            $table->unsignedTinyInteger('env_tv')->nullable()->default(null);
            $table->unsignedTinyInteger('env_projector')->nullable()->default(null);
            $table->unsignedTinyInteger('env_signage')->nullable()->default(null);
            $table->unsignedTinyInteger('env_cinema')->nullable()->default(null);
            $table->unsignedTinyInteger('env_gadget')->nullable()->default(null);
            $table->unsignedTinyInteger('env_other')->nullable()->default(null);
            $table->unsignedTinyInteger('client_produce')->nullable()->default(null);
            $table->unsignedTinyInteger('client_plan')->nullable()->default(null);
            $table->unsignedTinyInteger('client_cast')->nullable()->default(null);
            $table->unsignedTinyInteger('client_make')->nullable()->default(null);
            $table->unsignedTinyInteger('client_style')->nullable()->default(null);
            $table->unsignedTinyInteger('client_location')->nullable()->default(null);
            $table->unsignedTinyInteger('client_deco')->nullable()->default(null);
            $table->unsignedTinyInteger('client_film')->nullable()->default(null);
            $table->unsignedTinyInteger('client_edit')->nullable()->default(null);
            $table->unsignedTinyInteger('client_nalater')->nullable()->default(null);
            $table->unsignedTinyInteger('client_nstudio')->nullable()->default(null);
            $table->unsignedTinyInteger('client_ma')->nullable()->default(null);
            $table->unsignedTinyInteger('client_bgm')->nullable()->default(null);
            $table->unsignedTinyInteger('client_cg')->nullable()->default(null);
            $table->unsignedTinyInteger('client_other')->nullable()->default(null);
            $table->unsignedTinyInteger('category1')->nullable()->default(null);
            $table->unsignedTinyInteger('category2')->nullable()->default(null);
            $table->unsignedTinyInteger('category3')->nullable()->default(null);
            $table->unsignedTinyInteger('category4')->nullable()->default(null);
            $table->string('title')->nullable()->default(null);
            $table->string('opportunity')->nullable()->default(null);
            $table->text('target')->nullable()->default(null);
            $table->text('detail')->nullable()->default(null);
            $table->string('purpose')->nullable()->default(null);
            $table->text('element')->nullable()->default(null);
            $table->string('sample1')->nullable()->default(null);
            $table->string('sample1_explain')->nullable()->default(null);
            $table->string('sample2')->nullable()->default(null);
            $table->string('sample2_explain')->nullable()->default(null);
            $table->string('sample3')->nullable()->default(null);
            $table->string('sample3_explain')->nullable()->default(null);
            $table->string('deliver')->nullable()->default(null);
            $table->string('bgm')->nullable()->default(null);
            $table->string('nalation')->nullable()->default(null);
            $table->string('cast')->nullable()->default(null);
            $table->string('location')->nullable()->default(null);
            $table->text('supply')->nullable()->default(null);
            $table->text('restriction')->nullable()->default(null);
            $table->text('schedule')->nullable()->default(null);
            $table->text('other')->nullable()->default(null);
            $table->unsignedTinyInteger('deliver_instruct')->nullable()->default(null);
            $table->text('deliver_form')->nullable()->default(null);
            $table->string('attach')->nullable()->default(null);
            $table->text('request_other_text')->nullable()->default(null);
            $table->text('env_detail')->nullable()->default(null);
            $table->text('memo')->nullable()->default(null);
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
