<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "テスト管理者",
            'email' => "admin@gyaku.info",
            'password' => '$2y$10$t0oErtz9FGWLiXePKk4MCuwuFKpDiZmbIX0iV0KBx7PjRBKSe4oTO',
            'enabled' => "1",
            'activated_at' => '1977/01/01'
        ]);
        $user_id = DB::getPdo()->lastInsertId();
        DB::table('model_has_roles')->insert([
            'role_id' => '3',
            'model_id' => $user_id,
            'model_type' => 'App\User'
        ]);
    }
}
