<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Feedback;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $categories = Category::query()->withCount('articles')->get()->sortByDesc('articles_count');
        $latestComments = Comment::query()->with('user')->latest()->take(3)->get();
        $latestFeedbacks = Feedback::query()->where('is_closed', 0)->take(3)->get();

        return view('backend.dashboard', compact('categories', 'latestComments', 'latestFeedbacks'));
    }
}
