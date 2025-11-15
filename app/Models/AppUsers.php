<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class AppUsers extends Authenticatable
{
    use HasFactory;
    protected $table = 'app_users';
    protected $guarded = [];
    protected $hidden = [
        'password',
        'forgotid',
        'device_token',
    ];
}