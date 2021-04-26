<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTest extends Model
{
    use HasFactory;

    public $table = 'user_tests';

    protected $fillable = [
        'users_id',
        'tests_id',
        'score'
    ];

    protected $casts = [
        'users_id' => 'integer',
        'tests_id' => 'integer',
        'score' => 'integer'
    ];
}
