<?php

Route::group(['prefix' => 'products',  'middleware' => 'jwt.auth'], function()
{
	Route::post('', [
			'uses' => 'Products\ProductController@store'
	]);
	
	Route::post('/{id}', [
			'uses' => 'Products\ProductController@update'
	]);
	
	Route::get('{id}', [
			'uses' => 'Products\ProductController@show'
	]);
	
	Route::get('', [
			'uses' => 'Products\ProductController@index'
	]);
	
	Route::delete('{id}', [
			'uses' => 'Products\ProductController@destroy'
	]);
});
