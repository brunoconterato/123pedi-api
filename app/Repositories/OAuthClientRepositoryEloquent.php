<?php

namespace Drinking\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Drinking\Repositories\OAuthClientRepository;
use Drinking\Models\OAuthClient;
use Drinking\Validators\OAuthClientValidator;

/**
 * Class OAuthClientRepositoryEloquent
 * @package namespace Drinking\Repositories;
 */
class OAuthClientRepositoryEloquent extends BaseRepository implements OAuthClientRepository
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
        return OAuthClient::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
