<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class AboutController extends Controller
{
    function index()  {
        app()->setLocale("ar");
        return Inertia::render('About', [
            "text" => __("about.mawarith")
        ]);
    }
}
