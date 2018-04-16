<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProjectTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testCreateProject()
    {
        $this->browse(function ($admin, $creator/*, $client*/) {

            $admin->visit('/login')
                ->type('email', 'admin@gyaku.info')
                ->type('password', 'aaaaaa')
                ->press('input[type="submit"]');

            $creator->visit('/login')
                ->type('email', 'creator@gyaku.info')
                ->type('password', 'aaaaaa')
                ->press('input[type="submit"]');

            // $client->visit('/login')
            //     ->type('email', 'client@gyaku.info')
            //     ->type('password', 'aaaaaa')
            //     ->press('input[type="submit"]')
            //     ->visit('/projects/create')
            //     ->waitFor('.beige-back')
            //     ->pause(1000)
            //     ->click('.beige-back')->pause(1000);

            // $client->script(
            //     '$("#request_job_5").get(0).scrollIntoView();
            //     $("#style-1").prop("checked", true);
            //     $("#type-1").prop("checked", true);
            //     $("#part_of_work_1").prop("checked", true);
            //     $("#client_arrange_1").prop("checked", true)'
            // );

            // $client->type('place_pref', "It's automated by laravel dusk!")
            //     ->script('$("#request_job_6").get(0).scrollIntoView();');

            // $client->type('point', 'This text is automated by Dusk')
            //     ->type('describe', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit')
            //     ->script('$("#request_job_8").get(0).scrollIntoView();');

            // $title = '自動テストプロジェクト ' . \Carbon\Carbon::now()->format('Ymd his');
            // $client->type('title', $title)
            //     ->script('$("#request_job_9").get(0).scrollIntoView();');

            // $client->type('duedate_at', \Carbon\Carbon::now()->format('Y/m/d'))
            //     ->script('$("#submit_btn").get(0).scrollIntoView(); $("#submit_btn").prop("disabled", false)');

            // $client->click('#submit_btn')
            //     ->visit('/projects/client');

            // $client->pause(10000)->assertSee('プロジェクト');
        });
    }
}
