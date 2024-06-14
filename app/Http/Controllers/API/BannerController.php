<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\UserBanner;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        try {
            $baseUrl = "https://bmdublog.com/solutionkey/public/";
            $banners = UserBanner::where('status', true)->latest()->get();
            if ($banners->isEmpty()) {
                return response()->json(['status' => false, 'message' => 'No banners found.'], Response::HTTP_NOT_FOUND);
            }
            $banners->each(function ($banner) use ($baseUrl) {
                $banner->image = $baseUrl . $banner->image;
            });
            return response()->json(['status' => true, 'banners' => $banners], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Failed to retrieve banners.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
