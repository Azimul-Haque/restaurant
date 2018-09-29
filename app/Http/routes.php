<?php

Route::get('/phpinfo', function () {
    phpinfo(); 
});

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

	Route::resource('receipts','ReceiptController');
	Route::resource('commodities','CommodityController');
	Route::resource('categories','CategoryController');
	Route::resource('stocks','StockController');
	Route::resource('usages','UsageController');
	Route::resource('sources','SourceController');

	Route::get('income',['as'=>'receipts.income','uses'=>'ReceiptController@getIncome']);
	Route::get('expenditure',['as'=>'commodities.expenditure','uses'=>'CommodityController@getExpenditure']);
	Route::get('sales', ['as'=>'receipts.sales','uses'=>'ReceiptController@getSales']);

	// APIs
	Route::get('categories/getcategoryunit/{id}','CategoryController@getCategoryUnitAPI');
	Route::get('receipt/search/{receiptno}', ['as'=>'receipts.search','uses'=>'ReceiptController@searchReceiptAPI']);

	// Report Generation Controller
	Route::get('/reports', ['as'=>'reports.index','uses'=>'ReportController@getIndex']);
	Route::get('/reports/export/commodity/pdf', ['as'=>'reports.getcommoditypdf','uses'=>'ReportController@getPDFCommodity']);
	Route::get('/reports/export/stock/pdf', ['as'=>'reports.getstockpdf','uses'=>'ReportController@getPDFStock']);
	Route::get('/reports/export/source/pdf', ['as'=>'reports.getsourcepdf','uses'=>'ReportController@getPDFSource']);
	Route::get('/reports/export/usage/pdf', ['as'=>'reports.getusagepdf','uses'=>'ReportController@getPDFUsage']);
	Route::get('/reports/export/itemwise/pdf', ['as'=>'reports.getincomepdf','uses'=>'ReportController@getPDFIncome']);
});