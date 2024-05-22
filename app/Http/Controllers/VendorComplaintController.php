<?php

namespace App\Http\Controllers;

use App\Models\vendor_complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendorComplaintController extends Controller
{
    public function index()
    {
        $complaint = vendor_complaint::all();
        return view('admin.vendor_complaint', compact('complaint'));
    }

    public function filter(Request $request)
    {
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);
        $start = $request->start;
        $end = $request->end;
        $complaint = vendor_complaint::whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.vendor_complaint', compact('complaint', 'start', 'end'));
    }

    public function destroy($id)
    {
        try {
            $complaint = vendor_complaint::findOrFail($id);
            $complaint->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function reply(Request $request)
    {
        $feedback_reply = vendor_complaint::find($request->complaintId);
        $validator = Validator::make($request->all(), [
            'complaintId' => 'required|exists:vendor_complaints,id',
            'reply' => 'required|string',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $feedback_reply->reply = $request->reply;
        // $feedback->reply_person_id = auth()->user()->id;
        $feedback_reply->reply_date = now();
        $feedback_reply->save();
        return redirect('/vendor-complaint')->with('success', 'Reply Successfully!');
    }
}
