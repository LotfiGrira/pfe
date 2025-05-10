<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Heritage extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
    ];

    public function heirs()
    {
        return $this->hasMany(Heir::class);
    }
}
