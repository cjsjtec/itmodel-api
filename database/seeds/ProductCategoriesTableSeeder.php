<?php

use Illuminate\Database\Seeder;
use App\Entities\Products\ProductCategory;

class ProductCategoriesTableSeeder extends Seeder
{
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see \Illuminate\Database\Seeder::run()
	 */
	public function run()
	{
		$categories = [
			'Games','Eletrodomésticos','Móveis'
		];
		
		foreach ($categories as $category) {
			ProductCategory::create(['description' => $category]);
		}
	}
}
