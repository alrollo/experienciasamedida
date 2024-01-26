<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository
{
    protected Product $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    /**
     * @param int $family_id
     * @return Builder
     */
    public function search(int $family_id): Builder
    {
        $query = $this->model->select('*')->where([['family_id', $family_id]]);
        return $query->with('images');
    }

    /**
     * @param string $slug
     * @param bool|null $active
     * @return Product|null
     */
    public function getBySlug(string $slug, ?bool $active): ?Product
    {
        $query =$this->model->where([['title_slug->'.app()->getLocale(), $slug]]);

        if ($active != null)
            $query->where('active', $active);

        return $query->first();
    }
}
