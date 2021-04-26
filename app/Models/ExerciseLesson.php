<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExerciseLesson extends Model
{
    use HasFactory;

    public $table = 'exercises';

    protected $fillable = [
        'languages_id',
        'type',
        'sentence',
        'translation',
        'og_word',
        'correct_word',
        'wrong_word'
    ];

    protected $casts = [
        'languages_id' => 'integer',
        'type' => 'integer',
        'sentence' => 'json',
        'translation' => 'json',
        'og_word' => 'json',
        'correct_word' => 'json',
        'wrong_word' => 'json'
    ];

}
