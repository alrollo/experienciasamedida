<?php

namespace App\Http\Controllers\publico\articles;

use App\Http\Controllers\ControllerPublic;
use App\Repositories\ArticleRepository;

class ArticlesController extends ControllerPublic
{
    protected ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function grid($type = '')
    {
        $articles = $this->articleRepository->searchByType($type)
            ->where('active', true)
            ->simplePaginate(6);
        return view('public/articles/articles', compact('articles'));
    }

    public function detail($slug)
    {
        $article = $this->articleRepository->getBySlug($slug);

        if ($article == null)
            abort(404);

        return view('public/articles/article', compact('article'));
    }
}
