<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [ 'name' => 'article-read', 'display_name' => '', 'description' => '',],
            [ 'name' => 'article-create', 'display_name' => '', 'description' => '',],
            [ 'name' => 'article-edit', 'display_name' => '', 'description' => '',],
            [ 'name' => 'article-delete', 'display_name' => '', 'description' => '',],
            [ 'name' => 'category-read', 'display_name' => '', 'description' => '',],
            [ 'name' => 'category-create', 'display_name' => '', 'description' => '',],
            [ 'name' => 'category-edit', 'display_name' => '', 'description' => '',],
            [ 'name' => 'category-delete', 'display_name' => '', 'description' => '',],
            [ 'name' => 'comment-read', 'display_name' => '', 'description' => '',],
            [ 'name' => 'comment-create', 'display_name' => '', 'description' => '',],
            [ 'name' => 'comment-edit', 'display_name' => '', 'description' => '',],
            [ 'name' => 'comment-delete', 'display_name' => '', 'description' => '',],
            [ 'name' => 'keyword-read', 'display_name' => '', 'description' => '',],
            [ 'name' => 'keyword-create', 'display_name' => '', 'description' => '',],
            [ 'name' => 'keyword-edit', 'display_name' => '', 'description' => '',],
            [ 'name' => 'keyword-read', 'display_name' => '', 'description' => '',],
            [ 'name' => 'keyword-create', 'display_name' => '', 'description' => '',],
            [ 'name' => 'keyword-edit', 'display_name' => '', 'description' => '',],
            [ 'name' => 'keyword-delete', 'display_name' => '', 'description' => '',],
        ];
    }
}
