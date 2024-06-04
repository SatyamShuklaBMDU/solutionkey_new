<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\vendor_complaint;
use App\Models\vendor_feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VendorFeedbackController extends Controller
{
    public function addfeedback(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'message' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation error','errors'=> $validator->errors()],400);
        }
        $feedback = vendor_feedback::create([
            'vendor_id' => Auth::id(),
            'subject' => $request->subject,
            'message' => $request->message,
        ]);
        if ($feedback) {
            return response()->json(['status' => true, 'message' => 'Your Feedback has been submitted successfully'], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'failed'], 200);
        }
    }
    public function addcomplaint(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'message' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation error','errors'=> $validator->errors()],400);
        }
        $complaint = vendor_complaint::create([
            'vendor_id' => Auth::id(),
            'subject' => $request->subject,
            'message' => $request->message,
        ]);
        if ($complaint) {
            return response()->json(['status' => true,'message' => 'Your Complaint has been submitted successfully'], 200);
        } else {
            return response()->json([ 'status' => false,'message' => 'failed'], 400);
        }
    }
    public function GetFeedback(){
        $feedback = vendor_feedback::where('vendor_id',Auth::id())->get();
        if($feedback){
            return response()->json(['status' => true, 'message' => 'Feedback get successfully', 'feedback' => $feedback],200);
        }
        else{
        return response()->json(['status' => false, 'message' => 'Feedback not found'],400);
        }
    }
    public function Getcomplaint(){
        $complaint = vendor_complaint::where('vendor_id',Auth::id())->get();
        if($complaint){
            return response()->json(['status' => true, 'message' => 'Complaint get successfully', 'complaint' => $complaint],200);
        }
        else{
        return response()->json(['status' => false, 'message' => 'Complaint not found'],400);
        }
    }
}
