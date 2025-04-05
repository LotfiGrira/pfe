<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ListeHeritierController extends Controller
{
    public function index()
    {
        return view('listeheritier');
    }
}
