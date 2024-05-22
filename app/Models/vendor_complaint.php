<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vendor_complaint extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function vendors()
    {
        return $this->belongsTo(Vendor::class,'vendor_id');
    }

    protected $casts = [
        'reply_date' => 'datetime',
    ];
}
