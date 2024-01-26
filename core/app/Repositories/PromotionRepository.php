<?php

namespace App\Repositories;

use App\Models\Promotion;
use Illuminate\Database\Eloquent\Builder;

class PromotionRepository
{
    protected Promotion $model;

    public function __construct(Promotion $model)
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
     * @param bool|null $feature
     * @return Promotion|null
     */
    public function getBySlug($slug, ?bool $active = null, ?bool $feature = null): ?Promotion
    {
        $query = $this->model->where([['title_slug->'.app()->getLocale(), $slug]]);

        if ($active != null)
            $query->where('active', $active);
        if ($feature != null)
            $query->where('feature', $feature);

        return $query->first();
    }
}
