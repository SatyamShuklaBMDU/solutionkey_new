<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationFor extends Model
{
    use HasFactory;
    protected $table = "notificationfors";
    protected $fillable = ['for', 'subject', 'message'];
}
