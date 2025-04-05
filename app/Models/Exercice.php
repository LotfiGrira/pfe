<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercice extends Model
{
    use HasFactory;

    protected $fillable = ['titre'];

    public function propositions()
    {
        return $this->hasMany(Proposition::class, 'exercice_id');
    }
}