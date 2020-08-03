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
		'/settings',
		'SettingsController@index')
		->name('indexSettings');

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

	Route::get(
		'/profile/create-branch',
		'ProfileController@createBranch')
		->name('createBranch');

	Route::post(
		'/profile/store-create-branch',
		'ProfileController@storeCreateBranch')
		->name('storeCreateBranch');

	//route for summary reports
	Route::get(
		'/lolo-pinoy-lechon-de-cebu/summary-report/per-day',
		'LoloPinoyLechonDeCebuController@summaryReportPerDay')
		->name('summaryReportPerDay');

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/search-multiple-date',
		'LoloPinoyLechonDeCebuController@getSummaryReportMultiple')
		->name('getSummaryReportMultiple');

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/printMultipleSummary/{date}',
		'LoloPinoyLechonDeCebuController@printMultipleSummary')
		->name('printMultipleSummary');


	Route::get(
		'/lolo-pinoy-lechon-de-cebu/printSummary',
		'LoloPinoyLechonDeCebuController@printSummary')
		->name('printSummary');

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/printGetSummary/{date}',
		'LoloPinoyLechonDeCebuController@printGetSummary')
		->name('printSummary');

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/search-date',
		'LoloPinoyLechonDeCebuController@getSummaryReport')
		->name('getSummaryReport');

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/summary-report/search-number-code',
		'LoloPinoyLechonDeCebuController@searchNumberCode')
		->name('searchNumberCode');

	Route::post(
		'/lolo-pinoy-lechon-de-cebu/search',
		'LoloPinoyLechonDeCebuController@search')
		->name('search');

	//route for delete delivery receipt
	Route::delete('/lolo-pinoy-lechon-de-cebu/delete-delivery-receipt/{id}', 
		'LoloPinoyLechonDeCebuController@destroyDeliveryReceipt')
		->name('destroyDeliveryReceipt');


	Route::delete('/lolo-pinoy-lechon-de-cebu/delete/dr/{id}', 
		'LoloPinoyLechonDeCebuController@destroyDR')
		->name('destroyDR');


	Route::get(
		'/lolo-pinoy-lechon-de-cebu/petty-cash-list',
		'LoloPinoyLechonDeCebuController@pettyCashList')
		->name('pettyCashListLechonDeCebu');

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/suppliers',
		'LoloPinoyLechonDeCebuController@supplier')
		->name('supplier');

	Route::post(
		'/lolo-pinoy-lechon-de-cebu/supplier/add',
		'LoloPinoyLechonDeCebuController@addSupplier')
		->name('addSupplier');

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/suppliers/view/{id}',
		'LoloPinoyLechonDeCebuController@viewSupplier')
		->name('viewSupplier');

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/supplier/print/{id}',
		'LoloPinoyLechonDeCebuController@printSupplier')
		->name('printSupplier');

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/utilities',
		'LoloPinoyLechonDeCebuController@utilities')
		->name('utilitiesLechonDeCebu');

	Route::delete(
		'/lolo-pinoy-lechon-de-cebu/utilities/delete/{id}',
		'LoloPinoyLechonDeCebuController@destroyUtility')
		->name('destroyUtilityLechonDeCebu');

	Route::post(
		'/lolo-pinoy-lechon-de-cebu/petty-cash/add',
		'LoloPinoyLechonDeCebuController@addPettyCash')
		->name('addPettyCashLechonDeCebu');

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/edit-petty-cash/{id}',
		'LoloPinoyLechonDeCebuController@editPettyCash')
		->name('editPettyCashLechonDeCebu');

	Route::patch(
		'/lolo-pinoy-lechon-de-cebu/update-petty-cash/{id}',
		'LoloPinoyLechonDeCebuController@updatePettyCash')
		->name('updatePettyCashLechonDeCebu');
	
	Route::post(
		'/lolo-pinoy-lechon-de-cebu/add-new-petty-cash/{id}',
		'LoloPinoyLechonDeCebuController@addNewPettyCash')
		->name('addNewPettyCashLechonDeCebu');	

	Route::patch(
		'/lolo-pinoy-lechon-de-cebu/updatePC/{id}',
		'LoloPinoyLechonDeCebuController@updatePC')
		->name('updatePCLechonDeCebu');

	Route::delete(
		'/lolo-pinoy-lechon-de-cebu/petty-cash/delete/{id}',
		'LoloPinoyLechonDeCebuController@destroyPettyCash')
		->name('destroyPettyCashLechonDeCebu');

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/petty-cash/view/{id}',
		'LoloPinoyLechonDeCebuController@viewPettyCash')
		->name('viewPettCashLechonDeCebu');

	Route::get(
		'/lolo-pinoy-grill-commissary/printPettyCash/{id}',
		'LoloPinoyGrillCommissaryController@printPettyCash')
		->name('printPettyCashLoloPinoyGrill');

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/printPettyCash/{id}',
		'LoloPinoyLechonDeCebuController@printPettyCash')
		->name('printPettyCashLechonDeCebu');

	//route for payment vouchers
	Route::get(
		'/lolo-pinoy-lechon-de-cebu/payment-voucher-form', 
		'LoloPinoyLechonDeCebuController@paymentVoucherForm')
		->name('paymentVoucherFormLechonDeCebu');

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

	//route update payment voucher
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

	Route::post(
		'/lolo-pinoy-lechon-de-cebu/utilities/add-bill',
		'LoloPinoyLechonDeCebuController@addBills')
		->name('addBillsLechonDeCebu');

	Route::post(
		'/lolo-pinoy-lechon-de-cebu/utilities/add-internet',
		'LoloPinoyLechonDeCebuController@addInternet')
		->name('addInternetLechonDeCebu');

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/utilities/view-veco/{id}',
		'LoloPinoyLechonDeCebuController@viewBills')
		->name('viewBillsLechonDeCebu');

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/utilities/view-internet/{id}',
		'LoloPinoyLechonDeCebuController@viewBills')
		->name('viewBillsLechonDeCebu');
	
	Route::get(
			'/lolo-pinoy-lechon-de-cebu/edit-payables-detail/{id}',
			'LoloPinoyLechonDeCebuController@editPayablesDetail')
			->name('editPayablesDetailLechonDeCebu');

	Route::patch(
		'/lechon-de-cebu/payables/update-particulars/{id}',
		'LoloPinoyLechonDeCebuController@updateParticulars')
		->name('updateParticulars');

	Route::patch(
		'/lechon-de-cebu/payables/updateP/{id}',
		'LoloPinoyLechonDeCebuController@updateP')
		->name('updateP');

	Route::patch(
		'/lechon-de-cebu/payables/update-check/{id}',
		'LoloPinoyLechonDeCebuController@updateCheck')
		->name('updateCheck');

	Route::patch(
		'/lolo-pinoy-lechon-de-cebu/payables/update-cash/{id}',
		'LoloPinoyLechonDeCebuController@updateCash')
		->name('updateCash');

	Route::patch(
		'/lechon-de-cebu/payables/update-details/{id}',
		'LoloPinoyLechonDeCebuController@updateDetails')
		->name('updateDetails');
	
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

	Route::delete(
		'/lolo-pinoy-lechon-de-cebu/delete/PO/{id}',
		'LoloPinoyLechonDeCebuController@destroyPO')
		->name('destroyPO');

	//delete for lechon de cebu billint statement
	Route::delete('/lolo-pinoy-lechon-de-cebu/delete-billing-statement/{id}', 'LoloPinoyLechonDeCebuController@destroyBillingStatement')->name('lolo-pinoy-lechon-de-cebu.destroyBillingStatement');
	
	Route::delete(
		'/lolo-pinoy-lechon-de-cebu/delete-data-billing-statement/{id}',
		'LoloPinoyLechonDeCebuController@destroyBillingDataStatement')
		->name('destroyBillingDataStatement');

	Route::delete('/lolo-pinoy-lechon-de-cebu/delete-payment-voucher/{id}', 'LoloPinoyLechonDeCebuController@destroyPaymentVoucher')->name('lolo-pinoy-lechon-de-cebu.destroyPaymentVoucher');
	
	//route for delete sales invoice 
	Route::delete(
		'/lolo-pinoy-lechon-de-cebu/delete-sales-invoice/{id}', 
		'LoloPinoyLechonDeCebuController@destroySalesInvoice')
		->name('lolo-pinoy-lechon-de-cebu.destroySalesInvoice');

	Route::delete(
		'/lolo-pinoy-lechon-de-cebu/delete/SI/{id}',
		'LoloPinoyLechonDeCebuController@destroySI')
		->name('destroySI');
	
	//delete comissary RAW materials
	Route::delete('/lolo-pinoy-lechon-de-cebu/delete-raw-materials/{id}', 'LoloPinoyLechonDeCebuController@destroyRawMaterial')->name('lolo-pinoy-lechon-de-cebu.destroyRawMaterial');
	
	//destroy delivery receipt
	Route::delete('/lolo-pinoy-grill-commissary/delete-delivery-receipt/{id}', 'LoloPinoyGrillCommissaryController@destroyDeliveryReceipt')->name('lolo-pinoy-grill-commissary.destroyDeliveryReceipt');
	
	Route::delete(
		'/lolo-pinoy-grill-commissary/delete/DR/{id}',
		'LoloPinoyGrillCommissaryController@destroyDR')
		->name('destroyDR');

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
	Route::delete(
		'/lolo-pinoy-grill-commissary/delete-sales-invoice/{id}', 
		'LoloPinoyGrillCommissaryController@destroySalesInvoice')
		->name('destroySalesInvoice');

	Route::get(
		'/lolo-pinoy-grill-commissary/view-list-per-branch',
		'LoloPinoyGrillCommissaryController@listPerBranch')
		->name('listPerBranch');
	
	Route::delete(
		'/lolo-pinoy-grill-commissary/delete-statement-account/{id}', 
		'LoloPinoyGrillCommissaryController@destroyStatementAccount')
		->name('destroyStatementAccount');
	
	Route::delete(
		'/lolo-pinoy-grill-commissary/delete-raw-materials/{id}',
		'LoloPinoyGrillCommissaryController@destroyRawMaterial')
		->name('destroyRawMaterial');
	
	Route::delete(
		'/lolo-pinoy-grill-commissary/utilities/delete/{id}',
		'LoloPinoyGrillCommissaryController@destroyUtility')
		->name('destroyUtility');
	
	Route::delete(
		'/lolo-pinoy-grill-branches/delete/{id}',
		'LoloPinoyGrillBranchesController@destroy')
		->name('destroy');
	
	Route::delete(
		'/lolo-pinoy-grill-branches/delete-transaction-list/{id}',
		'LoloPinoyGrillBranchesController@destroyTransactionList')
		->name('destroyTransactionList');

	//delete
	Route::delete(
		'/mr-potato/delete/{id}',
		'MrPotatoController@destroy')
		->name('destroy');

	Route::delete(
			'/mr-potato/delete-delivery-receipt/{id}',
			'MrPotatoController@destroyDeliveryReceipt')
			->name('mr-potato.destroyDeliveryReceipt');

	Route::delete(
			'/mr-potato/delete/dr/{id}',
			'MrPotatoController@destroyDR')
			->name('destroyDR');

	
	
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
		'/mr-potato/delete/si/{id}',
		'MrPotatoController@destroySI')
		->name('mr-potato.destroySI');
	
	Route::delete(
			'/ribos-bar/delete-delivery-receipt/{id}',
			'RibosBarController@destroyDeliveryReceipt')
			->name('ribos-bar.destroyDeliveryReceipt');

	Route::delete(
		'/ribos-bar/delete/{id}',
		'RibosBarController@destroy')
		->name('destroy');
	
	Route::delete(
		'/ribos-bar/delete/PO/{id}',
		'RibosBarController@destroyPO')
		->name('destroyPO');

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
		->name('destroySalesInvoice');
	
	Route::delete(
		'/ribos-bar/delete/SI/{id}',
		'RibosBarController@destroySI')
		->name('destroySI');

	Route::delete(
		'/ribos-bar/cashiers-report-form/delete-item/{id}',
		'RibosBarController@destroyCashiersReport')
		->name('ribos-bar.destroyCashiersReport');
	
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

	Route::get(
		'/lolo-pinoy-grill-commissary/summary-report',
		'LoloPinoyGrillCommissaryController@summaryReport')
		->name('summaryReportLpGrillComm');

	Route::get(
		'/lolo-pinoy-grill-commissary/search-mutiple-date',
		'LoloPinoyGrillCommissaryController@getSummaryReportMultiple')
		->name('getSummaryReportMultiple');

	Route::get(
		'/lolo-pinoy-grill-commissary/printMultipleSummary/{date}',
		'LoloPinoyGrillCommissaryController@printMultipleSummary')
		->name('printMultipleSummary');

	Route::get(
		'/lolo-pinoy-grill-commissary/summary-report/search-number-code',
		'LoloPinoyGrillCommissaryController@searchNumberCode')
		->name('searchNumberCode');

	Route::get(
		'/lolo-pinoy-grill-commissary/search',
		'LoloPinoyGrillCommissaryController@search')
		->name('search');

	Route::get(
		'/lolo-pinoy-grill-commissary/printSummary',
		'LoloPinoyGrillCommissaryController@printSummary')
		->name('printSummary');

	Route::get(
		'/lolo-pinoy-grill-commissary/printGetSummary/{date}',
		'LoloPinoyGrillCommissaryController@printGetSummary')
		->name('printGetSummary');

	Route::get(
		'/lolo-pinoy-grill-commissary/search-date',
		'LoloPinoyGrillCommissaryController@getSummaryReport')
		->name('getSummaryReport');

	//payment voucher form
	Route::get(
		'/lolo-pinoy-grill-commissary/payment-voucher-form', 
		'LoloPinoyGrillCommissaryController@paymentVoucherForm')
		->name('paymentVoucherFormLoloPinoyGril');

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
		->name('editPayablesDetailLoloPinoyGrill');

	Route::patch(
		'/lolo-pinoy-grill-commissary/payables/update-particulars/{id}',
		'LoloPinoyGrillCommissaryController@updateParticulars')
		->name('updateParticulars');

	Route::patch(
		'/lolo-pinoy-grill-commissary/payables/updateP/{id}',
		'LoloPinoyGrillCommissaryController@updateP')
		->name('updateP');

	Route::patch(
		'/lolo-pinoy-grill-commissary/payables/update-check/{id}',
		'LoloPinoyGrillCommissaryController@updateCheck')
		->name('updateCheck');

	Route::patch(
		'/lolo-pinoy-grill-commissary/payables/update-cash/{id}',
		'LoloPinoyGrillCommissaryController@updateCash')
		->name('updateCash');

	Route::patch(
		'/lolo-pinoy-grill-commissary/payables/update-details/{id}',
		'LoloPinoyGrillCommissaryController@updateDetails')
		->name('updateDetails');
	
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
		'/lolo-pinoy-grill-commissary/view-payables-details/{id}',
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
		->name('paymentVoucherFormLpBranches');

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
		->name('editPayablesDetailLpBranches');

	Route::patch(
		'/lolo-pinoy-grill-branches/payables/update-particulars/{id}',
		'LoloPinoyGrillBranchesController@updateParticulars')
		->name('updateParticulars');


	Route::patch(
		'/lolo-pinoy-grill-branches/payables/updateP/{id}',
		'LoloPinoyGrillBranchesController@updateP')
		->name('updateP');

	Route::patch(
		'/lolo-pinoy-grill-branches/payables/update-check/{id}',
		'LoloPinoyGrillBranchesController@updateCheck')
		->name('updateCheck');

	Route::patch(
		'/lolo-pinoy-grill-branches/payables/update-cash/{id}',
		'LoloPinoyGrillBranchesController@updateCash')
		->name('updateCash');

	Route::patch(
		'/lolo-pinoy-grill-branches/payables/update-details/{id}',
		'LoloPinoyGrillBranchesController@updateDetails')
		->name('updateDetails');

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
		->name('paymentVoucherFormMrPotato');

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
		->name('editPayablesDetailMrPotato');

	Route::patch(
		'/mr-potato/payables/update-particulars/{id}',
		'MrPotatoController@updateParticulars')
		->name('updateParticulars');
		
	Route::patch(
		'/mr-potato/payables/updateP/{id}',
		'MrPotatoController@updateP')
		->name('updateP');

	Route::patch(
		'/mr-potato/payables/update-check/{id}',
		'MrPotatoController@updateCheck')
		->name('updateCheck');

	Route::patch(
		'/mr-potato/payables/update-cash/{id}',
		'MrPotatoController@updateCash')
		->name('updateCash');

	Route::patch(
		'/mr-potato/payables/update-details/{id}',
		'MrPotatoController@updateDetails')
		->name('updateDetails');

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
		'/mr-potato/suppliers',
		'MrPotatoController@supplier')
		->name('supplier');

	Route::post(
		'/mr-potato/supplier/add',
		'MrPotatoController@addSupplier')
		->name('addSupplier');

	Route::get(
		'/mr-potato/suppliers/view/{id}',
		'MrPotatoController@viewSupplier')
		->name('viweSupplier');

	Route::get(
		'/mr-potato/supplier/print/{id}',
		'MrPotatoController@printSupplier')
		->name('printSupplier');

	Route::get(
		'/mr-potato/summary-report',
		'MrPotatoController@summaryReport')
		->name('summaryReport');

	Route::get(
		'/mr-potato/search-multiple-date',
		'MrPotatoController@getSummaryReportMultiple')
		->name('getSummaryReportMultiple');

	Route::get(
		'/mr-potato/printMultipleSummary/{date}',
		'MrPotatoController@printMultipleSummary')
		->name('printMultipleSummary');

	Route::get(
		'/mr-potato/summary-report/search-number-code',
		'MrPotatoController@searchNumberCode')
		->name('searchNumberCode');

	Route::get(
		'/mr-potato/search',
		'MrPotatoController@search')
		->name('search');

	Route::get(
		'/mr-potato/printSummary',
		'MrPotatoController@printSummary')
		->name('printSummaryMrPotato');

	Route::get(
		'/mr-potato/search-date',
		'MrPotatoController@getSummaryReport')
		->name('getSummaryReport');

	Route::get(
		'/mr-potato/printGetSummary/{date}',
		'MrPotatoController@printGetSummary')
		->name('printGetSummary');

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
		'/ribos-bar/suppliers',
		'RibosBarController@supplier')
		->name('supplier');

	Route::post(
		'/ribos-bar/supplier/add',
		'RibosBarController@addSupplier')
		->name('addSupplier');

	Route::get(
		'/ribos-bar/suppliers/view/{id}',
		'RibosBarController@viewSupplier')
		->name('viewSupplier');

	Route::get(
		'/ribos-bar/supplier/print/{id}',
		'RibosBarController@printSupplier')
		->name('printSupplier');
	
	Route::get(
			'/ribos-bar/payment-voucher-form',
			'RibosBarController@paymentVoucherForm')
			->name('paymentVoucherFormRibosBar');
	
	//store
	Route::post(
		'/ribos-bar/payment-voucher-store',
		'RibosBarController@paymentVoucherStore')
		->name('paymentVoucherStore');

	Route::get(
		'/ribos-bar/payables/transaction-list',
		'RibosBarController@transactionList')
		->name('transactionListRibosBar');

	Route::get(
		'/ribos-bar/edit-ribos-bar-payables-detail/{id}',
		'RibosBarController@editPayablesDetail')
		->name('editPayablesDetailRibosBar');

	Route::patch(
		'/ribos-bar/payables/update-particulars/{id}',
		'RibosBarController@updateParticulars')
		->name('updateParticulars');

	Route::patch(
		'/ribos-bar/payables/updateP/{id}',
		'RibosBarController@updateP')
		->name('updateP');
	
	Route::patch(
		'/ribos-bar/payables/update-check/{id}',
		'RibosBarController@updateCheck')
		->name('updateCheck');

	Route::patch(
		'/ribos-bar/payables/update-cash/{id}',
		'RibosBarController@updateCash')
		->name('updateCash');

	Route::patch(
		'/ribos-bar/payables/update-details/{id}',
		'RibosBarController@updateDetails')
		->name('updateDetails');
	
	Route::post(
		'/ribos-bar/add-particulars/{id}',
		'RibosBarController@addParticulars')
		->name('addParticulars');

	Route::post(
		'/ribos-bar/add-payment/{id}',
		'RibosBarController@addPayment')
		->name('addPayment');

	Route::patch(
		'/ribos-bar/accept/{id}',
		'RibosBarController@accept')
		->name('accept');

	Route::get(
		'/ribos-bar/view-payables-details/{id}',
		'RibosBarController@viewPayableDetails')
		->name('viewPayableDetails');
	

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


	Route::post(
		'/dno-personal/payment-voucher-store/',
		'DnoPersonalController@paymentVoucherStore')
		->name('dno-personal.paymentVoucherStore');

	Route::get(
		'/dno-personal/suppliers',
		'DnoPersonalController@supplier')
		->name('supplier');


	Route::post(
		'/dno-personal/supplier/add',
		'DnoPersonalController@addSupplier')
		->name('addSupplier');

	Route::get(
		'/dno-personal/suppliers/view/{id}',
		'DnoPersonalController@viewSupplier')
		->name('viewSupplier');

	Route::get(
		'/dno-personal/supplier/print/{id}',
		'DnoPersonalController@printSupplier')
		->name('printSupplier');

	Route::get(
			'/dno-personal/payment-voucher-form',
			'DnoPersonalController@paymentVoucherForm')
		->name('paymentVoucherFormDNOPersonal');

	Route::get(
		'/dno-personal/payables/transaction-list',
		'DnoPersonalController@transactionList')
		->name('dno-personal.transactionList');

	Route::get(
		'/dno-personal/edit-dno-personal-payables-detail/{id}',
		'DnoPersonalController@editPayablesDetail')
		->name('editPayablesDetailDnoPersonal');

	Route::patch(
		'/dno-personal/payables/update-particulars/{id}',
		'DnoPersonalController@updateParticulars')
		->name('updateParticulars');

	Route::patch(
		'/dno-personal/payables/updateP/{id}',
		'DnoPersonalController@updateP')
		->name('updateP');

	Route::patch(
		'/dno-personal/payables/update-check/{id}',
		'DnoPersonalController@updateCheck')
		->name('updateCheck');

	Route::patch(
		'/dno-personal/payables/update-cash/{id}',
		'DnoPersonalController@updateCash')
		->name('updateCash');

	Route::patch(
		'/dno-personal/payables/update-details-cc/{id}',
		'DnoPersonalController@updateDetailsCC')
		->name('updateDetailsCC');

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
		->name('paymentVoucherFormDnoResources');

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
		->name('editPayablesDetailDnoResources');

	Route::patch(
		'/dno-resources-development/payables/update-particulars/{id}',
		'DnoResourcesDevelopmentController@updateParticulars')
		->name('updateParticulars');

	Route::patch(
		'/dno-resources-development/payables/updateP/{id}',
		'DnoResourcesDevelopmentController@updateP')
		->name('updateP');

	Route::patch(
		'/dno-resources-development/payables/update-check/{id}',
		'DnoResourcesDevelopmentController@updateCheck')
		->name('updateCheck');

	Route::patch(
		'/dno-resources-development/payables/update-cash/{id}',
		'DnoResourcesDevelopmentController@updateCash')
		->name('updateCash');

	Route::patch(
		'/dno-resources-development/payables/update-details/{id}',
		'DnoResourcesDevelopmentController@updateDetails')
		->name('updateDetails');

	Route::get(
		'/dno-resources-development/printSummary',
		'DnoResourcesDevelopmentController@printSummary')
		->name('printSummary');

	Route::get(
		'/dno-resources-development/search-date',
		'DnoResourcesDevelopmentController@getSummaryReport')
		->name('getSummaryReport');


	Route::get(
		'/dno-resources-development/printGetSummary/{date}',
		'DnoResourcesDevelopmentController@printGetSummary')
		->name('printGetSummary');
	
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

