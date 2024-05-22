<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vendor_feedback extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function vendors()
    {
        return $this->belongsTo(Vendor::class,'vendor_id');
    }
}
