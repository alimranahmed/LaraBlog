<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Article;
use App\Models\HitLogger;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $articleCategories = Article::all()->groupBy('category_name');


        //$hitCountByCountries = $this->getHitByCountries();

        $hitCountByCountries = $this->getRawHitByCountries();

        return view('backend.dashboard', compact('hitCountByCountries', 'articleCategories'));
    }

    private function getRawHitByCountries()
    {
        $hitLoggerTable = (new HitLogger())->getTable();
        $addressTable = (new Address())->getTable();

         return DB::table($hitLoggerTable)
            ->join($addressTable, "{$hitLoggerTable}.address_id", '=', "{$addressTable}.id")
            ->selectRaw("$addressTable.country_name as country, count(*) as totalHit")
            ->groupBy("$addressTable.country_name")
            ->orderBy('totalHit')
            ->get();

    }

    private function getHitByCountries(){
        $hitCountries = HitLogger::all()->groupBy('country');

        $hitCountByCountries = collect([]);
        foreach ($hitCountries as $country => $hits) {
            $hitCount = new \stdClass();
            $hitCount->country = $country;
            $hitCount->totalHit = $hits->count();
            $hitCountByCountries->push($hitCount);
        }

        $hitCountByCountries = $hitCountByCountries->sortByDesc('totalHit');
        return $hitCountByCountries;
    }
}
