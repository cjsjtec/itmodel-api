<?php
namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Lab123\Odin\Traits\ApiResponse;
use App\Repositories\Products\ProductRepository;
use App\Repositories\Products\ProductCategoryRepository;

class ProductCategoryController extends Controller
{
	use ApiResponse;
	
	/**
	 *
	 * @var ProductRepository $repository
	 */
	protected $repository;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @return void
	 */
	public function __construct(ProductCategoryRepository $repository)
	{
		$this->repository = $repository;
	}
}