<?php

namespace Drinking\Repositories;

use Carbon\Carbon;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Drinking\Repositories\OpenIntervalRepository;
use Drinking\Models\OpenInterval;

/**
 * Class OpenIntervalRepositoryEloquent
 * @package namespace Drinking\Repositories;
 */
class OpenIntervalRepositoryEloquent extends BaseRepository implements OpenIntervalRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OpenInterval::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
