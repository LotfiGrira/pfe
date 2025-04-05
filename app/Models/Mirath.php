<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mirath extends Model
{
    use HasFactory;

    protected $fillable = ['warith', 'sharh', 'bast', 'maqam', 'ta3seeb'];
}
