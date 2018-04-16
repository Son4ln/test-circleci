<?php

use Illuminate\Database\Seeder;

class ConvertOldPortfolioScope extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('portfolios')->where('scope', '>=', 1)->update(['scope' => 1]);
/*
        DB::table('portfolios')->where('scope', '>=', 3)->update(['scope' => 100]);
        DB::table('portfolios')->where('scope', 1)->update(['scope' => 102]);
        DB::table('portfolios')->where('scope', 2)->update(['scope' => 101]);

        DB::table('portfolios')->where('scope', '>=', 100)->decrement('scope', 100);
        */
    }
}
