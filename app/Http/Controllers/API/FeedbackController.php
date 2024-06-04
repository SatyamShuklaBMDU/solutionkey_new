<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class FeedbackController extends Controller
{
    public function feedbackDetail(Request $request)
    {
        $user_id = Auth::id();
        if ($request->has('type')) {
            if ($request->type == 2) {
                $feedback = Complaint::create([
                    'user_id' => $user_id,
                    'subject' => $request->subject,
                    'message' => $request->message,
                ]);
                if ($feedback) {
                    return response()->json(['message' => 'Your Complaint has been submitted successfully', 'status' => true], 200);
                } else {
                    return response()->json(['message' => 'failed', 'status' => false], 200);
                }
            }
            if ($request->type == 1) {
                $feedback = Feedback::create([
                    'user_id' => $user_id,
                    'subject' => $request->subject,
                    'message' => $request->message,
                ]);
                if ($feedback) {
                    return response()->json(['message' => 'Your feedback has been submitted successfully', 'status' => true], 200);
                } else {
                    return response()->json(['message' => 'failed', 'status' => false], 200);
                }
            }
        }
    }
    public function addfeedback(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'message' => 'required',
        ]);
        if ($validator->fails()) {
            $response = ['status' => false];
            foreach ($validator->errors()->toArray() as $field => $messages) {
                $response[$field] = $messages[0];
            }
            return response()->json($response, Response::HTTP_BAD_REQUEST);
        }
        $feedback = Feedback::create([
            'customer_id' => Auth::id(),
            'subject' => $request->subject,
            'message' => $request->message,
        ]);
        if ($feedback) {
            return response()->json(['message' => 'Your Feedback has been submitted successfully', 'status' => true], Response::HTTP_CREATED);
        } else {
            return response()->json(['message' => 'failed', 'status' => false], Response::HTTP_BAD_REQUEST);
        }
    }
    public function addcomplaint(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'message' => 'required',
        ]);
        if ($validator->fails()) {
            $response = ['status' => false];
            foreach ($validator->errors()->toArray() as $field => $messages) {
                $response[$field] = $messages[0];
            }
            return response()->json($response, Response::HTTP_BAD_REQUEST);
        }
        $complaint = Complaint::create([
            'customer_id' => Auth::id(),
            'subject' => $request->subject,
            'message' => $request->message,
        ]);
        if ($complaint) {
            return response()->json(['message' => 'Your Complaint has been submitted successfully', 'status' => true], Response::HTTP_CREATED);
        } else {
            return response()->json(['message' => 'failed', 'status' => false], Response::HTTP_BAD_REQUEST);
        }
    }
    public function GetFeedback()
    {
        $feedback = Feedback::where('customer_id', Auth::id())->get();
        if ($feedback) {
            return response()->json(['status' => true, 'message' => 'Feedback get successfully', 'feedback' => $feedback], Response::HTTP_OK);
        } else {
            return response()->json(['status' => false, 'message' => 'Feedback not found'], Response::HTTP_NOT_FOUND);
        }
    }
    public function Getcomplaint()
    {
        $complaint = Complaint::where('customer_id', Auth::id())->get();
        if ($complaint) {
            return response()->json(['status' => true, 'message' => 'Complaint get successfully', 'complaint' => $complaint], Response::HTTP_OK);
        } else {
            return response()->json(['status' => false, 'message' => 'Complaint not found'], Response::HTTP_NOT_FOUND);
        }
    }
}
