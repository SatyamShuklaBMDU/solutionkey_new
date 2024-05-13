<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'post_id' => 'required|exists:posts,id',
                'user_id' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }
            $like = new Like();
            $like->post_id = $request->input('post_id');
            $like->like_user_id = $request->input('user_id');
            $like->save();
            return response()->json(['message' => 'Like created successfully', 'like' => $like], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
