<?php

namespace Drinking\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class OAuthClient extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'oauth_clients';

    protected $fillable = [
        'id', 'email', 'user_id', 'name', 'secret', 'password_client',
        'personal_access_client', 'redirect', 'revoked'
    ];


}
