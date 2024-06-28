<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Contracts\View\View;

class CommentController extends Controller
{
    public function index(): View
    {
        return view('backend.comments.index');
    }

    public function edit(Comment $comment): View
    {
        return view('backend.comments.edit', compact('comment'));
    }

    public function show(Comment $comment): View
    {
        return view('backend.comments.show', compact('comment'));
    }
}
