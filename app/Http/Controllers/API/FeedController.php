<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            Activity::with(['vendor','target'])->latest()->get()
        ]);
    }
}
