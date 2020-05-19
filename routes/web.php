<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    //return view('welcome');
    return redirect(route('login'));
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' =>['user']], function(){
	Route::get(
		'/profile/create-user',
		'ProfileController@createUser')
		->name('createUser')
		->middleware(['user','auth']);
	
	Route::post(
		'/profile/store-create-user',
		'ProfileController@storeCreateUser')
		->name('storeCreateUser')
		->middleware(['user','auth']);

	//route for delete delivery receipt
	Route::delete('/lolo-pinoy-lechon-de-cebu/delete-delivery-receipt/{id}', 
		'LoloPinoyLechonDeCebuController@destroyDeliveryReceipt')
		->name('destroyDeliveryReceipt');


	//route for payment vouchers
	Route::get(
		'/lolo-pinoy-lechon-de-cebu/payment-voucher-form', 
		'LoloPinoyLechonDeCebuController@paymentVoucherForm')
		->name('paymentVoucherForm');

	//route for payment vouchers store
	Route::post(
		'/lolo-pinoy-lechon-de-cebu/payment-voucher-store', 
		'LoloPinoyLechonDeCebuController@paymentVoucherStore')
		->name('paymnentVoucherStore');

	
	//route for edit payment vouchers
	Route::get(
		'/lolo-pinoy-lechon-de-cebu/edit-payment-voucher/{id}', 
		'LoloPinoyLechonDeCebuController@editPaymentVoucher')
		->name('editPaymentVoucher');

	//route update payment vouhcer
	Route::patch(
		'/lolo-pinoy-lechon-de-cebu/update-payment-voucher/{id}', 
		'LoloPinoyLechonDeCebuController@updatePaymentVoucher')
		->name('updatePaymentVoucher');

	//Route for add new payment voucher
	Route::get(
		'/lolo-pinoy-lechon-de-cebu/add-new-payment-voucher/{id}', 
		'LoloPinoyLechonDeCebuController@addNewPaymentVoucher')
		->name('lolo-pinoy-lechon-de-cebu.addNewPaymentVoucher');

	Route::get(
			'/lolo-pinoy-lechon-de-cebu/payables/transaction-list',
			'LoloPinoyLechonDeCebuController@transactionList')
			->name('lolo-pinoy-lechon-de-cebu.transactionList');
	
	Route::get(
			'/lolo-pinoy-lechon-de-cebu/edit-payables-detail/{id}',
			'LoloPinoyLechonDeCebuController@editPayablesDetail')
			->name('lolo-pinoy-lechon-de-cebu.editPayablesDetail');

	
	Route::delete(
		'/lolo-pinoy-lechon-de-cebu/delete-transaction-list/{id}',
		'LoloPinoyLechonDeCebuController@destroyTransactionList')
		->name('lolo-pinoy-lechon-de-cebu.destroyTransactionList');
	
	Route::get(
		'/lolo-pinoy-lechon-de-cebu/view-payables-details/{id}',
		'LoloPinoyLechonDeCebuController@viewPayableDetails')
		->name('lolo-pinoy-lechon-de-cebu.viewPayableDetails');
	
	Route::get(
		'/lolo-pinoy-lechon-de-cebu/printPayables/{id}',
		'LoloPinoyLechonDeCebuController@printPayables')
		->name('lolo-pinoy-lechon-de-cebu.printPayables');

	//delete for lechon de cebu purchase order
	Route::delete('/lolo-pinoy-lechon-de-cebu/delete/{id}', 'LoloPinoyLechonDeCebuController@destroy')->name('lolo-pinoy-lechon-de-cebu.destroy');

	//delete for lechon de cebu billint statement
	Route::delete('/lolo-pinoy-lechon-de-cebu/delete-billing-statement/{id}', 'LoloPinoyLechonDeCebuController@destroyBillingStatement')->name('lolo-pinoy-lechon-de-cebu.destroyBillingStatement');
	
	Route::delete('/lolo-pinoy-lechon-de-cebu/delete-payment-voucher/{id}', 'LoloPinoyLechonDeCebuController@destroyPaymentVoucher')->name('lolo-pinoy-lechon-de-cebu.destroyPaymentVoucher');
	
	//route for delete sales invoice 
	Route::delete('/lolo-pinoy-lechon-de-cebu/delete-sales-invoice/{id}', 'LoloPinoyLechonDeCebuController@destroySalesInvoice')->name('lolo-pinoy-lechon-de-cebu.destroySalesInvoice');
	
	//delete comissary RAW materials
	Route::delete('/lolo-pinoy-lechon-de-cebu/delete-raw-materials/{id}', 'LoloPinoyLechonDeCebuController@destroyRawMaterial')->name('lolo-pinoy-lechon-de-cebu.destroyRawMaterial');
	
	//destroy delivery receipt
	Route::delete('/lolo-pinoy-grill-commissary/delete-delivery-receipt/{id}', 'LoloPinoyGrillCommissaryController@destroyDeliveryReceipt')->name('lolo-pinoy-grill-commissary.destroyDeliveryReceipt');
	
	//delete 
	Route::delete('/lolo-pinoy-grill-commissary/delete/{id}', 'LoloPinoyGrillCommissaryController@destroy')->name('lolo-pinoy-grill-commissary.delete');
	
	//destroy billing statement
	Route::delete('/lolo-pinoy-grill-commissary/delete-billing-statement/{id}', 'LoloPinoyGrillCommissaryController@destroyBillingStatement')->name('lolo-pinoy-grill-commissary.destroyBillingStatement');
	
	Route::delete(
		'/lolo-pinoy-grill-commissary/delete-transaction-list/{id}',
		'LoloPinoyGrillCommissaryController@destroyTransactionList')
		->name('lolo-pinoy-grill-commissary.destroyTransactionList');

	//delete
	Route::delete('/lolo-pinoy-grill-commissary/delete-payment-voucher/{id}', 'LoloPinoyGrillCommissaryController@destroyPaymentVoucher')->name('lolo-pinoy-grill-commissary.destroyPaymentVoucher');
	
	//delete
	Route::delete('/lolo-pinoy-grill-commissary/delete-sales-invoice/{id}', 'LoloPinoyGrillCommissaryController@destroySalesInvoice')->name('lolo-pinoy-grill-commissary.destroySalesInvoice');
	
	Route::delete('/lolo-pinoy-grill-commissary/delete-statement-account/{id}', 'LoloPinoyGrillCommissaryController@destroyStatementAccount')->name('lolo-pinoy-grill-commissary.destroyStatementAccount');
	
	Route::delete(
		'/lolo-pinoy-grill-commissary/delete-raw-materials/{id}',
		'LoloPinoyGrillCommissaryController@destroyRawMaterial')
		->name('lolo-pinoy-grill-commissary.destroyRawMaterial');
	
	Route::delete(
		'/lolo-pinoy-grill-commissary/utilities/delete/{id}',
		'LoloPinoyGrillCommissaryController@destroyUtility')
		->name('lolo-pinoy-grill-commissary.destroyUtility');
	
	Route::delete(
		'/lolo-pinoy-grill-branches/delete/{id}',
		'LoloPinoyGrillBranchesController@destroy')
		->name('lolo-pinoy-grill-branches.destroy');
	
	Route::delete(
		'/lolo-pinoy-grill-branches/delete-transaction-list/{id}',
		'LoloPinoyGrillBranchesController@destroyTransactionList')
		->name('lolo-pinoy-grill-branches.destroyTransactionList');

	//delete
	Route::delete(
		'/mr-potato/delete/{id}',
		'MrPotatoController@destroy')
		->name('mr-potato.destroy');

	Route::delete(
			'/mr-potato/delete-delivery-receipt/{id}',
			'MrPotatoController@destroyDeliveryReceipt')
			->name('mr-potato.destroyDeliveryReceipt');
	
	Route::delete(
		'/mr-potato/delete-transaction-list/{id}',
		'MrPotatoController@destroyTransactionList')
		->name('mr-potato.destroyTransactionList');

	Route::delete(
		'/mr-potato/delete-payment-voucher/{id}',
		'MrPotatoController@destroyPaymentVoucher')
		->name('mr-potato.destroyPaymentVoucher');

	Route::delete(
		'/mr-potato/delete-sales-invoice/{id}',
		'MrPotatoController@destroySalesInvoice')
		->name('mr-potato.destroySalesInvoice');	
	
	Route::delete(
			'/ribos-bar/delete-delivery-receipt/{id}',
			'RibosBarController@destroyDeliveryReceipt')
			->name('ribos-bar.destroyDeliveryReceipt');

	Route::delete(
		'/ribos-bar/delete/{id}',
		'RibosBarController@destroy')
		->name('ribos-bar.destroy');

	Route::delete(
		'/ribos-bar/delete-transaction-list/{id}',
		'RibosBarController@destroyTransactionList')
		->name('ribos-bar.destroyTransactionList');
	
	Route::delete(
			'/ribos-bar/delete-payment-voucher/{id}',
			'RibosBarController@destroyPaymentVoucher')
			->name('ribos-bar.destroyPaymentVoucher');
	
	//delete
	Route::delete(
		'/ribos-bar/delete-sales-invoice/{id}',
		'RibosBarController@destroySalesInvoice')
		->name('ribos-bar.destroySalesInvoice');

	Route::delete(
		'/ribos-bar/delete-billing-statement/{id}',
		'RibosBarController@destroyBillingStatement')
		->name('ribos-bar.destroyBillingStatement');

	Route::delete(
		'/ribos-bar/cashiers-report-form/delete-item/{id}',
		'RibosBarController@destroyCashiersReport')
		->name('ribos-bar.destroyCashiersReport');
	
	Route::delete(
		'/dno-personal/delete-transaction-list/{id}',
		'DnoPersonalController@destroyTransactionList')
		->name('dno-personal.destroyTransactionList');

	Route::delete(
		'/dno-personal/credit-card/delete/{id}',
		'DnoPersonalController@destroyCreditCard')
		->name('dno-personal.destroyCreditCard');
	
	Route::delete(
		'/dno-personal/delete-property/{id}',
		'DnoPersonalController@destroyProperty')
		->name('dno-personal.destroyProperty');

	Route::delete(
		'/dno-perosonal/vehicles/delete/{id}',
		'DnoPersonalController@destroyVehicles')
		->name('dno-personal.destroyVehicles');
	
	Route::delete(
		'/dno-resources-development/delete-transaction-list/{id}',
		'DnoResourcesDevelopmentController@destroyTransactionList')
		->name('dno-resources-development.destroyTransactionList');

	Route::delete(
		'/dno-resources-development/delete/{id}',
		'DnoResourcesDevelopmentController@destroy')
		->name('dno-resources-development.destroy');

	//payment voucher form
	Route::get('/lolo-pinoy-grill-commissary/payment-voucher-form', 'LoloPinoyGrillCommissaryController@paymentVoucherForm')->name('lolo-pinoy-grill-commissary.paymentVoucherForm');

	//save 
	Route::post('/lolo-pinoy-grill-commissary/payment-voucher-store', 'LoloPinoyGrillCommissaryController@paymentVoucherStore')->name('lolo-pinoy-grill-commissary.paymentVoucherStore');

	Route::get(
		'/lolo-pinoy-grill-commissary/payables/transaction-list',
		'LoloPinoyGrillCommissaryController@transactionList')
		->name('lolo-pinoy-grill-commissary.transactionList');

	Route::get(
		'/lolo-pinoy-grill-commissary/printPayables/{id}',
		'LoloPinoyGrillCommissaryController@printPayables')
		->name('lolo-pinoy-grill-commissary.printPayables');

	Route::get(
		'/lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-payables-detail/{id}',
		'LoloPinoyGrillCommissaryController@editPayablesDetail')
		->name('lolo-pinoy-grill-commissary.editPayablesDetail');
	
	Route::post(
		'/lolo-pinoy-grill-commissary/add-particulars/{id}',
		'LoloPinoyGrillCommissaryController@addParticulars')
		->name('lolo-pinoy-grill-commissary.addParticulars');

	Route::post(
		'/lolo-pinoy-grill-commissary/add-payment/{id}',
		'LoloPinoyGrillCommissaryController@addPayment')
		->name('lolo-pinoy-grill-commissary.addPayment');

	Route::patch(
		'/lolo-pinoy-grill-commissary/accept/{id}',
		'LoloPinoyGrillCommissaryController@accept')
		->name('lolo-pinoy-grill-commissary.accept');

	Route::get(
		'/lolo-pinoy-grill-commissary/view-lolo-pinoy-grill-payables-details/{id}',
		'LoloPinoyGrillCommissaryController@viewPayableDetails')
		->name('lolo-pinoy-grill-commissary.viewPayableDetails');


	//edit payment voucher
	Route::get('/lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-payment-voucher/{id}', 'LoloPinoyGrillCommissaryController@editPaymentVoucher')->name('lolo-pinoy-grill-commissary.editPaymentVoucher');

	Route::patch('/lolo-pinoy-grill-commissary/update-payment-voucher/{id}', 'LoloPinoyGrillCommissaryController@updatePaymentVoucher')->name('lolo-pinoy-grill-commissary.updatePaymentVoucher');

	Route::get('/lolo-pinoy-grill-commissary/add-new-lolo-pinoy-grill-payment-voucher/{id}', 'LoloPinoyGrillCommissaryController@addNewPaymentVoucher')->name('lolo-pinoy-grill-commissary.addNewPaymentVoucher');

	Route::post('/lolo-pinoy-grill-commissary/add-new-payment-voucher-data/{id}', 'LoloPinoyGrillCommissaryController@addNewPaymentVoucherData')->name('lolo-pinoy-grill-commissary.addNewPaymentVoucherData');

	Route::patch('/lolo-pinoy-grill-commissary/update-pv/{id}', 'LoloPinoyGrillCommissaryController@updatePV')->name('lolo-pinoy-grill-commissary.updatePV');

	Route::get(
		'/lolo-pinoy-grill-branches/payment-voucher-form',
		'LoloPinoyGrillBranchesController@paymentVoucherForm')
		->name('lolo-pinoy-grill-branches.paymentVoucherForm');

	Route::post(
		'/lolo-pinoy-grill-branches/payment-voucher-store',
		'LoloPinoyGrillBranchesController@paymentVoucherStore')
		->name('lolo-pinoy-grill-branches.paymentVoucherStore');

	Route::get(
		'/lolo-pinoy-grill-branches/payables/transaction-list',
		'LoloPinoyGrillBranchesController@transactionList')
		->name('lolo-pinoy-grill-branches.transactionList');

	Route::get(
		'/lolo-pinoy-grill-branches/edit-lolo-pinoy-grill-branches-payables-detail/{id}',
		'LoloPinoyGrillBranchesController@editPayablesDetail')
		->name('lolo-pinoy-grill-branches.editPayablesDetail');

	Route::post(
		'/lolo-pinoy-grill-branches/add-particulars/{id}',
		'LoloPinoyGrillBranchesController@addParticulars')
		->name('lolo-pinoy-grill-branhces.addParticulars');

	Route::patch(
		'/lolo-pinoy-grill-branches/accept/{id}',
		'LoloPinoyGrillBranchesController@accept')
		->name('lolo-pinoy-grill-branches.accept');

	Route::get(
		'/lolo-pinoy-grill-branches/view-lolo-pinoy-grill-branches-payables-details/{id}',
		'LoloPinoyGrillBranchesController@viewPayableDetails')
		->name('lolo-pinoy-grill-branches.viewPayableDetails');

	Route::get(
		'/lolo-pinoy-grill-branches/printPayables/{id}',
		'LoloPinoyGrillBranchesController@printPayables')
		->name('lolo-pinoy-grill-branches.printPayables');

	Route::post(
		'/lolo-pinoy-grill-branches/add-payment/{id}',
		'LoloPinoyGrillBranchesController@addPayment')
		->name('lolo-pinoy-grill-branches.addPayment');

	//payment voucher mr potato
	Route::get(
		'/mr-potato/payment-voucher-form',
		'MrPotatoController@paymentVoucherForm')
		->name('mr-potato.paymentVoucherForm');

	Route::post(
		'/mr-potato/store-payment',
		'MrPotatoController@paymentVoucherStore')
		->name('mr-potato.paymentVoucherStore');

	Route::get(
		'/mr-potato/payables/transaction-list',
		'MrPotatoController@transactionList')
		->name('mr-potato.transactionList');

	Route::get(
		'/mr-potato/edit-mr-potato-payables-detail/{id}',
		'MrPotatoController@editPayablesDetail')
		->name('mr-potato.editPayablesDetail');

	Route::post(
		'/mr-potato/add-particulars/{id}',
		'MrPotatoController@addParticulars')	
		->name('mr-potato.addParticulars');

	Route::get(
		'/mr-potato/print-payables/{id}',
		'MrPotatoController@printPayables')
		->name('mr-potato.printPayables');

	Route::post(
		'/mr-potato/add-payment/{id}',
		'MrPotatoController@addPayment')
		->name('mr-potato.addPayment');

	Route::patch(
		'/mr-potato/accept/{id}',
		'MrPotatoController@accept')
		->name('mr-potato.accept');

	Route::get(
		'/mr-potato/view-mr-potato-payables-details/{id}',
		'MrPotatoController@viewPayableDetails')
		->name('mr-potato.viewPayableDetails');



	Route::get(
		'/mr-potato/edit-mr-potato-payment-voucher/{id}',
		'MrPotatoController@editPaymentVoucher')
		->name('mr-potato.editPaymentVoucher');

	Route::patch(
		'/mr-potato/update-payment-voucher/{id}',
		'MrPotatoController@updatePaymentVoucher')
		->name('mr-potato.updatePaymentVoucher');

	Route::get(
		'/mr-potato/add-new-mr-potato-payment-voucher/{id}',
		'MrPotatoController@addNewPaymentVoucher')
		->name('mr-potato.addNewPaymentVoucher');

	Route::post(
		'/mr-potato/add-new-payment-voucher-data/{id}',
		'MrPotatoController@addNewPaymentVoucherData')
		->name('mr-potato.addNewPaymentVoucherData');

	Route::patch(
		'/mr-potato/update-pv/{id}',
		'MrPotatoController@updatePV')
		->name('mr-potato.updatePV');
	
		Route::get(
			'/ribos-bar/payment-voucher-form',
			'RibosBarController@paymentVoucherForm')
			->name('ribos-bar.paymentVoucherForm');
	
	//store
	Route::post(
		'/ribos-bar/payment-voucher-store',
		'RibosBarController@paymentVoucherStore')
		->name('ribos-bar.paymentVoucherStore');

	Route::get(
		'/ribos-bar/payables/transaction-list',
		'RibosBarController@transactionList')
		->name('ribos-bar.transactionList');

	Route::get(
		'/ribos-bar/edit-ribos-bar-payables-detail/{id}',
		'RibosBarController@editPayablesDetail')
		->name('ribos-bar.editPayablesDetail');
	
	Route::post(
		'/ribos-bar/add-particulars/{id}',
		'RibosBarController@addParticulars')
		->name('ribos-bar.addParticulars');

	Route::post(
		'/ribos-bar/add-payment/{id}',
		'RibosBarController@addPayment')
		->name('ribos-bar.addPayment');

	Route::patch(
		'/ribos-bar/accept/{id}',
		'RibosBarController@accept')
		->name('ribos-bar.accept');

	Route::get(
		'/ribos-bar/view-ribos-bar-payables-details/{id}',
		'RibosBarController@viewPayableDetails')
		->name('ribos-bar.viewPayableDetails');

	

	Route::get(
		'/ribos-bar/print-payables/{id}',
		'RibosBarController@printPayablesRibosBar')
		->name('ribos-bar.printPayablesRibosBar');

	Route::get(
		'/ribos-bar/edit-ribos-bar-payment-voucher/{id}',
		'RibosBarController@editPaymentVoucher')
		->name('ribos-bar.editPaymentVoucher');

	Route::patch(
		'/ribos-bar/update-payment-voucher/{id}',
		'RibosBarController@updatePaymentVoucher')
		->name('ribos-bar.updatePaymentVoucher');

	Route::get(
		'/ribos-bar/add-new-ribos-bar-payment-voucher/{id}',
		'RibosBarController@addNewPaymentVoucher')
		->name('ribos-bar.addNewPaymentVoucher');

	Route::post(
		'/ribos-bar/add-new-payment-voucher-data/{id}',
		'RibosBarController@addNewPaymentVoucherData')
		->name('ribos-bar.addNewPaymentVoucherData');

	Route::patch(
		'/ribos-bar/update-pv/{id}',
		'RibosBarController@updatePV')
		->name('ribos-bar.updatePV');
	
	Route::get(
		'/dno-personal/payment-voucher-form',
		'DnoPersonalController@paymentVoucherForm')
		->name('dno-personal.paymentVoucherForm');

	Route::post(
		'/dno-personal/payment-voucher-store/',
		'DnoPersonalController@paymentVoucherStore')
		->name('dno-personal.paymentVoucherStore');

	Route::get(
		'/dno-personal/payables/transaction-list',
		'DnoPersonalController@transactionList')
		->name('dno-personal.transactionList');

	Route::get(
		'/dno-personal/edit-dno-personal-payables-detail/{id}',
		'DnoPersonalController@editPayablesDetail')
		->name('dno-resources-development.editPayablesDetail');

	Route::post(
		'/dno-personal/add-particulars/{id}',
		'DnoPersonalController@addParticulars')
		->name('dno-personal.addParticulars');

	Route::post(
		'/dno-personal/add-payment/{id}',
		'DnoPersonalController@addPayment')
		->name('dno-personal.addPayment');

	Route::patch(
		'/dno-personal/accept/{id}',
		'DnoPersonalController@accept')
		->name('dno-personal.accept');

	Route::get(
		'/dno-personal/view-dno-personal-payables-details/{id}',
		'DnoPersonalController@viewPayableDetails')
		->name('dno-personal.viewPayableDetails');

	Route::get(
		'/dno-personal/printPayables/{id}',
		'DnoPersonalController@printPayablesDnoPersonal')
		->name('dno-personal.printPayablesDnoPersonal');
	
	Route::get(
		'/dno-resources-development/payment-voucher-form',
		'DnoResourcesDevelopmentController@paymentVoucherForm')
		->name('dno-resources-development.paymentVoucherForm');

	Route::post(
		'/dno-resources-development/payment-voucher-store',
		'DnoResourcesDevelopmentController@paymentVoucherStore')
		->name('dno-resources-development.paymentVoucherStore');

	Route::get(
		'/dno-resources-development/payables/transaction-list',
		'DnoResourcesDevelopmentController@transactionList')
		->name('dno-resources-development.transactionList');

	Route::get(
		'/dno-resources-development/edit-dno-resources-payables-detail/{id}',
		'DnoResourcesDevelopmentController@editPayablesDetail')
		->name('dno-resources-development.editPayablesDetail');
	
	Route::post(
		'/dno-resources-developemtn/add-particulars/{id}',
		'DnoResourcesDevelopmentController@addParticulars')
		->name('dno-resources-development.addParticulars');

	Route::post(
		'/dno-resources-development/add-payment/{id}',
		'DnoResourcesDevelopmentController@addPayment')
		->name('dno-resources-development.addPayment');

	Route::patch(
		'/dno-resources-development/accept/{id}',
		'DnoResourcesDevelopmentController@accept')
		->name('dno-resources-development.accept');

	Route::get(
		'/dno-resources-development/view-dno-resources-payables-details/{id}',
		'DnoResourcesDevelopmentController@viewPayableDetails')
		->name('dno-resources-development.viewPayableDetails');

	Route::get(
		'/dno-resources-development/printPayables/{id}',
		'DnoResourcesDevelopmentController@printPayables')
		->name('dno-resources-development.printPayables');


});

