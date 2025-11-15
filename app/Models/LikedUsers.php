<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikedUsers extends Model
{
    use HasFactory;
    protected $table = 'liked_users';
}