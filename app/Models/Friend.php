<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;

    public $table = 'friends';

    protected $fillable = [
        'user_id',
        'friend_id'
    ];

    protected $casts = [
        'user_id' => 'integer',
        'friend_id' => 'integer'
    ];

    /**
     * Get the user that owns the Friend
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'friend_id');
    }
}
