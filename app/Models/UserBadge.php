<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBadge extends Model
{
    use HasFactory;

    public $table = 'badges_users';

    protected $fillable = [
        'user_id',
        'badge_id',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'badge_id' => 'integer'
    ];
}
