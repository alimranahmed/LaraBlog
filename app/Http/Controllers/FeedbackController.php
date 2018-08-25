<?php

namespace App\Http\Controllers;

use App\Mail\NotifyAdmin;
use App\Models\Config;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::where('is_closed', 0)->get();
        return view('backend.feedbackList', compact('feedbacks'));
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, ['email' => 'required|email', 'name' => 'required', 'content' => 'required']);

            $feedback = Feedback::create([
                'email' => $request->get('email'),
                'name' => $request->get('name'),
                'content' => $request->get('content'),
                'ip' => $clientIP = $_SERVER['REMOTE_ADDR'] ?? null,
            ]);
            Mail::to(Config::get('admin_email'))->queue(new NotifyAdmin($feedback->content, route('login-form')));
        } catch (\Exception $e) {
            Log::error($this->getLogMsg($e));
            return back()->with('errorMsg', $this->getMessage($e));
        }
        return back()->with('successMsg', 'Thanks for your time to provide feedback');
    }

    public function toggleResolved($feedbackId)
    {
        try {
            $feedback = Feedback::find($feedbackId);
            $feedback->update(['is_resolved' => !$feedback->is_resolved]);
        } catch (\Exception $e) {
            Log::error($this->getLogMsg($e));
            return back()->with('errorMsg', $this->getMessage($e));
        }
        return back()->with('successMsg', 'Feedback updated successfully!');
    }

    public function close($feedbackId)
    {
        try {
            $feedback = Feedback::find($feedbackId);
            $feedback->update(['is_closed' => 1]);
        } catch (\Exception $e) {
            Log::error($this->getLogMsg($e));
            return back()->with('errorMsg', $this->getMessage($e));
        }
        return back()->with('successMsg', 'Feedback closed!');
    }
}
