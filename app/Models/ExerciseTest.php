<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExerciseTest extends Model
{
    use HasFactory;

    public $table = 'exercises_tests';

    protected $fillable = [
        'tests_id',
        'type',
        'sentence',
        'translation',
        'og_word',
        'correct_word',
        'wrong_word'
    ];

    protected $casts = [
        'tests_id' => 'integer',
        'type' => 'integer',
        'sentence' => 'json',
        'translation' => 'json',
        'og_word' => 'json',
        'correct_word' => 'json',
        'wrong_word' => 'json'
    ];
}
