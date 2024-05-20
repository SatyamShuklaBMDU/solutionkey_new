<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function show()
    {
        $customer = Customer::all();
        // dd('ok');
        return view('admin.all_customer', compact('customer'));
    }

    public function filter(Request $request)
    {
        // dd($request);
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);
        $start = $request->start;
        $end = $request->end;
        $customer = Customer::whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.all_customer', compact('customer', 'start', 'end'));
    }
    public function destroy($id)
    {
        Customer::destroy($id);
        return response()->json(['message' => 'Status updated successfully']);
    }
    public function changeAccountStatus(Request $request)
    {
        // dd($request->all());
        $customerId = $request->input('customer_id');
        $newStatus = $request->input('new_status');
        $remark = $request->input('remark');
        $customer = Customer::find($customerId);
        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Customer not found'], 404);
        }
        $customer->account_status = $newStatus;
        if ($newStatus == 0 && !empty($remark)) {
            $customer->deactivation_remark = $remark;
            $customer->deactivated_at = Carbon::now();
        } else {
            $customer->deactivated_at = null;
            $customer->deactivation_remark = null;
        }
        $customer->save();
        return response()->json(['success' => true, 'message' => 'Account status updated successfully']);
    }
    public function family()
    {
        return view('admin.all_family');
    }

    public function getCustomerDetails($id)
    {
        $customer = Customer::find($id);

        if ($customer) {
            return response()->json([
                'id' => $customer->customers_id,
                'name' => $customer->name,
                'gender' => $customer->gender,
                'phone_number' => $customer->phone_number,
                'email' => $customer->email,
                'marital_status' => $customer->marital_status,
                'dob' => $customer->dob,
                'city' => $customer->city,
                'state' => $customer->state,
                'address' => $customer->address,
                'profile_pic' => $customer->profile_pic ? asset($customer->profile_pic) : null,
                'created_at' => $customer->created_at,
                'account_status' => $customer->account_status,
                'deactivation_remark' => $customer->deactivation_remark,
            ]);
        }

        return response()->json(['error' => 'Customer not found'], 404);
    }
}
