<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vendors_id' => 'required|exists:vendors,id',
            'rating' => 'required|integer|between:0,5',
            'content' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }
        try {
            $review = Review::create([
                'customer_id' => Auth::id(),
                'vendor_id' => $request->vendors_id,
                'rating' => $request->rating,
                'content' => $request->content,
            ]);
            $data['customer_detail'] = $review->customer->name;
            $data['vendors_detail'] = $review->vendor->name;
            $data['rating'] = $review->rating;
            $data['content'] = $review->content;
            return response()->json(['status' => true, 'message' => 'Review created successfully', 'data' => $data], Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json(['status' => false, 'error' => 'Failed to create review'], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'error' => 'Something went wrong'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
