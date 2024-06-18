<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;
    protected $guarded = [];

    public function follow(Vendor $vendor)
    {
        if (!$this->isFollowing($vendor)) {
            Follow::create([
                'customer_id' => Auth::id(), 
                'vendor_id' => $vendor->id,
            ]);
        }
    }

    public function unfollow(Vendor $user) 
    {
        Follow::where('customer_id', Auth::id())->where('vendor_id', $user->id)->delete();
    }

    public function isFollowing(Vendor $vendor)
    {
        return $this->following()->where('vendors.id', $vendor->id)->exists();
    }

    public function following()
    {
        return $this->hasManyThrough(
            Vendor::class, 
            Follow::class, 
            'customer_id',
            'id',
            'id',
            'vendor_id'
        );
    }

    public function followers()
    {
        return $this->hasManyThrough(
            Customer::class,
            Follow::class,
            'vendor_id',
            'id',
            'id',
            'customer_id'
        );
    }
}
