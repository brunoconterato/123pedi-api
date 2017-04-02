<?php

namespace Drinking\Repositories;

use Lcobucci\JWT\Signer\Key;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Drinking\Repositories\ProductRepository;
use Drinking\Models\Product;

/**
 * Class ProductRepositoryEloquent
 * @package namespace Drinking\Repositories;
 */
class ProductRepositoryEloquent extends BaseRepository implements ProductRepository
{
    public function pluck($column, $key = null)
    {
        return $this->model->pluck(['id', 'name', 'manufacturer', 'brand']);
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Product::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
