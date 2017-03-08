<?php

namespace Drinking\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Drinking\Repositories\UnregisteredOrderRepository;
use Drinking\Models\UnregisteredOrder;
use Drinking\Validators\UnregisteredOrderValidator;

/**
 * Class UnregisteredOrderRepositoryEloquent
 * @package namespace Drinking\Repositories;
 */
class UnregisteredOrderRepositoryEloquent extends BaseRepository implements UnregisteredOrderRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UnregisteredOrder::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
