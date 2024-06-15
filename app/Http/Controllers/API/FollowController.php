<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\FollowUnfollowRequest;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function follow(FollowUnfollowRequest $request){
        $vendorToFollow = Vendor::findOrfail(request('vendor_id'));
        dd(Auth::user()->follow($vendorToFollow));
    }
}
