<?php

namespace App\Http\Controllers;

use App\Models\ScheduleSlot;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function online_booking()
    {
        $schedule_slots = ScheduleSlot::where('type','online')->get();
        return view('admin.all_online_booking',compact('schedule_slots'));
    }
    public function physical_booking(){
        $schedule_slots = ScheduleSlot::where('type','physical')->get();
        return view('admin.all_physical_booking',compact('schedule_slots'));
    }

    public function online_filter(Request $request)
    {
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);
        $start = $request->start;
        $end = $request->end;
        $schedule_slots= ScheduleSlot::whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.all_online_booking', compact('schedule_slots', 'start', 'end'));
    }
    public function physical_filter(Request $request)
    {
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);
        
        $start = $request->start;
        $end = $request->end;
        $schedule_slots= ScheduleSlot::whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.all_physical_booking', compact('schedule_slots', 'start', 'end'));
    }
}
