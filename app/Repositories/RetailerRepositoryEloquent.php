<?php

namespace Drinking\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Drinking\Repositories\RetailerRepository;
use Drinking\Models\Retailer;
use Drinking\Validators\RetailerValidator;

/**
 * Class RetailerRepositoryEloquent
 * @package namespace Drinking\Repositories;
 */
class RetailerRepositoryEloquent extends BaseRepository implements RetailerRepository
{
    public function pluck()
    {
        return $this->model->get(['id', 'user_id']);
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Retailer::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
