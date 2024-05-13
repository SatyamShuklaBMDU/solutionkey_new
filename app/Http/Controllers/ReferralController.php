<?php

namespace App\Http\Controllers;

use App\Models\Referral;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function index()
    {
        $referrals = Referral::all();
        return view('admin.all_referral',compact('referrals'));
    }
    public function filter(Request $request)
    {
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);
        $start = $request->start;
        $end = $request->end;
        $referrals= Referral::whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.all_referral', compact('referrals', 'start', 'end'));
    }
}
