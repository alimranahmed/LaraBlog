<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index(){
        $feedbacks = Feedback::where('is_closed', 0)->get();
        return view('backend.feedbackList', compact('feedbacks'));
    }
    public function store(Request $request){
        $this->validate($request, ['email' => 'required', 'name' => 'required', 'content' => 'required']);
        try{
            Feedback::create([
                'email' => $request->get('email'),
                'name' => $request->get('name'),
                'content' => $request->get('content'),
                'ip' => $clientIP = $_SERVER['REMOTE_ADDR'],
            ]);
        }catch(\Exception $e){
            return back()->with('errorMsg', $this->getMessage($e));
        }
        return back()->with('successMsg', 'Thanks for your time to provide feedback');
    }

    public function toggleResolved($feedbackId){
        try{
            $feedback = Feedback::find($feedbackId);
            $feedback->update(['is_resolved' => !$feedback->is_resolved]);
        }catch (\Exception $e){
            return back()->with('errorMsg', $this->getMessage($e));
        }
        return back()->with('successMsg', 'Feedback updated successfully!');
    }

    public function close($feedbackId){
        try{
            $feedback = Feedback::find($feedbackId);
            $feedback->update(['is_closed' => 1]);
        }catch (\Exception $e){
            return back()->with('errorMsg', $this->getMessage($e));
        }
        return back()->with('successMsg', 'Feedback closed!');
    }
}