/***********************************************************
 * 
 * 
 * 
 * 
 * 
 * 
 **********************************************************/

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

		//route for summary reports
		Route::get(
			'/lolo-pinoy-lechon-de-cebu/summary-report',
			'LoloPinoyLechonDeCebuController@summaryReportPerDay')
			->name('summaryReportPerDay');
	
		Route::get(
			'/lolo-pinoy-lechon-de-cebu/printSummary',
			'LoloPinoyLechonDeCebuController@printSummary')
			->name('printSummary');
	
		Route::get(
			'/lolo-pinoy-lechon-de-cebu/printGetSummary/{date}',
			'LoloPinoyLechonDeCebuController@printGetSummary')
			->name('printSummary');
	
		Route::get(
			'/lolo-pinoy-lechon-de-cebu/search-date',
			'LoloPinoyLechonDeCebuController@getSummaryReport')
			->name('getSummaryReport');
	
		Route::get(
			'/lolo-pinoy-lechon-de-cebu/summary-report/search-number-code',
			'LoloPinoyLechonDeCebuController@searchNumberCode')
			->name('searchNumberCode');
	
		Route::get(
			'/lolo-pinoy-lechon-de-cebu/search',
			'LoloPinoyLechonDeCebuController@search')
			->name('search');

	Route::post(
		'/dno-personal/payment-voucher-store/',
		'DnoPersonalController@paymentVoucherStore')
		->name('dno-personal.paymentVoucherStore');

	Route::get(
			'/dno-personal/payment-voucher-form',
			'DnoPersonalController@paymentVoucherForm')
		->name('paymentVoucherFormDNOPersonal');

	Route::get(
		'/dno-personal/payables/transaction-list',
		'DnoPersonalController@transactionList')
		->name('dno-personal.transactionList');

	Route::get(
		'/dno-personal/edit-dno-personal-payables-detail/{id}',
		'DnoPersonalController@editPayablesDetail')
		->name('editPayablesDetailDnoPersonal');

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/payables/transaction-list',
		'LoloPinoyLechonDeCebuController@transactionList')
		->name('lolo-pinoy-lechon-de-cebu.transactionList');


	//delete for lechon de cebu billint statement
	Route::delete('/lolo-pinoy-lechon-de-cebu/delete-billing-statement/{id}', 'LoloPinoyLechonDeCebuController@destroyBillingStatement')->name('lolo-pinoy-lechon-de-cebu.destroyBillingStatement');
	
	Route::delete('/lolo-pinoy-lechon-de-cebu/delete-payment-voucher/{id}', 'LoloPinoyLechonDeCebuController@destroyPaymentVoucher')->name('lolo-pinoy-lechon-de-cebu.destroyPaymentVoucher');
	
	//route for delete sales invoice 
	Route::delete('/lolo-pinoy-lechon-de-cebu/delete-sales-invoice/{id}', 'LoloPinoyLechonDeCebuController@destroySalesInvoice')->name('lolo-pinoy-lechon-de-cebu.destroySalesInvoice');
	
	Route::delete(
		'/lolo-pinoy-lechon-de-cebu/delete/SI/{id}',
		'LoloPinoyLechonDeCebuController@destroySI')
		->name('destroySI');

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/suppliers',
		'LoloPinoyLechonDeCebuController@supplier')
		->name('supplier');

	Route::post(
		'/lolo-pinoy-lechon-de-cebu/supplier/add',
		'LoloPinoyLechonDeCebuController@addSupplier')
		->name('addSupplier');

	//delete comissary RAW materials
	Route::delete('/lolo-pinoy-lechon-de-cebu/delete-raw-materials/{id}', 'LoloPinoyLechonDeCebuController@destroyRawMaterial')->name('lolo-pinoy-lechon-de-cebu.destroyRawMaterial');
	
	//destroy delivery receipt
	Route::delete('/lolo-pinoy-grill-commissary/delete-delivery-receipt/{id}', 'LoloPinoyGrillCommissaryController@destroyDeliveryReceipt')->name('lolo-pinoy-grill-commissary.destroyDeliveryReceipt');
	
	Route::delete(
		'/lolo-pinoy-grill-commissary/delete/DR/{id}',
		'LoloPinoyGrillCommissaryController@destroyDR')
		->name('destroyDR');
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
			'/mr-potato/delete/si/{id}',
			'MrPotatoController@destroySI')
			->name('mr-potato.destroySI');
	
	Route::delete(
			'/ribos-bar/delete-delivery-receipt/{id}',
			'RibosBarController@destroyDeliveryReceipt')
			->name('ribos-bar.destroyDeliveryReceipt');

	Route::delete(
		'/ribos-bar/delete/{id}',
		'RibosBarController@destroy')
		->name('ribos-bar.destroy');


	
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
		'/dno-resources-development/delete-transaction-list/{id}',
		'DnoResourcesDevelopmentController@destroyTransactionList')
		->name('dno-resources-development.destroyTransactionList');

	Route::delete(
		'/dno-resources-development/delete/{id}',
		'DnoResourcesDevelopmentController@destroy')
		->name('dno-resources-development.destroy');


	
});

