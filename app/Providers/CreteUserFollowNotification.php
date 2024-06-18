<?php

namespace App\Providers;

use App\Models\Vendor;
use App\Notifications\NewFollow;
use App\Providers\NewFollowCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreteUserFollowNotification
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
        $user = Vendor::findOrfail($event->follow->vendor_id);
        $user->notify(new NewFollow($event->follow));
    }
}
