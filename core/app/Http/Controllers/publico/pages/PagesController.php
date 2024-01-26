<?php

namespace App\Http\Controllers\publico\pages;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllerPublic;
use App\Models\Page;
use App\Services\PagesService;

class PagesController extends ControllerPublic
{
    public function get(PagesService $pagesService, $url)
    {
        $page_id = $pagesService->GetIdByUrl($url);

        if ($page_id == null)
            abort(404);

        $page = Page::where('id', $page_id)->with('modules')->first();

        return view('public/pages/page', compact('page'));
    }
}
