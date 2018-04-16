<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 5; $i++) {
            DB::table('projects')->insert([
                // Fill for common
                'user_id' => '1',
                'title' => sprintf('Project %02d', $i),
                'is_prime' => 0,
                'status' => rand(0, 6) * 10,
                'start_at' => Carbon::now()->addDay(rand(1, 10) - 5),
                'aspect' => 1,
                'aspect_text' => '画面の比率補足',
                'point' => '1 Point',
                'describe' => 'Description',

                // Fill for normal project
                'is_certcreator' => rand(0, 1),
                'real_or_anime' => '',
                'type_of_movie' => '',
                'price_min' => 50,
                'price_max' => 200,
                'is_price_undecided' => 0,
                'part_of_work' => '',
                'client_arrange' => '',
                'client_arrange_text' => '',
                'place_pref' => rand(1, 20),
                'is_place_pref_undecided' => 0,

                // Fill for prime project
                'business_type' => 0,
                'purpose' => '',
                'duedate_at' => null,
            ]);
        }
    }
}
