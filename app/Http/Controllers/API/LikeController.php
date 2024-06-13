<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'post_id' => 'required|exists:posts,id',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }
            $check = Like::where('post_id',$request->post_id)->where('like_user_id',Auth::id())->exists();
            if($check){
                Like::where('post_id',$request->post_id)->where('like_user_id',Auth::id())->delete();
                return response()->json(['message' => 'Disliked the Post.'], 200);
            }
            $count = Like::where('post_id',$request->post_id)->count();
            $like = new Like();
            $like->post_id = $request->input('post_id');
            $like->like_user_id = Auth::id();
            $like->save();
            return response()->json(['message' => 'Liked the Post.', 'like' => $like, 'count' => $count], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
