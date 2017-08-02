<?php

namespace App\Entities\Products;

use App\Entities\Entity;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\Uploaders\Products\ImageProduct;


class Product extends Entity
{
	use SoftDeletes;
	
	protected $table = 'products';
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id',
		'name',
		'price',
		'picture',
	];
	
	/**
	 * Class Fields Manage.
	 *
	 * @var $fieldManager
	 */
	protected $fieldManager = \App\FieldManagers\Products\ProductFieldManager::class;
	
	
	public function categories()
	{
		return $this->belongsToMany('App\Entities\Products\ProductCategory','products_product_categories', 'id_products', 'id_product_categories');
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
		
		$this->attributes['picture'] = (new ImageProduct())->updateOrCreate(
			$this->picture,
			$picture,
			uniqid()
		);
	}
}
