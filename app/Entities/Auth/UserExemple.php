<?php

namespace App\Entities\Auth;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Laravel\Lumen\Auth\Authorizable as BaseAuthorizable;
use App\Entities\Entity;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class UserExemple extends Entity implements AuthenticatableContract, AuthorizableContract, JWTSubject, CanResetPasswordContract 
{
	use Authenticatable, BaseAuthorizable, Authorizable, CanResetPassword, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'document_number',
        'birthdate',
        'picture',
        'email',
        'password',
        'cellphone',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];

    /**
     * Class Fields Manage.
     *
     * @var $fieldManager
     */
    //protected $fieldManager = \App\FieldManagers\Auth\UserFieldManager::class;
}