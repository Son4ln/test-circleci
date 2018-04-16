<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\Storage;
use App\Services\VideoThumbnail;

class ImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function hashName($path = null)
    {
        if ($path) {
            $path = rtrim($path, '/').'/';
        }
        return $path.md5_file($this->path()).'.'.$this->extension();
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $importdata_path =  storage_path('app') . "/importdata";

//        echo $this->hashName("2.jpg");
//        $filename = pathinfo("2.jpg")["filename"];
        //
//        DB::connection('mysql')->select('select * from users');
//        $thumbnailMaker = new VideoThumbnail();
//        $importdata_path =  storage_path('app') . "/importdata";
//      $importdata_path =  "/importdata";
//        $photo = Storage::disk('local')->get($avator);
//        $store = Storage::disk('cloud')->put('avatars', 's3');

//        $thumbnailMaker = new VideoThumbnail();
//        $thumbnailMaker.thumb
//        $input['thumb_path'] = $thumbnailMaker->makeThumbnail( $avator)
//            ->storePublicly("avator", 's3');

//        }


/*
        $users = DB::connection('mysql')->table('users')->get();
        foreach ($users as $user) {
            $user = (array)$user;
            $model_has_roles = array("role_id"=>$user["kind"] ,"model_id"=>$user["id"] ,"model_type"=>"App\User");
            if($user["kind"] == "1" && $user["enabled"] == "1"){
                $user["is_creator"] = 2;
            }

//            unset($user["kind"]);

            $id = $user["id"];
            $avatar = "importdata/" . $id . "/photo.png";
            if(Storage::disk('local')->has($avatar)){
                $absolute_avatar = $importdata_path . "/" . $id . "/photo.png";
                $hash = md5_file($absolute_avatar).'.png';

//                $avatar = Storage::disk('local')->get($avatar);
//                $store = Storage::disk('s3')->put('/avatars/'.$hash, $avatar, 'public');
                $user["photo"] = '/avatars/'.$hash;
            }


            $background = "importdata/" . $id . "/background.png";
            if(Storage::disk('local')->has($background)){
                $absolute_background = $importdata_path . "/" . $id . "/background.png";
                $hash = md5_file($absolute_background).'.png';

//                $background = Storage::disk('local')->get($background);
//                $store = Storage::disk('s3')->put('/background/'.$hash, $background, 'public');
                $user["background"] = '/background/'.$hash;
            }

            DB::table('users')->insert($user);
            DB::table('model_has_roles')->insert($model_has_roles);


            echo "uploading ". $id . "¥n";


        }
  //      continue;
*/

        print $importdata_path;
        $src  = "/Users/kakumaminoru/laravel/importdata/portfolios";
        $dst  = "/Users/kakumaminoru/laravel/importdata/pf_user";
        $portfolios = DB::connection('mysql')->table('portfolios')->get();
        foreach ($portfolios as $portfolio) {
            $srcpath = $src ."/" .$portfolio->id . "/*";
            $dstpath = $dst ."/" .$portfolio->user_id . "/" ;

            foreach (glob( $srcpath) as $filename_full) {
//                print "src:".$filename ."\n";
                $filename =  basename($filename_full);
                if(!file_exists($dstpath)){
                    mkdir($dstpath);
                }
                rename($filename_full, $dstpath. "/" . $filename);
            }  
            print "dst:".$dstpath ."\n";

            //print $portfolio->id . " " .$portfolio->user_id. "\n";
        }
/*
        //  convert the portfolio data
        $portfolios = DB::connection('mysql')->table('portfolios')->get();
        foreach ($portfolios as $portfolio) {
            $portfolio = (array)$portfolio;
            unset($portfolio["category1"]);
            unset($portfolio["category2"]);
            unset($portfolio["category3"]);
            unset($portfolio["category4"]);
            $portfolio["scope"] = $portfolio["publish"];
            unset($portfolio["publish"]);
//            unset($portfolio["disp"]);
            $portfolio["thumb_path"]="nothing";
//            print_r($portfolio);

//           DB::table('portfolios')->insert($portfolio);
            $id = $portfolio["id"];
//            $video = "importdata/video/" . $id . ".mp4";
//            if(Storage::disk('local')->has($video)){            
//                $absolute_video = $importdata_path . "/video/" . $id . ".mp4";
//                $hash = $id."_".md5_file($absolute_video).'.mp4';
//                echo $hash . "\n";
//            }

*/
/*
            $video = "importdata/video/" . $id . ".mp4";

            if(Storage::disk('local')->has($video)){            
//                $absolute_video = $importdata_path . "/video/" . $id . ".mp4";
//                $hash = $id."_".md5_file($absolute_video).'.mp4';

                $absolute_video = $importdata_path . "/video/" . $id . ".mp4";
                $hash = $id."_".md5_file($absolute_video).'.mp4';
                $dist_video     = $importdata_path . "/video/" . $hash;
                rename($absolute_video, $dist_video);
                echo $dist_video . "\n";
            }

            $video = "importdata/video/" . $id . ".png";

            if(Storage::disk('local')->has($video)){            
//                $absolute_video = $importdata_path . "/video/" . $id . ".mp4";
//                $hash = $id."_".md5_file($absolute_video).'.mp4';

                $absolute_video = $importdata_path . "/video/" . $id . ".png";
                $hash = $id."_".md5_file($absolute_video).'.png';
                $dist_video     = $importdata_path . "/video/" . $hash;
                rename($absolute_video, $dist_video);
                echo $dist_video . "\n";
            }


            $thumb = "importdata/thumb/" . $id . "_thumb.png";

            if(Storage::disk('local')->has($thumb)){            
//                $absolute_video = $importdata_path . "/video/" . $id . ".mp4";
//                $hash = $id."_".md5_file($absolute_video).'.mp4';

                $absolute_video = $importdata_path . "/thumb/" . $id . "_thumb.png";
                $hash = $id."_".md5_file($absolute_video).'.png';
                $dist_video     = $importdata_path . "/thumb/" . $hash;
                rename($absolute_video, $dist_video);
                echo $dist_video . "\n";
            }
*/

//            continue;
//            foreach (glob( $importdata_path ."/thumb/4_*.png") as $filename) {
//                  echo "$filename size " . filesize($filename) . "\n";
//            }


/*
            $dist = $importdata_path ."/portfolios/";
            $id = $portfolio["id"];
*/
/*            $exists = glob( $importdata_path ."/thumb/" .$id.  "_*.png");
            if(!empty($exists)){
                $filename =  basename($exists[0]);
                if(!file_exists($dist .$id)){
                    mkdir( $dist. $id);
                }
                rename( $importdata_path . "/thumb/" . $filename, $dist . $id . "/" . $filename);

//                $portfolio["thumb_path"] = "portfolios/thumb/" . $filename;
            }

            $exists = glob( $importdata_path ."/video/" .$id.  "_*.mp4");
            if(!empty($exists)){
                $filename =  basename($exists[0]);
                if(!file_exists($dist .$id)){
                    mkdir( $dist. $id);
                }
                rename( $importdata_path . "/video/" . $filename, $dist . $id . "/" . $filename);
            }

            $exists = glob( $importdata_path ."/video/" .$id.  "_*.png");
            if(!empty($exists)){
                $filename =  basename($exists[0]);
                if(!file_exists($dist .$id)){
                    mkdir( $dist. $id);
                }
                rename( $importdata_path . "/video/" . $filename, $dist . $id . "/" . $filename);
            }
*/
/*

            $id = $portfolio["id"];

            // videoがあったらvideoとサムネイル
            $exists = glob( $dist .$id.  "/" . $id . "_*.mp4");
            if(!empty($exists)){
                $filename =  basename($exists[0]);
                echo "\n";
                $portfolio["url"] = "portfolios/" . $id ."/" . $filename;

                $exists = glob( $dist .$id.  "/" . $id . "_*.png");
                if(!empty($exists)){
                    $filename =  basename($exists[0]);
                    echo "\n";
                    $portfolio["thumb_path"] = "portfolios/" . $id ."/" . $filename;
                }
            }else{
                // なければ対象が画像とサムネイル
                $exists = glob( $dist .$id.  "/" . $id . "_*.png");
                if(!empty($exists)){
                    $filename =  basename($exists[0]);
                    echo "\n";
                    $portfolio["url"] = "portfolios/" . $id ."/" . $filename;
                    $portfolio["thumb_path"] = "portfolios/" . $id ."/" . $filename;
                }
            }

            print $portfolio["url"];
            print "\n";
            print $portfolio["thumb_path"];
            print "\n";

            DB::table('portfolios')->insert($portfolio);

        }
 */       
    }
}
