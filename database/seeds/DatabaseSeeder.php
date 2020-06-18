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
        $this->call(RolesAndPermissionsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ReadersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(KeywordsTableSeeder::class);
        $this->call(ArticlesTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        $this->call(ConfigsTableSeeder::class);
        if (env('APP_ENV') == 'local') {
            $this->command->info('All table seeded successfully!');
            $this->command->info('username: owner@gmail.com | password: owner');
        }
    }
}
