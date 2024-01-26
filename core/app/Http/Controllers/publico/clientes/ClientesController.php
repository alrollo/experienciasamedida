<?php

namespace App\Http\Controllers\publico\clientes;

use App\Http\Controllers\ControllerPublic;
use App\Models\Article;
use App\Repositories\ArticleRepository;
use App\Repositories\ReviewRepository;

class ClientesController extends ControllerPublic
{

    public function get(ReviewRepository $reviewRepository, $experiencia = '')
    {

        $opiniones = $reviewRepository->search(true, $experiencia)->orderBy('dateTime', 'desc')->get();

        return view('public/clientes/clientes', compact('opiniones'));
    }
}
