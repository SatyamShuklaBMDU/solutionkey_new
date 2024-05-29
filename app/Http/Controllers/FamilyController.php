<?php

namespace App\Http\Controllers;

use App\Models\CustomerFamily;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    public function index($id)
    {
        $Did = decrypt($id);
        $customer_families = CustomerFamily::where('customer_id',$Did)->get();
        return view('admin.all_family', compact('customer_families','Did'));
    }

    public function filter(Request $request, $id)
    {
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);

        $Did = decrypt($id);
        $start = $request->start;
        $end = $request->end;
        $customer_families = CustomerFamily::where('customer_id',$Did)
            ->whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.all_family', compact('customer_families', 'start', 'end','Did'));
    }
    public function getCustomerDetails($id)
    {
        $customer = CustomerFamily::find($id);

        if ($customer) {
            return response()->json([
                'success' => true,
                'data' => $customer,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found',
            ], 404);
        }
    }

}