Route::group(['middleware' =>['sales']], function(){
	Route::get(
		'/profile/create-user',
		'ProfileController@createUser')
		->name('profile.createUser')
		->middleware(['user','auth']);
	
	Route::post(
		'/profile/store-create-user',
		'ProfileController@storeCreateUser')
		->name('profile.storeCreateUser')
		->middleware(['user','auth']);

	//delete for lechon de cebu billint statement
	Route::delete('/lolo-pinoy-lechon-de-cebu/delete-billing-statement/{id}', 'LoloPinoyLechonDeCebuController@destroyBillingStatement')->name('lolo-pinoy-lechon-de-cebu.destroyBillingStatement');
	
	Route::delete('/lolo-pinoy-lechon-de-cebu/delete-payment-voucher/{id}', 'LoloPinoyLechonDeCebuController@destroyPaymentVoucher')->name('lolo-pinoy-lechon-de-cebu.destroyPaymentVoucher');
	
	//route for delete sales invoice 
	Route::delete('/lolo-pinoy-lechon-de-cebu/delete-sales-invoice/{id}', 'LoloPinoyLechonDeCebuController@destroySalesInvoice')->name('lolo-pinoy-lechon-de-cebu.destroySalesInvoice');
	
	//delete comissary RAW materials
	Route::delete('/lolo-pinoy-lechon-de-cebu/delete-raw-materials/{id}', 'LoloPinoyLechonDeCebuController@destroyRawMaterial')->name('lolo-pinoy-lechon-de-cebu.destroyRawMaterial');
	
	//destroy delivery receipt
	Route::delete('/lolo-pinoy-grill-commissary/delete-delivery-receipt/{id}', 'LoloPinoyGrillCommissaryController@destroyDeliveryReceipt')->name('lolo-pinoy-grill-commissary.destroyDeliveryReceipt');
	
	//delete 
	Route::delete('/lolo-pinoy-grill-commissary/delete/{id}', 'LoloPinoyGrillCommissaryController@destroy')->name('lolo-pinoy-grill-commissary.delete');
	
	//destroy billing statement
	Route::delete('/lolo-pinoy-grill-commissary/delete-billing-statement/{id}', 'LoloPinoyGrillCommissaryController@destroyBillingStatement')->name('lolo-pinoy-grill-commissary.destroyBillingStatement');
	
	Route::delete(
		'/lolo-pinoy-grill-commissary/delete-transaction-list/{id}',
		'LoloPinoyGrillCommissaryController@destroyTransactionList')
		->name('lolo-pinoy-grill-commissary.destroyTransactionList');

	//delete
	Route::delete('/lolo-pinoy-grill-commissary/delete-payment-voucher/{id}', 'LoloPinoyGrillCommissaryController@destroyPaymentVoucher')->name('lolo-pinoy-grill-commissary.destroyPaymentVoucher');
	
	//delete
	Route::delete('/lolo-pinoy-grill-commissary/delete-sales-invoice/{id}', 'LoloPinoyGrillCommissaryController@destroySalesInvoice')->name('lolo-pinoy-grill-commissary.destroySalesInvoice');
	
	Route::delete('/lolo-pinoy-grill-commissary/delete-statement-account/{id}', 'LoloPinoyGrillCommissaryController@destroyStatementAccount')->name('lolo-pinoy-grill-commissary.destroyStatementAccount');
	
	Route::delete(
		'/lolo-pinoy-grill-commissary/delete-raw-materials/{id}',
		'LoloPinoyGrillCommissaryController@destroyRawMaterial')
		->name('lolo-pinoy-grill-commissary.destroyRawMaterial');
	
	Route::delete(
		'/lolo-pinoy-grill-commissary/utilities/delete/{id}',
		'LoloPinoyGrillCommissaryController@destroyUtility')
		->name('lolo-pinoy-grill-commissary.destroyUtility');
	
	Route::delete(
		'/lolo-pinoy-grill-branches/delete/{id}',
		'LoloPinoyGrillBranchesController@destroy')
		->name('lolo-pinoy-grill-branches.destroy');
	
	Route::delete(
		'/lolo-pinoy-grill-branches/delete-transaction-list/{id}',
		'LoloPinoyGrillBranchesController@destroyTransactionList')
		->name('lolo-pinoy-grill-branches.destroyTransactionList');

	//delete
	Route::delete(
		'/mr-potato/delete/{id}',
		'MrPotatoController@destroy')
		->name('mr-potato.destroy');

	Route::delete(
			'/mr-potato/delete-delivery-receipt/{id}',
			'MrPotatoController@destroyDeliveryReceipt')
			->name('mr-potato.destroyDeliveryReceipt');
	
	Route::delete(
		'/mr-potato/delete-transaction-list/{id}',
		'MrPotatoController@destroyTransactionList')
		->name('mr-potato.destroyTransactionList');

	Route::delete(
		'/mr-potato/delete-payment-voucher/{id}',
		'MrPotatoController@destroyPaymentVoucher')
		->name('mr-potato.destroyPaymentVoucher');

	Route::delete(
		'/mr-potato/delete-sales-invoice/{id}',
		'MrPotatoController@destroySalesInvoice')
		->name('mr-potato.destroySalesInvoice');	
	
	Route::delete(
			'/ribos-bar/delete-delivery-receipt/{id}',
			'RibosBarController@destroyDeliveryReceipt')
			->name('ribos-bar.destroyDeliveryReceipt');

	Route::delete(
		'/ribos-bar/delete/{id}',
		'RibosBarController@destroy')
		->name('ribos-bar.destroy');

	Route::delete(
		'/ribos-bar/delete-transaction-list/{id}',
		'RibosBarController@destroyTransactionList')
		->name('ribos-bar.destroyTransactionList');
	
	Route::delete(
			'/ribos-bar/delete-payment-voucher/{id}',
			'RibosBarController@destroyPaymentVoucher')
			->name('ribos-bar.destroyPaymentVoucher');
	
	//delete
	Route::delete(
		'/ribos-bar/delete-sales-invoice/{id}',
		'RibosBarController@destroySalesInvoice')
		->name('ribos-bar.destroySalesInvoice');

	Route::delete(
		'/ribos-bar/delete-billing-statement/{id}',
		'RibosBarController@destroyBillingStatement')
		->name('ribos-bar.destroyBillingStatement');

	Route::delete(
		'/ribos-bar/cashiers-report-form/delete-item/{id}',
		'RibosBarController@destroyCashiersReport')
		->name('ribos-bar.destroyCashiersReport');
	
	Route::delete(
		'/dno-personal/delete-transaction-list/{id}',
		'DnoPersonalController@destroyTransactionList')
		->name('dno-personal.destroyTransactionList');

	Route::delete(
		'/dno-personal/credit-card/delete/{id}',
		'DnoPersonalController@destroyCreditCard')
		->name('dno-personal.destroyCreditCard');
	
	Route::delete(
		'/dno-personal/delete-property/{id}',
		'DnoPersonalController@destroyProperty')
		->name('dno-personal.destroyProperty');

	Route::delete(
		'/dno-perosonal/vehicles/delete/{id}',
		'DnoPersonalController@destroyVehicles')
		->name('dno-personal.destroyVehicles');
	
	Route::delete(
		'/dno-resources-development/delete-transaction-list/{id}',
		'DnoResourcesDevelopmentController@destroyTransactionList')
		->name('dno-resources-development.destroyTransactionList');

	Route::delete(
		'/dno-resources-development/delete/{id}',
		'DnoResourcesDevelopmentController@destroy')
		->name('dno-resources-development.destroy');


	
});


