<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function show()
    {
        $vendor = Vendor::all();
        return view('Professional.showVendor', compact('vendor'));
    }
    public function showdetails($id)
    {
        $vendor = Vendor::find($id);
        $vendor->profile_picture = 'https://bmdublog.com/SolutionkeyPartner/public/vendor/' . $vendor->profile_picture;
        $vendor->cover_picture = 'https://bmdublog.com/SolutionkeyPartner/public/vendor/' . $vendor->cover_pic;
        dd($vendor);
        if ($vendor) {
            return response()->json($vendor);
        } else {
            return response()->json(['error' => 'Vendor not found'], 404);
        }
    }

    public function filter(Request $request)
    {
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);
        $start = $request->start;
        $end = $request->end;
        $vendor = Vendor::whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('Professional.showVendor', compact('vendor', 'start', 'end'));
    }
    public function changeAccountStatus(Request $request)
    {
        // dd($request->all());
        $VendorId = $request->input('vendor_id');
        $newStatus = $request->input('new_status');
        $remark = $request->input('remark');
        $Vendor = Vendor::find($VendorId);
        if (!$Vendor) {
            return response()->json(['success' => false, 'message' => 'Customer not found'], 404);
        }
        $Vendor->account_status = $newStatus == "false" ? 0 : 1;
        if ($newStatus == "false" && !empty($remark)) {
            $Vendor->deactivation_remark = $remark;
            $Vendor->deactivated_at = Carbon::now();
        } else {
            $Vendor->deactivated_at = null;
            $Vendor->deactivation_remark = null;
        }
        $Vendor->save();
        return response()->json(['success' => true, 'message' => 'Account status updated successfully']);
    }
}
