<?php

use Illuminate\Database\Seeder;
use App\Entities\Auth\User;

class UsersTableSeeder extends Seeder
{

    /**
     * (non-PHPdoc)
     *
     * @see \Illuminate\Database\Seeder::run()
     */
    public function run()
    {	
    	$user = User::create([
    		'name' => 'Cloves Junior',
    		'document_number' => '39738976898',
    		'picture' => '',
    		'password' => '12345678',
    		'email' => 'cjsj.tec@gmail.com',
    		'cellphone' => '11999999999',
    	]);
    }
}
