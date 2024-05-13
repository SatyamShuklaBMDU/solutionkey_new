<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Vendor extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    protected $guarded = [];
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