/************************************************
 * 
 * 
 * 
 * 
 * 
 * ***********************************************
 */

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

	//route for summary reports
	Route::get(
			'/lolo-pinoy-lechon-de-cebu/summary-report/per-day',
			'LoloPinoyLechonDeCebuController@summaryReportPerDay')
			->name('summaryReportPerDay');
	
	Route::get(
			'/lolo-pinoy-lechon-de-cebu/printSummary',
			'LoloPinoyLechonDeCebuController@printSummary')
			->name('printSummary');
	
	Route::get(
			'/lolo-pinoy-lechon-de-cebu/printGetSummary/{date}',
			'LoloPinoyLechonDeCebuController@printGetSummary')
			->name('printSummary');
	
	Route::get(
			'/lolo-pinoy-lechon-de-cebu/search-date',
			'LoloPinoyLechonDeCebuController@getSummaryReport')
			->name('getSummaryReport');
	
	Route::get(
			'/lolo-pinoy-lechon-de-cebu/summary-report/search-number-code',
			'LoloPinoyLechonDeCebuController@searchNumberCode')
			->name('searchNumberCode');
	
	Route::post(
			'/lolo-pinoy-lechon-de-cebu/search',
			'LoloPinoyLechonDeCebuController@search')
			->name('search');


	//route for lechon de cebu purchase order
	Route::get('lolo-pinoy-lechon-de-cebu/purchase-order', 'LoloPinoyLechonDeCebuController@purchaseOrder')->name('lolo-pinoy-lechon-de-cebu.purchaseOrder');

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/purchase-order-lists', 
		'LoloPinoyLechonDeCebuController@purchaseOrderAllLists')
		->name('purchaseOrderAllLists');

	//save purchase order
	Route::post('lolo-pinoy-lechon-de-cebu/store', 'LoloPinoyLechonDeCebuController@store')->name('lolo-pinoy-lechon-de-cebu.store');


	//edit purchase order
	Route::get(
		'lolo-pinoy-lechon-de-cebu/edit/{id}', 
		'LoloPinoyLechonDeCebuController@edit')
		->name('editLechonDeCebu');

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
	Route::get(
		'/lolo-pinoy-lechon-de-cebu/billing-statement-form', 
		'LoloPinoyLechonDeCebuController@billingStatementForm')
		->name('billingStatementFormLechonDecebu');

	//
	Route::post('/lolo-pinoy-lechon-de-cebu/store-billing-statement', 'LoloPinoyLechonDeCebuController@storeBillingStatement')->name('lolo-pinoy-lechon-de-cebu.storeBillingStatement');


	//route for lechon de cebu billing statement form edit
	Route::get(
		'/lolo-pinoy-lechon-de-cebu/edit-billing-statement/{id}', 
		'LoloPinoyLechonDeCebuController@editBillingStatement')
		->name('editBillingStatementLechonDeCebu');

	//route for add new billing in lechon de cebu
	Route::post(
		'/lolo-pinoy-lechon-de-cebu/add-new-billing/{id}', 
		'LoloPinoyLechonDeCebuController@addNewBilling')
		->name('addNewBillingLechonDeCebu');

	
	//route for billing statement lists
	Route::get(
		'/lolo-pinoy-lechon-de-cebu/billing-statement-lists', 
		'LoloPinoyLechonDeCebuController@billingStatementLists')
		->name('billingStatementListsLechonDeCebu');

	//update billing statement 
	Route::patch(
		'/lolo-pinoy-lechon-de-cebu/update-billing/{id}', 
		'LoloPinoyLechonDeCebuController@updateBillingStatement')
		->name('updateBillingStatementLechonDeCebu');

	//update billing statement info
	Route::patch(
		'/lolo-pinoy-lechon-de-cebu/update-billing-info/{id}', 
		'LoloPinoyLechonDeCebuController@updateBillingInfo')
		->name('lolo-pinoy-lechon-de-cebu.updateBillingInfo');

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
			'/lolo-pinoy-lechon-de-cebu/payables/transaction-list',
			'LoloPinoyLechonDeCebuController@transactionList')
			->name('lolo-pinoy-lechon-de-cebu.transactionList');

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
	Route::get(
		'/lolo-pinoy-lechon-de-cebu/commissary/stocks-inventory', 
		'LoloPinoyLechonDeCebuController@stocksInventory')
		->name('stocksInventory');


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
	Route::get(
		'/lolo-pinoy-lechon-de-cebu/delivery-receipt-form', 
		'LoloPinoyLechonDeCebuController@deliveryReceiptForm')
		->name('deliveryReceiptForm');

	//route store delivery receipt
	Route::post('/lolo-pinoy-lechon-de-cebu/store-delivery-receipt', 'LoloPinoyLechonDeCebuController@storeDeliveryReceipt')->name('lolo-pinoy-lechon-de-cebu.storeDeliveryReceipt');

	//route edit delivery receipt
	Route::get(
		'/lolo-pinoy-lechon-de-cebu/edit-delivery-receipt/{id}', 
		'LoloPinoyLechonDeCebuController@editDeliveryReceipt')
		->name('editDeliveryReceiptLechonDeCebu');


	//route update delviery receipt
	Route::patch('/lolo-pinoy-lechon-de-cebu/update-delivery-receipt/{id}', 'LoloPinoyLechonDeCebuController@updateDeliveryReceipt')->name('lolo-pinoy-lechon-de-cebu.updateDeliveryReceipt');

	//route for add new delivery receipt
	Route::post(
		'/lolo-pinoy-lechon-de-cebu/add-new-delivery-receipt-data/{id}', 
		'LoloPinoyLechonDeCebuController@addNewDeliveryReceiptData')
		->name('addNewDeliveryReceiptDataLechonDeCebu');

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

	Route::delete(
		'/lolo-pinoy-lechon-de-cebu/delete/SI/{id}',
		'LoloPinoyLechonDeCebuController@destroySI')
		->name('destroySI');


	Route::get(
		'/lolo-pinoy-lechon-de-cebu/sales-per-outlet',
		'LoloPinoyLechonDeCebuController@salesInvoiceSalesPerOutlet')
		->name('lolo-pinoy-lechon-de-cebu.salesInvoiceSalesPerOutlet');

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/sales-invoice/private-orders',
		'LoloPinoyLechonDeCebuController@privateOrders')
		->name('lolo-pinoy-lechon-de-cebu.privateOrders');


	Route::get(
		'/lolo-pinoy-lechon-de-cebu/suppliers',
		'LoloPinoyLechonDeCebuController@supplier')
		->name('supplier');

	Route::post(
		'/lolo-pinoy-lechon-de-cebu/supplier/add',
		'LoloPinoyLechonDeCebuController@addSupplier')
		->name('addSupplier');

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
	Route::get(
		'/lolo-pinoy-lechon-de-cebu/commissary/raw-materials',
		'LoloPinoyLechonDeCebuController@rawMaterials')
		->name('rawMaterials');

	
	//route add commissary RAW materials
	Route::post(
		'/lolo-pinoy-lechon-de-cebu/commissary/add-raw-material',
		'LoloPinoyLechonDeCebuController@addRawMaterial')
		->name('addRawMaterial');


	//update commissary RAW materials
	Route::patch(
		'/lolo-pinoy-lechon-de-cebu/commissary/update-raw-material/{id}',
		'LoloPinoyLechonDeCebuController@updateRawMaterial')
		->name('updateRawMaterial');
	
	//route for view RAW material details
	Route::get(
		'/lolo-pinoy-lechon-de-cebu/view-raw-material-details/{id}',
		'LoloPinoyLechonDeCebuController@viewRawMaterialDetails')
		->name('lolo-pinoy-lechon-de-cebu.viewRawMaterialDetails');

	//route for add delivery in RAW material
	Route::post(
		'/lolo-pinoy-lechon-de-cebu/add-req-stocks/{id}', 
		'LoloPinoyLechonDeCebuController@addDIRST')
		->name('addDIRST');

	//route for request stock out RAW material
	Route::post('/lolo-pinoy-lechon-de-cebu/request-stock-out-raw-material/{id}', 'LoloPinoyLechonDeCebuController@requestStockOut')->name('lolo-pinoy-lechon-de-cebu.requestStockOut');

	//route for view stock inventory
	Route::get('/lolo-pinoy-lechon-de-cebu/view-stock-inventory/{id}', 'LoloPinoyLechonDeCebuController@viewStockInventory')->name('lolo-pinoy-lechon-de-cebu.viewStockInventory');

	//route for commissary inventory of stocks
	Route::get(
		'/lolo-pinoy-lechon-de-cebu/commissary/inventory-of-stocks', 
		'LoloPinoyLechonDeCebuController@inventoryOfStocks')
		->name('inventoryOfStocks');

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
	Route::get(
		'/lolo-pinoy-grill-commissary/delivery-receipt-form', 
		'LoloPinoyGrillCommissaryController@deliveryReceiptForm')
		->name('deliveryReceiptFormLoloPinoyGrill');

	//store deivery receipt
	Route::post(
		'/lolo-pinoy-grill-commissary/store-delivery-receipt', 
		'LoloPinoyGrillCommissaryController@storeDeliveryReceipt')
		->name('lolo-pinoy-grill-commissary.storeDeliveryReceipt');

	Route::get(
		'/lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-commissary-delivery-receipt/{id}', 
		'LoloPinoyGrillCommissaryController@editDeliveryReceipt')
		->name('editDeliveryReceiptLoloPinoyGrillCommissary');

	Route::patch('/lolo-pinoy-grill-commissary/update-delivery-receipt/{id}', 'LoloPinoyGrillCommissaryController@updateDeliveryReceipt')->name('lolo-pinoy-grill-commissary.updateDeliveryReceipt');


	
	//save add new delivery receipt lolo pinoy grill 
	Route::post('/lolo-pinoy-grill-commissary/add-new-lolo-pinoy-grill-delivery-receipt-data/{id}', 'LoloPinoyGrillCommissaryController@addNewDeliveryReceiptData')->name('lolo-pinoy-grill-commissary.addNewDeliveryReceiptData');

	//
	Route::patch('/lolo-pinoy-grill-commissary/update-dr/{id}', 'LoloPinoyGrillCommissaryController@updateDr')->name('lolo-pinoy-grill-commissary.updateDr');


	//delivery receipt lists
	Route::get('/lolo-pinoy-grill-commissary/delivery-receipt/lists', 'LoloPinoyGrillCommissaryController@deliveryReceiptList')->name('lolo-pinoy-grill-commissary.deliveryReceiptList');

	
	//view 
	Route::get(
		'/lolo-pinoy-grill-commissary/view-lolo-pinoy-grill-commissary-delivery-receipt/{id}', 
		'LoloPinoyGrillCommissaryController@viewDeliveryReceipt')
		->name('lolo-pinoy-grill-commissary.viewDeliveryReceipt');


	Route::get(
		'/lolo-pinoy-grill-commissary/delivery-receipt/view-per-branch',
		'LoloPinoyGrillCommissaryController@viewPerBranch')
		->name('viewPerBranch');

	Route::get(
		'/lolo-pinoy-grill-commissary/suppliers',
		'LoloPinoyGrillCommissaryController@supplier')
		->name('supplier');

	Route::post(
			'/lolo-pinoy-grill-commissary/supplier/add',
			'LoloPinoyGrillCommissaryController@addSupplier')
			->name('addSupplier');

	Route::get(
		'/lolo-pinoy-grill-commissary/suppliers/view/{id}',
		'LoloPinoyGrillCommissaryController@viewSupplier')
		->name('viewSupplier');

	Route::get(
		'/lolo-pinoy-grill-commissary/view-lolo-pinoy-grill-commissary-purchase-order/{id}',
		'LoloPinoyGrillCommissaryController@show')
		->name('show');

	Route::delete(
		'/lolo-pinoy-grill-commissary/delete-purchase-order/{id}',
		'LoloPinoyGrillCommissaryController@destroyPO')
		->name('destroyPO');

	Route::get(
		'/lolo-pinoy-grill-commissary/pintPO/{id}',
		'LoloPinoyGrillCommissaryController@printPO')
		->name('printPoLoloPinoyGrillCommissary');

	
	//print delivery receipt lolo pinoy grill
	Route::get('/lolo-pinoy-grill-commissary/prntDeliveryReceipt/{id}', 'LoloPinoyGrillCommissaryController@printDelivery')->name('lolo-pinoy-grill-commissary.printDelivery');

	//route for purchase order lolo pinoy grill
	Route::get('/lolo-pinoy-grill-commissary/purchase-order', 'LoloPinoyGrillCommissaryController@purchaseOrder')->name('lolo-pinoy-grill-commissary.purchaseOrder
		');

	//store purchase order lolo pinoy grill
	Route::post('/lolo-pinoy-grill-commissary/store', 'LoloPinoyGrillCommissaryController@store')->name('lolo-pinoy-grill-commissary');

	//edit purchase order lolo pinoy grill
	Route::get(
	'/lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-commissary-purchase-order/{id}', 
	'LoloPinoyGrillCommissaryController@edit')
	->name('editLoloPinoyGrill');

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
	Route::get(
		'/lolo-pinoy-grill-commissary/billing-statement-form', 
		'LoloPinoyGrillCommissaryController@billingStatementForm')
		->name('billingStatementFormLoloPinoyGrillCommissary');

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
	Route::get(
		'/lolo-pinoy-grill-commissary/billing-statement-lists', 
		'LoloPinoyGrillCommissaryController@billingStatementLists')
		->name('lolo-pinoy-grill-commissary.billingStatementLists');

	//view billing statement
	Route::get(
		'/lolo-pinoy-grill-commissary/view-lolo-pinoy-grill-billing-statement/{id}', 
		'LoloPinoyGrillCommissaryController@viewBillingStatement')
		->name('viewBillingStatementLoloPinoyGrill');

	Route::get(
		'/lolo-pinoy-grill-commmissary/printBillingStatement/{id}',
		'LoloPinoyGrillCommissaryController@printBillingStatement')
		->name('printBillingStatementLoloPinoyGrill');


	Route::delete(
		'/lolo-pinoy-grill-commissary/delete-billing-statement/{id}',
		'LoloPinoyGrillCommissaryController@destroyBillingStatement')
		->name('destroyBillingStatementLoloPinoyGrillCommissary');

	
	//cash vouchers lolo pinoy grill
	Route::get('/lolo-pinoy-grill-commissary/cash-vouchers', 'LoloPinoyGrillCommissaryController@cashVouchers')->name('lolo-pinoy-grill-commissary.cashVouchers');

	//cheque vouchers lolo pinoy grill
	Route::get('/lolo-pinoy-grill-commissary/cheque-vouchers', 'LoloPinoyGrillCommissaryController@chequeVouchers')->name('lolo-pinoy-grill-commissary.chequeVouchers');

	//view payment voucher lolo pinoy grill
	Route::get('/lolo-pinoy-grill-commissary/view-lolo-pinoy-grill-payment-voucher/{id}', 'LoloPinoyGrillCommissaryController@viewPaymentVoucher')->name('lolo-pinoy-grill-commissary.viewPaymentVoucher');

	//sales invoice lolo pinoy grill
	Route::get(
		'/lolo-pinoy-grill-commissary/sales-invoice-form', 
		'LoloPinoyGrillCommissaryController@salesInvoiceForm')
		->name('lolo-pinoy-grill-commissary.salesInvoiceForm');

	Route::post('/lolo-pinoy-grill-commissary/store-sales-invoice', 'LoloPinoyGrillCommissaryController@storeSalesInvoice')->name('lolo-pinoy-grill-commissary.storeSalesInvoice');

	Route::get(
		'/lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-sales-invoice/{id}', 
		'LoloPinoyGrillCommissaryController@editSalesInvoice')
		->name('editSalesInvoiceLpGrillCommissary');

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
		->name('rawMaterials');

	Route::post(
		'/lolo-pinoy-grill-commissary/commissary/create-raw-materials',
		'LoloPinoyGrillCommissaryController@addRawMaterial')
		->name('addRawMaterial');

	Route::patch(
		'/lolo-pinoy-grill-commissary/commissary/update-raw-material/{id}',
		'LoloPinoyGrillCommissaryController@updateRawMaterial')
		->name('updateRawMaterial');

	Route::get(
		'/lolo-pinoy-grill-commissary/commissary/stocks-inventory',
		'LoloPinoyGrillCommissaryController@stocksInventory')
		->name('stocksInventory');

	Route::get(
		'/lolo-pinoy-grill-commissary/view-raw-material-details/{id}',
		'LoloPinoyGrillCommissaryController@viewRawMaterialDetails')
		->name('viewRawMaterialDetails');

	
	Route::post(
		'/lolo-pinoy-grill-commissary/add-delivery-in-raw-material/{id}',
		'LoloPinoyGrillCommissaryController@addDIRST')
		->name('addDIRST');


	Route::get(
		'/lolo-pinoy-grill-commissary/view-stock-inventory/{id}',
		'LoloPinoyGrillCommissaryController@viewStockInventory')
		->name('lolo-pinoy-grill-commissary.viewStockInventory');

	Route::get(
		'/lolo-pinoy-grill-commissary/commissary/delivery-outlets',
		'LoloPinoyGrillCommissaryController@commissaryDeliveryOutlet')
		->name('commissaryDeliveryOutlet');


	Route::get(
		'/lolo-pinoy-grill-commissary/commissary/inventory-of-stocks',
		'LoloPinoyGrillCommissaryController@inventoryOfStocks')
		->name('inventoryOfStocks');

	Route::get(
		'/lolo-pinoy-grill-commissary/view-inventory-of-stocks/{id}',
		'LoloPinoyGrillCommissaryController@viewInventoryOfStocks')
		->name('viewInventoryOfStocks');

	Route::patch(
		'/lolo-pinoy-grill-commissary/inventory-stock-update/{id}',
		'LoloPinoyGrillCommissaryController@inventoryStockUpdate')
		->name('inventoryStockUpdate');

	Route::get(
		'/lolo-pinoy-grill-commissary/commissary/production',
		'LoloPinoyGrillCommissaryController@production')
		->name('lolo-pinoy-grill-commissary.production');
	
	Route::get(
		'/lolo-pinoy-grill-commissary/petty-cash-list',
		'LoloPinoyGrillCommissaryController@pettyCashList')
		->name('lolo-pinoy-grill-commissary.pettyCashList');

	Route::post(
		'/lolo-pinoy-grill-commissary/petty-cash/add',
		'LoloPinoyGrillCommissaryController@addPettyCash')
		->name('addPettyCashLoloPinoyGrill');
	
	Route::get(
		'/lolo-pinoy-grill-commissary/edit-petty-cash/{id}',
		'LoloPinoyGrillCommissaryController@editPettyCash')
		->name('editPettyCashLoloPinoyGrill');

	Route::patch(
		'/lolo-pinoy-grill-commissary/update-petty-cash/{id}',
		'LoloPinoyGrillCommissaryController@updatePettyCash')
		->name('updatePettyCashLoloPinoyGrill');

	Route::post(
		'/lolo-pinoy-grill-commissary/add-new-petty-cash/{id}',
		'LoloPinoyGrillCommissaryController@addNewPettyCash')
		->name('addNewPettyCashLoloPinoyGrill');

	Route::patch(
		'/lolo-pinoy-grill-commissary/update-pc/{id}',
		'LoloPinoyGrillCommissaryController@updatePC')
		->name('updatePCLoloPinoyGrill');

	Route::delete(
		'/lolo-pinoy-grill-commissary/petty-cash/delete/{id}',
		'LoloPinoyGrillCommissaryController@destroyPettyCash')
		->name('destroyPettyCashLoloPinoyGrill');

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
		->name('editLpBranches');

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

	Route::delete(
		'/lolo-pinoy-grill-branches/delete/{id}',
		'LoloPinoyGrillBranchesController@destroy')
		->name('destroy');

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
		'/lolo-pinoy-grill-branches/summary-report',
		'LoloPinoyGrillBranchesController@summaryReport')
		->name('summaryReport');

	Route::get(
		'/lolo-pinoy-grill-branches/search-multiple-date',
		'LoloPinoyGrillBranchesController@getSummaryReportMultiple')
		->name('getSummaryReportMultiple');

	Route::get(
		'/lolo-pinoy-grill-branches/printMultipleSummary/{date}',
		'LoloPinoyGrillBranchesController@printMultipleSummary')
		->name('printMultipleSummary');

	Route::get(
		'/lolo-pinoy-grill-branches/summary-report/search-number-code',
		'LoloPinoyGrillBranchesController@searchNumberCode')
		->name('searchNumberCode');

	Route::get(
		'/lolo-pinoy-grill-branches/search',
		'LoloPinoyGrillBranchesController@search')
		->name('search');

	Route::get(
		'/lolo-pinoy-grill-branches/printSummary',
		'LoloPinoyGrillBranchesController@printSummary')
		->name('printSummary');

	Route::get(
		'/lolo-pinoy-grill-branches/printGetSummary/{date}',
		'LoloPinoyGrillBranchesController@printGetSummary')
		->name('printGetSummary');

	Route::get(
		'/lolo-pinoy-grill-branches/search-date',
		'LoloPinoyGrillBranchesController@getSummaryReport')
		->name('getSummaryReport');

	Route::post(
		'/lolo-pinoy-grill-branches/sales-form/login-branch',
		'LoloPinoyGrillBranchesController@loginSales')
		->name('loginSales');

	Route::get(
		'/lolo-pinoy-grill-branches/sales-form',
		'LoloPinoyGrillBranchesController@salesInvoiceForm')
		->name('salesInvoiceForm');

	Route::get(
		'/lolo-pinoy-grill-branches/{type}/sales-form',
		'LoloPinoyGrillBranchesController@salesInvoiceFormBranch')
		->name('salesInvoiceFormBranch');

	Route::post(
		'lolo-pinoy-grill-branches/sales-form/logout-branch',
		'LoloPinoyGrillBranchesController@logOutBranch')
		->name('logOutBranch');

	Route::post(
		'/lolo-pinoy-grill-branches/sales-form/add-transaction',
		'LoloPinoyGrillBranchesController@addSalesTransaction')
		->name('addSalesTransaction');

	Route::get(
		'/lolo-pinoy-grill-branches/{type}/sales-form/transaction/{id}',
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

	Route::post(
		'/lolo-pinoy-grill-branches/petty-cash/add',
		'LoloPinoyGrillBranchesController@addPettyCash')
		->name('addPettyCashLoloPinoyGrillBranches');

	Route::get(
		'/lolo-pinoy-grill-branches/petty-cash/view/{id}',
		'LoloPinoyGrillBranchesController@viewPettyCash')
		->name('lolo-pinoy-grill-branches.viewPettyCash');

	Route::get(
		'/lolo-pinoy-grill-branches/edit-petty-cash/{id}',
		'LoloPinoyGrillBranchesController@editPettyCash')
		->name('editPettyCashLoloPinoyGrillBranches');

	Route::patch(
		'/lolo-pinoy-grill-branches/update-petty-cash/{id}',
		'LoloPinoyGrillBranchesController@updatePettyCash')
		->name('updatePettyCashLoloPinoyGrillBranches');

	Route::post(
		'/lolo-pinoy-grill-branches/add-new-petty-cash/{id}',
		'LoloPinoyGrillBranchesController@addNewPettyCash')
		->name('addNewPettyCashLoloPinoyGrillBranches');

	Route::patch(
		'/lolo-pinoy-grill-branches/update-pc/{id}',
		'LoloPinoyGrillBranchesController@updatePC')
		->name('updatePCLoloPinoyGrillBranches');

	Route::delete(
		'/lolo-pinoy-grill-branches/petty-cash/delete/{id}',
		'LoloPinoyGrillBranchesController@destroyPettyCash')
		->name('destroyPettyCash');

	Route::get(
		'/lolo-pinoy-grill-branches/printPettyCash/{id}',
		'LoloPinoyGrillBranchesController@printPettyCash')
		->name('printPettyCashLoloPinoyGrillBranches');
	
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
	
	Route::delete(
		'/lolo-pinoy-grill-branches/delete-utility/{id}',
		'LoloPinoyGrillBranchesController@destroyUtility')
		->name('destroyUtility');

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

	Route::get(
		'/lolo-pinoy-grill-branches/suppliers',
		'LoloPinoyGrillBranchesController@supplier')
		->name('supplier');

	Route::post(
		'/lolo-pinoy-grill-branches/supplier/add',
		'LoloPinoyGrillBranchesController@addSupplier')
		->name('addSupplier');

	Route::get(
		'/lolo-pinoy-grill-branches/suppliers/view/{id}',
		'LoloPinoyGrillBranchesController@viewSupplier')
		->name('viewSupplier');

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
		->name('editDeliveryReceiptMrPotato');

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
		'/mr-potato/billing-statement-form',
		'MrPotatoController@billingStatementForm')
		->name('billingStatementFormMrPotato');

	Route::get(
		'/mr-potato/billing-statement-lists',
		'MrPotatoController@billingStatementList')
		->name('billingStatementList');

	Route::post(
		'/mr-potato/store-billing-statement',
		'MrPotatoController@storeBillingStatement')
		->name('storeBillingStatement');

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
		->name('editSalesInvoiceMrPotato');

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

	Route::post(
		'/mr-potato/petty-cash/add',
		'MrPotatoController@addPettyCash')
		->name('addPettyCash');
	
	Route::get(
		'/mr-potato/edit-petty-cash/{id}',
		'MrPotatoController@editPettyCash')
		->name('editPettyCashMrPotato');

	Route::patch(
			'/mr-potato/update-petty-cash/{id}',
			'MrPotatoController@updatePettyCash')
			->name('updatePettyCash');

	Route::post(
		'/mr-potato/add-new-petty-cash/{id}',
		'MrPotatoController@addNewPettyCash')
		->name('addNewPettyCash');

	Route::patch(
		'/mr-potato/update-pc/{id}',
		'MrPotatoController@updatePC')
		->name('updatePC');

	Route::delete(
		'/mr-potato/petty-cash/delete/{id}',
		'MrPotatoController@destroyPettyCash')
		->name('destroyPettyCash');

	Route::get(
		'/mr-potato/petty-cash/view/{id}',
		'MrPotatoController@viewPettyCash')
		->name('viewPettyCashMrPotato');

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

	Route::delete(
		'/ribos-bar/delete-transaction-list/{id}',
		'RibosBarController@destroyTransactionList')
		->name('ribos-bar.destroyTransactionList');

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
		->name('editRB');

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

	Route::get(
		'/ribos-bar/summary-report',
		'RibosBarController@summaryReport')
		->name('summaryReportRB');

	Route::get(
		'/ribos-bar/search-multiple-date',
		'RibosBarController@getSummaryReportMultiple')
		->name('getSummaryReportMultiple');

	Route::get(
		'/ribos-bar/printMultipleSummary/{date}',
		'RibosBarController@printMultipleSummary')
		->name('printMultipleSummary');

	Route::get(
		'/ribos-bar/summary-report/search-number-code',
		'RibosBarController@searchNumberCode')
		->name('searchNumberCode');

	Route::get(
		'/ribos-bar/search',
		'RibosBarController@search')
		->name('search');

	Route::get(
		'/ribos-bar/printSummary',
		'RibosBarController@printSummary')
		->name('printSummary');

	Route::get(
		'/ribos-bar/search-date',
		'RibosBarController@getSummaryReport')
		->name('getSummaryReport');

	Route::get(
		'/ribos-bar/printGetSummary/{date}',
		'RibosBarController@printGetSummary')
		->name('printGetSummary');

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
		->name('editSalesInvoiceRB');

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

	Route::post(
		'/ribos-bar/petty-cash/add',
		'RibosBarController@addPettyCash')
		->name('addPettyCashRibosBar');

	Route::get(
		'/ribos-bar/edit-petty-cash/{id}',
		'RibosBarController@editPettyCash')
		->name('editPettyCashRibosBar');

	Route::patch(
		'/ribos-bar/update-petty-cash/{id}',
		'RibosBarController@updatePettyCash')
		->name('updatePettyCashRibosBar');

	Route::patch(
		'/ribos-bar/update-pc/{id}',
		'RibosBarController@updatePC')
		->name('updatePCRibosBar');

	Route::post(
		'/ribos-bar/add-new-petty-cash/{id}',
		'RibosBarController@addNewPettyCash')
		->name('addNewPettyCashRibosBar');

	Route::delete(
		'/ribos-bar/petty-cash/delete/{id}',
		'RibosBarController@destroyPettyCash')
		->name('destroyPettyCash');
	
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
		'/ribos-bar/printPettyCash/{id}',
		'RibosBarController@printPettyCash')
		->name('printPettyCashRibosBar');

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

	Route::get(
		'/dno-personal/summary-report',
		'DnoPersonalController@summaryReport')
		->name('summaryReport');

	Route::get(
		'/dno-personal/printSummary',
		'DnoPersonalController@printSummary')
		->name('printSummary');

	Route::get(
		'/dno-personal/search-date',
		'DnoPersonalController@getSummaryReport')
		->name('getSummaryReport');

	Route::get(
		'/dno-personal/search-multiple-date',
		'DnoPersonalController@getSummaryReportMultiple')
		->name('getSummaryReportMultiple');

	Route::get(
		'/dno-personal/printGetSummary/{date}',
		'DnoPersonalController@printGetSummary')
		->name('printGetSummary');

	Route::get(
		'/dno-personal/printMultipleSummary/{date}',
		'DnoPersonalController@printMultipleSummary')
		->name('printMultipleSummary');

	Route::get(
		'/dno-personal/summary-report/search-number-code',
		'DnoPersonalController@searchNumberCode')
		->name('searchNumberCode');

	Route::get(
		'/dno-personal/search',
		'DnoPersonalController@search')
		->name('search');

	Route::post(
		'/dno-personal/payment-voucher-store/',
		'DnoPersonalController@paymentVoucherStore')
		->name('dno-personal.paymentVoucherStore');

	Route::get(
			'/dno-personal/payment-voucher-form',
			'DnoPersonalController@paymentVoucherForm')
		->name('paymentVoucherFormDNOPersonal');

	Route::get(
		'/dno-personal/payables/transaction-list',
		'DnoPersonalController@transactionList')
		->name('dno-personal.transactionList');

	Route::get(
		'/dno-personal/edit-dno-personal-payables-detail/{id}',
		'DnoPersonalController@editPayablesDetail')
		->name('editPayablesDetailDnoPersonal');

	Route::patch(
		'/dno-personal/payables/update-details/{id}',
		'DnoPersonalController@updateDetails')
		->name('updateDetailsDnoPersonal');
	
	
	Route::delete(
		'/dno-personal/delete-transaction-list/{id}',
		'DnoPersonalController@destroyTransactionList')
		->name('dno-personal.destroyTransactionList');
	
	Route::delete(
			'/dno-personal/delete-property/{id}',
			'DnoPersonalController@destroyProperty')
			->name('dno-personal.destroyProperty');

	Route::delete(
			'/dno-personal/credit-card/delete/{id}',
			'DnoPersonalController@destroyCreditCard')
			->name('dno-personal.destroyCreditCard');
			
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
		'DnoPersonalController@addCommunications')
		->name('addPLDT');

	Route::post(
		'/dno-personal/properties/add-globe',
		'DnoPersonalController@addCommunications')
		->name('addGlobe');

	Route::post(
		'/dno-personal/properties/add-smart',
		'DnoPersonalController@addCommunications')
		->name('addSmart');

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
		->name('viewBills');

	Route::get(
		'/dno-personal/cebu-properties/view-pldt/{id}',
		'DnoPersonalController@viewBills')
		->name('viewBills');
	
	Route::get(
			'/dno-personal/cebu-properties/view-globe/{id}',
			'DnoPersonalController@viewBills')
			->name('viewBills');

	Route::get(
			'/dno-personal/manila-properties/view-veco/{id}',
			'DnoPersonalController@viewBills')
			->name('viewBills');

	Route::get(
		'/dno-personal/manila-properties/view-meralco/{id}',
		'DnoPersonalController@viewBills')
		->name('viewBills');

	Route::get(
		'/dno-personal/manila-properties/view-mcwd/{id}',
		'DnoPersonalController@viewBills')
		->name('viewBills');
	
	Route::get(
			'/dno-personal/manila-properties/view-pldt/{id}',
			'DnoPersonalController@viewBills')
			->name('viewBills');
	
	Route::get(
				'/dno-personal/manila-properties/view-globe/{id}',
				'DnoPersonalController@viewBills')
				->name('viewBills');
	
	Route::get(
			'/dno-personal/manila-properties/view-skycable/{id}',
			'DnoPersonalController@viewBills')
			->name('viewBills');


	Route::patch(
		'/dno-personal/properties/update/{id}',
		'DnoPersonalController@updateProperties')
		->name('updteProperties');

	Route::patch(
		'/dno-personal/properties/update-pldt/{id}',
		'DnoPersonalController@updatePldt')
		->name('dno-personal.updatePLDT');

	Route::patch(
		'/dno-personal/properties/update-globe/{id}',
		'DnoPersonalController@updateGlobe')
		->name('updateGlobe');

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

	Route::delete(
			'/dno-perosonal/vehicles/delete/{id}',
			'DnoPersonalController@destroyVehicles')
			->name('dno-personal.destroyVehicles');

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

	Route::get(
		'/dno-personal/receivables-form',
		'DnoPersonalController@receivableForm')
		->name('receivableFormDno');

	Route::post(
		'/dno-personal/receivables/store-receivables',
		'DnoPersonalController@storeReceivables')
		->name('storeReceivablesDnoPersonal');

	Route::get(
		'/dno-personal/receivables/edit/{id}',
		'DnoPersonalController@editReceivables')
		->name('editReceivablesDnoPersonal');

	Route::post(
		'/dno-personal/receivables/add-receivables/{id}',
		'DnoPersonalController@addReceivables')
		->name('addReceivablesDnoPersonal');

	Route::patch(
		'/dno-personal/receivables/update-r/{id}',
		'DnoPersonalController@updateR')
		->name('updateRDnoPersonal');

	Route::delete(
		'/dno-personal/receivables/delete/{id}',
		'DnoPersonalController@destroyReceivables')
		->name('destroyReceivablesDnoPersonal');

	Route::get(
		'/dno-personal/receivables/list',
		'DnoPersonalController@receivableList')
		->name('receivableListDnoPersonal');

	Route::get(
		'/dno-personal-controller/receivables/payments/{id}',
		'DnoPersonalController@receivablePayment')
		->name('receivablePaymentDnoPersonal');

	Route::patch(
		'/dno-personal/receivables/paid/{id}',
		'DnoPersonalController@paid')
		->name('padiDnoPersonal');

	Route::get(
		'/dno-personal/receivables/view/{id}',
		'DnoPersonalController@viewReceivable')
		->name('viewReceivableDnoPersonal');

	//DNO food ventures
	Route::get(
		'/dno-food-ventures',
		'DnoFoodVenturesController@index')
		->name('dno-food-ventures');

	Route::get(
		'/dno-food-ventures/payment-voucher-form',
		'DnoFoodVenturesController@paymentVoucherForm')
		->name('paymentVoucherFormDNOfoodventures');

	Route::post(
		'/dno-food-ventures/store-payment-voucher',
		'DnoFoodVenturesController@paymentVoucherStore')
		->name('paymentVoucherStore');

	Route::get(
		'/dno-food-ventures/edit-payables-detail/{id}',
		'DnoFoodVenturesController@editPayablesDetail')
		->name('editPayablesDetailDNOFoodVentures');

	Route::patch(
		'/dno-food-ventures/payables/update-particulars/{id}',
		'DnoFoodVenturesController@updateParticulars')
		->name('updateParticulars');

	Route::patch(
		'/dno-food-ventures/payables/updateP/{id}',
		'DnoFoodVenturesController@updateP')
		->name('updateP');

	Route::patch(
		'/dno-food-ventures/payables/update-check/{id}',
		'DnoFoodVenturesController@updateCheck')
		->name('updateCheck');

	Route::patch(
		'/dno-food-ventures/payables/update-cash/{id}',
		'DnoFoodVenturesController@updateCash')
		->name('updateCash');

	Route::patch(
		'/dno-food-ventures/payables/update-details/{id}',
		'DnoFoodVenturesController@updateDetails')
		->name('updateDetails');

	Route::post(
		'/dno-food-ventures/add-payment/{id}',
		'DnoFoodVenturesController@addPayment')
		->name('addPayment');

	Route::get(
		'/dno-food-ventures/summary-report',
		'DnoFoodVenturesController@summaryReport')
		->name('summaryReport');

	Route::get(
		'/dno-food-ventures/search-multiple-date',
		'DnoFoodVenturesController@getSummaryReportMultiple')
		->name('getSummaryReportMultiple');

	Route::get(
		'/dno-food-ventures/printMultipleSummary/{date}',
		'DnoFoodVenturesController@printMultipleSummary')
		->name('printMultipleSummary');

	Route::get(
		'/dno-food-ventures/summary-report/search-number-code',
		'DnoFoodVenturesController@searchNumberCode')
		->name('searchNumberCode');

	Route::get(
		'/dno-food-ventures/search',
		'DnoFoodVenturesController@search')
		->name('search');

	Route::get(
		'/dno-food-ventures/search-date',
		'DnoFoodVenturesController@getSummaryReport')
		->name('getSummaryReport');

	Route::get(
		'/dno-food-ventures/printSummary',
		'DnoFoodVenturesController@printSummary')
		->name('printSummary');

	Route::get(
		'/dno-food-ventures/printGetSummary/{date}',
		'DnoFoodVenturesController@printGetSummary')
		->name('printGetSummary');

	Route::get(
		'/dno-food-ventures/payables/transaction-list',
		'DnoFoodVenturesController@transactionList')
		->name('transactionList');

	Route::get(
		'/dno-food-ventures/view-payables-details/{id}',
		'DnoFoodVenturesController@viewPayableDetails')
		->name('viewPayableDetails');

	Route::get(
		'/dno-food-ventures/printPayables/{id}',
		'DnoFoodVenturesController@printPayables')
		->name('printPayables');

	Route::post(
		'/dno-food-ventures/add-particular/{id}',
		'DnoFoodVenturesController@addParticulars')
		->name('addParticularsDNOFoodVentures');

	Route::patch(
			'/dno-food-ventures/accept/{id}',
			'DnoFoodVenturesController@accept')
			->name('accept');

	Route::delete(
		'/dno-food-ventures/delete-transaction-list/{id}',
		'DnoFoodVenturesController@destroyTransactionList')
		->name('destroyTransactionList');


	Route::get(
		'/dno-food-ventures/suppliers',
		'DnoFoodVenturesController@supplier')
		->name('supplier');
	
	Route::post(
		'/dno-food-ventures/supplier/add',
		'DnoFoodVenturesController@addSupplier')
		->name('addSupplier');

	Route::get(
		'/dno-food-ventures/suppliers/view/{id}',
		'DnoFoodVenturesController@viewSupplier')
		->name('viewSupplier');

	Route::get(
		'/dno-food-ventures/supplier/print/{id}',
		'DnoFoodVenturesController@printSupplier')
		->name('printSupplier');

	//DNO resources and devlopment corp
	Route::get(
		'/dno-resources-development',
		'DnoResourcesDevelopmentController@index')
		->name('dno-resources-development');

	Route::get(
		'/dno-resources-development/summary-report',
		'DnoResourcesDevelopmentController@summaryReport')
		->name('summaryReport');

	Route::get(
		'/dno-resources-development/search-multiple-date',
		'DnoResourcesDevelopmentController@getSummaryReportMultiple')
		->name('getSummaryReportMultiple');

	Route::get(
		'/dno-resources-development/printMultipleSummary/{date}',
		'DnoResourcesDevelopmentController@printMultipleSummary')
		->name('printMultipleSummary');

	
	Route::get(
		'/dno-resources-development/summary-report/search-number-code',
		'DnoResourcesDevelopmentController@searchNumberCode')
		->name('searchNumberCode');

	Route::get(
		'/dno-resources-development/search',
		'DnoResourcesDevelopmentController@search')
		->name('search');
	
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

	Route::get(
		'/dno-resources-development/suppliers',
		'DnoResourcesDevelopmentController@supplier')
		->name('supplier');

	Route::post(
		'/dno-resources-development/supplier/add',
		'DnoResourcesDevelopmentController@addSupplier')
		->name('addSupplier');

	Route::get(
		'/dno-resources-development/suppliers/view/{id}',
		'DnoResourcesDevelopmentController@viewSupplier')
		->name('viewSupplier');

	Route::get(
		'/dno-resources-development/supplier/print/{id}',
		'DnoResourcesDevelopmentController@printSupplier')
		->name('printSupplier');

	//Dong Fang Corporation
	Route::get(
		'/dong-fang-corporation',
		'DongFangCorporationController@index')
		->name('index');

	Route::get(
		'/dong-fang-corporation/payment-voucher-form',
		'DongFangCorporationController@paymentVoucherForm')
		->name('paymentVoucherFormDongFang');
	
	Route::post(
		'/dong-fang-corporation/payment-voucher-store',
		'DongFangCorporationController@paymentVoucherStore')
		->name('paymentVoucherStoreDongFang');

	Route::get(
		'/dong-fang-corporation/edit-dong-fang-payables-detail/{id}',
		'DongFangCorporationController@editPayablesDetail')
		->name('editPayablesDetailDongFang');

	Route::patch(
		'/dong-fang-corporation/payables/update-particulars/{id}',
		'DongFangCorporationController@updateParticulars')
		->name('updateParticulars');

	Route::patch(
		'/dong-fang-corporation/payables/updateP/{id}',
		'DongFangCorporationController@updateP')
		->name('updateP');

	Route::patch(
		'/dong-fang-corporation/payables/update-check/{id}',
		'DongFangCorporationController@updateCheck')
		->name('updateCheck');

	Route::patch(
		'/dong-fang-corporation/payables/update-cash/{id}',
		'DongFangCorporationController@updateCash')
		->name('updateCash');

	Route::patch(
		'/dong-fang-corporation/payables/update-details/{id}',
		'DongFangCorporationController@updateDetails')
		->name('updateDetails');
	
	Route::patch(
		'/dong-fang-corporation/accept/{id}',
		'DongFangCorporationController@accept')
		->name('acceptDongFang');

	Route::post(
		'/dong-fang-corporation/add-payment/{id}',
		'DongFangCorporationController@addPayment')
		->name('addPayment');

	Route::post(
		'/dong-fang-corportaion/add-particulars/{id}',
		'DongFangCorporationController@addParticulars')
		->name('addParticulars');
	
	Route::get(
		'/dong-fang-corporation/payables/transaction-list',
		'DongFangCorporationController@transactionList')
		->name('transactionList');

	Route::get(
		'/dong-fang-corporation/view-dong-fang-payables-details/{id}',
		'DongFangCorporationController@viewPayableDetails')
		->name('viewPayableDetailsDongFang');

	Route::get(
		'/dong-fang-corporation/printPayables/{id}',
		'DongFangCorporationController@printPayablesDongFang')
		->name('printPayablesDongFang');

	Route::get(
		'/dong-fang-corporation/summary-report',
		'DongFangCorporationController@summaryReport')
		->name('summaryReport');

	Route::get(
		'/dong-fang-corporation/search-multiple-date',
		'DongFangCorporationController@getSummaryReportMultiple')
		->name('getSummaryReportMultiple');

	Route::get(
		'/dong-fang-corporation/printMultipleSummary/{date}',
		'DongFangCorporationController@printMultipleSummary')
		->name('printMultipleSummary');

	Route::get(
		'/dong-fang-corporation/summary-report/search-number-code',
		'DongFangCorporationController@searchNumberCode')
		->name('searchNumberCode');

	Route::get(
		'/dong-fang-corporation/search',
		'DongFangCorporationController@search')
		->name('search');

	Route::get(
		'/dong-fang-corporation/printSummary',
		'DongFangCorporationController@printSummary')
		->name('printSummary');

	Route::get(
		'/dong-fang-corporation/search-date',
		'DongFangCorporationController@getSummaryReport')
		->name('getSummaryReport');

	Route::get(
		'/dong-fang-corporation/printGetSummary/{date}',
		'DongFangCorporationController@printGetSummary')
		->name('printGetSummary');

	Route::delete(
		'/dong-fang-corporation/delete-transaction-list/{id}',
		'DongFangCorporationController@destroyTransaction')
		->name('destroyTransaction');

	Route::get(
		'/dong-fang-corporation/billing-statement-form',
		'DongFangCorporationController@billingStatementForm')
		->name('billingStatementFormDongFang');
	
	Route::post(
		'/dong-fang-corporation/store-billing-statement',
		'DongFangCorporationController@storeBillingStamtement')
		->name('storeBillingStatementDongFang');

	Route::get(
		'/dong-fang-corporation/edit-billing-statment/{id}',
		'DongFangCorporationController@editBillingStatement')
		->name('editBillingStatementDongFang');

	Route::post(
		'/dong-fang-corporation/add-new-billing-statment/{id}',
		'DongFangCorporationController@addNewBillingStatement')
		->name('addNewBillingStatementDongFang');

	Route::patch(
		'/dong-fang-corporation/update-bl/{id}',
		'DongFangCorporationController@updateBL')
		->name('updateBLDongFang');

	Route::delete(
		'/dong-fang-corporation/billing-statement/delete/{id}',
		'DongFangCorporationController@destroyBillingStatment')
		->name('destroyBillingStatmentDongFang');

	Route::get(
		'/dong-fang-corporation/billing-statement/list',
		'DongFangCorporationController@billingStatementList')
		->name('billingStatementListDongFang');

	Route::get(
		'/dong-fang-corporation/view-billing-statement/{id}',
		'DongFangCorporationController@viewBillingStatement')
		->name('viewBillingStatementDongFang');

	Route::get(
		'/dong-fang-corporation/petty-cash-list',
		'DongFangCorporationController@pettyCashList')
		->name('pettyCashListDongFang');

	Route::post(
		'/dong-fang-corporation/petty-cash/add',
		'DongFangCorporationController@addPettyCash')
		->name('addPettyCash');

	Route::get(
		'/dong-fang-corporation/edit-petty-cash/{id}',
		'DongFangCorporationController@editPettyCash')
		->name('editPettyCashDongFang');

	Route::patch(
		'/dong-fang-corporation/update/{id}',
		'DongFangCorporationController@updatePC')
		->name('updatePCDongFang');

	Route::post(
		'/dong-fang-corporation/add-new-petty-cash/{id}',
		'DongFangCorporationController@addNewPettyCash')
		->name('addNewPettyCashDongFang');

	Route::patch(
		'/dong-fang-corporation/update-petty-cash/{id}',
		'DongFangCorporationController@updatePettyCash')
		->name('updatePettycashDongFang');

	Route::delete(
		'/dong-fang-corporation/petty-cash/delete/{id}',
		'DongFangCorporationController@destroyPettyCash')
		->name('destroyPettyCash');

	Route::get(
		'/dong-fang-corporation/petty-cash/view/{id}',
		'DongFangCorporationController@viewPettyCash')
		->name('viewPettyCash');

	Route::get(
		'/dong-fang-corporation/printPettyCash/{id}',
		'DongFangCorporationController@printPettyCash')
		->name('printPettyCash');


	Route::get(
		'/dong-fang-corporation/suppliers',
		'DongFangCorporationController@supplier')
		->name('supplier');

	Route::post(
		'/dong-fang-corporation/supplier/add',
		'DongFangCorporationController@addSupplier')
		->name('addSupplier');

	Route::get(
		'/dong-fang-corporation/suppliers/view/{id}',
		'DongFangCorporationController@viewSupplier')
		->name('viewSupplier');

	Route::get(
		'/dong-fang-corporation/supplier/print/{id}',
		'DongFangCorporationController@printSupplier')
		->name('printSupplier');

	//WLG Corporation
	Route::get(
		'/wlg-corporation',
		'WlgCorporationController@index')
		->name('indexWlg');
	
	Route::get(
		'/wlg-corporation/pro-forma-invoice/lists',
		'WlgCorporationController@index')
		->name('indexProFormaWlg');
	
	Route::get(
		'/wlg-corporation/commercial-invoice/lists',
		'WlgCorporationController@index')
		->name('indexCommercialInvoice');

	Route::get(
		'/wlg-corporation/quotation-invoice/lists',
		'WlgCorporationController@index')
		->name('indexQuotation');
	
	Route::get(
		'/wlg-corporation/packing-list/lists',
		'WlgCorporationController@index')
		->name('indexPackingList');
		
	Route::get(
		'/wlg-corporation/payment-voucher-form',
		'WlgCorporationController@paymentVoucherForm')
		->name('paymentVoucherFormWlg');

	Route::post(
		'/wlg-corporation/payment-voucher-store',
		'WlgCorporationController@paymentVoucherStore')
		->name('paymentVoucherStoreWlg');

	Route::get(
		'/wlg-corporation/edit-wlg-corporation-payables-detail/{id}',
		'WlgCorporationController@editPayablesDetail')
		->name('editPayablesDetailWlg');

	Route::patch(
		'/wlg-corporation/payables/update-particulars/{id}',
		'WlgCorporationController@updateParticulars')
		->name('updateParticulars');

	Route::patch(
		'/wlg-corporation/payables/updateP/{id}',
		'WlgCorporationController@updateP')
		->name('updateP');

	Route::patch(
		'/wlg-corporation/payables/update-check/{id}',
		'WlgCorporationController@updateCheck')
		->name('updateCheck');

	Route::patch(
		'/wlg-corporation/payables/update-cash/{id}',
		'WlgCorporationController@updateCash')
		->name('updateCash');

	Route::patch(
		'/wlg-corporation/payables/update-details/{id}',
		'WlgCorporationController@updateDetails')
		->name('updateDetails');

	Route::post(
		'/wlg-corporation/add-particulars/{id}',
		'WlgCorporationController@addParticulars')
		->name('addParticularsWlg');

	Route::patch(
		'/wlg-corporation/accept/{id}',
		'WlgCorporationController@accept')
		->name('acceptWlg');

	Route::post(
		'/wlg-corporation/add-payment/{id}',
		'WlgCorporationController@addPayment')
		->name('addPaymentWlg');
	
	Route::get(
		'/wlg-corporation/payables/transaction-list',
		'WlgCorporationController@transactionList')
		->name('transactionListWlg');

	Route::delete(
		'/wlg-corporation/delete-transaction-list/{id}',
		'WlgCorporationController@destroyTransaction')
		->name('destroyTransactionWlg');

	Route::get(
		'/wlg-corporation/view-wlg-corporation-payables-details/{id}',
		'WlgCorporationController@viewPayableDetails')
		->name('viewPayableDetailsWlg');

	Route::get(
		'/wlg-corporation/printPayables/{id}',
		'WlgCorporationController@printPayablesWlg')
		->name('printPayablesWlg');

	Route::get(
		'/wlg-corporation/summary-report',
		'WlgCorporationController@summaryReport')
		->name('summaryReport');

	Route::get(
		'/wlg-corporation/search-multiple-date',
		'WlgCorporationController@getSummaryReportMultiple')
		->name('getSummaryReportMultiple');

	Route::get(
		'/wlg-corporation/printMultipleSummary/{date}',
		'WlgCorporationController@printMultipleSummary')
		->name('printMultipleSummary');

	Route::get(
		'/wlg-corporation/summary-report/search-number-code',
		'WlgCorporationController@searchNumberCode')
		->name('searchNumberCode');

	Route::get(
		'/wlg-corporation/search',
		'WlgCorporationController@search')
		->name('search');

	Route::get(
		'/wlg-corporation/printSummary',
		'WlgCorporationController@printSummary')
		->name('printSummary');

	Route::get(
		'/wlg-corporation/search-date',
		'WlgCorporationController@getSummaryReport')
		->name('getSummaryReport');

	Route::get(
		'/wlg-corporation/printGetSummary/{date}',
		'WlgCorporationController@printGetSummary')
		->name('printGetSummary');

	Route::get(
		'/wlg-corporation/purchase-order',
		'WlgCorporationController@purchaseOrderForm')
		->name('purchaseOrderFormWlg');

	Route::post(
		'/wlg-corporation/store',
		'WlgCorporationController@store')
		->name('storeWlg');

	Route::get(
		'/wlg-corporation/edit-wlg-corporation-purchase-order/{id}',
		'WlgCorporationController@edit')
		->name('editWlg');

	Route::post(
		'/wlg-corporation/add-new-particulars/{id}',
		'WlgCorporationController@addNewParticulars')
		->name('addNewParticularsWlg');
	
	Route::patch(
		'/wlg-corporation/update-po/{id}',
		'WlgCorporationController@updatePo')
		->name('updatePoWlg');

	Route::delete(
		'/wlg-corporation/delete/{id}',
		'WlgCorporationController@destroy')
		->name('destroyWlg');

	Route::get(
		'/wlg-corporation/purchase-order-lists',
		'WlgCorporationController@purchaseOrderAllLists')
		->name('purchaseOrderAllListsWlg');
	
	Route::get(
		'/wlg-corporation/view-wlg-corporation-purchase-order/{id}',
		'WlgCorporationController@show')
		->name('showWlg');
	
	Route::get(
		'/wlg-corporation/printPurchaseOrder/{id}',
		'WlgCorporationController@printPO')
		->name('printPOWlg');

	Route::get(
		'/wlg-corporation/petty-cash-list',
		'WlgCorporationController@pettyCashList')
		->name('pettyCashList');

	Route::post(
		'/wlg-corporation/petty-cash/add',
		'WlgCorporationController@addPettyCash')
		->name('addPettyCashWlg');

	Route::get(
		'/wlg-corporation/edit-petty-cash/{id}',
		'WlgCorporationController@editPettyCash')
		->name('editPettyCashWLG');

	Route::patch(
		'/wlg-corporation/update-petty-cash/{id}',
		'WlgCorporationController@updatePettyCash')
		->name('updatePettyCashWLG');

	Route::post(
		'/wlg-corporation/add-new-petty-cash/{id}',
		'WlgCorporationController@addNewPettyCash')
		->name('addNewPettyCashWLG');

	Route::delete(
		'/wlg-corporation/petty-cash/delete/{id}',
		'WlgCorporationController@destroyPettyCash')
		->name('destroyPettyCash');

	Route::get(
		'/wlg-corporation/petty-cash/view/{id}',
		'WlgCorporationController@viewPettyCash')
		->name('viewPettyCashWLG');

	Route::get(
		'/wlg-corporaton/printPettyCash/{id}',
		'WlgCorporationController@printPettyCash')
		->name('printPettyCash');
		
	Route::get(
		'/wlg-corporation/invoice-form',
		'WlgCorporationController@invoiceForm')
		->name('invoiceFormWlg');

	Route::get(
			'/wlg-corporation/pro-forma-invoice',
			'WlgCorporationController@invoiceForm')
			->name('invoiceFormProForma');

	Route::get(
		'/wlg-corporation/commercial-invoice',
		'WlgCorporationController@invoiceForm')
		->name('invoiceFormCommercial');

	Route::get(
		'/wlg-corporation/quotation-invoice',
		'WlgCorporationController@invoiceForm')
		->name('invoiceFormQuotation');
	
	Route::get(
		'/wlg-corporation/packing-list',
		'WlgCorporationController@invoiceForm')
		->name('invoiceFormPackingList');

	Route::post(
		'/wlg-corporation/add-invoice',
		'WlgCorporationController@addInvoice')
		->name('addInvoiceWlg');

	Route::post(
		'/wlg-corporation/add-pro-forma-invoice',
		'WlgCorporationController@addProFormaInvoice')
		->name('addProFormaInvoiceWlf');

	Route::post(
		'/wlg-corporation/add-commercial-invoice',
		'WlgCorporationController@addCommercialInvoice')
		->name('addCommercialInvoiceWlg');

	
	Route::post(
		'/wlg-corporation/add-quotation-invoice',
		'WlgCorporationController@addQuotationInvoice')
		->name('addQuotationInvoiceWlg');
	
	Route::post(
		'/wlg-corporation/add-packing-list',
		'WlgCorporationController@addPackingList')
		->name('addPackingListWlg');

	Route::get(
		'/wlg-corporation/edit-invoice/{id}',
		'WlgCorporationController@editInvoice')
		->name('editInvoiceWlg');

	Route::get(
		'/wlg-corporation/edit-pro-forma-invoice/{id}',
		'WlgCorporationController@editInvoiceProForma')
		->name('editInvoiceProForma');

	Route::get(
		'/wlg-corporation/edit-commercial-invoice/{id}',
		'WlgCorporationController@editCommercialInvoice')
		->name('editCommercialInvoiceWlg');

	Route::get(
		'/wlg-corporation/edit-quotation-invoice/{id}',
		'WlgCorporationController@editQuotationInvoice')
		->name('editQuotationInvoiceWlg');

	Route::get(
		'/wlg-corporation/edit-packing-list/{id}',
		'WlgCorporationController@editPackingList')
		->name('editPackingListWlg');
	
	Route::post(
		'/wlg-corporation/add-new/{id}',
		'WlgCorporationController@addNewInvoice')
		->name('addNewInvoiceWlg');
	
	Route::post(
		'/wlg-corporation/add-new-pro-forma/{id}',
		'WlgCorporationController@addNewInvoiceProForma')
		->name('addNewInvoiceProFormaWlg');

	Route::post(
		'/wlg-corporation/add-new-commerical-invoice/{id}',
		'WlgCorporationController@addNewCommercialInvoice')
		->name('addNewCommercialInvoiceWlg');
	
	Route::post(
		'/wlg-corporation/add-new-quotation-invoice/{id}',
		'WlgCorporationController@addNewQuotation')
		->name('addNewQuotationWlg');
	
	Route::post(
		'/wlg-corporation/add-new-packing-list/{id}',
		'WlgCorporationController@addNewPackingList')
		->name('addNewPackingListWlg');
	

	Route::patch(
		'/wlg-corporation/update-invoice/{id}',
		'WlgCorporationController@updateIF')
		->name('updateIFWlg');

	Route::patch(
		'/wlg-corporation/update-invoice-pro-forma/{id}',
		'WlgCorporationController@updateProForma')
		->name('updateProFormaWlg');

	Route::patch(
		'/wlg-corporation/update-commercial-invoice/{id}',
		'WlgCorporationController@updateCommercialInvoice')
		->name('updateCommercialInvoiceWlg');

	Route::patch(
		'/wlg-corporation/update-quotation-invoice/{id}',
		'WlgCorporationController@updateQuotation')
		->name('updateQuotationWlg');
	
	Route::patch(
		'/wlg-corporation/update-packing-list/{id}',
		'WlgCorporationController@updatePackingList')
		->name('updatePackingListWlg');
	
	Route::delete(
		'/wlg-corporation/invoice/delete/{id}',
		'WlgCorporationController@destroyInvoice')
		->name('destroyInvoiceWlg');

	Route::get(
		'/wlg-corporation/view-invoice/{id}',
		'WlgCorporationController@viewInvoice')
		->name('viewInvoiceWlg');

	Route::get(
		'/wlg-corporation/view-pro-forma-invoice/{id}',
		'WlgCorporationController@viewInvoice')
		->name('viewInvoiceProForma');

	Route::get(
		'/wlg-corporation/view-commercial-invoice/{id}',
		'WlgCorporationController@viewInvoice')
		->name('viewInvoiceCommercialInvoice');

	Route::get(
		'/wlg-corporation/view-quotation-invoice/{id}',
		'WlgCorporationController@viewInvoice')
		->name('viewInvoiceQuotation');

	Route::get(
		'/wlg-corporation/view-packing-list/{id}',
		'WlgCorporationController@viewInvoice')
		->name('viewInvoicePackingList');


	Route::get(
		'/wlg-corporation/suppliers',
		'WlgCorporationController@supplier')
		->name('supplier');

	Route::post(
		'/wlg-corporation/supplier/add',
		'WlgCorporationController@addSupplier')
		->name('addSupplier');

	Route::get(
		'/wlg-corporation/suppliers/view/{id}',
		'WlgCorporationController@viewSupplier')
		->name('viewSupplier');

	Route::get(
		'/wlg-corporation/supplier/print/{id}',
		'WlgCorporationController@printSupplier')
		->name('printSupplier');

	//DINO Industrial Corporation
	Route::get(
		'/dino-industrial-corporation',
		'DinoIndustrialCorporationController@index')
		->name('indexDino');

	Route::get(
		'/dino-industrial-corporation/payment-voucher-form',
		'DinoIndustrialCorporationController@paymentVoucherForm')
		->name('paymentVoucherFormDinoIndustrial');

	Route::post(
		'/dino-industrial-corporation/payment-voucher-store',
		'DinoIndustrialCorporationController@paymentVoucherStore')
		->name('paymentVoucherStoreDinoIndustrial');

	Route::get(
		'/dino-industrial-corporation/edit-dino-industrial-payables-detail/{id}',
		'DinoIndustrialCorporationController@editPayablesDetail')
		->name('editPayablesDetailDinoIndustrial');

	Route::patch(
		'/dino-industrial-corporation/payables/update-particulars/{id}',
		'DinoIndustrialCorporationController@updateParticulars')
		->name('updateParticulars');

	Route::patch(
		'/dino-industrial-corporation/payables/updateP/{id}',
		'DinoIndustrialCorporationController@updateP')
		->name('updateP');

	Route::patch(
		'/dino-industrial-corporation/payables/update-check/{id}',
		'DinoIndustrialCorporationController@updateCheck')
		->name('updateCheck');

	Route::patch(
		'/dino-industrial-corporation/payables/update-cash/{id}',
		'DinoIndustrialCorporationController@updateCash')
		->name('updateCash');

	Route::patch(
		'/dino-industrial-corporation/payables/update-details/{id}',
		'DinoIndustrialCorporationController@updateDetails')
		->name('updateDetails');

	Route::get(
		'/dino-industrial-corporation/view-dino-industrial-payables-details/{id}',
		'DinoIndustrialCorporationController@viewPayableDetails')
		->name('viewPayableDetails');

	Route::get(
		'/dino-industrial-corporation/printPayables/{id}',
		'DinoIndustrialCorporationController@printPayables')
		->name('printPayables');
	
	Route::get(
		'/dino-industrial-corporation/payables/transaction-list',
		'DinoIndustrialCorporationController@transactionList')
		->name('transactionListDinoIndustrial');

	Route::delete(
		'/dino-industrial-corporation/delete-transaction-list/{id}',
		'DinoIndustrialCorporationController@destroyTransactionList')
		->name('destroyTransactionList');
	
	Route::get(
		'/dino-industrial-corporation/summary-report',
		'DinoIndustrialCorporationController@summaryReport')
		->name('summaryReport');

	Route::get(
		'/dino-industrial-corporation/search-multiple-date',
		'DinoIndustrialCorporationController@getSummaryReportMultiple')
		->name('getSummaryReportMultiple');

	Route::get(
		'/dino-industrial-corporation/printMultipleSummary/{date}',
		'DinoIndustrialCorporationController@printMultipleSummary')
		->name('printMultipleSummary');

	Route::get(
		'/dino-industrial-corporation/summary-report/search-number-code',
		'DinoIndustrialCorporationController@searchNumberCode')
		->name('searchNumberCode');

	Route::get(
		'/dino-industrial-corporation/search',
		'DinoIndustrialCorporationController@search')
		->name('search');

	Route::get(
		'/dino-industrial-corporation/printSummary',
		'DinoIndustrialCorporationController@printSummary')
		->name('printSummary');

	Route::get(
		'/dino-industrial-corporation/search-date',
		'DinoIndustrialCorporationController@getSummaryReport')
		->name('getSummaryReport');

	Route::get(
		'/dino-industrial-corporation/printGetSummary/{date}',
		'DinoIndustrialCorporationController@printGetSummary')
		->name('printGetSummary');

	Route::post(
		'/dino-industrial-corporation/add-particulars/{id}',
		'DinoIndustrialCorporationController@addParticulars')
		->name('addParticularsDinoIndustrial');

	Route::post(
		'/dino-industrial-corporation/add-payment/{id}',
		'DinoIndustrialCorporationController@addPayment')
		->name('addPaymentDinoIndustrial');

	Route::patch(
		'/dino-industrial-corporation/accept/{id}',
		'DinoIndustrialCorporationController@accept')
		->name('acceptDinoIndustrial');

	Route::get(
		'/dino-industrial-corporation/suppliers',
		'DinoIndustrialCorporationController@supplier')
		->name('supplier');

	Route::post(
		'/dino-industrial-corporation/supplier/add',
		'DinoIndustrialCorporationController@addSupplier')
		->name('addSupplier');

	Route::get(
		'/dino-industrial-corporation/suppliers/view/{id}',
		'DinoIndustrialCorporationController@viewSupplier')
		->name('viewSupplier');

	Route::get(
		'/dino-industrial-corporation/supplier/print/{id}',
		'DinoIndustrialCorporationController@printSupplier')
		->name('printSupplier');

	/*********************************************
	 * LOCAL GROUND
	 * 
	 */
	Route::get(
		'/local-ground',
		'LocalGroundController@index')
		->name('index');

	Route::get(
		'/local-ground/payment-voucher-form',
		'LocalGroundController@paymentVoucherForm')
		->name('paymentVoucherForm');

	Route::post(
		'/local-ground/payment-voucher-store',
		'LocalGroundController@paymentVoucherStore')
		->name('paymentVoucherStoreLocalGround');

	Route::get(
		'/local-ground/edit-local-ground-payables-details/{id}',
		'LocalGroundController@editPayablesDetail')
		->name('editPayablesDetailLocalGround');

	Route::patch(
		'/local-ground/payables/update-particulars/{id}',
		'LocalGroundController@updateParticulars')
		->name('updateParticulars');

	Route::patch(
		'/local-ground/payables/updateP/{id}',
		'LocalGroundController@updateP')
		->name('updateP');

	Route::patch(
		'/local-ground/payables/update-check/{id}',
		'LocalGroundController@updateCheck')
		->name('updateCheck');

	Route::patch(
		'/local-ground/payables/update-cash/{id}',
		'LocalGroundController@updateCash')
		->name('updateCash');

	Route::patch(
		'/local-ground/payables/update-details/{id}',
		'LocalGroundController@updateDetails')
		->name('updateDetails');

	Route::post(
		'/local-ground/add-payment/{id}',
		'LocalGroundController@addPayment')
		->name('addPaymentLocalGround');

	Route::post(
		'/local-ground/add-particulars/{id}',
		'LocalGroundController@addParticulars')
		->name('addParticularsLocalGround');

	Route::patch(
		'/local-ground/accept/{id}',
		'LocalGroundController@accept')
		->name('acceptLocalGround');

	Route::get(
		'/local-ground/payables/transaction-list',
		'LocalGroundController@transactionList')
		->name('transactionList');

	Route::delete(
		'/local-ground/delete-transaction-list/{id}',
		'LocalGroundController@destroyTransaction')
		->name('destroyTransaction');

	Route::get(
		'/local-ground/view-local-ground-payables-details/{id}',
		'LocalGroundController@viewPayableDetails')
		->name('viewPayableDetailsLocalGround');

	Route::get(
		'/local-ground/printPayables/{id}',
		'LocalGroundController@printPayables')
		->name('printPayablesLocalGround');

	Route::get(
		'/local-ground/summary-report',
		'LocalGroundController@summaryReport')
		->name('summaryReport');

	Route::get(
		'/local-ground/search-date',
		'LocalGroundController@getSummaryReport')
		->name('getSummaryReport');

	Route::get(
		'/local-ground/printSummary',
		'LocalGroundController@printSummary')
		->name('printSummary');

	Route::get(
		'/local-ground/search-multiple-date',
		'LocalGroundController@getSummaryReportMultiple')
		->name('getSummaryReportMultiple');

	Route::get(
		'/local-ground/printMultipleSummary/{date}',
		'LocalGroundController@printMultipleSummary')
		->name('printMultipleSummary');

	Route::get(
		'/local-ground/printGetSummary/{date}',
		'LocalGroundController@printGetSummary')
		->name('printGetSummary');


	Route::get(
		'/local-ground/suppliers',
		'LocalGroundController@supplier')
		->name('supplier');

	Route::post(
		'/local-ground/supplier/add',
		'LocalGroundController@addSupplier')
		->name('addSupplier');

	Route::get(
		'/local-ground/suppliers/view/{id}',
		'LocalGroundController@viewSupplier')
		->name('viewSupplier');

	Route::get(
		'/local-ground/supplier/print/{id}',
		'LocalGroundController@printSupplier')
		->name('printSupplier');


});


