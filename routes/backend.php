<?php
Route::post('backend/login', 'Backend\AdminController@doLogin');
Route::get('backend/login', 'Backend\AdminController@login');

Route::group(['prefix' => 'backend', 'middleware' => 'auth'], function() {
	Route::get('/', 'Backend\ActiveController@index');
	Route::get('active/list', 'Backend\ActiveController@index');
});
