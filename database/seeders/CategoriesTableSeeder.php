<?php

namespace Database\Seeders;

use App\Models\FeedbackCategory;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Bug report'],
            ['name' => 'Feature request'],
            ['name' => 'Improvement'],
            ['name' => 'Security'],
            ['name' => 'Performance'],
            ['name' => 'User Experience '],
        ];

        foreach ($categories as $category) {
            FeedbackCategory::create($category);
        }
    }
}
