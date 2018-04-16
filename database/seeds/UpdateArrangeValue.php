<?php

use Illuminate\Database\Seeder;

class UpdateArrangeValue extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projects = \App\Project::select('id', 'part_of_work', 'client_arrange')->get();

        foreach ($projects as $project) {
            if ($project->part_of_work && in_array('all', $project->part_of_work)) {
                $project->part_of_work = [1, 2, 3, 4, 5];
            }

            if (is_array($project->client_arrange)) {
                $newValue = [];
                foreach ($project->client_arrange as $value) {
                    if ($value <= 6) {
                        $newValue[] = $value + 5;
                    } else {
                        $newValue = $value;
                    }
                }
                $project->client_arrange = $newValue;
            }

            $project->save();
        }
    }
}
