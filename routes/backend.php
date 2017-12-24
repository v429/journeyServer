<?php
/**
 * 后台管理系统路由白名单
 */

Route::group(['prefix' => 'backend'], function() {
	//需要登录权限验证的
	Route::group(['middleware' => 'auth'], function(){
		Route::get('/', 'Backend\ActiveController@index');
		//活动相关
		Route::get('active/list', 'Backend\ActiveController@index');

		//管理员相关
		Route::get('admin/list', 'Backend\AdminController@adminList');
		Route::get('admin/add', 'Backend\AdminController@add');
		Route::get('admin/edit', 'Backend\AdminController@edit');

		//系统相关
		Route::get('role/list', 'Backend\SystemController@roleList');
		Route::get('role/add', 'Backend\SystemController@addRole');
		Route::get('role/edit', 'Backend\SystemController@editRole');
		Route::get('auth/list', 'Backend\SystemController@authList');
		Route::get('auth/add', 'Backend\SystemController@addAuth');
		Route::get('auth/edit', 'Backend\SystemController@editAuth');
	});

	//不需要登录权限验证
	Route::get('login', 'Backend\AdminController@login');
	Route::get('logout', 'Backend\AdminController@logout');

	Route::post('login', 'Backend\AdminController@doLogin');
	Route::post('admin/create', 'Backend\AdminController@create');
	Route::post('admin/update', 'Backend\AdminController@update');
	Route::post('admin/change-status', 'Backend\AdminController@changeStatus');
	Route::post('role/create', 'Backend\SystemController@createRole');
	Route::post('role/update', 'Backend\SystemController@updateRole');
	Route::post('auth/create', 'Backend\SystemController@createAuth');
	Route::post('auth/update', 'Backend\SystemController@updateAuth');
	Route::post('auth/del', 'Backend\SystemController@delAuth');
});

