<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker; 

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Post::class;

    public function definition(): array
    {
        //$user = User::id->first();
        return [
            'title' => fake()->text,
            'body' => fake()->randomHtml(10),
            'author' => fake()->firstName,
            'image' => fake()->imageUrl(),
            //'image' => "public/storage/images/8PMVJLVRoBPyrsGXhOgBWQ5fd7cT3tCV1gaGpPK1.jpg",
        ];
    }
}
