<?php

namespace App\Http\Controllers\publico\blog;

use App\Http\Controllers\ControllerPublic;
use App\Models\Article;
use App\Repositories\ArticleRepository;

class BlogController extends ControllerPublic
{

    public function get(ArticleRepository $articleRepository, $type = '')
    {
        $posts = $articleRepository->search($type)->orderBy('dateTime', 'desc')->get();

        return view('public/blog/blog', compact('posts'));
    }

    public function getByTitle(ArticleRepository $articleRepository, $title_slug)
    {

        $post = $articleRepository->getBySlug($title_slug, true);

        if ($post == null)
            abort(404);

        $ultimosPost = Article::where([['active', true]])
            ->orderBy('dateTime', 'desc')
            ->with(['images'])
            ->limit(3)
            ->get();

        return view('public/blog/post', compact('post', 'ultimosPost'));
    }
}
