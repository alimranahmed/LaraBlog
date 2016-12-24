<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ReadersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(KeywordsTableSeeder::class);
        $this->call(ArticlesTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        $this->command->info('All table seeded successfully!');
        $this->command->info('Admin Route: domain-name/admin');
        $this->command->info('username: owner@gmail.com | password: owner');
    }
}
