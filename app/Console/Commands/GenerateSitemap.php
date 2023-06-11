<?php

namespace App\Console\Commands;

use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Generate sitemap';

    public function handle()
    {
        $paginatedArticles = Article::getPaginated();
        $latestArticleAt = $paginatedArticles->first()->created_at ?? Carbon::now()->toDateString();

        $sitemap = Sitemap::create();

        $sitemap->add(Url::create('article'));

        $sitemap->add(route('home'));
        //            ->setLastModificationDate($latestArticleAt)
        //            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
        //            ->setPriority(1.0);

        $sitemap->add(route('articles'));
        //        ->setLastModificationDate($latestArticleAt)
        //        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
        //        ->setPriority(1.0);

        $sitemap->add(route('page.about'));
        //            ->setLastModificationDate($latestArticleAt)
        //            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
        //            ->setPriority(1.0);

        $sitemap->add(route('contact'));
        //        ->setLastModificationDate($latestArticleAt)
        //        ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
        //        ->setPriority(1.0);

        // add every article to the sitemap
        foreach ($paginatedArticles as $article) {
            $sitemap->add(route('get-article', $article->slug));
            //        ->setLastModificationDate($article->created_at)
            //        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            //        ->setPriority(0.9);
        }

        foreach (range(1, $paginatedArticles->lastPage()) as $page) {
            $sitemap->add(route('articles', compact('page')));
            //        ->setLastModificationDate($latestArticleAt)
            //        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            //        ->setPriority(0.8);
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));
    }
}
