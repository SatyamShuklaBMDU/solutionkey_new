<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardCommission extends Model
{
    use HasFactory;

    protected $fillable = [
        'reward_type',
        'reward_amount',
        'status'
    ];
}
