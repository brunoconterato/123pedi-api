<?php

namespace Drinking\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Drinking\Repositories\UserMessageGetterRepository;
use Drinking\Models\UserMessageGetter;
use Drinking\Validators\UserMessageGetterValidator;

/**
 * Class UserMessageGetterRepositoryEloquent
 * @package namespace Drinking\Repositories;
 */
class UserMessageGetterRepositoryEloquent extends BaseRepository implements UserMessageGetterRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UserMessageGetter::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
