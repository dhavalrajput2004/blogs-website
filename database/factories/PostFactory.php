<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $fileNames = ['1.jpeg', '2.jpeg' , '3.png', '4.jpeg'];

        $fileName = Arr::random($fileNames);

        $arr = explode('.',$fileName);

        $newName = Str::random().'.'.end($arr);

        $fileContents = Storage::disk('main')->get("test/$fileName");

        Storage::disk('public')->put('images'.'/' . $newName, $fileContents);

        return [
            'title' => fake()->text,
            'body' => fake()->randomHtml(10),
            'image' => "images/$newName",
        ];
    }
}