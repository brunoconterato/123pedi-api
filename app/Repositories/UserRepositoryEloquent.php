<?php

namespace Drinking\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Drinking\Repositories\UserRepository;
use Drinking\Models\User;
use Drinking\Validators\UserValidator;

/**
 * Class UserRepositoryEloquent
 * @package namespace Drinking\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    public function getByEmail($email){
        $result = $this->findWhere(['email' => $email]);

        $result = $result->first();

        return $result;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
