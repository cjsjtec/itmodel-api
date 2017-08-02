<?php
namespace App\FieldManagers\Auth;

use App\FieldManagers\FieldManager;

class UserFieldManager extends FieldManager
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
    	
        'document_number' => [
            'rules' => 'min:11|max:18'
        ],
        
        'birthdate' => [
            'rules' => ''
        ],
        
        'picture' => [],
        
        'email' => [
            'rules' => 'min:5|max:254|email'
        ],
        
        'password' => [
            'rules' => 'min:8|max:14'
        ],
        
        'cellphone' => [
            'rules' => 'min:11|max:15'
        ],
    	'picture_url' => []	
    ];

    public function store()
    {
        $fields = [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'password_confirmation' => 'required',
            'document_number' => 'required'
        ];
        
        return $this->rules($fields);
    }
    
    public function autenticate()
    {
    	$fields =  [
    		'password' => 'required',
    		'email' => 'required'
    	];
    	
    	return $this->rules($fields);
    }
}