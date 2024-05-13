<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;
    public function fromcustomer()
    {
        return $this->belongsTo(Customer::class, 'from_customer_id');
    }
    public function tocustomer()
    {
        return $this->belongsTo(Customer::class, 'to_customer_id');
    }
}
