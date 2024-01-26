<?php

namespace App\Http\Controllers\publico\home;

use App\Http\Controllers\ControllerPublic;
use App\Models\Service;
use App\Models\ServiceFamily;

class HomeController extends ControllerPublic
{
    public function get()
    {

        $familias = ServiceFamily::where([['active', true]])
            ->with('images')
            ->orderBy('title', 'asc')
            ->get();

        $experiencias = Service::where([['active', true]])
            ->with('images')
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('public/home/home', compact('familias', 'experiencias'));
    }
}
