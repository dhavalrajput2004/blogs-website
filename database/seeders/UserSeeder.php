<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //   User::factory()
        //     ->has(Post::factory(), 'posts')
        //     ->has(Comment::factory(), 'comments')
        //   ->create();

        $users = User::factory()->count(10)->make();

        foreach ($users as $user) {

            $user->save();

            $posts = Post::factory()->count(10)->make();

            foreach ($posts as $post) {

                $post->user_id  = $user->id;

                $category  = Category::inRandomOrder()->first();
                $post->category_id = $category->id;

                $post->save();

                $comments = Comment::factory()->count(10)->make();

                foreach ($comments as $comment) {

                    $comment->post_id = $post->id;

                    $commentator = User::inRandomOrder()->first();

                    $comment->user_id = $commentator->id;

                    $comment->save();
                }
            }
        }
    }
}
