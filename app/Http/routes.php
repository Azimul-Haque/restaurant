<?php

Route::get('/',['as'=>'index.index','uses'=>'IndexController@index']);

Route::auth();

Route::group(['middleware' => ['auth']], function() {

	Route::get('dashboard', ['as'=>'dashboard','uses'=>'DashboardController@index']);

	Route::resource('users','UserController');

	Route::get('roles',['as'=>'roles.index','uses'=>'RoleController@index']);
	Route::get('roles/create',['as'=>'roles.create','uses'=>'RoleController@create']);
	Route::post('roles/create',['as'=>'roles.store','uses'=>'RoleController@store']);
	Route::get('roles/{id}',['as'=>'roles.show','uses'=>'RoleController@show']);
	Route::get('roles/{id}/edit',['as'=>'roles.edit','uses'=>'RoleController@edit']);
	Route::patch('roles/{id}',['as'=>'roles.update','uses'=>'RoleController@update']);
	Route::delete('roles/{id}',['as'=>'roles.destroy','uses'=>'RoleController@destroy']);

	Route::get('sms',['as'=>'sms.index','uses'=>'SmsController@sendsms']);

	Route::resource('receipts','ReceiptController');
	Route::get('accounts',['as'=>'receipts.accounts','uses'=>'ReceiptController@getaccounts']);
	Route::resource('commodities','CommodityController');
	Route::resource('categories','CategoryController');
});

