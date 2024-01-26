<?php

namespace App\Repositories;

use App\Models\ProductFamily;
use Illuminate\Database\Eloquent\Builder;

class ProductFamilyRepository
{
    protected ProductFamily $model;

    public function __construct(ProductFamily $model)
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
     * @return ProductFamily|null
     */
    public function getBySlug(string $slug, ?bool $active): ?ProductFamily
    {
        $query =$this->model->where([['title_slug->'.app()->getLocale(), $slug]]);

        if ($active != null)
            $query->where('active', $active);

        return $query->first();
    }
}
