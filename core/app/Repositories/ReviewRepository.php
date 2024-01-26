<?php

namespace App\Repositories;


use App\Models\Review;
use Illuminate\Database\Eloquent\Builder;

class ReviewRepository
{
    protected Review $model;

    public function __construct(Review $model)
    {
        $this->model = $model;
    }

    /**
     * @param bool|null $active
     * @return Builder
     */
    public function search(?bool $active = null, $experiencia): Builder
    {
        $query = $this->model->select('*');

        if ($active != null) {
            $query->where([['active', $active]]);
        }

        if ($experiencia != '') {
            $query->whereHas('experiencia', function($query) use ($experiencia) {
                $query->where('title_slug->'.app()->getLocale(), $experiencia);
            });
        }

        return $query->with('images');
    }
}
