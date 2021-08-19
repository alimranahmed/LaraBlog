<?php

namespace App\Http\Controllers;

use App\Mail\NotifyAdmin;
use App\Models\Config;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FeedbackController extends Controller
{
    public function index()
    {
        return view('backend.feedback.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'name' => ["required", "not_regex:/(http|ftp|mailto|www\.|\.com)/"],
            'content' => ["required", "not_regex:/(http|ftp|mailto|www\.|\.com)/"]
        ]);

        $data['ip'] = $_SERVER['REMOTE_ADDR'];

        $feedback = Feedback::create($data);

        Mail::to(Config::get('admin_email'))->queue(new NotifyAdmin($feedback, route('login-form')));

        return back()->with('successMsg', 'Thanks for your time to provide feedback');
    }
}
