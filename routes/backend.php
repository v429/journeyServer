<?php
Route::post('backend/login', 'Backend\AdminController@doLogin');
Route::get('backend/login', 'Backend\AdminController@login');

Route::group(['prefix' => 'backend', 'middleware' => 'auth'], function() {
	Route::get('/', 'Backend\ActiveController@index');
	//活动相关
	Route::get('active/list', 'Backend\ActiveController@index');

	//管理员相关
	Route::get('admin/list', 'Backend\AdminController@adminList');
	Route::get('admin/add', 'Backend\AdminController@add');
	Route::post('admin/create', 'Backend\AdminController@create');
});
