<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposition extends Model
{
    use HasFactory;

    protected $fillable = ['propos', 'is_true', 'question_id'];

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
    
}