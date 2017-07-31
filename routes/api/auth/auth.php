<?php

Route::post('auth/login',[
	'uses' => 'Auth\AuthController@postLogin'
]);


Route::group(['prefix' => 'auth',  'middleware' => 'auth.api'], function()
{
	Route::post('logout', [
			'uses' => 'Auth\AuthController@getLogout'
	]);
	
	Route::get('authorized', [
			'uses' => 'Auth\AuthController@getValidate'
	]);
	
	Route::get('refresh', [
			'uses' => 'Auth\AuthController@getRefresh'
	]);
	
});