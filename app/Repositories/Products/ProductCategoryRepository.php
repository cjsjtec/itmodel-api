<?php
namespace App\Repositories\Products;


use App\Repositories\Repository;
use App\Entities\Products\ProductCategory;

class ProductCategoryRepository extends Repository
{
    /**
     *
     * @var Product
     */
    protected $model;

    public function __construct()
    {
        $this->model = new ProductCategory();
    }

}