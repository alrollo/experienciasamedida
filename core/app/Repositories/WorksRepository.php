<?php

namespace App\Repositories;

use App\Models\Work;
use Illuminate\Database\Eloquent\Builder;


class WorksRepository
{
    protected Work $model;

    public function __construct(Work $model)
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
     * @param $slug
     * @param bool|null $active
     * @return News|null
     */
    public function getBySlug($slug, ?bool $active = null): ?News
    {
        $query = $this->model->where([['title_slug->'.app()->getLocale(), $slug]]);

        if ($active != null)
            $query->where('active', $active);

        return $query->first();
    }
}
