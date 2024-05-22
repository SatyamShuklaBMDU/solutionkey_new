<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComplaintController extends Controller
{
   public function index()
    {    
        $complaint = Complaint::all();
        return view('admin.complaint',compact('complaint'));
    }

    public function filter(Request $request)
    {
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);
        $start = $request->start;
        $end = $request->end;
        $complaint= Complaint::whereDate('created_at', '>=', $start)
        ->whereDate('created_at', '<=', $end)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.complaint', compact('complaint', 'start', 'end'));
    }
    
    public function destroy($id)
    {
        try {
            $complaint =Complaint::findOrFail($id);
            $complaint->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function reply(Request $request)
    {
        $feedback_reply = complaint::find($request->complaintId);
        $validator = Validator::make($request->all(), [
            'complaintId' => 'required|exists:complaints,id',
            'reply' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }
        $feedback_reply->reply = $request->reply;
        // $feedback->reply_person_id = auth()->user()->id;
        $feedback_reply->reply_date = now();
        $feedback_reply->save();
        return redirect('/complaint')->with('success', 'Reply Successfully!');
    }
    
}
