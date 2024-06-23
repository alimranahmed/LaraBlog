<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Contracts\View\View;

class SubscriberController
{
    public function index(): View
    {
        return view('backend.subscribers.index');
    }
}
