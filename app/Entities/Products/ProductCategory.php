<?php

namespace App\Entities\Products;

use App\Entities\Entity;

class ProductCategory extends Entity
{
	protected $table = 'product_categories';
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
			'id',
			'name'
	];
	
	/**
	 * Class Fields Manage.
	 *
	 * @var $fieldManager
	 */
	protected $fieldManager = \App\FieldManagers\Products\ProductsCategoryFieldManager::class;
	
	public function products()
	{
		return $this->belongsToMany('App\Entities\Products\Product','products_product_categories', 'id_product_categories', 'id_products');
		
	}
	
}
