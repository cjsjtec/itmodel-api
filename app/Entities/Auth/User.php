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
    protected $appends = [
    	'picture_url'
    ];
    
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
    
    /**
     * @param UploadedFile|string $image
     */
    public function setPictureAttribute($picture)
    {
    	if (is_string($picture) || is_null($picture) ) {
    		$this->attributes['picture'] = $picture;
    		return;
    	}
    	
    	$this->attributes['picture'] = (new ImageProfile())->updateOrCreate(
    			$this->picture,
    			$picture,
    			'thumb-'.uniqid()
    			);
    }
    
    /**
     * Get full url for picture
     *
     * @return boolean
     */
    public function getPictureUrlAttribute()
    {
    	if (!$this->picture) {
    		return env('DEFAULT_PROFILE_PICTURE');
    	}
    	
    	return config('filesystems.urls.profile-url') . "/{$this->picture}";
    }
}
