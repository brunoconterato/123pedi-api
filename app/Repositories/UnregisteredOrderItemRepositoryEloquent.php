<?php

namespace Drinking\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Drinking\Repositories\UnregisteredOrderItemRepository;
use Drinking\Models\UnregisteredOrderItem;
use Drinking\Validators\UnregisteredOrderItemValidator;

/**
 * Class UnregisteredOrderItemRepositoryEloquent
 * @package namespace Drinking\Repositories;
 */
class UnregisteredOrderItemRepositoryEloquent extends BaseRepository implements UnregisteredOrderItemRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UnregisteredOrderItem::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
