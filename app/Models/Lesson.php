<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    public $table = 'lessons';

    protected $fillable = [
        'languages_id',
        'title',
        'theory'
    ];

    protected $casts = [
        'languages_id' => 'integer',
        'title' => 'json',
        'theoy' => 'json'
    ];
}
