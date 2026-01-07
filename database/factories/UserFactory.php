<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password = 'admin';

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fileNames = ['1.jpeg', '2.jpeg' , '3.png', '4.jpeg'];

        $fileName = Arr::random($fileNames);

        $arr = explode('.',$fileName);

        $newName = Str::random().'.'.end($arr);

        $fileContents = Storage::disk('main')->get("test/$fileName");

        Storage::disk('public')->put('images'.'/' . $newName, $fileContents);

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->email(),
            'email_verified_at' => now(),
            'bio' =>fake()->text(),
            'profile_image' => "images/$newName",
            'phone_number' => fake()->phoneNumber(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
