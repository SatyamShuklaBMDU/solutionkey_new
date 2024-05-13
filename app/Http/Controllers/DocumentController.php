<?php

namespace App\Http\Controllers;

use App\Models\CustomerDocument;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index(){
        $customer_documents = CustomerDocument::all();
        return view('admin.all_documents',compact('customer_documents'));
        // dd($customer_documents);
    }

    public function filter(Request $request)
    {
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);
        $start = $request->start;
        $end = $request->end;
        $customer_documents= CustomerDocument::whereDate('created_at', '>=', $start)
        ->whereDate('created_at', '<=', $end)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.all_documents', compact('customer_documents', 'start', 'end'));
    }
}