Route::group(['middleware' => ['auth']], function(){
	
	//route for profile
	Route::get('/profile', 'ProfileController@index')->name('profile.index');
	Route::get('/profile/edit/{id}', 'ProfileController@edit')->name('profile.edit');
	Route::post('/profile/update/{id}', 'ProfileController@update')->name('profile.update');

	//route for change password
	Route::get('/change-password', 'ChangePasswordController@index')->name('change-password.index');

	Route::patch('/change-password/update/{id}', 'ChangePasswordController@update')->name('change-password.update');

	//route for lolo pinoy lechon de cebu
	Route::get('lolo-pinoy-lechon-de-cebu', 'LoloPinoyLechonDeCebuController@index')->name('lolo-pinoy-lechon-de-cebu.index');

	//route for lechon de cebu purchase order
	Route::get('lolo-pinoy-lechon-de-cebu/purchase-order', 'LoloPinoyLechonDeCebuController@purchaseOrder')->name('lolo-pinoy-lechon-de-cebu.purchaseOrder');

	Route::get('lolo-pinoy-lechon-de-cebu/purchase-order-lists', 'LoloPinoyLechonDeCebuController@purchaseOrderAllLists')->name('lolo-pinoy-lechon-de-cebu.purchaseOrderAllLists');

	//save purchase order
	Route::post('lolo-pinoy-lechon-de-cebu/store', 'LoloPinoyLechonDeCebuController@store')->name('lolo-pinoy-lechon-de-cebu.store');


	//edit purchase order
	Route::get('lolo-pinoy-lechon-de-cebu/edit/{id}', 'LoloPinoyLechonDeCebuController@edit')->name('lolo-pinoy-lechon-de-cebu.edit');

	//update 
	Route::patch('lolo-pinoy-lechon-de-cebu/update/{id}', 'LoloPinoyLechonDeCebuController@update')->name('lolo-pinoy-lechon-de-cebu.update');

	//route for add new in lechon de cebu purchase order
	Route::get('lolo-pinoy-lechon-de-cebu/add-new/{id}', 'LoloPinoyLechonDeCebuController@addNew')->name('lolo-pinoy-lechon-de-cebu.addNew');

	//save add new purchase order 
	Route::post('lolo-pinoy-lechon-de-cebu/add-new-purchase-order/{id}', 'LoloPinoyLechonDeCebuController@addNewPurchaseOrder')->name('lolo-pinoy-lechon-de-cebu.addNewPurchaseOrder');

	//view purchase order lechon de cebu
	Route::get('lolo-pinoy-lechon-de-cebu/view/{id}', 'LoloPinoyLechonDeCebuController@show')->name('lolo-pinoy-lechon-de-cebu.show');


	//
	Route::patch('/lolo-pinoy-lechon-de-cebu/update-po/{id}', 'LoloPinoyLechonDeCebuController@updatePo')->name('lolo-pinoy-lechon-de-cebu.updatePo');

	//route for lechon de cebu billing statement form
	Route::get('/lolo-pinoy-lechon-de-cebu/billing-statement-form', 'LoloPinoyLechonDeCebuController@billingStatementForm')->name('lolo-pinoy-lechon-de-cebu.billingStatementForm');

	//
	Route::post('/lolo-pinoy-lechon-de-cebu/store-billing-statement', 'LoloPinoyLechonDeCebuController@storeBillingStatement')->name('lolo-pinoy-lechon-de-cebu.storeBillingStatement');

	//route for lechon de cebu billing statement form edit
	Route::get('/lolo-pinoy-lechon-de-cebu/edit-billing-statement/{id}', 'LoloPinoyLechonDeCebuController@editBillingStatement')->name('lolo-pinoy-lechon-de-cebu.editBillingStatement');

	//route for add new billing in lechon de cebu
	Route::get('/lolo-pinoy-lechon-de-cebu/add-new-billing/{id}', 'LoloPinoyLechonDeCebuController@addNewBilling')->name('lolo-pinoy-lechon-de-cebu.addNewBilling');

	Route::post('/lolo-pinoy-lechon-de-cebu/add-new-billing-data/{id}', 'LoloPinoyLechonDeCebuController@addNewBillingData')->name('lolo-pinoy-lechon-de-cebu.addNewBillingData');

	//route for billing statement lists
	Route::get('/lolo-pinoy-lechon-de-cebu/billing-statement-lists', 'LoloPinoyLechonDeCebuController@billingStatementLists')->name('lolo-pinoy-lechon-de-cebu.billingStatementLists');

	//update billing statement 
	Route::patch('/lolo-pinoy-lechon-de-cebu/update-billing/{id}', 'LoloPinoyLechonDeCebuController@updateBillingStatement')->name('lolo-pinoy-lechon-de-cebu.updateBillingStatement');

	//update billing statement info
	Route::patch('/lolo-pinoy-lechon-de-cebu/update-billing-info/{id}', 'LoloPinoyLechonDeCebuController@updateBillingInfo')->name('lolo-pinoy-lechon-de-cebu.updateBillingInfo');

	//view billing statement
	Route::get('/lolo-pinoy-lechon-de-cebu/view-billing-statement/{id}', 'LoloPinoyLechonDeCebuController@viewBillingStatement')->name('lolo-pinoy-lechon-de-cebu.viewBillingStatement');

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/view-per-accounts-billing-statement',
		'LoloPinoyLechonDeCebuController@viewPerAccountsBilling')
		->name('lolo-pinoy-lechon-de-cebu.viewPerAccountsBilling');

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/billing-statement/view-ssps/{id}',
		'LoloPinoyLechonDeCebuController@viewSsps')
		->name('lolo-pinoy-lechon-de-cebu.viewSsps');

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/printSsps/{id}',
		'LoloPinoyLechonDeCebuController@printSsps')
		->name('lolo-pinoy-lechon-de-cebu.printSsps');

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/printBillingDelivery/{id}',
		'LoloPinoyLechonDeCebuController@printBillingDelivery')
		->name('lolo-pinoy-lechon-de-cebu.printBillingDelivery');

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/billing-statement/view-per-account-delivery-receipt/{id}',
		'LoloPinoyLechonDeCebuController@viewPerAccountDeliveryReceipt')
		->name('lolo-pinoy-lechon-de-cebu.viewPerAccountDeliveryReceipt');

	//route for lechon de cebu statement of account
	Route::get('/lolo-pinoy-lechon-de-cebu/statement-of-account-form', 'LoloPinoyLechonDeCebuController@statementOfAccount')->name('lolo-pinoy-lechon-de-cebu.statementOfAccount');

	//route for lechon de cebu statement of account store data
	Route::post('/lolo-pinoy-lechon-de-cebu/store-statement-account', 'LoloPinoyLechonDeCebuController@storeStatementAccount')->name('lolo-pinoy-lechon-de-cebu.storeStatementAccount');
	//route for lechon de cebu statement of account lists
	Route::get('/lolo-pinoy-lechon-de-cebu/statement-of-account/lists', 'LoloPinoyLechonDeCebuController@statementOfAccountLists')->name('lolo-pinoy-lechon-de-cebu.statementOfAccountLists');

	//edit for statement of account
	Route::get('/lolo-pinoy-lechon-de-cebu/edit-statement-of-account/{id}', 'LoloPinoyLechonDeCebuController@editStatementAccount')->name('lolo-pinoy-lechon-de-cebu.editStatementAccount');

	//route for add new statement of account
	Route::get('/lolo-pinoy-lechon-de-cebu/add-new-statement-account/{id}', 'LoloPinoyLechonDeCebuController@addNewStatementAccount')->name('lolo-pinoy-lechon-de-cebu.addNewStatementAccount');

	//route for add new statement of account
	Route::post('/lolo-pinoy-lechon-de-cebu/add-new-statement-data/{id}', 'LoloPinoyLechonDeCebuController@addNewStatementData')->name('lolo-pinoy-lechon-de-cebu.addNewStatementData');


	//update add statement information
	Route::patch('lolo-pinoy-lechon-de-cebu/update-added-statement/{id}', 'LoloPinoyLechonDeCebuController@updateAddStatement')->name('lolo-pinoy-lechon-de-cebu.updateAddStatement');

	

	//view statement of account
	Route::get('/lolo-pinoy-lechon-de-cebu/view-statement-account/{id}', 'LoloPinoyLechonDeCebuController@viewStatementAccount')->name('lolo-pinoy-lechon-de-cebu.viewStatementAccount');

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/printSOA/{id}',
		'LoloPinoyLechonDeCebuController@printSOA')
		->name('lolo-pinoy-lechon-de-cebu.printSOA');

	//route for commissary stocks inventory
	Route::get('/lolo-pinoy-lechon-de-cebu/commissary/stocks-inventory', 'LoloPinoyLechonDeCebuController@stocksInventory')->name('lolo-pinoy-lechon-de-cebu.stocksInventory');


	Route::post(
		'/lolo-pinoy-lechon-de-cebu/add-payment/{id}',
		'LoloPinoyLechonDeCebuController@addPayment')
		->name('lolo-pinoy-lechon-de-cebu.addPayment');

	Route::post(
		'/lolo-pinoy-lechon-de-cebu/add-particulars/{id}',
		'LoloPinoyLechonDeCebuController@addParticulars')
		->name('lolo-pinoy-lechon-de-cebu.addParticulars');

	Route::patch(
		'/lolo-pinoy-lechon-de-cebu/accept/{id}',
		'LoloPinoyLechonDeCebuController@accept')
		->name('lolo-pinoy-lechon-de-cebu.accept');



	//route for add new payment voucher data
	Route::post('/lolo-pinoy-lechon-de-cebu/add-new-payment-voucher-data/{id}', 'LoloPinoyLechonDeCebuController@addNewPaymentVoucherData')->name('lolo-pinoy-lechon-de-cebu.addNewPaymentVoucherData');

	Route::patch('/lolo-pinoy-lechon-de-cebu/update-pv/{id}', 'LoloPinoyLechonDeCebuController@updatePV')->name('lolo-pinoy-lechon-de-cebu.updatePV');

	//route for payment voucher cash vouchers
	Route::get('/lolo-pinoy-lechon-de-cebu/cash-vouchers', 'LoloPinoyLechonDeCebuController@cashVouchers')->name('lolo-pinoy-lechon-de-cebu.cashVouchers');

	//route for payment voucher cheque vouchers
	Route::get('/lolo-pinoy-lechon-de-cebu/cheque-vouchers', 'LoloPinoyLechonDeCebuController@chequeVouchers')->name('lolo-pinoy-lechon-de-cebu.chequeVouchers');

	//route for payment voucher view 
	Route::get('/lolo-pinoy-lechon-de-cebu/view-payment-voucher/{id}', 'LoloPinoyLechonDeCebuController@viewPaymentVoucher')->name('lolo-pinoy-lechon-de-cebu.viewPaymentVoucher');

	//route for delivery receipt 
	Route::get('/lolo-pinoy-lechon-de-cebu/delivery-receipt-form', 'LoloPinoyLechonDeCebuController@deliveryReceiptForm')->name('lolo-pinoy-lechon-de-cebu.deliveryReceiptForm');

	//route store delivery receipt
	Route::post('/lolo-pinoy-lechon-de-cebu/store-delivery-receipt', 'LoloPinoyLechonDeCebuController@storeDeliveryReceipt')->name('lolo-pinoy-lechon-de-cebu.storeDeliveryReceipt');

	//route edit delivery receipt
	Route::get(
		'/lolo-pinoy-lechon-de-cebu/edit-delivery-receipt/{id}', 
		'LoloPinoyLechonDeCebuController@editDeliveryReceipt')
		->name('editDeliveryReceipt');


	//route update delviery receipt
	Route::patch('/lolo-pinoy-lechon-de-cebu/update-delivery-receipt/{id}', 'LoloPinoyLechonDeCebuController@updateDeliveryReceipt')->name('lolo-pinoy-lechon-de-cebu.updateDeliveryReceipt');

	//route for add new delivery receipt
	Route::get('/lolo-pinoy-lechon-de-cebu/add-new-delivery-receipt/{id}', 'LoloPinoyLechonDeCebuController@addNewDeliveryReceipt')->name('lolo-pinoy-lechon-de-cebu.addNewDelivertReceipt');

	Route::post('/lolo-pinoy-lechon-de-cebu/add-new-delivery-receipt-data/{id}', 'LoloPinoyLechonDeCebuController@addNewDeliveryReceiptData')->name('lolo-pinoy-lechon-de-cebu.addNewDeliveryReceiptData');

	//route for delivery receipts lists
	Route::get('/lolo-pinoy-lechon-de-cebu/delivery-receipt/lists', 'LoloPinoyLechonDeCebuController@deliveryReceiptLists')->name('lolo-pinoy-lechon-de-cebu.deliveryReceiptLists');

	//route for update delivery recipt add new
	Route::patch('/lolo-pinoy-lechon-de-cebu/update-dr/{id}', 'LoloPinoyLechonDeCebuController@updateDr')->name('lolo-pinoy-lechon-de-cebu.updateDr');


	//route for view delivery receipt
	Route::get('/lolo-pinoy-lechon-de-cebu/view-delivery-receipt/{id}', 'LoloPinoyLechonDeCebuController@viewDeliveryReceipt')->name('lolo-pinoy-lechon-de-cebu.viewDeliveryReceipt');

	//route for duplicate copy
	Route::get('/lolo-pinoy-lechon-de-cebu/duplicate-copy/{id}', 'LoloPinoyLechonDeCebuController@duplicateCopy')->name('lolo-pinoy-lechon-de-cebu.duplicateCopy');

	//view duplicate copy
	Route::get('/lolo-pinoy-lechon-de-cebu/view-delivery-duplicate/{id}', 'LoloPinoyLechonDeCebuController@viewDeliveryDuplicate')->name('lolo-pinoy-lechon-de-cebu.viewDeliveryDuplicate');

	//route for sales invoice form lechon de cebu
	Route::get('/lolo-pinoy-lechon-de-cebu/sales-invoice-form', 'LoloPinoyLechonDeCebuController@salesInvoiceForm')->name('lolo-pinoy-lechon-de-cebu.salesInvoiceForm');

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/sales-per-outlet',
		'LoloPinoyLechonDeCebuController@salesInvoiceSalesPerOutlet')
		->name('lolo-pinoy-lechon-de-cebu.salesInvoiceSalesPerOutlet');

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/sales-invoice/private-orders',
		'LoloPinoyLechonDeCebuController@privateOrders')
		->name('lolo-pinoy-lechon-de-cebu.privateOrders');

	//route for add sales invoice lechon de cebu
	Route::post('/lolo-pinoy-lechon-de-cebu/store-sales-invoice', 'LoloPinoyLechonDeCebuController@storeSalesInvoice')->name('lolo-pinoy-lechon-de-cebu.storeSalesInvoice');

	//route for edit sales invoice lechon de cebu
	Route::get('/lolo-pinoy-lechon-de-cebu/edit-sales-invoice/{id}', 'LoloPinoyLechonDeCebuController@editSalesInvoice')->name('lolo-pinoy-lechon-de-cebu.editSalesInvoice');

	//update edit sales invoice lechon de cebu
	Route::patch('/lolo-pinoy-lechon-de-cebu/update-sales-invoice/{id}', 'LoloPinoyLechonDeCebuController@updateSalesInvoice')->name('lolo-pinoy-lechon-de-cebu.updateSalesInvoice');

	//route for add new sales invoice lechon de cebu
	Route::get('/lolo-pinoy-lechon-de-cebu/add-new-sales-invoice/{id}', 'LoloPinoyLechonDeCebuController@addNewSalesInvoice')->name('lolo-pinoy-lechon-de-cebu.addNewSalesInvoice');

	Route::post('/lolo-pinoy-lechon-de-cebu/add-new-sales-invoice-data/{id}', 'LoloPinoyLechonDeCebuController@addNewSalesInvoiceData')->name('lolo-pinoy-lechon-de-cebu.addNewSalesInvoiceData');


	//update Sales invoice add new
	Route::patch('/lolo-pinoy-lechon-de-cebu/update-si/{id}', 'LoloPinoyLechonDeCebuController@updateSi')->name('lolo-pinoy-lechon-de-cebu.upodateSi');


	//route for sales invoice view 
	Route::get('/lolo-pinoy-lechon-de-cebu/view-sales-invoice/{id}', 'LoloPinoyLechonDeCebuController@viewSalesInvoice')->name('lolo-pinoy-lechon-de-cebu.viewSalesInvoice');

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/printSalesInvoice/{id}',
		'LoloPinoyLechonDeCebuController@printSalesInvoice')
		->name('lolo-pinoy-lechon-de-cebu.printSalesInvoice');

	//route for commissary RAW materials
	Route::get('/lolo-pinoy-lechon-de-cebu/commissary/raw-materials','LoloPinoyLechonDeCebuController@rawMaterials')->name('lolo-pinoy-lechon-de-cebu.rawMaterials');

	//route create commissary RAW materials
	Route::get('/lolo-pinoy-lechon-de-cebu/commissary/create-raw-materials', 'LoloPinoyLechonDeCebuController@createRawMaterials')->name('lolo-pinoy-lechon-de-cebu.createRawMaterials');

	//route add commissary RAW materials
	Route::post('/lolo-pinoy-lechon-de-cebu/commissary/add-raw-material','LoloPinoyLechonDeCebuController@addRawMaterial')->name('lolo-pinoy-lechon-de-cebu.addRawMaterial');

	//route for commissary RAW materials
	Route::get('/lolo-pinoy-lechon-de-cebu/commissary/edit-raw-materials/{id}', 'LoloPinoyLechonDeCebuController@editRawMaterial')->name('lolo-pinoy-lechon-de-cebu.editRawMaterial');

	//update commissary RAW materials
	Route::patch('/lolo-pinoy-lechon-de-cebu/comissary/update-raw-material/{id}','LoloPinoyLechonDeCebuController@updateRawMaterial')->name('lolo-pinoy-lechon-de-cebu.updateRawMaterial');

	
	//route for view RAW material details
	Route::get('/lolo-pinoy-lechon-de-cebu/view-raw-material-details/{id}', 'LoloPinoyLechonDeCebuController@viewRawMaterialDetails')->name('lolo-pinoy-lechon-de-cebu.viewRawMaterialDetails');

	//route for RAW materials add delivery in
	Route::get('/lolo-pinoy-lechon-de-cebu/raw-material/add-delivery-in/{id}', 'LoloPinoyLechonDeCebuController@rawMaterialAddDeliveryIn')->name('lolo-pinoy-lechon-de-cebu.rawMaterialAddDeliveryIn');

	//route for add delivery in RAW material
	Route::post('/lolo-pinoy-lechon-de-cebu/add-delivery-in-raw-material/{id}', 'LoloPinoyLechonDeCebuController@addDeliveryInRawMaterial')->name('lolo-pinoy-lechon-de-cebu.addDeliveryInRawMaterial');

	//route for RAW material request stock out
	Route::get('/lolo-pinoy-lechon-de-cebu/raw-material/request-stock-out/{id}', 'LoloPinoyLechonDeCebuController@rawMaterialRequestStockOut')->name('lolo-pinoy-lechon-de-cebu.rawMaterialRequestStockOut');

	//route for request stock out RAW material
	Route::post('/lolo-pinoy-lechon-de-cebu/request-stock-out-raw-material/{id}', 'LoloPinoyLechonDeCebuController@requestStockOut')->name('lolo-pinoy-lechon-de-cebu.requestStockOut');

	//route for view stock inventory
	Route::get('/lolo-pinoy-lechon-de-cebu/view-stock-inventory/{id}', 'LoloPinoyLechonDeCebuController@viewStockInventory')->name('lolo-pinoy-lechon-de-cebu.viewStockInventory');

	//route for commissary inventory of stocks
	Route::get('/lolo-pinoy-lechon-de-cebu/commissary/inventory-of-stocks', 'LoloPinoyLechonDeCebuController@inventoryOfStocks')->name('lolo-pinoy-lechon-de-cebu.inventoryOfStocks');

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/view-inventory-of-stocks/{id}',
		'LoloPinoyLechonDeCebuController@viewInventoryOfStocks')
		->name('lolo-pinoy-lechon-de-cebu.viewInventoryOfStocks');

	Route::patch(
		'/lolo-pinoy-lechon-de-cebu/inventory-stock-update/{id}',
		'LoloPinoyLechonDeCebuController@inventoryStockUpdate')
		->name('lolo-pinoy-lechon-de-cebu.inventoryStockUpdate');

	//route for download PDF file
	Route::get('/lolo-pinoy-lechon-de-cebu/printDelivery/{id}', 'LoloPinoyLechonDeCebuController@printDelivery')->name('lolo-pinoy-lechon-de-cebu.printDelivery');

	//print Duplicate delivery receipt
	Route::get('/lolo-pinoy-lechon-de-cebu/printDuplicateDelivery/{id}', 'LoloPinoyLechonDeCebuController@printDuplicateDelivery')->name('lolo-pinoy-lechon-de-cebu.printDuplicateDelivery');

	//print PO
	Route::get('/lolo-pinoy-lechon-de-cebu/printPO/{id}', 'LoloPinoyLechonDeCebuController@printPO')->name('lolo-pinoy-lechon-de-cebu.printPO');

	Route::get('/lolo-pinoy-lechon-de-cebu/printBillingStatement/{id}', 'LoloPinoyLechonDeCebuController@printBillingStatement')->name('lolo-pinoy-lechon-de-cebu.printBillingStatement');

	Route::get('/lolo-pinoy-lechon-de-cebu/printPaymentVoucher/{id}', 'LoloPinoyLechonDeCebuController@printPaymentVoucher')->name('lolo-pinoy-lechon-de-cebu.printPaymentVoucher');

	Route::patch(
		'/lolo-pinoy-lechon-de-cebu/s-account/{id}',
		'LoloPinoyLechonDeCebuController@sAccountUpdate')
		->name('lolo-pinoy-lechon-de-cebu.sAccountUpdate');

	//Lolo Pinoy Grill Commissary
	Route::get('/lolo-pinoy-grill-commissary', 'LoloPinoyGrillCommissaryController@index')->name('lolo-pinoy-grill-commissary.index');

	//delivery receipt
	Route::get('/lolo-pinoy-grill-commissary/delivery-receipt-form', 'LoloPinoyGrillCommissaryController@deliveryReceiptForm')->name('lolo-pinoy-grill-commissary.deliveryReceiptForm');

	//store deivery receipt
	Route::post(
		'/lolo-pinoy-grill-commissary/store-delivery-receipt', 
		'LoloPinoyGrillCommissaryController@storeDeliveryReceipt')
		->name('lolo-pinoy-grill-commissary.storeDeliveryReceipt');

	Route::get(
		'/lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-commissary-delivery-receipt/{id}', 
		'LoloPinoyGrillCommissaryController@editDeliveryReceipt')
		->name('lolo-pinoy-grill-commissary.editDeliveryReceipt');

	Route::patch('/lolo-pinoy-grill-commissary/update-delivery-receipt/{id}', 'LoloPinoyGrillCommissaryController@updateDeliveryReceipt')->name('lolo-pinoy-grill-commissary.updateDeliveryReceipt');

	//add new delivery receipt lolo pinoy grill commissary
	Route::get('/lolo-pinoy-grill-commissary/add-new-lolo-pinoy-grill-delivery-receipt/{id}', 'LoloPinoyGrillCommissaryController@addNewDelivery')->name('lolo-pinoy-grill-commissary.addNewDelivery');

	//save add new delivery receipt lolo pinoy grill 
	Route::post('/lolo-pinoy-grill-commissary/add-new-lolo-pinoy-grill-delivery-receipt-data/{id}', 'LoloPinoyGrillCommissaryController@addNewDeliveryReceiptData')->name('lolo-pinoy-grill-commissary.addNewDeliveryReceiptData');

	//
	Route::patch('/lolo-pinoy-grill-commissary/update-dr/{id}', 'LoloPinoyGrillCommissaryController@updateDr')->name('lolo-pinoy-grill-commissary.updateDr');


	//delivery receipt lists
	Route::get('/lolo-pinoy-grill-commissary/delivery-receipt/lists', 'LoloPinoyGrillCommissaryController@deliveryReceiptList')->name('lolo-pinoy-grill-commissary.deliveryReceiptList');

	//view 
	Route::get('/lolo-pinoy-grill-commissary/view-lolo-pinoy-grill-commissary-delivery-receipt/{id}', 'LoloPinoyGrillCommissaryController@viewDeliveryReceipt')->name('lolo-pinoy-grill-commissary.viewDeliveryReceipt');

	//print delivery receipt lolo pinoy grill
	Route::get('/lolo-pinoy-grill-commissary/prntDeliveryReceipt/{id}', 'LoloPinoyGrillCommissaryController@printDelivery')->name('lolo-pinoy-grill-commissary.printDelivery');

	//route for purchase order lolo pinoy grill
	Route::get('/lolo-pinoy-grill-commissary/purchase-order', 'LoloPinoyGrillCommissaryController@purchaseOrder')->name('lolo-pinoy-grill-commissary.purchaseOrder
		');

	//store purchase order lolo pinoy grill
	Route::post('/lolo-pinoy-grill-commissary/store', 'LoloPinoyGrillCommissaryController@store')->name('lolo-pinoy-grill-commissary');

	//edit purchase order lolo pinoy grill
	Route::get('/lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-commissary-purchase-order/{id}', 'LoloPinoyGrillCommissaryController@edit')->name('lolo-pinoy-grill-commissary.edit');

	//update purchase order lolo pinoy grill
	Route::patch('/lolo-pinoy-grill-commissary/update/{id}', 'LoloPinoyGrillCommissaryController@update')->name('lolo-pinoy-grill-commissary.update');


	//add new purchase order lolo pinoy grill
	Route::get('/lolo-pinoy-grill-commissary/add-new/{id}', 'LoloPinoyGrillCommissaryController@addNew')->name('lolo-pinoy-grill-commissary.addNew');

	//store add new purchase order lolo pinoy grill
	Route::post('/lolo-pinoy-grill-commissary/add-new-purchase-order/{id}', 'LoloPinoyGrillCommissaryController@addNewPurchaseOrder')->name('lolo-pinoy-grill-commissary.addNewPurchaseOrder');


	Route::patch('/lolo-pinoy-grill-commissary/update-po/{id}', 'LoloPinoyGrillCommissaryController@updatePo')->name('lolo-pinoy-grill-commissary.updatePo');


	//lolo pinoy grill commissary purchase order lists
	Route::get('/lolo-pinoy-grill-commissary/purchase-order-lists', 'LoloPinoyGrillCommissaryController@purchaseOrderAllLists')->name('lolo-pinoy-grill-commissary.purchaseOrderAllLists');

	//billing statement form lolo pinoy grill commissary
	Route::get('/lolo-pinoy-grill-commissary/billing-statement-form', 'LoloPinoyGrillCommissaryController@billingStatementForm')->name('lolo-pinoy-grill-commissary.billingStatementForm');

	//save billing statement form lolo pinoy grill commissary
	Route::post('/lolo-pinoy-grill-commissary/store-billing-statement', 'LoloPinoyGrillCommissaryController@storeBillingStatement')->name('lolo-pinoy-grill-commissary.storeBillingStatement');


	//edit billing statement form lolo pinoy grill commissary
	Route::get('/lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-commissary-billing-statement/{id}', 'LoloPinoyGrillCommissaryController@editBillingStatement')->name('lolo-pinoy-grill-commissary.editBillingStatement');

	Route::patch('/lolo-pinoy-grill-commissary/update-billing-info/{id}', 'LoloPinoyGrillCommissaryController@updateBillingInfo')->name('lolo-pinoy-grill-commissary.updateBillingInfo');

	Route::get('/lolo-pinoy-grill-commissary/add-new-lolo-pinoy-grill-billing-statement/{id}', 'LoloPinoyGrillCommissaryController@addNewBillingStatement')->name('lolo-pinoy-grill-commissary.addNewBillingStatement');

	Route::post('/lolo-pinoy-grill-commissary/add-new-billing-data/{id}', 'LoloPinoyGrillCommissaryController@addNewBillingData')->name('lolo-pinoy-grill-commissary.addNewBillingData');

	//update billing statement in add new
	Route::patch('/lolo-pinoy-grill-commissary/update-billing-statement/{id}', 'LoloPinoyGrillCommissaryController@updateBillingStatement')->name('lolo-pinoy-grill-commissary.updateBillingStatement');


	//billing statement lists
	Route::get('/lolo-pinoy-grill-commissary/billing-statement-lists', 'LoloPinoyGrillCommissaryController@billingStatementLists')->name('lolo-pinoy-grill-commissary.billingStatementLists');

	//view billing statement
	Route::get('/lolo-pinoy-grill-commissary/view-lolo-pinoy-grill-billing-statement/{id}', 'LoloPinoyGrillCommissaryController@viewBillingStatement')->name('lolo-pinoy-grill-commissary.viewBillingStatement');

	
	//cash vouchers lolo pinoy grill
	Route::get('/lolo-pinoy-grill-commissary/cash-vouchers', 'LoloPinoyGrillCommissaryController@cashVouchers')->name('lolo-pinoy-grill-commissary.cashVouchers');

	//cheque vouchers lolo pinoy grill
	Route::get('/lolo-pinoy-grill-commissary/cheque-vouchers', 'LoloPinoyGrillCommissaryController@chequeVouchers')->name('lolo-pinoy-grill-commissary.chequeVouchers');

	//view payment voucher lolo pinoy grill
	Route::get('/lolo-pinoy-grill-commissary/view-lolo-pinoy-grill-payment-voucher/{id}', 'LoloPinoyGrillCommissaryController@viewPaymentVoucher')->name('lolo-pinoy-grill-commissary.viewPaymentVoucher');

	//sales invoice lolo pinoy grill
	Route::get('/lolo-pinoy-grill-commissary/sales-invoice-form', 'LoloPinoyGrillCommissaryController@salesInvoiceForm')->name('lolo-pinoy-grill-commissary.salesInvoiceForm');

	Route::post('/lolo-pinoy-grill-commissary/store-sales-invoice', 'LoloPinoyGrillCommissaryController@storeSalesInvoice')->name('lolo-pinoy-grill-commissary.storeSalesInvoice');

	Route::get('/lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-sales-invoice/{id}', 'LoloPinoyGrillCommissaryController@editSalesInvoice')->name('lolo-pinoy-grill-commissary.editSalesInvoice');

	Route::patch('/lolo-pinoy-grill-commissary/update-sales-invoice/{id}', 'LoloPinoyGrillCommissaryController@updateSalesInvoice')->name('lolo-pinoy-grill-commissary.updateSalesInvoice');

	Route::get('/lolo-pinoy-grill-commissary/add-new-lolo-pinoy-grill-sales-invoice/{id}', 'LoloPinoyGrillCommissaryController@addNewSalesInvoice')->name('lolo-pinoy-grill-commissary.addNewSalesInvoice');

	Route::post('/lolo-pinoy-grill-commissary/add-new-sales-invoice-data/{id}', 'LoloPinoyGrillCommissaryController@addNewSalesInvoiceData')->name('lolo-pinoy-grill-commissary.addNewSalesInvoiceData');

	Route::patch('/lolo-pinoy-grill-commissary/update-si/{id}', 'LoloPinoyGrillCommissaryController@updateSi')->name('lolo-pinoy-grill-commissary.updateSi');


	//view 
	Route::get('/lolo-pinoy-grill-commissary/view-lolo-pinoy-grill-sales-invoice/{id}', 'LoloPinoyGrillCommissaryController@viewSalesInvoice')->name('lolo-pinoy-grill-commissary.viewSalesInvoice');


	//store statement of account
	Route::post('/lolo-pinoy-grill-commissary/store-statement-account', 'LoloPinoyGrillCommissaryController@storeStatementAccount')->name('lolo-pinoy-grill-commissary.storeStatementAccount');

	//edit
	Route::get('/lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-statement-of-account/{id}', 'LoloPinoyGrillCommissaryController@editStatementOfAccount')->name('lolo-pinoy-grill-commissary.editStatementOfAccount');


	Route::get('/lolo-pinoy-grill-commissary/statement-of-account-lists', 'LoloPinoyGrillCommissaryController@statementOfAccountList')->name('lolo-pinoy-grill-commissary.statementOfAccountList');

	Route::patch(
		'/lolo-pinoy-grill-commissary/s-account/{id}',
		'LoloPinoyGrillCommissaryController@sAccountUpdate')
		->name('lolo-pinoy-grill-commissary.sAccountUpdate');

	Route::get(
		'/lolo-pinoy-grill-commissary/view-statement-account/{id}',
		'LoloPinoyGrillCommissaryController@viewStatementAccount')
		->name('lolo-pinoy-grill-commissary.viewStatementAccount');

	Route::get(
		'/lolo-pinoy-grill-commissary/printSOA/{id}',
		'LoloPinoyGrillCommissaryController@printSOA')
		->name('lolo-pinoy-grill-commissary.printSOA');

	//
	Route::get('/lolo-pinoy-grill-commissary/view-lolo-pinoy-grill-statement-account/{id}', 'LoloPinoyGrillCommissaryController@viewStatementAccount')->name('lolo-pinoy-grill-commissary.viewStatementAccount');


	Route::get(
		'/lolo-pinoy-grill-commissary/printDelivery/{id}',
		'LoloPinoyGrillCommissaryController@printDelivery')
		->name('lolo-pinoy-grill-commissary.printDelivery');

	//
	Route::get(
		'/lolo-pinoy-grill-commissary/commissary/raw-materials',
		'LoloPinoyGrillCommissaryController@rawMaterials')
		->name('lolo-pinoy-grill-commissary.rawMaterials');

	Route::get(
		'/lolo-pinoy-grill-commissary/commissary/create-raw-materials',
		'LoloPinoyGrillCommissaryController@createRawMaterials')
		->name('lolo-pinoy-grill-commissary.createRawMaterials');

	Route::post(
		'/lolo-pinoy-grill-commissary/commissary/create-raw-materials',
		'LoloPinoyGrillCommissaryController@addRawMaterial')
		->name('lolo-pinoy-grill-commissary.addRawMaterial');

	Route::get(
		'/lolo-pinoy-grill-commissary/commissary/edit-raw-materials/{id}',
		'LoloPinoyGrillCommissaryController@editRawMaterials')
		->name('lolo-pinoy-grill-commissary.editRawMaterials');

	Route::patch(
		'/lolo-pinoy-grill-commissary/commissary/update-raw-material/{id}',
		'LoloPinoyGrillCommissaryController@updateRawMaterial')
		->name('lolo-pinoy-grill-commissary.updateRawMaterial');



	Route::get(
		'/lolo-pinoy-grill-commissary/commissary/stocks-inventory',
		'LoloPinoyGrillCommissaryController@stocksInventory')
		->name('lolo-pinoy-grill-commissary.stocksInventory');

	Route::get(
		'/lolo-pinoy-grill-commissary/view-raw-material-details/{id}',
		'LoloPinoyGrillCommissaryController@viewRawMaterialDetails')
		->name('lolo-pinoy-grill-commissary.viewRawMaterialDetails');

	Route::get(
		'/lolo-pinoy-grill-commissary/raw-material/add-delivery-in/{id}',
		'LoloPinoyGrillCommissaryController@rawMaterialAddDeliveryIn')
		->name('lolo-pinoy-grill-commissary.rawMaterialAddDeliveryIn');

	Route::post(
		'/lolo-pinoy-grill-commissary/add-delivery-in-raw-material/{id}',
		'LoloPinoyGrillCommissaryController@addDeliveryInRawMaterial')
		->name('lolo-pinoy-grill-commissary.addDeliveryInRawMaterial');

	Route::get(
		'/lolo-pinoy-grill-commissary/raw-material/request-stock-out/{id}',
		'LoloPinoyGrillCommissaryController@rawMaterialRequestStockOut')
		->name('lolo-pinoy-grill-commissary.rawMaterialRequestStockOut');

	Route::post(
		'/lolo-pinoy-grill-commissary/request-stock-out/{id}',
		'LoloPinoyGrillCommissaryController@requestStockOut')
		->name('lolo-pinoy-grill-commissary.requestStockOut');

	Route::get(
		'/lolo-pinoy-grill-commissary/view-stock-inventory/{id}',
		'LoloPinoyGrillCommissaryController@viewStockInventory')
		->name('lolo-pinoy-grill-commissary.viewStockInventory');

	Route::get(
		'/lolo-pinoy-grill-commissary/commissary/delivery-outlets',
		'LoloPinoyGrillCommissaryController@commissaryDeliveryOutlet')
		->name('lolo-pinoy-grill-commissary.commissaryDeliveryOutlet');


	Route::get(
		'/lolo-pinoy-grill-commissary/commissary/inventory-of-stocks',
		'LoloPinoyGrillCommissaryController@inventoryOfStocks')
		->name('lolo-pinoy-grill-commissary.inventoryOfStocks');

	Route::get(
		'/lolo-pinoy-grill-commissary/view-inventory-of-stocks/{id}',
		'LoloPinoyGrillCommissaryController@viewInventoryOfStocks')
		->name('lolo-pinoy-grill-commissary.viewInventoryOfStocks');

	Route::patch(
		'/lolo-pinoy-grill-commissary/inventory-stock-update/{id}',
		'LoloPinoyGrillCommissaryController@inventoryStockUpdate')
		->name('lolo-pinoy-grill-commissary.inventoryStockUpdate');

	Route::get(
		'/lolo-pinoy-grill-commissary/commissary/production',
		'LoloPinoyGrillCommissaryController@production')
		->name('lolo-pinoy-grill-commissary.production');
	
	Route::get(
		'/lolo-pinoy-grill-commissary/petty-cash-list',
		'LoloPinoyGrillCommissaryController@pettyCashList')
		->name('lolo-pinoy-grill-commissary.pettyCashList');

	Route::get(
		'/lolo-pinoy-grill-commissary/utilities',
		'LoloPinoyGrillCommissaryController@utilities')
		->name('lolo-pinoy-grill-commissary.utilities');

	Route::post(
		'/lolo-pinoy-grill-commissary/utilities/add-bill',
		'LoloPinoyGrillCommissaryController@addBills')
		->name('lolo-pinoy-grill-commissary.addBills');
	
	Route::post(
		'/lolo-pinoy-grill-commissary/utilities/add-internet',
		'LoloPinoyGrillCommissaryController@addInternet')
		->name('lolo-pinoy-grill-commissary.addInternet');
	
	Route::get(
		'/lolo-pinoy-grill-commissary/utilities/view-veco/{id}',
		'LoloPinoyGrillCommissaryController@viewBills')
		->name('lolo-pinoy-grill-commissary.viewBills');

	Route::get(
		'/lolo-pinoy-grill-commissary/utilities/view-mcwd/{id}',
		'LoloPinoyGrillCommissaryController@viewBills')
		->name('lolo-pinoy-grill-commissary.viewBills');

	Route::get(
		'/lolo-pinoy-grill-commissary/utilities/view-internet/{id}',
		'LoloPinoyGrillCommissaryController@viewBills')
		->name('lolo-pinoy-grill-commissary.viewBills');



	Route::get(
		'/lolo-pinoy-grill-commissary/petty-cash/view/{id}',
		'LoloPinoyGrillCommissaryController@viewPettyCash')
		->name('lolo-pinoy-grill-commissary.viewPettyCash');

	//Lolo Pinoy Grill Branches
	Route::get('/lolo-pinoy-grill-branches', 'LoloPinoyGrillBranchesController@index')->name('lolo-pinoy-grill-branches.index');

	
	Route::get(
		'/lolo-pinoy-grill-branches/requisition-slip',
		'LoloPinoyGrillBranchesController@requisitionSlip')
		->name('lolo-pinoy-grill-branches.requisitionSlip');

	Route::post(
		'/lolo-pinoy-grill-branches/store',
		'LoloPinoyGrillBranchesController@store')
		->name('lolo-pinoy-grill-branches.store');

	Route::get(
		'/lolo-pinoy-grill-branches/edit/{id}',
		'LoloPinoyGrillBranchesController@edit')
		->name('lolo-pinoy-grill-branches.edit');

	Route::patch(
		'/lolo-pinoy-grill-branches/update/{id}',
		'LoloPinoyGrillBranchesController@update')
		->name('lolo-pinoy-grill-branches.update');

	Route::get(
		'/lolo-pinoy-grill-branches/add-new/{id}',
		'LoloPinoyGrillBranchesController@addNew')
		->name('lolo-pinoy-grill-branches.addNew');

	Route::post(
		'/lolo-pinoy-grill-branches/add-new-requistion-slip/{id}',
		'LoloPinoyGrillBranchesController@addNewRequisitionSlip')
		->name('lolo-pinoy-grill-branches.addNewRequisitionSlip');

	Route::patch(
		'/lolo-pinoy-grill-branches/update-rs/{id}',
		'LoloPinoyGrillBranchesController@updateRs')
		->name('lolo-pinoy-grill-branches.updateRs');


	Route::get(
		'/lolo-pinoy-grill-branches/requisition-slip-lists',
		'LoloPinoyGrillBranchesController@requisitionSlipList')
		->name('lolo-pinoy-grill-branches.requisitionSlipList');

	Route::get(
		'/lolo-pinoy-grill-branches/view/{id}',
		'LoloPinoyGrillBranchesController@show')
		->name('lolo-pinoy-grill-branches.show');

	Route::get(
		'/lolo-pinoy-grill-branches/printRS/{id}',
		'LoloPinoyGrillBranchesController@printRS')
		->name('lolo-pinoy-grill-branches.printRS');

	Route::get(
		'/lolo-pinoy-grill-branches/requistion/transaction-list',
		'LoloPinoyGrillBranchesController@reqTransactionList')
		->name('lolo-pinoy-grill-branches.reqTransactionList');

	Route::get(
		'/lolo-pinoy-grill-branches/sales-form',
		'LoloPinoyGrillBranchesController@salesInvoiceForm')
		->name('lolo-pinoy-grill-branches.salesInvoiceForm');

	Route::post(
		'/lolo-pinoy-grill-branches/sales-form/add-transaction',
		'LoloPinoyGrillBranchesController@addSalesTransaction')
		->name('addSalesTransaction');

	Route::get(
		'/lolo-pinoy-grill-branches/sales-form/transaction/{id}',
		'LoloPinoyGrillBranchesController@salesTransaction')
		->name('salesTransaction');

	Route::post(
		'/lolo-pinoy-grill-branches/sales-form/transaction/additional',
		'LoloPinoyGrillBranchesController@addSalesAdditional')
		->name('addSalesAdditional');

	Route::post(
		'/lolo-pinoy-grill-branches/sales-form/transaction/settle-transaction/{id}',
		'LoloPinoyGrillBranchesController@settleTransactions')
		->name('settleTransactions');

	Route::get(
		'/lolo-pinoy-grill-branches/sales-form/transaction/detail-transaction/{id}',
		'LoloPinoyGrillBranchesController@detailTransactions')
		->name('detailTransactions');

	Route::post(
		'/lolo-pinoy-grill-branches/sales-form/transaction/pay/{id}',
		'LoloPinoyGrillBranchesController@payCash')
		->name('payCash');

	Route::get(
		'/lolo-pinoy-grill-branches/petty-cash-list',
		'LoloPinoyGrillBranchesController@pettyCashList')
		->name('lolo-pinoy-grill-branches.pettyCashList');

	Route::get(
		'/lolo-pinoy-grill-branches/petty-cash/view/{id}',
		'LoloPinoyGrillBranchesController@viewPettyCash')
		->name('lolo-pinoy-grill-branches.viewPettyCash');
	
	Route::get(
		'/lolo-pinoy-grill-branches/utilities',
		'LoloPinoyGrillBranchesController@utilities')
		->name('lolo-pinoy-grill-branches.utilities');

	Route::post(
		'/lolo-pinoy-grill-branches/utilities/add-bill',
		'LoloPinoyGrillBranchesController@addBills')
		->name('lolo-pinoy-grill-branches.addBills');

	Route::post(
		'/lolo-pinoy-grill-branches/utilities/add-internet',
		'LoloPinoyGrillBranchesController@addInternet')
		->name('lolo-pinoy-grill-branches.addInternet');

	Route::get(
		'/lolo-pinoy-grill-branches/utilities/view-veco/{id}',
		'LoloPinoyGrillBranchesController@viewBills')
		->name('lolo-pioy-grill-branches.viewBills');
	
	Route::get(
		'/lolo-pinoy-grill-branches/utilities/view-mcwd/{id}',
		'LoloPinoyGrillBranchesController@viewBills')
		->name('viewBills');
	
	Route::get(
			'/lolo-pinoy-grill-branches/utilities/view-internet/{id}',
			'LoloPinoyGrillBranchesController@viewBills')
			->name('viewBills');

	Route::get(
		'/lolo-pinoy-grill-branches/store-stock/stock-status',
		'LoloPinoyGrillBranchesController@stockStatus')
		->name('stockStatus');

	Route::get(
		'/lolo-pinoy-grill-branches/store-stock/stock-inventory',
		'LoloPinoyGrillBranchesController@stockInventory')
		->name('stockInventory');

	Route::get(
		'/lolo-pinoy-grill-branches/store-stock/view-stock-inventory/{id}',
		'LoloPinoyGrillBranchesController@viewStockInventory')
		->name('viewStockInventory');

	//Mr Potato
	Route::get('/mr-potato', 'MrPotatoController@index')->name('mr-potato.index');

	//purchase order
	Route::get('/mr-potato/purchase-order', 'MrPotatoController@purchaseOrder')->name('mr-potato.purchaseOrder');

	//save purchase order
	Route::post('/mr-potato/store', 'MrPotatoController@store')->name('mr-potato.store');

	Route::get('/mr-potato/edit-mr-potato-purchase-order/{id}', 'MrPotatoController@edit')->name('mr-potato.edit');

	Route::patch(
		'/mr-potato/update/{id}', 
		'MrPotatoController@update')
		->name('mr-potato.update');

	//add new Po
	Route::post	(
		'/mr-potato/add-new/{id}', 
		'MrPotatoController@addNew')
		->name('mr-potato.addNew');

	Route::get(
		'/mr-potato/purchase-order/printPO/{id}',
		'MrPotatoController@printPO')
		->name('mr-potato.printPO');

	Route::post(
		'/mr-potato/add-new-purchase-order/{id}', 
		'MrPotatoController@addNewPurchaseOrder')
		->name('mr-potato.addNewPurchaseOrder');

	Route::patch(
		'/mr-potato/update-po/{id}',
		'MrPotatoController@updatePo')
		->name('mr-potato.updatePo');

	

	//purchase order lists
	Route::get(
		'/mr-potato/purchase-order-lists',
		'MrPotatoController@purchaseOrderAllLists')
		->name('mr-potato.purchaseOrderAllLists');

	//view
	Route::get(
		'/mr-potato/view-mr-potato-purchase-order/{id}',
		'MrPotatoController@show')
		->name('mr-potato.show');

	Route::get(
		'/mr-potato/delivery-receipt-form',
		'MrPotatoController@deliveryReceiptForm')
		->name('mr-potato.deliveryReceiptForm');

	//store delivery receipt
	Route::post(
		'/mr-potato/store-delivery-receipt',
		'MrPotatoController@storeDeliveryReceipt')
		->name('mr-potato.storeDeliveryReceipt');

	Route::get(
		'/mr-potato/edit-mr-potato-delivery-receipt/{id}',
		'MrPotatoController@editDeliveryReceipt')
		->name('mr-potato.editDeliveryReceipt');

	Route::patch(
		'/mr-potato/update-delivery-receipt/{id}',
		'MrPotatoController@updateDeliveryReceipt')
		->name('mr-potato.updateDeliveryReceipt');

	Route::get(
		'/mr-potato/add-new-delivery-receipt/{id}',
		'MrPotatoController@addNewDelivery')
		->name('mr-potato.addNewDelivery');

	Route::post(
		'/mr-potato/add-new-delivery-receipt-data/{id}',
		'MrPotatoController@addNewDeliveryReceiptData')
		->name('mr-potato.addNewDeliveryReceiptData');

	Route::patch(
		'/mr-potato/update-dr/{id}',
		'MrPotatoController@updateDr')
		->name('mr-potato.updateDr');



	Route::get(
		'/mr-potato/delivery-receipt-lists',
		'MrPotatoController@deliveryReceiptList')
		->name('deliveryReceiptList');

	Route::get(
		'/mr-potato/view-mr-potato-delivery-receipt/{id}',
		'MrPotatoController@viewDeliveryReceipt')
		->name('mr-potato.viewDeliveryReceipt');



	Route::get(
		'/mr-potato/cash-vouchers',
		'MrPotatoController@cashVouchers')
		->name('mr-potato.cashVouchers');

	Route::get(
		'/mr-potato/cheque-vouchers',
		'MrPotatoController@chequeVouchers')
		->name('mr-potato.chequeVouchers');

	//sales invoice
	Route::get(
		'/mr-potato/sales-invoice-form',
		'MrPotatoController@salesInvoiceForm')
		->name('mr-potato.salesInvoiceForm');

	Route::post(
		'/mr-potato/store-sales-invoice',
		'MrPotatoController@storeSalesInvoice')
		->name('mr-potato.storeSalesInvoice');

	Route::get(
		'/mr-potato/edit-mr-potato-sales-invoice/{id}',
		'MrPotatoController@editSalesInvoice')
		->name('mr-potato.editSalesInvoice');

	Route::patch(
		'/mr-potato/update-sales-invoice/{id}',
		'MrPotatoController@updateSalesInvoice')
		->name('mr-potato.updateSalesInvoice');

	Route::get(
		'/mr-potato/add-new-mr-potato-sales-invoice/{id}',
		'MrPotatoController@addNewSalesInvoice')
		->name('mr-potato.addNewSalesInvoice');

	Route::post(
		'/mr-potato/add-new-sales-invoice-data/{id}',
		'MrPotatoController@addNewSalesInvoiceData')
		->name('mr-potato.addNewSalesInvoiceData');

	Route::patch(
		'/mr-potato/update-si/{id}',
		'MrPotatoController@updateSi')
		->name('mr-potato.updateSi');

	

	Route::get(
		'/mr-potato/view-mr-potato-sales-invoice/{id}',
		'MrPotatoController@viewSalesInvoice')
		->name('mr-potato.viewSalesInvoice');

	Route::get(
		'/mr-potato/printDelivery/{id}',
		'MrPotatoController@printDelivery')
		->name('mr-potato.printDelivery');

	Route::get(
		'/mr-potato/petty-cash-list',
		'MrPotatoController@pettyCashList')
		->name('mr-potato.pettyCashList');

	Route::get(
		'/mr-potato/utilities',
		'MrPotatoController@utilities')
		->name('mr-potato.utilities');

	Route::post(
		'/mr-potato/utilities/add-bill',
		'MrPotatoController@addBills')
		->name('mr-potato.addBills');
	
	Route::post(
		'/mr-potato/utilities/add-internet',
		'MrPotatoController@addInternet')
		->name('mr-potato.addInternet');

	Route::get(
		'/mr-potato/utilities/view-veco/{id}',
		'MrPotatoController@viewBills')
		->name('mr-potato.viewBills');
	
	Route::get(
		'/mr-potato/utilities/view-mcwd/{id}',
		'MrPotatoController@viewBills')
		->name('mr-potato.viewBills');

	//Ribos Bar
	Route::get('/ribos-bar', 'RibosBarController@index')->name('ribos-bar.index');

	Route::get(
		'/ribos-bar/delivery-receipt-form',
		'RibosBarController@deliveryReceiptForm')
		->name('ribos-bar.deliveryReceiptForm');

	//store delivery receipt
	Route::post(
		'/ribos-bar/store-delivery-receipt',
		'RibosBarController@storeDeliveryReceipt')
		->name('ribos-bar.storeDeliveryReceipt');

	Route::get(
		'/ribos-bar/edit-ribos-bar-delivery-receipt/{id}',
		'RibosBarController@editDeliveryReceipt')
		->name('ribos-bar.editDeliveryReceipt');

	Route::patch(
		'/ribos-bar/update-delivery-receipt/{id}',
		'RibosBarController@updateDeliveryReceipt')
		->name('ribos-bar.updateDeliveryReceipt');

	Route::get(
		'/ribos-bar/add-new-delivery-receipt/{id}',
		'RibosBarController@addNewDelivery')
		->name('ribos-bar.addNewDelivery');

	Route::post(
		'/ribos-bar/add-new-delivery-receipt-data/{id}',
		'RibosBarController@addNewDeliveryReceiptData')
		->name('ribos-bar.addNewDeliveryReceiptData');

	Route::patch(
		'/ribos-bar/update-dr/{id}',
		'RibosBarController@updateDr')
		->name('ribos-bar.updateDr');



	Route::get(
		'/ribos-bar/delivery-receipt-lists',
		'RibosBarController@deliveryReceiptList')
		->name('ribos-bar.deliveryReceiptList');

	Route::get(
		'/ribos-bar/view-ribos-bar-delivery-receipt/{id}',
		'RibosBarController@viewDeliveryReceipt')
		->name('ribos-bar.viewDeliveryReceipt');

	Route::get(
		'/ribos-bar/printDelivery/{id}',
		'RibosBarController@printDelivery')
		->name('ribos-bar.printDelivery');

	Route::get(
		'/ribos-bar/purchase-order',
		'RibosBarController@purchaseOrder')
		->name('ribos-bar.purchaseOrder');

	//store po 
	Route::post(
		'/ribos-bar/store',
		'RibosBarController@store')
		->name('ribos-bar.store');

	Route::get(
		'/ribos-bar/edit-ribos-bar-purchase-order/{id}',
		'RibosBarController@edit')
		->name('ribos-bar.edit');

	Route::patch(
		'/ribos-bar/update/{id}',
		'RibosBarController@update')
		->name('ribos-bar.update');

	Route::post(
		'/ribos-bar/add-new/{id}',
		'RibosBarController@addNew')
		->name('ribos-bar.addNew');

	Route::post(
		'/ribos-bar/add-new-purchase-order/{id}',
		'RibosBarController@addNewPurchaseOrder')
		->name('ribos-bar.addNewPurchaseOrder');

	Route::patch(
		'/ribos-bar/update-po/{id}',
		'RibosBarController@updatePo')
		->name('ribos-bar.updatePo');

	Route::get(
		'/ribos-bar/purchase-order/printPO/{id}',
		'RibosBarController@printPO')
		->name('ribos-bar.printPO');
	

	Route::get(
		'/ribos-bar/purchase-order-lists',
		'RibosBarController@purchaseOrderList')
		->name('ribos-bar.purchaseOrderList');

	Route::get(
		'/ribos-bar/view-ribos-bar-purchase-order/{id}',
		'RibosBarController@show')
		->name('ribos-bar.show');

	Route::get(
		'/ribos-bar/cash-vouchers',
		'RibosBarController@cashVoucher')
		->name('ribos-bar.cashVoucher');

	Route::get(
		'/ribos-bar/cheque-vouchers',
		'RibosBarController@chequeVoucher')
		->name('ribos-bar.chequeVoucher');

	Route::get(
		'/ribos-bar/view-ribos-bar-payment-voucher/{id}',
		'RibosBarController@viewPaymentVoucher')
		->name('ribos-bar.viewPaymentVoucher');

	//sales invoice 
	Route::get(
		'/ribos-bar/sales-invoice-form',
		'RibosBarController@salesInvoiceForm')
		->name('ribos-bar.salesInvoiceForm');

	Route::post(
		'/ribos-bar/store-sales-invoice',
		'RibosBarController@storeSalesInvoice')
		->name('ribos-bar.storeSalesInvoice');

	Route::get(
		'/ribos-bar/edit-ribos-bar-sales-invoice/{id}',
		'RibosBarController@editSalesInvoice')
		->name('ribos-bar.editSalesInvoice');

	Route::patch(
		'/ribos-bar/update-sales-invoice/{id}',
		'RibosBarController@updateSalesInvoice')
		->name('ribos-bar.updateSalesInvoice');

	Route::get(
		'/ribos-bar/add-new-ribos-bar-sales-invoice/{id}',
		'RibosBarController@addNewSalesInvoice')
		->name('ribos-bar.addNewSalesInvoice');

	Route::post(
		'/ribos-bar/add-new-sales-invoice-data/{id}',
		'RibosBarController@addNewSalesInvoiceData')
		->name('ribos-bar.addNewSalesInvoiceData');

	Route::patch(
		'/ribos-bar/update-si/{id}',
		'RibosBarController@updateSi')
		->name('ribos-bar.updateSi');

	

	Route::get(
		'/ribos-bar/view-ribos-bar-sales-invoice/{id}',
		'RibosBarController@viewSalesInvoice')
		->name('ribos-bar.viewSalesInvoice');

	Route::get(
		'/ribos-bar/billing-statement-form',
		'RibosBarController@billingStatementForm')
		->name('ribos-bar.billingStatementForm');

	Route::post(
		'/ribos-bar/store-billing-statement',
		'RibosBarController@storeBillingStatement')
		->name('ribos-bar.storeBillingStatement');

	Route::get(
		'/ribos-bar/edit-ribos-bar-billing-statement/{id}',
		'RibosBarController@editBillingStatement')
		->name('ribos-bar.editBillingStatement');

	Route::patch(
		'/ribos-bar/update-billing-info/{id}',
		'RibosBarController@updateBillingInfo')
		->name('ribos-bar.updateBillingInfo');

	Route::get(
		'/ribos-bar/add-new-ribos-bar-billing/{id}',
		'RibosBarController@addNewBilling')
		->name('ribos-bar.addNewBilling');

	Route::post(
		'/ribos-bar/add-new-billing-data/{id}',
		'RibosBarController@addNewBillingData')
		->name('ribos-bar.addNewBillingData');

	Route::patch(
		'/ribos-bar/update-billing-statement/{id}',
		'RibosBarController@updateBillingStatement')
		->name('ribos-bar.updateBillingStatement');



	Route::get(
		'/ribos-bar/billing-statement-lists',
		'RibosBarController@billingStatementLists')
		->name('ribos-bar.billingStatementLists');

	Route::get(
		'/ribos-bar/view-ribos-bar-billing-statement/{id}',
		'RibosBarController@viewBillingStatement')
		->name('ribos-bar.viewBillingStatement');

	Route::get(
		'/ribos-bar/statement-of-account-form',
		'RibosBarController@statementOfAccountForm')
		->name('ribos-bar.statementOfAccountForm');

	Route::post(
		'/ribos-bar/store-statement-account',
		'RibosBarController@storeStatementAccount')
		->name('ribos-bar.storeStatementAccount');

	Route::get(
		'/ribos-bar/edit-ribos-bar-statement-of-account/{id}',
		'RibosBarController@editStatementOfAccount')
		->name('ribos-bar.editStatementAccount');

	Route::patch(
		'/ribos-bar/update-statement-info/{id}',
		'RibosBarController@updateStatementInfo')
		->name('ribos-bar.updateStatementInfo');

	Route::get(
		'/ribos-bar/statement-of-account-lists',
		'RibosBarController@statementOfAccountList')
		->name('ribos-bar.statementOfAccountList');

	Route::get(
		'/ribos-bar/view-ribos-bar-statement-account/{id}',
		'RibosBarController@viewStatementAccount')
		->name('ribos-bar.viewStatementAccount');

	Route::get(
		'/ribos-bar/cashiers-form',
		'RibosBarController@cashiersForm')
		->name('ribos-bar.cashiersForm');

	Route::get(
		'/ribos-bar/edit-cashiers-report-inventory-list/{id}',
		'RibosBarController@editCashiersForm')
		->name('ribos-bar.editCashiersForm');

	Route::post(
		'/ribos-bar/cashiers-store-form',
		'RibosBarController@cashiersFormStore')
		->name('ribos-bar.cashiersFormStore');

	Route::patch(
		'/ribos-bar/update-cashiers-form/{id}',
		'RibosBarController@updateCashiersForm')
		->name('ribos-bar.updateCashiersForm');	

	Route::post(
		'/ribos-bar/add-cashiers-list/{id}',
		'RibosBarController@addCashiersList')
		->name('ribos-bar.addCashiersList');

	Route::get(
		'/ribos-bar/cashiers-report/inventory-list',
		'RibosBarController@cashiersInventoryList')
		->name('ribos-bar.cashiersInventoryList');

	Route::get(
		'/ribos-bar/cashiers-report/view-inventory-list/{id}',
		'RibosBarController@viewCashiersReportList')
		->name('ribos-bar.viewCashiersReportList');

	Route::patch(
		'/ribos-bar/update-item/{id}',
		'RibosBarController@updateItem')
		->name('ribos-bar.updateItem');

	

	Route::get(
		'/ribos-bar/cashiers-report/printCashiersReport/{id}',
		'RibosBarController@printCashiersReport')
		->name('ribos-bar.printCashiersReport');

	Route::get(
		'ribos-bar/petty-cash-list',
		'RibosBarController@pettyCashList')
		->name('ribos-bar.pettyCashList');
	
	Route::get(
		'/ribos-bar/utilities',
		'RibosBarController@utilities')
		->name('ribos-bar.utilities');
	
	Route::post(
		'/ribos-bar/utilities/add-bill',
		'RibosBarController@addBills')
		->name('ribos-bar.addBills');
	
	Route::post(
		'/ribos-bar/utilities/add-internet',
		'RibosBarController@addInternet')
		->name('ribos-bar.addInternet');

	Route::get(
		'/ribos-bar/utilities/view-veco/{id}',
		'RibosBarController@viewBills')
		->name('ribos-bar.viewBills');

	Route::get(
		'/ribos-bar/utilities/view-mcwd/{id}',
		'RibosBarController@viewBills')
		->name('ribos-bar.viewBills');
	
	Route::get(
		'/ribos-bar/utilities/view-internet/{id}',
		'RibosBarController@viewBills')
		->name('ribos-bar.viewBills');
	
	Route::get(
		'/ribos-bar/petty-cash/view/{id}',
		'RibosBarController@viewPettyCash')
		->name('ribo-bar.viewPettyCash');

	Route::get(
		'/ribos-bar/store-stock/raw-materials',
		'RibosBarController@rawMaterials')
		->name('ribos-bar.rawMaterials');
	
	Route::post(
		'/ribos-bar/store-stock/raw-materials/add-raw',
		'RibosBarController@addRawMaterial')
		->name('ribos-bar.addRawMaterial');

	Route::get(
		'/ribos-bar/store-stock/view-raw-material-details/{id}',
		'RibosBarController@viewRawMaterialDetails')
		->name('ribos-bar.viewRawMaterialDetails');

	Route::post(
		'/ribos-bar/store-stock/add-delivery-in',
		'RibosBarController@addDeliveryIn')
		->name('ribos-bar.addDeliveryIn');
	
	Route::post(
			'/ribos-bar/store-stock/request-stock-out',
			'RibosBarController@addDeliveryIn')
			->name('ribos-bar.addDeliveryIn');
	
	Route::get(
		'/ribos-bar/store-stock/stocks-inventory',
		'RibosBarController@stocksInventory')
		->name('ribos-bar.stocksInventory');

	Route::get(
		'/ribos-bar/store-stock/delivery-outlets',
		'RibosBarController@deliveryOutlet')
		->name('ribos-bar.deliveryOutlet');
	
	Route::get(
		'/ribos-bar/store-stock/view-stock-inventory/{id}',
		'RibosBarController@viewStockInventory')
		->name('ribos-bar.viewStockInventory');

	Route::get(
		'/ribos-bar/store-stock/inventory-of-stocks',
		'RibosBarController@inventoryOfStocks')
		->name('ribos-bar.inventoryOfStocks');	
		
	Route::get(
		'/ribos-bar/store-stock/view-inventory-of-stocks/{id}',
		'RibosBarController@viewInventoryOfStocks')
		->name('ribos-bar.viewInventoryOfStocks');

	Route::patch(
		'/ribos-bar/inventory-stock-update/{id}',
		'RibosBarController@inventoryStockUpdate')
		->name('ribos-bar.inventoryStockUpdate');
		
	//DNO Personal
	Route::get('/dno-personal', 'DnoPersonalController@index')->name('dno-personal');

	


	Route::post(
		'/dno-personal/store-credit-card',
		'DnoPersonalController@storeCreditCard')
		->name('dno-pesonal.storeCreditCard');

	Route::get(
		'/dno-personal/credit-card/ald-accounts',
		'DnoPersonalController@creditCardAccount')
		->name('dno-personal.creditCardAccount');

	Route::get(
		'/dno-personal/credit-card/mod-accounts',
		'DnoPersonalController@creditCardAccount')
		->name('db-personal.creditCardAccount');

	Route::patch(
		'/dno-personal/credit-card/accounts/edit/{id}',
		'DnoPersonalController@editCreditCardAccount')
		->name('dno-personal.creditCardAccount');

	Route::patch(
		'/dno-personal/credit-card/update/{id}',
		'DnoPersonalController@updateCard')
		->name('dno-personal.updateCard');



	Route::get(
		'/dno-personal/credit-card/ald-accounts/transactions/{id}',
		'DnoPersonalController@cardTransaction')
		->name('dno-personal.cardTransaction');

	Route::get(
		'/dno-personal/credit-card/ald-accounts/view/{id}',
		'DnoPersonalController@viewTransaction')
		->name('dno-personal.viewTransaction');

	Route::get(
			'/dno-personal/credit-card/mod-accounts/view/{id}',
			'DnoPersonalController@viewTransaction')
			->name('dno-personal.viewTransaction');

	Route::get(
		'/dno-personal/credit-card/mod-accounts/transactions/{id}',
		'DnoPersonalController@cardTransaction')
		->name('dno-personal.cardTransaction');

	Route::get(
		'/dno-personal/personal-expenses/ald-accounts/transactions/{id}',
		'DnoPersonalController@personalTransaction')
		->name('dno-personal.personalTransaction');
	
	Route::get(
		'/dno-personal/personal-expenses/mod-accounts/transactions/{id}',
		'DnoPersonalController@personalTransaction')
		->name('dno-personal.personalTransaction');
	
	Route::get(
		'/dno-personal/personal-expenses/mod-accounts',
		'DnoPersonalController@index')
		->name('dno-personal.index');

	Route::get(
		'/dno-personal/credit-card/account/printCardTransactions/{id}',
		'DnoPersonalController@printCardTransactions')
		->name('dno-personal.printCardTransactions');

	Route::get(
		'/dno-personal/personal-account/printPersonalTransactions/{id}',
		'DnoPersonalController@printPersonalTransactions')
		->name('dno-personal.printPersonalTransactions');

	Route::get(
		'/dno-personal/cebu-properties',
		'DnoPersonalController@properties')
		->name('dno-personal.properties');

	Route::patch(
		'/dno-personal/properties/update-property/{id}',
		'DnoPersonalController@updateProperty')
		->name('dno-personal.updateProperty');

	Route::get(
		'/dno-personal/manila-properties',
		'DnoPersonalController@properties')
		->name('dno-personal.properties');

	Route::post(
		'/dno-personal/store-properties',
		'DnoPersonalController@storeProperties')
		->name('dno-personal.storeProperties');
		
	
	Route::get(
		'/dno-personal/cebu-properties/view/{id}',
		'DnoPersonalController@viewProperties')
		->name('dno-personal.viewProperties');

	Route::get(
		'/dno-personal/cebu-properties/view-service-provider/{id}',
		'DnoPersonalController@viewServiceProvider')
		->name('dno-personal.viewServiceProvider');

	Route::get(
		'/dno-personal/manila-properties/view/{id}',
		'DnoPersonalController@viewProperties')
		->name('dno-personal.viewProperties');

	Route::post(
		'/dno-personal/properties/add-bill',
		'DnoPersonalController@addOtherBills')
		->name('dno-personal.addOtherBills');
	
	Route::post(
		'/dno-personal/properties/add-pldt',
		'DnoPersonalController@addPLDT')
		->name('dno-personal.addPLDT');

	Route::post(
		'/dno-persona/properties/add-skycable',
		'DnoPersonalController@addSky')
		->name('dno-personal.addSky');

	Route::get(
		'/dno-personal/cebu-properties/view-skycable/{id}',
		'DnoPersonalController@viewBills')
		->name('dno-personal.viewBills');

	Route::get(
		'/dno-personal/cebu-properties/view-veco/{id}',
		'DnoPersonalController@viewBills')
		->name('dno-personal.viewBills');

	Route::get(
		'/dno-personal/cebu-properties/view-mcwd/{id}',
		'DnoPersonalController@viewBills')
		->name('dno-personal.viewBills');

	Route::get(
		'/dno-personal/cebu-properties/view-pldt/{id}',
		'DnoPersonalController@viewBills')
		->name('dno-personal.viewBills');

	Route::get(
			'/dno-personal/manila-properties/view-veco/{id}',
			'DnoPersonalController@viewBills')
			->name('dno-personal.viewBills');

	Route::get(
		'/dno-personal/manila-properties/view-mcwd/{id}',
		'DnoPersonalController@viewBills')
		->name('dno-personal.viewBills');
	
	Route::get(
			'/dno-personal/manila-properties/view-pldt/{id}',
			'DnoPersonalController@viewBills')
			->name('dno-personal.viewBills');
	
	Route::get(
			'/dno-personal/manila-properties/view-skycable/{id}',
			'DnoPersonalController@viewBills')
			->name('dno-personal.viewBills');


	Route::patch(
		'/dno-personal/properties/update/{id}',
		'DnoPersonalController@updateProperties')
		->name('dno-persona.updteProperties');

	Route::patch(
		'/dno-personal/properties/update-pldt/{id}',
		'DnoPersonalController@updatePldt')
		->name('dno-personal.updatePLDT');

	Route::patch(
		'/dno-personal/properties/update-skycable/{id}',
		'DnoPersonalController@updateSky')
		->name('dno-personal.updateSky');

	Route::get(
		'/dno-personal/vehicles',
		'DnoPersonalController@vehicles')
		->name('dno-personal.vehicles');

	Route::patch(
		'/dno-personal/vehicles/update-vehicle/{id}',
		'DnoPersonalController@vehicleUpdate')
		->name('dno-personal.vehicleUpdate');



	Route::post(
		'/dno-personal/vehicles/store-vehicles',
		'DnoPersonalController@storeVehicles')
		->name('dno-personal.storeVehicles');

	Route::get(
		'/dno-personal/vehicles/view/{id}',
		'DnoPersonalController@viewVehicle')
		->name('dno-personal.viewVehicle');

	Route::post(
		'/dno-personal/vehicles/store-document/{id}',
		'DnoPersonalController@storeDocument')
		->name('dno-personal.storeDocument');

	Route::get(
		'/dno-personal/vehicles/or-list/{id}',
		'DnoPersonalController@viewDocumentList')
		->name('dno-personal.viewDocumentList');
	
	Route::get(
		'/dno-personal/vehicles/pms-list/{id}',
		'DnoPersonalController@viewDocumentList')
		->name('dno-personal.viewDocumentList');
	
	Route::post(
		'/dno-personal/vehicles/store-pms/{id}',
		'DnoPersonalController@storePMSDocument')
		->name('dno-personal.storePMSDocument');

	//do ajax call	
	Route::get(
		'/dno-personal/get-data/{id}',
		'DnoPersonalController@getData')
		->name('dno-personal.getData');

	Route::get(
		'/dno-personal/get-cebu-properties/{id}',
		'DnoPersonalController@getCebuProp')
		->name('dno-personal.getCebuProp');

	Route::get(
		'/dno-personal/petty-cash-list',
		'DnoPersonalController@pettyCashList')
		->name('dno-personal.pettyCashList');

	Route::post(
		'/dno-personal/petty-cash/add',
		'DnoPersonalController@addPettyCash')
		->name('addPettyCash');

	Route::get(
		'/dno-personal/edit-petty-cash/{id}',
		'DnoPersonalController@editPettyCash')
		->name('editPettyCash');

	Route::post(
		'/dno-personal/petty-cash/add-new/{id}',
		'DnoPersonalController@addNewPettyCash')
		->name('addNewPettyCash');
	
	Route::get(
		'/dno-personal/petty-cash/view/{id}',
		'DnoPersonalController@viewPettyCash')
		->name('dno-personal.viewPettyCash');
	
	Route::get(
		'/dno-personal/petty-cash/print/{id}',
		'DnoPersonalController@printPettyCash')
		->name('printPettyCash');

	Route::patch(
		'/dno-personal/petty-cash/update/{id}',
		'DnoPersonalController@updatePettyCash')
		->name('updatePettyCash');

	Route::patch(
		'/dno-personal/petty-cash/updatePC/{id}',
		'DnoPersonalController@updatePC')
		->name('updatePC');

	Route::delete(
		'/dno-personal/petty-cash/delete/{id}',
		'DnoPersonalController@destroyPettyCash')
		->name('destroyPettyCash');

	//DNO food ventures
	Route::get(
		'/dno-food-ventures',
		'DnoFoodVenturesController@index')
		->name('dno-food-ventures');

	//DNO resources and devlopment corp
	Route::get(
		'/dno-resources-development',
		'DnoResourcesDevelopmentController@index')
		->name('dno-resources-development');

	
	Route::get(
		'/dno-resources-development/purchase-order',
		'DnoResourcesDevelopmentController@purchaseOrder')
		->name('purchaseOrder');

	Route::post(
		'/dno-resources-development/store',
		'DnoResourcesDevelopmentController@store')
		->name('store');
	
	Route::get(
		'/dno-resources-development/edit-dno-resources-purchase-order/{id}',
		'DnoResourcesDevelopmentController@edit')
		->name('edit');

	Route::post(
		'/dno-resources-development/add-new/{id}',
		'DnoResourcesDevelopmentController@addNew')
		->name('addNew');

	Route::patch(
		'/dno-resources-development/update-po/{id}',
		'DnoResourcesDevelopmentController@updatePo')
		->name('dno-resources-development.updatePo');



	Route::get(
		'/dno-resources-development/purchase-order-lists',
		'DnoResourcesDevelopmentController@purchaseOrderList')
		->name('purchaseOrderList');

	Route::delete(
		'/dno-resources-development/delete/{id}',
		'DnoResourcesDevelopmentController@destroy')
		->name('destroy');

	Route::get(
		'/dno-resources-development/view-dno-resources-purchase-order/{id}',
		'DnoResourcesDevelopmentController@show')
		->name('show');

	Route::get(
		'/dno-resources-development/delivery-form',
		'DnoResourcesDevelopmentController@deliveryForm')
		->name('deliveryForm');
	
	Route::post(
		'/dno-resources-development/store-delivery-transaction',
		'DnoResourcesDevelopmentController@addDeliveryTransaction')
		->name('addDeliveryTransaction');

	Route::get(
		'/dno-resources-development/edit-delivery-transaction/{id}',
		'DnoResourcesDevelopmentController@editDeliveryTransaction')
		->name('editDeliveryTransaction');

	Route::post(
		'/dno-resources-development/add-delivery-transaction/{id}',
		'DnoResourcesDevelopmentController@addDelivery')
		->name('addDelivery');

	Route::patch(
		'/dno-resources-development/update-dt/{id}',
		'DnoResourcesDevelopmentController@updateDT')
		->name('updateDT');
	
	Route::delete(
		'/dno-resources-development/delivery-transaction/delete/{id}',
		'DnoResourcesDevelopmentController@destroyDeliveryTransaction')
		->name('destroyDeliveryTransaction');

	Route::get(
		'/dno-resources-development/delivery-transaction/records',
		'DnoResourcesDevelopmentController@deliveryRecords')
		->name('deliveryRecords');

	Route::get(
		'/dno-resources-development/view-dno-resources-delivery-transaction/{id}',
		'DnoResourcesDevelopmentController@viewDeliveryTransaction')
		->name('viewDeliveryTransaction');
		
});


