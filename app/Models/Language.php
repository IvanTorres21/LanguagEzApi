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
        'image',
        'visible'
    ];

    protected $casts = [
        'name' => 'json',
        'image' => 'string',
        'visible' => 'boolean'
    ];
    
    public function lessons() {
        return $this->hasMany('App\Models\Lesson', 'languages_id');
    }
    
    public function tests() {
        return $this->hasMany('App\Models\Test', 'languages_id');
    }
}
