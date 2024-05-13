<?php

namespace App\Listeners;

use App\Models\Customer;
use Illuminate\Auth\Events\Registered;

class GenerateReferralCode
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        $customer = $event->user; // Accessing the registered user from the event
        if (!$customer->refer_code) { // Only generate referral code if not already assigned
            $attempts = 0;
            do {
                $randomDigits = mt_rand(10000, 99999);
                $referralCode = 'SOLU' . $randomDigits;
                $existingCustomer = Customer::where('refer_code', $referralCode)->exists();
                $attempts++;
            } while ($existingCustomer && $attempts < 5); // Limit the number of attempts
            if (!$existingCustomer) {
                $customer->refer_code = $referralCode;
                $customer->save();
            }
        }
    }
}
