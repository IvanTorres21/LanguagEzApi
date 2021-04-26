<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    public $table = 'languages';

    protected $fillable = [
        'name',
        'images'
    ];

    protected $casts = [
        'name' => 'json',
        'images' => 'string'
    ];
}
