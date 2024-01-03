<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MajorCategory;

class MajorCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $major_categories = [
            '駆動装置',
            '走行装置',
            '変速装置',
            '制動装置',
            '附属品',
        ];

        foreach($major_categories as $category) {
            MajorCategory::create([
                'name' => $category,
            ]);
        }
    }
}
