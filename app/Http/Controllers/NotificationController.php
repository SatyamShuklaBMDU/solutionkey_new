<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\NotificationFor;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notification = NotificationFor::all();
        return view('admin.all_notification',compact('notification'));
        
    }

    public function create(){
        return view('admin.notification');
    }
    public function store(Request $request)
    {
       
        $validatedData = $request->validate([
            'for' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);
        // dd($validatedData);
        
        $notification = new NotificationFor();
        $notification->for = $validatedData['for'];
        $notification->subject = $validatedData['subject'];
        $notification->message = $validatedData['message'];
        $notification->save();
        return redirect()->route('notification')->with('success', 'Notification Created successfully!');
    }
    public function filter(Request $request)
    {
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);
        $start = $request->start;
        $end = $request->end;
        $notification = NotificationFor::whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.all_notification', compact('notification', 'start', 'end'));
    }
    
    public function destroy($id){
        $notification = NotificationFor::find($id);
        $notification->delete();
        return response()->json(['success'=>'Deleted Successfully']);
    }
}
