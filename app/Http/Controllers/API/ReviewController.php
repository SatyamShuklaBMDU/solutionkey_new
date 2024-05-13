<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'customers_id' => 'required|exists:customers,id',
            'vendors_id' => 'required|exists:vendors,id',
            'rating' => 'required|integer|between:0,5',
            'content' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
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
            return response()->json(['message' => 'Review created successfully', 'data' => $data], 201);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Failed to create review'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    
}
