<?php

namespace App\Providers;

use App\Models\Activity;
use App\Providers\NewFollowCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateFollowActivity
{
    /**
     * Create the event listener.
     */
    // public function __construct()
    // {
    //     //
    // }

    /**
     * Handle the event.
     */
    public function handle(NewFollowCreated $event): void
    {
        Activity::create([
            'vendor_id' => $event->follow->vendor_id,
            'type' => 'follow',
            'target_id' => $event->follow->customer_id,
        ]);
    }
}
