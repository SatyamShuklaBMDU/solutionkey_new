<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        // $feedback = Feedback::all();
        $feedback = Feedback::all();
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
}
