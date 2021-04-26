<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    public $table = 'tests';

    protected $fillable = [
        'name',
        'languages_id'
    ];

    protected $casts = [
        'name' => 'json',
        'languages_id' => 'integer'
    ];
}
