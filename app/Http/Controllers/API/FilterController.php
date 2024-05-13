<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FilterController extends Controller
{
    public function filterVendors(Request $request)
    {
        $designationFilter = $request->input('designation_filter');
        $areaOfInterestFilter = $request->input('area_of_interest_filter');
        $experienceFilter = $request->input('experience_filter');
        $chargeAudioMin = $request->input('charge_audio_min');
        $chargeAudioMax = $request->input('charge_audio_max');
        $chargeVideoMin = $request->input('charge_video_min');
        $chargeVideoMax = $request->input('charge_video_max');
        $chargeChatMin = $request->input('charge_chat_min');
        $chargeChatMax = $request->input('charge_chat_max');
        $genderFilter = $request->input('gender_filter');
        $minRating = $request->input('min_rating');

        $results = DB::statement('CALL filter_vendors(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $designationFilter,
            $areaOfInterestFilter,
            $experienceFilter,
            $chargeAudioMin,
            $chargeAudioMax,
            $chargeVideoMin,
            $chargeVideoMax,
            $chargeChatMin,
            $chargeChatMax,
            $genderFilter,
            $minRating,
        ]);
        return response()->json($results);
    }
}
