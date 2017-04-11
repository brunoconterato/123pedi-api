<?php

namespace Drinking\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Drinking\Repositories\CartItemGetterRepository;
use Drinking\Models\CartItemGetter;
use Drinking\Validators\CartItemGetterValidator;

/**
 * Class CartItemGetterRepositoryEloquent
 * @package namespace Drinking\Repositories;
 */
class CartItemGetterRepositoryEloquent extends BaseRepository implements CartItemGetterRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CartItemGetter::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
