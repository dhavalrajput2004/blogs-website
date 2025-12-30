<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $likeable = [
            Post::class , Comment::class
        ];
      
        $userIds = User::get('id)')->toArray();

        return [
            'user_id' => Arr::random($userIds),
            // 'likeable_id' => ,
            'likeable_type' => Arr::random($likeable),
        ];
    }
}
