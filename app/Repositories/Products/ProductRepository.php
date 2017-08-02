<?php
namespace App\Repositories\Products;


use App\Repositories\Repository;
use App\Entities\Products\Product;

class ProductRepository extends Repository
{
    /**
     *
     * @var Product
     */
    protected $model;

    public function __construct()
    {
        $this->model = new Product();
    }

}