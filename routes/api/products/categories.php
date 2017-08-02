<?php

use App\Http\Controllers\Products\ProductCategoryController;

Route::group(['prefix' => 'products',  'middleware' => 'jwt.auth'], function()
{
	Route::get('/categories', [
			'uses' => 'Products\ProductCategoryController@index'
	]);
});

