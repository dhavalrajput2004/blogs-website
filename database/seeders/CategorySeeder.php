<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $categories = ['tech', 'sports' , 'ai' ,'travel', 'news'];

        foreach ($categories as $category) {
            Category::create([
                'category_name' => $category,
            ]);
        }
    }
}
