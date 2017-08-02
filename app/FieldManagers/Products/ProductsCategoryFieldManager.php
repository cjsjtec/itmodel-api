<?php
namespace App\FieldManagers\Products;

use App\FieldManagers\FieldManager;

class ProductsCategoryFieldManager extends FieldManager
{

    /**
     * General rules to validate this request.
     *
     * @var $rules
     */
    protected $fields = [
        'id' => [],
        
        'description' => [
            'rules' => 'min:3|max:150'
        ],
    ];
}