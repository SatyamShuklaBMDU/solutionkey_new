<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\FollowUnfollowRequest;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function follow(FollowUnfollowRequest $request)
    {
        $vendorToFollow = Vendor::findOrfail(request('vendor_id'));
        $user = Auth::user();
        if ($user->isFollowing($vendorToFollow)) {
            return response()->json(['status' => true, 'message' => 'Already following'], 200);
        }
        $user->follow($vendorToFollow);
        return response()->json(['status' => true, 'message' => 'Followed'], 200);
    }

    public function unfollow(FollowUnfollowRequest $request)
    {
        $vendorToUnFollow = Vendor::findOrfail(request('vendor_id'));
        $user = Auth::user();
        if (!$user->isFollowing($vendorToUnFollow)) {
            return response()->json(['status' => false, 'message' => 'Not following'], 200);
        }
        $user->unfollow($vendorToUnFollow);
        return response()->json(['status' => true, 'message' => 'Unfollowed'], 200);
    }
}
