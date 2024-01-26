<?php

namespace App\Http\Controllers\publico\home;

use App\Http\Controllers\ControllerPublic;

class HomeController extends ControllerPublic
{
    public function get()
    {
        return view('public/home/home');
    }
}
