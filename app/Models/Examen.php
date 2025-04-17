<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
    use HasFactory;

    protected $fillable = ['titre']; // ajoute d'autres champs si besoin

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
