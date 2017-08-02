<?php
namespace App\FieldManagers\Products;

use App\FieldManagers\FieldManager;

class ProductFieldManager extends FieldManager
{

    /**
     * General rules to validate this request.
     *
     * @var $rules
     */
    protected $fields = [
        'id' => [],
        
        'name' => [
            'rules' => 'min:3|max:150'
        ],
    	
        'price' => [
        	'rules' => 'numeric'
        ],
		
    	'picture' => [
    		'rules' => 'image|mimes:jpg,png'
    	]	
    ];
    
    public function store()
    {
    	$fields = [
    			'name' => 'required',
    			'price' => 'required',
    			'picture' => 'required'
    	];
    	
    	return $this->rules($fields);
    }
    
}