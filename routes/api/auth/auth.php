<?php

use App\Http\Controllers\Auth\AuthController;

Route::post('auth/login',[
	'uses' => 'Auth\AuthController@postLogin'
]);

Route::group(['prefix' => 'auth',  'middleware' => 'jwt.auth'], function()
{
	Route::post('logout', [
			'uses' => 'Auth\AuthController@logout'
	]);
	
	Route::get('authorized', [
			'uses' => 'Auth\AuthController@getValidate'
	]);
	
	Route::get('refresh', [
			'uses' => 'Auth\AuthController@getRefresh'
	]);
	
});
