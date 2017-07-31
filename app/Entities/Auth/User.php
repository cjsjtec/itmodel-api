<?php

namespace App\Entities\Auth;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use App\Entities\Entity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;


class User extends Entity implements AuthenticatableContract
{
	use Notifiable, SoftDeletes, Authenticatable;

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
    
}
