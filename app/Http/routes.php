<?php

Route::get('/clear', ['as'=>'clear', 'uses'=>'IndexController@clear']);

Route::get('/', ['as'=>'index.index','uses'=>'IndexController@index']);

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
	Route::resource('waiters','WaiterController');

	Route::get('income',['as'=>'receipts.income','uses'=>'ReceiptController@getIncome']);
	Route::get('expenditure',['as'=>'commodities.expenditure','uses'=>'DashboardController@getExpenditure']);
	Route::get('sales', ['as'=>'receipts.sales','uses'=>'ReceiptController@getSales']);
	Route::get('deleted/receipts', ['as'=>'receipts.deleted','uses'=>'ReceiptController@getDeleted']);
	Route::get('deleted/commodities', ['as'=>'commodities.deleted','uses'=>'CommodityController@getDeleted']);
	Route::post('delete/all/commodities', ['as'=>'commodities.delete.all','uses'=>'CommodityController@deleteAllCommodities']);

	// APIs
	Route::get('categories/getcategoryunit/{id}','CategoryController@getCategoryUnitAPI');
	Route::get('stocks/getcategorymax/{category_id}','StockController@getCategoryMaxAPI');
	Route::get('receipt/search/{receiptno}', ['as'=>'receipts.search','uses'=>'ReceiptController@searchReceiptAPI']);

	// Source Print from Category & Source Page
	Route::get('print/sources/normal', ['as'=>'sources.print.normal','uses'=>'SourceController@printSourcesNormal']);
	// Receipt print route through POS
	Route::get('receipt/print/{receiptno}', ['as'=>'receipt.print','uses'=>'ReceiptController@printReceipt']);
	Route::get('receipt/sales/{date}', ['as'=>'sales.print','uses'=>'ReceiptController@printSales']);

	// Report Generation Controller
	Route::get('/reports', ['as'=>'reports.index','uses'=>'ReportController@getIndex']);
	Route::get('/reports/export/commodity/pdf', ['as'=>'reports.getcommoditypdf','uses'=>'ReportController@getPDFCommodity']);
	Route::get('/reports/export/stock/pdf', ['as'=>'reports.getstockpdf','uses'=>'ReportController@getPDFStock']);
	Route::get('/reports/export/qikstock/pdf', ['as'=>'reports.getqikstockpdf','uses'=>'ReportController@getPDFQIKStock']);
	Route::get('/reports/export/source/pdf', ['as'=>'reports.getsourcepdf','uses'=>'ReportController@getPDFSource']);
	Route::get('/reports/export/usage/pdf', ['as'=>'reports.getusagepdf','uses'=>'ReportController@getPDFUsage']);
	Route::get('/reports/export/qikusage/pdf', ['as'=>'reports.getqikusagepdf','uses'=>'ReportController@getPDFQIKUsage']);
	Route::get('/reports/export/datewise/income/pdf', ['as'=>'reports.getincomepdf','uses'=>'ReportController@getPDFIncome']);
	Route::get('/reports/export/datewise/expense/pdf', ['as'=>'reports.getexpensepdf','uses'=>'ReportController@getPDFExpense']);
	Route::get('/reports/export/members/pdf', ['as'=>'reports.getmembers','uses'=>'ReportController@getPDFMember']);
	Route::get('/reports/export/items/date/wise/pdf', ['as'=>'reports.getitemsdatewise','uses'=>'ReportController@getPDFItemsDateWise']);
	Route::get('/reports/export/sms/history/pdf', ['as'=>'reports.getsmshistory','uses'=>'ReportController@getPDFSMSHistory']);
	Route::get('/reports/export/stuffs/payment/pdf', ['as'=>'reports.getstuffspaymentpdf','uses'=>'ReportController@getPDFStuffsPayment']);
	Route::get('/reports/export/single/stuff/payment/pdf', ['as'=>'reports.getsinglestuffpdf','uses'=>'ReportController@getPDFSingleStuffPayment']);
	Route::get('/reports/export/all/source/report/pdf', ['as'=>'reports.getallsourcepdf','uses'=>'ReportController@getPDFAllSource']);

	// QIK Stocks and Usages
	Route::get('qikstocks', ['as' => 'qikstocks.index', 'uses' => 'QikstockController@index']);
	Route::post('qikstocks/store', ['as' => 'qikstocks.store', 'uses' => 'QikstockController@store']);
	Route::put('qikstocks/{id}', ['as' => 'qikstocks.update', 'uses' => 'QikstockController@update']);
	Route::post('qikstocks/usage', ['as' => 'qikstocks.storeusage', 'uses' => 'QikstockController@storeUsage']);
	Route::get('qikusage', ['as' => 'qikstocks.qikusage', 'uses' => 'QikstockController@getQIKUsage']);

	Route::delete('qikstocks/usage/delete/{id}', ['as' => 'qikstocks.deleteqikusage', 'uses' => 'QikstockController@deleteQIKUsage']);
	Route::get('qikstocks/getqikstockunit/{id}', 'QikstockController@getQIKStockUnitAPI');
	Route::get('qikstocks/getqikstockmax/{id}', 'QikstockController@getQIKStockMaxAPI');
	// QIK Stocks and Usages

	// POS Print from Report
	Route::get('/reports/export/source/pos', ['as'=>'reports.getsourcepos','uses'=>'ReportController@getPOSSource']);

	// Membership Controller
	Route::get('/membership', ['as'=>'membership.index','uses'=>'MembershipController@getIndex']);
	Route::post('/membership', ['as'=>'membership.store','uses'=>'MembershipController@store']);
	Route::post('/direct_contact/membership', ['as'=>'membership.store_direct_contact','uses'=>'MembershipController@storeDirectContact']);
	Route::put('/membership/{id}', ['as'=>'membership.update','uses'=>'MembershipController@update']);
	Route::patch('/membership/award/{id}', ['as'=>'membership.award','uses'=>'MembershipController@award']);
	Route::post('/membership/send/sms/{id}', ['as'=>'membership.singlesms','uses'=>'MembershipController@sendSingleSMS']);
	Route::delete('/membership/{id}', ['as'=>'membership.destroy','uses'=>'MembershipController@destroy']);

	// Stuffs Management
	Route::get('/stuffs', ['as'=>'stuffs.index','uses'=>'StuffController@index']);
	Route::post('/stuffs/store', ['as'=>'stuffs.store','uses'=>'StuffController@store']);
	Route::put('/stuffs/{id}', ['as'=>'stuffs.update','uses'=>'StuffController@update']);
	Route::post('/stuffs/payment', ['as'=>'stuffs.payment','uses'=>'StuffController@staffPayment']);
	Route::put('/stuffs/payment/{id}', ['as'=>'stuffs.payment.update','uses'=>'StuffController@updatePayment']);
	Route::delete('/stuffs/payment/{id}', ['as'=>'stuffs.payment.destroy','uses'=>'StuffController@destroyPayment']);
	// Stuffs Management

	// website homepage design
	Route::get('/design', ['as'=>'design.index','uses'=>'DesignController@index']);
	Route::post('/design/store/about/us', ['as'=>'design.store.aboutus','uses'=>'DesignController@storeAboutUs']);
	Route::post('/design/store/menu/item', ['as'=>'design.store.menuitem','uses'=>'DesignController@storeMenuItem']);
	Route::put('/design/update/menu/item/{id}', ['as'=>'design.update.menuitem','uses'=>'DesignController@updateMenuItem']);
	Route::delete('/design/delete/menu/item/{id}', ['as'=>'design.destroy.menuitem','uses'=>'DesignController@destroyMenuItem']);
	Route::post('/design/store/slider/image', ['as'=>'design.store.sliderimg','uses'=>'DesignController@storeSliderImg']); 
	Route::delete('/design/delete/slider/image/{id}', ['as'=>'design.destroy.slideritem','uses'=>'DesignController@destroySliderImage']);

	
	// SMS Admin Panel
	Route::get('/sms/admin', ['as'=>'sms.admin','uses'=>'SmsController@getAdmin']);
	Route::post('/sms/add/sms', ['as'=>'sms.addsms','uses'=>'SmsController@addSms']);
	// SMS Admin Panel

	Route::get('/sms', ['as'=>'sms.index','uses'=>'SmsController@index']);
	Route::post('/sms/send/bulk', ['as'=>'sms.sendbulk','uses'=>'SmsController@sendBulk']);
	Route::get('/sms/soap/test', ['as'=>'sms.soaptest','uses'=>'SmsController@soapTest']);
});

	// Public APIs
	Route::get('member/points/{phone}','IndexController@getMemberAPI');
	Route::post('subsribe/new/member', ['as' => 'index.subscribe', 'uses' => 'IndexController@subscribe']);
	
	Route::any('{query}', 
	  function() { return redirect('/'); })
	  ->where('query', '.*');