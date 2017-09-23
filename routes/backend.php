<?php


Route::group(['prefix' => 'backend'], function() {
	Route::get('active/list', 'Backend\ActiveController@index');
});
