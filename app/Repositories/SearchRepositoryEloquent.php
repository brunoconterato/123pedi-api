<?php

namespace Drinking\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Drinking\Repositories\SearchRepository;
use Drinking\Models\Search;
use Drinking\Validators\SearchValidator;

/**
 * Class SearchRepositoryEloquent
 * @package namespace Drinking\Repositories;
 */
class SearchRepositoryEloquent extends BaseRepository implements SearchRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Search::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
