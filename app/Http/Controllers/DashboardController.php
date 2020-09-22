<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Feedback;
use App\Models\HitLogger;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $articleCategories = Article::all()->groupBy('category_name');
        $latestComments = Comment::latest()->take(3)->get();
        $latestFeedbacks = Feedback::where('is_closed', 0)->take(3)->get();

        return view('backend.dashboard', compact('articleCategories', 'latestComments', 'latestFeedbacks'));
    }

    //This method is not being used now, but can be usable in future
    private function getRawHitByCountries()
    {
        $hitLoggerTable = (new HitLogger())->getTable();
        $addressTable = (new Address())->getTable();

        return DB::table($hitLoggerTable)
            ->join($addressTable, "{$hitLoggerTable}.address_id", '=', "{$addressTable}.id")
            ->selectRaw("$addressTable.country_name as country, count(*) as totalHit")
            ->groupBy("$addressTable.country_name")
            ->orderBy('totalHit', 'desc')
            ->get();
    }
}
