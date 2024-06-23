<?php

namespace Database\Seeders;

use App\Models\Category;
use DateTime;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories[] = [
            'name' => 'Object Oriented Programming',
            'alias' => 'oop',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ];

        $categories[] = [
            'name' => 'Programming',
            'alias' => 'programming',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ];

        $categories[] = [
            'name' => 'PHP',
            'alias' => 'php',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ];

        $categories[] = [
            'name' => 'Java',
            'alias' => 'java',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ];

        $categories[] = [
            'name' => 'Python',
            'alias' => 'python',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ];

        $categories[] = [
            'name' => 'Web Frontend',
            'alias' => 'web_frontend',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ];

        $categories[] = [
            'name' => 'Miscellaneous',
            'alias' => 'misc',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ];

        Category::query()->insert($categories);
    }
}
