<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Heir extends Model
{
    use HasFactory;

    protected $fillable = [
        'heritage_id',
        'nom',
        'lien',
        'sexe',
        'is_alive',
    ];

    public function heritage()
    {
        return $this->belongsTo(Heritage::class);
    }

    public function propositions()
    {
        return $this->hasMany(Propositio-m::class);
    }
}
