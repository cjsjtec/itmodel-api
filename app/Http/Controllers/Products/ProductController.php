<?php
namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Lab123\Odin\Traits\ApiResponse;
use App\Repositories\Products\ProductRepository;
use Lab123\Odin\Requests\FilterRequest;

class ProductController extends Controller
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
	public function __construct(ProductRepository $repository)
	{
		$this->repository = $repository;
	}
	
	/**
	 * Create and display the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(FilterRequest $request)
	{	
		//return $this->success([$request->all()]);
		$this->fieldManager = $this->getFieldManager();
		
		$this->validate($request->request, $this->fieldManager->store());
		
		$input = $request->only('name', 'price', 'picture');
		
		$product = $this->repository->create($input);
		
		$categories = $request->input('categories');
		
		$product->categories()->attach($categories);

		return $this->created($product->load('categories'));
	}
}