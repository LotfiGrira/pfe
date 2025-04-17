<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['titre', 'examen_id'];

    public function examen()
    {
        return $this->belongsTo(Examen::class);
    }

    public function propositions()
    {
        return $this->hasMany(Proposition::class);
    }
}