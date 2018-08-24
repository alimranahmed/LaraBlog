<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\HitLogger;

class DashboardController extends Controller
{
    public function index()
    {
        $articleCategories = Article::all()->groupBy('category_name');
        $hitCountries = HitLogger::all()->groupBy('country');
        $hitCountByCountries = collect([]);
        foreach ($hitCountries as $country => $hits) {
            $hitCount = new \stdClass();
            $hitCount->country = $country;
            $hitCount->totalHit = $hits->count();
            $hitCountByCountries->push($hitCount);
        }
        $hitCountByCountries = $hitCountByCountries->sortByDesc('totalHit');
        return view('backend.dashboard', compact('hitCountByCountries', 'articleCategories'));
    }
}
