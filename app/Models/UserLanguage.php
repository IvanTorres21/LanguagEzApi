<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLanguage extends Model
{
    use HasFactory;

    public $table = 'user_languages';

    protected $fillable = [
        'users_id',
        'languages_id'
    ];

    protected $casts = [
        'users_id' => 'integer',
        'languages_id' => 'integer'
    ];
}
