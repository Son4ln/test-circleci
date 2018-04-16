<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;

class ChangeCOperationClientName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $role = Role::where('name', 'prime-client')->first();

        if ($role) {
            $role->fill(['name' => 'c-operation-client']);
            $role->update();
        }
    }
}
