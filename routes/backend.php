<?php
Route::post('backend/login', 'Backend\AdminController@doLogin');
Route::get('backend/login', 'Backend\AdminController@login');

Route::group(['prefix' => 'backend'], function() {
	Route::group(['middleware' => 'auth'], function(){
		Route::get('/', 'Backend\ActiveController@index');
		//活动相关
		Route::get('active/list', 'Backend\ActiveController@index');

		//管理员相关
		Route::get('admin/list', 'Backend\AdminController@adminList');
		Route::get('admin/add', 'Backend\AdminController@add');
		Route::get('admin/edit', 'Backend\AdminController@edit');
	});

	Route::post('admin/create', 'Backend\AdminController@create');
	Route::post('admin/update', 'Backend\AdminController@update');

});


