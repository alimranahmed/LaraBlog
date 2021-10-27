<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Laravelium\Sitemap\Sitemap;

class SiteMapController extends Controller
{
    public function __invoke(Sitemap $sitemap)
    {
        $sitemap->setCache('larablog.sitemap', 60);

        if ($sitemap->isCached()) {
            return $sitemap->render('xml');
        }

        $paginatedArticles = Article::getPaginated();
        $latestArticleAt = $paginatedArticles->first()->created_at;

        $sitemap->addSitemap('articles');

        // add item to the sitemap (url, date, priority, freq)
        $sitemap->add(route('home'), $latestArticleAt, '1.0', 'weekly');
        $sitemap->add(route('articles'), $latestArticleAt, '1.0', 'weekly');
        $sitemap->add(route('page.about'), $latestArticleAt, '1.0', 'monthly');
        $sitemap->add(route('contact'), $latestArticleAt, '1.0', 'monthly');

        // add every article to the sitemap
        foreach ($paginatedArticles as $article) {
            $sitemap->add(
                route('get-article', [$article->id, make_slug($article->heading)]),
                $article->created_at,
                '0.9',
                'weekly'
            );
        }

        foreach (range(1, $paginatedArticles->lastPage()) as $page) {
            $sitemap->add(
                route('articles', compact('page')),
                $latestArticleAt,
                0.8,
                'weekly'
            );
        }

        // show your sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
        return $sitemap->render('xml');
    }
}
