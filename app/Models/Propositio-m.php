<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proposition extends Model
{
    use HasFactory;

    protected $fillable = [
        'heir_id',
        'description',
        'fraction',
        'est_valide',
        'raison_invalide',
    ];

    public function heir()
    {
        return $this->belongsTo(Heir::class);
    }
}
