<?php

namespace App\Http\Controllers\publico\experiencias;

use App\Http\Controllers\ControllerPublic;
use App\Models\Service;
use App\Models\ServiceFamily;
use App\Repositories\ServiceRepository;


class ExperienciasController extends ControllerPublic
{

    public function get()
    {
        $familias = ServiceFamily::where([['active', true]])
            ->orderBy('title', 'asc')
            ->with('images')
            ->get();

        return view('public/experiencias/experiencias', compact('familias'));
    }

    public function getFamily($type)
    {
        $familia = ServiceFamily::where([['active', true],['title_slug->'.app()->getLocale(), $type]])
            ->with('images', 'services')
            ->first();

        if ($familia == null)
            abort(404);

        $familias = ServiceFamily::where([['active', true]])
            ->orderBy('title', 'asc')
            ->with('images')
            ->get();

        return view('public/experiencias/experiencias-listado', compact('familia', 'familias'));
    }

    public function getByTitle(ServiceRepository $serviceRepository, $title_slug)
    {
        $servicio = $serviceRepository->getBySlug($title_slug, true);

        if ($servicio == null)
            abort(404);

        $familias = ServiceFamily::where([['active', true]])
            ->orderBy('title', 'asc')
            ->with('images')
            ->get();

        return view('public/experiencias/experiencia', compact('servicio', 'familias'));
    }
}
