<?php

namespace App\Entities\Auth;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use App\Entities\Entity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Entity implements AuthenticatableContract, AuthorizableContract
{
	use Notifiable, SoftDeletes, Authenticatable, Authorizable;

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
    protected $fieldManager = \App\FieldManagers\Auth\UserFieldManager::class;
    
    /**
     *
     * @param string $value
     */
    public function setPasswordAttribute($password)
    {
    	if (Hash::needsRehash($password)) {
    		$password = Hash::make($password);
    	}
    	
    	$this->attributes['password'] = $password;
    }
    
    
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
    	return $this->getKey();
    }
    
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
    	return [];
    }
}
