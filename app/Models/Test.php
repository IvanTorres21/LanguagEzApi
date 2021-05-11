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

    
    public function exercises() {
        return $this->hasMany('App\Models\ExerciseTest', 'tests_id');
    }
}
