<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ScheduleSlot;
use App\Models\SlotSchedulingPartner;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SlotController extends Controller
{
    public function bookSlot(Request $request)
    {
        $rules = [
            'slot_scheduling_partner_id' => 'required|exists:slot_scheduling_partners,id',
            'customer_id' => 'required|exists:customers,id',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 400);
        }
        $slotSchedulingPartner = SlotSchedulingPartner::findOrFail($request->slot_scheduling_partner_id);
        if ($slotSchedulingPartner->is_booked) {
            return response()->json(['message' => 'Slot is already booked'], 400);
        }
        $slotSchedulingPartner->update([
            'customer_id' => $request->customer_id,
            'is_booked' => true,
        ]);

        return response()->json(['message' => 'Slot booked successfully', 'data' => $slotSchedulingPartner], 200);
    }

    public function scheduleSlot(Request $request)
    {
        $rule = [
            'vendor_id' => 'required|exists:vendors,id',
            'slots' => 'array',
            'slots.*.day_name' => 'required|string',
            'slots.*.preferred_slot_start1' => 'required|date_format:H:i',
            'slots.*.preferred_slot_end1' => 'required|date_format:H:i|after:slots.*.preferred_slot_start1',
            'slots.*.preferred_slot_start2' => 'nullable|date_format:H:i|different:slots.*.preferred_slot_start1',
            'slots.*.preferred_slot_end2' => 'nullable|date_format:H:i|after:slots.*.preferred_slot_start2',
        ];
        // dd($request->slots);
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $createdSlots = [];
        foreach ($request->slots as $slot) {
            $start1 = Carbon::parse($slot['preferred_slot_start1']);
            $end1 = Carbon::parse($slot['preferred_slot_end1']);
            $start2 = isset($slot['preferred_slot_start2']) ? Carbon::parse($slot['preferred_slot_start2']) : null;
            $end2 = isset($slot['preferred_slot_end2']) ? Carbon::parse($slot['preferred_slot_end2']) : null;
            $slotSchedulingPartner = SlotSchedulingPartner::create([
                'vendor_id' => $request->vendor_id,
                'day_name' => $slot['day_name'],
                'preferred_slot_start1' => $start1,
                'preferred_slot_end1' => $end1,
                'preferred_slot_start2' => $start2,
                'preferred_slot_end2' => $end2,
                'is_booked' => false,
            ]);
            $createdSlots[] = $slotSchedulingPartner;
        }
        return response()->json(['message' => 'Slots scheduled successfully', 'data' => $createdSlots], 201);
    }

    public function getVendorTimeSlots(Request $request)
    {
        $slotSchedulingPartners = SlotSchedulingPartner::where('vendor_id', $request->vendor_id)->get();
        $slotsData = [];
        foreach ($slotSchedulingPartners as $slotSchedulingPartner) {
            $start1 = Carbon::parse($slotSchedulingPartner->preferred_slot_start1);
            $end1 = Carbon::parse($slotSchedulingPartner->preferred_slot_end1);
            $slots = [];
            $currentSlot = clone $start1;
            while ($currentSlot < $end1) {
                $nextSlot = $currentSlot->copy()->addMinutes(30);
                $slots[] = [
                    'start_time' => $currentSlot->format('H:i'),
                    'end_time' => $nextSlot->format('H:i')
                ];
                $currentSlot = $nextSlot;
            }
            $slotsData[] = [
                'slot_scheduling_partner_id' => $slotSchedulingPartner->id,
                'day_name' => $slotSchedulingPartner->day_name,
                'time_slots' => $slots
            ];
        }
        return response()->json(['message' => 'Time slots retrieved successfully', 'data' => $slotsData], 200);
    }
}
