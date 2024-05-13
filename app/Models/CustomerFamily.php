<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerFamily extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'name',
        'gender',
        'dob',
        'phone_number',
        'email',
        'address',
        'city',
        'state',
        'account_status',
        'deactivated_at',
        'deactivation_remark',
        'password',
        'marital_status'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
}
