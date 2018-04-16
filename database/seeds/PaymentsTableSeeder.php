<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 5; $i++) {
            DB::table('payments')->insert([
                'user_id' => '1',
                'title' => 'クルオAd月額入金、クルオバジェット入金',
                'amount' => rand(1, 5) * 1000,
                'status' => rand(0, 1) === 1 ? 1 : 100,
                'paid_at' => Carbon::now()->addHour(rand(1, 5)),
            ]);
        }
    }
}
