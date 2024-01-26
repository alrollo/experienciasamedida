<?php

namespace App\Http\Controllers\intranet\dashboard;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function get()
    {
        return view('intranet/dashboard/dashboard');
    }

}
