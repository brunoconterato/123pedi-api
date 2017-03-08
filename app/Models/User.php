<?php

namespace Drinking\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements Transformable,
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use TransformableTrait, Authenticatable, Authorizable, CanResetPassword, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    protected $table = 'users';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function client(){
        return $this->hasOne(Client::class);
    }

    public function retailer(){
        #return $this->hasOne(retailer::class, 'id', 'id');
        return $this->hasOne(Retailer::class);
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
//    public function getAuthIdentifierName()
//    {
//        // TODO: Implement getAuthIdentifierName() method.
//    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
//    public function getAuthIdentifier()
//    {
//        // TODO: Implement getAuthIdentifier() method.
//    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
//    public function getAuthPassword()
//    {
//        // TODO: Implement getAuthPassword() method.
//    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
//    public function getRememberToken()
//    {
//        // TODO: Implement getRememberToken() method.
//    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string $value
     * @return void
     */
//    public function setRememberToken($value)
//    {
//        // TODO: Implement setRememberToken() method.
//    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
//    public function getRememberTokenName()
//    {
//        // TODO: Implement getRememberTokenName() method.
//    }
}