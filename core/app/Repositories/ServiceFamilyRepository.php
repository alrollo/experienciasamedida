<?php

namespace App\Repositories;

use App\Models\ServiceFamily;
use Illuminate\Database\Eloquent\Builder;

class ServiceFamilyRepository
{
    protected ServiceFamily $model;

    public function __construct(ServiceFamily $model)
    {
        $this->model = $model;
    }

    /**
     * @param bool|null $active
     * @return Builder
     */
    public function search(?bool $active = null): Builder
    {
        $query = $this->model->select('*');

        if ($active != null) {
            $query->where([['active', $active]]);
        }

        return $query->with('images');
    }

    /**
     * @param string $slug
     * @param bool|null $active
     * @return ServiceFamily|null
     */
    public function getBySlug(string $slug, ?bool $active): ?ServiceFamily
    {
        $query =$this->model->where([['title_slug->'.app()->getLocale(), $slug]]);

        if ($active != null)
            $query->where('active', $active);

        return $query->first();
    }
}
