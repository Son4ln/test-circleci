<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecreateColumnRecipientId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('creativeroom_messages', function (Blueprint $table) {
            $table->unsignedInteger('recipient_id')->default(0);
            $table->unsignedInteger('is_public')->default(0);
        });

        Schema::table('creative_rooms', function (Blueprint $table) {
            $table->string('invitation_token')->nullable();
        });

        if (Schema::hasColumn('creativeroom_users', 'recipient_id')) {
            Schema::table('creativeroom_users', function (Blueprint $table) {
                $table->dropColumn('recipient_id');
            });
        }

        if (Schema::hasColumn('creativeroom_users', 'invitation_token')) {
            Schema::table('creativeroom_users', function (Blueprint $table) {
                $table->dropColumn('invitation_token');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('creativeroom_messages', function (Blueprint $table) {
            $table->dropColumn(['recipient_id', 'is_public']);
        });
    }
}
