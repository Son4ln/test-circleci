<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class setUsersThumbnail extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = DB::update("update users set photo_thumbnail = replace(photo,'avatars/','avatars/thumbnails/') where photo_thumbnail is null");
        $users = DB::update("update users set background_thumbnail = replace(background,'background/','background/thumbnails/') where background_thumbnail is null");
    }
}
