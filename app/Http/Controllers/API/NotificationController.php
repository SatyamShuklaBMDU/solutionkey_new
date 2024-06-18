<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\NotificationFor;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = NotificationFor::where('for', 'all')->orWhere('for', 'customer')->latest()->get();
        return response()->json([
            'notifications' => $notifications,
            'status' => true,
        ], Response::HTTP_OK);
    }

    public function sendNotify(Request $request)
    {
        $notifications = [];
        foreach (Auth::user()->unreadNotifications as $notification) {
            $notification->markAsRead();
            if ($notification['type'] == "App\Notifications\NewFollow") {
                $notifications[] = [
                    'type' => 'follow',
                    'user' => Vendor::findOrfail($notification['data']['follower_id']),
                ];
            }
        }
        return response()->json($notifications);
    }
}
