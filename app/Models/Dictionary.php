<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dictionary extends Model
{
    use HasFactory;

    public $table = 'dictionaries';

    protected $fillable = [
        'og_word',
        'tr_word',
        'pr_word',
        'languages_id'
    ];

    protected $casts = [
        'og_word' => 'string',
        'tr_word' => 'json',
        'pr_word' => 'string',
        'languages_id' => 'integer'
    ];
}
