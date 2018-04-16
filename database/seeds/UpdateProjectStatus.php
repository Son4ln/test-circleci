<?php

use Illuminate\Database\Seeder;

class UpdateProjectStatus extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->where('status', 0)
            ->update(['status' => 10]);
    }
}
