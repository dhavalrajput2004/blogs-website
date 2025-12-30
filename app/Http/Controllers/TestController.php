<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //// $name = 'Dhaval';
      //  Mail::to("mohmmad.husain@bytestechnolab.com")->send(new TestMail($name));
     // Cache::put('key','123',$seconds = 10);
      //$value = Cache::store('file')->get('key');  
    //  dd($value);
        
       // UserJob::dispatch();
                 /*  $postIds = [3,5];
            $posts = DB::table('posts')->join('comments','posts.id','=','comments.post_id')
               ->whereIn('posts.id',$postIds)->select('comments.post_id','comments.id as comments_id', 'comments.comment')->get();*/

               //$paths = glob('public/test' . '/*.*');
      //  $images = Storage::disk('main')->allFiles('storage/images');

        // dd($fileContents);

        // // foreach($fileNames as $fileName) 
        // // {
        // //     $fileContents = Storage::disk('main')->get("test/$fileName");

        // //     Storage::disk('main')->put('storage/images'.'/' . $fileName, $fileContents);
        // // }

        //$files = glob('public/storage/images' . '/*.*');
           //  dd($images);
            //$this->faker->image('public/images',500,500,null,false),

                     //   $tagExists = Tag::search($tag)->pluck('id');


           /* if (count($tagExists) == 0) {

                $newtag = new Tag();

                $newtag->tag_name = $tag;

                $newtag->save();

                $tagpost->tag_id  = $newtag->id;
            }
                */

      //      if(!isset($tagpost->tag_id)) { $tagpost->tag_id  = $tagExists; }

                  // $tagpost = new TagPost();

            // $tagpost->tag_id  = $tag->id;

            // $tagpost->post_id = $post->id;

            // $tagpost->save();
}
