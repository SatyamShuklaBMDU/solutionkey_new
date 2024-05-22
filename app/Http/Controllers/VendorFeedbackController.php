<?php

namespace App\Http\Controllers;

use App\Models\vendor_feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Contracts\Service\Attribute\Required;



class VendorFeedbackController extends Controller
{
    public function index()
    {
        // $feedback = Feedback::all();
        $feedback = vendor_feedback::all();
        return view('admin.vendor_feedback', compact('feedback'));
    }

    public function filter(Request $request)
    {
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);
        $start = $request->start;
        $end = $request->end;
        $feedback = vendor_feedback::whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.vendor_feedback', compact('feedback', 'start', 'end'));
    }
    public function destroy($id)
    {
        $feedback = vendor_feedback::findOrFail($id);
        $feedback->delete();
        return response()->json(['success' => 'Deleted Successfully']);
    }
    public function reply(Request $request)
    {
        $feedback_reply = vendor_feedback::find($request->feedbackId);
        $validator = Validator::make($request->all(), [
            'feedbackId' => 'required|exists:vendor_feedbacks,id',
            'reply' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }
        $feedback_reply->reply = $request->reply;
        // $feedback->reply_person_id = auth()->user()->id;
        $feedback_reply->reply_date = now();
        $feedback_reply->save();
        return redirect('/vendor-feedback')->with('successs', 'Reply Successfully!');
    }
}
