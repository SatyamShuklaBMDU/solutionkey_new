<?php

namespace App\Http\Controllers;

use App\Models\CustomerFamily;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    public function index()
    {   
        $customer_families = CustomerFamily::all();
        return view('admin.all_family',compact('customer_families'));
        dd($customer_families);
    }

    public function filter(Request $request)
    {
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);
        $start = $request->start;
        $end = $request->end;
        $customer_families= CustomerFamily::whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.all_family', compact('customer_families', 'start', 'end'));
    }
}
