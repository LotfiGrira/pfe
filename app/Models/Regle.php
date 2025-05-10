<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Regle extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'heir_type',
        'condition',
        'effet',
        'cible',
    ];
}
