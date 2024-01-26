<?php

namespace App\Repositories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;


class ArticleRepository
{
    protected Article $model;

    public function __construct(Article $model)
    {
        $this->model = $model;
    }

    /**
     * @param string $type
     * @return Builder
     */
    public function search(string $type = ''): Builder
    {
        $query = $this->model->select('*');

        if ($type != '') {
            $query->whereHas('type', function($query) use ($type) {
                $query->where('option_slug->'.app()->getLocale(), $type);
            });
        }

        return $query->with('images');
    }

    /**
     * @param string $slug
     * @param bool|null $active
     * @return Article|null
     */
    public function getBySlug(string $slug, ?bool $active): ?Article
    {
        $query =$this->model->where([['title_slug->'.app()->getLocale(), $slug]]);

        if ($active != null)
            $query->where('active', $active);

        return $query->first();
    }
}
