<?php

use App\Models\Article;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('slug')->after('id')->unique()->nullable();
        });

        foreach (Article::query()->get() as $article) {
            $article->update(['slug' => Str::slug($article->heading, '-', $article->language)]);
        }
    }

    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
