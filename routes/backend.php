<?php

Route::any('backend/login', 'Backend\AdminController@login');
Route::get('/', 'Backend\ActiveController@index');

Route::group(['prefix' => 'backend', 'middleware' => 'auth'], function() {

	Route::get('active/list', 'Backend\ActiveController@index');
});
