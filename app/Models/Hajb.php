<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hajb extends Model
{
    use HasFactory;

    protected $fillable = ['warith', 'count', 'blocker'];
}
