<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes; 
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'services_name',
        'description',
        'image',
        'status',
        'delete_at'
    ];
    
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
}
