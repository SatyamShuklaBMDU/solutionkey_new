<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    public function index()
    {
        // $feedback = Feedback::all();
        $feedback = Feedback::all();
        // dd($feedback);
        return view('admin.feedback',compact('feedback'));
    }

    public function filter(Request $request)
    {
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);
        $start = $request->start;
        $end = $request->end;
        $feedback= Feedback::whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.feedback', compact('feedback', 'start', 'end'));
    }
    public function destroy($id){
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();
        return response()->json(['success'=>'Deleted Successfully']);
    }
    public function reply(Request $request)
    {
        $feedback_reply = feedback::find($request->feedbackId);
        $validator = Validator::make($request->all(), [
            'feedbackId' => 'required|exists:feedback,id',
            'reply' => 'required|string'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $feedback_reply->reply = $request->reply;
        $feedback_reply->reply_date = now();
        $feedback_reply->save();
        return redirect('/feedback')->with('success', 'Reply Successfully!');
    }
}
