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

Route::match(['get', 'post'], 'register', function () {
    echo "FORBIDDEN";
})->name('register');

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' =>['user']], function(){
	Route::get(
		'/settings',
		'SettingsController@index')
		->name('indexSettings')
		->middleware(['cashier']);

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
		->name('createBranch')
		->middleware(['cashier']);

	Route::post(
		'/profile/store-create-branch',
		'ProfileController@storeCreateBranch')
		->name('storeCreateBranch')
		->middleware(['cashier']);


	Route::post(
		'/profile/reset-password-branch',
		'ProfileController@resetBranchPassword')
		->name('resetBranchPassword')
		->middleware(['cashier']);


	//route for summary reports
	Route::get(
		'/lolo-pinoy-lechon-de-cebu/summary-report/per-day',
		'LoloPinoyLechonDeCebuController@summaryReportPerDay')
		->name('summaryReportPerDay')
		->middleware(['cashier']);


	Route::get(
		'/lolo-pinoy-lechon-de-cebu/search-multiple-date',
		'LoloPinoyLechonDeCebuController@getSummaryReportMultiple')
		->name('getSummaryReportMultiple')
		->middleware(['cashier']);


	Route::get(
		'/lolo-pinoy-lechon-de-cebu/printMultipleSummary/{date}',
		'LoloPinoyLechonDeCebuController@printMultipleSummary')
		->name('printMultipleSummary')
		->middleware(['cashier']);



	Route::get(
		'/lolo-pinoy-lechon-de-cebu/printSummary',
		'LoloPinoyLechonDeCebuController@printSummary')
		->name('printSummary')
		->middleware(['cashier']);


	Route::get(
		'/lolo-pinoy-lechon-de-cebu/printGetSummary/{date}',
		'LoloPinoyLechonDeCebuController@printGetSummary')
		->name('printSummary')
		->middleware(['cashier']);


	Route::get(
		'/lolo-pinoy-lechon-de-cebu/search-date',
		'LoloPinoyLechonDeCebuController@getSummaryReport')
		->name('getSummaryReport')
		->middleware(['cashier']);


	Route::get(
		'/lolo-pinoy-lechon-de-cebu/summary-report/search-number-code',
		'LoloPinoyLechonDeCebuController@searchNumberCode')
		->name('searchNumberCode')
		->middleware(['cashier']);

	Route::post(
		'/lolo-pinoy-lechon-de-cebu/search',
		'LoloPinoyLechonDeCebuController@search')
		->name('search')
		->middleware(['cashier']);


	//route for delete delivery receipt
	Route::delete('/lolo-pinoy-lechon-de-cebu/delete-delivery-receipt/{id}', 
		'LoloPinoyLechonDeCebuController@destroyDeliveryReceipt')
		->name('destroyDeliveryReceipt')
		->middleware(['cashier']);



	Route::delete('/lolo-pinoy-lechon-de-cebu/delete/dr/{id}', 
		'LoloPinoyLechonDeCebuController@destroyDR')
		->name('destroyDR')
		->middleware(['cashier']);



	Route::get(
		'/lolo-pinoy-lechon-de-cebu/petty-cash-list',
		'LoloPinoyLechonDeCebuController@pettyCashList')
		->name('pettyCashListLechonDeCebu')
		->middleware(['cashier']);


	Route::get(
		'/lolo-pinoy-lechon-de-cebu/suppliers',
		'LoloPinoyLechonDeCebuController@supplier')
		->name('supplier')
		->middleware(['cashier']);


	Route::post(
		'/lolo-pinoy-lechon-de-cebu/supplier/add',
		'LoloPinoyLechonDeCebuController@addSupplier')
		->name('addSupplier')
		->middleware(['cashier']);


	Route::get(
		'/lolo-pinoy-lechon-de-cebu/suppliers/view/{id}',
		'LoloPinoyLechonDeCebuController@viewSupplier')
		->name('viewSupplier')
		->middleware(['cashier']);


	Route::get(
		'/lolo-pinoy-lechon-de-cebu/supplier/print/{id}',
		'LoloPinoyLechonDeCebuController@printSupplier')
		->name('printSupplier')
		->middleware(['cashier']);


	Route::get(
		'/lolo-pinoy-lechon-de-cebu/utilities',
		'LoloPinoyLechonDeCebuController@utilities')
		->name('utilitiesLechonDeCebu')
		->middleware(['cashier']);

	Route::delete(
		'/lolo-pinoy-lechon-de-cebu/utilities/delete/{id}',
		'LoloPinoyLechonDeCebuController@destroyUtility')
		->name('destroyUtilityLechonDeCebu')
		->middleware(['cashier']);

	Route::post(
		'/lolo-pinoy-lechon-de-cebu/petty-cash/add',
		'LoloPinoyLechonDeCebuController@addPettyCash')
		->name('addPettyCashLechonDeCebu')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/edit-petty-cash/{id}',
		'LoloPinoyLechonDeCebuController@editPettyCash')
		->name('editPettyCashLechonDeCebu')
		->middleware(['cashier']);

	Route::patch(
		'/lolo-pinoy-lechon-de-cebu/update-petty-cash/{id}',
		'LoloPinoyLechonDeCebuController@updatePettyCash')
		->name('updatePettyCashLechonDeCebu')
		->middleware(['cashier']);
	
	Route::post(
		'/lolo-pinoy-lechon-de-cebu/add-new-petty-cash/{id}',
		'LoloPinoyLechonDeCebuController@addNewPettyCash')
		->name('addNewPettyCashLechonDeCebu')
		->middleware(['cashier']);

	Route::patch(
		'/lolo-pinoy-lechon-de-cebu/updatePC/{id}',
		'LoloPinoyLechonDeCebuController@updatePC')
		->name('updatePCLechonDeCebu')
		->middleware(['cashier']);

	Route::delete(
		'/lolo-pinoy-lechon-de-cebu/petty-cash/delete/{id}',
		'LoloPinoyLechonDeCebuController@destroyPettyCash')
		->name('destroyPettyCashLechonDeCebu')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/petty-cash/view/{id}',
		'LoloPinoyLechonDeCebuController@viewPettyCash')
		->name('viewPettCashLechonDeCebu')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-commissary/printPettyCash/{id}',
		'LoloPinoyGrillCommissaryController@printPettyCash')
		->name('printPettyCashLoloPinoyGrill')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/printPettyCash/{id}',
		'LoloPinoyLechonDeCebuController@printPettyCash')
		->name('printPettyCashLechonDeCebu')
		->middleware(['cashier']);

	//route for payment vouchers
	Route::get(
		'/lolo-pinoy-lechon-de-cebu/payment-voucher-form', 
		'LoloPinoyLechonDeCebuController@paymentVoucherForm')
		->name('paymentVoucherFormLechonDeCebu')
		->middleware(['cashier']);

	//route for payment vouchers store
	Route::post(
		'/lolo-pinoy-lechon-de-cebu/payment-voucher-store', 
		'LoloPinoyLechonDeCebuController@paymentVoucherStore')
		->name('paymnentVoucherStore')
		->middleware(['cashier']);

	
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
		->name('lolo-pinoy-lechon-de-cebu.addNewPaymentVoucher')
		->middleware(['cashier']);

	Route::get(
			'/lolo-pinoy-lechon-de-cebu/payables/transaction-list',
			'LoloPinoyLechonDeCebuController@transactionList')
			->name('lolo-pinoy-lechon-de-cebu.transactionList')
			->middleware(['cashier']);

	Route::post(
		'/lolo-pinoy-lechon-de-cebu/utilities/add-bill',
		'LoloPinoyLechonDeCebuController@addBills')
		->name('addBillsLechonDeCebu')
		->middleware(['cashier']);

	Route::post(
		'/lolo-pinoy-lechon-de-cebu/utilities/add-internet',
		'LoloPinoyLechonDeCebuController@addInternet')
		->name('addInternetLechonDeCebu')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/utilities/view-veco/{id}',
		'LoloPinoyLechonDeCebuController@viewBills')
		->name('viewBillsLechonDeCebu')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/utilities/view-internet/{id}',
		'LoloPinoyLechonDeCebuController@viewBills')
		->name('viewBillsLechonDeCebu')
		->middleware(['cashier']);
	
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
		->name('summaryReportLpGrillComm')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-commissary/search-mutiple-date',
		'LoloPinoyGrillCommissaryController@getSummaryReportMultiple')
		->name('getSummaryReportMultiple')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-commissary/printMultipleSummary/{date}',
		'LoloPinoyGrillCommissaryController@printMultipleSummary')
		->name('printMultipleSummary')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-commissary/summary-report/search-number-code',
		'LoloPinoyGrillCommissaryController@searchNumberCode')
		->name('searchNumberCode')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-commissary/search',
		'LoloPinoyGrillCommissaryController@search')
		->name('search')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-commissary/printSummary',
		'LoloPinoyGrillCommissaryController@printSummary')
		->name('printSummary')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-commissary/printGetSummary/{date}',
		'LoloPinoyGrillCommissaryController@printGetSummary')
		->name('printGetSummary')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-commissary/search-date',
		'LoloPinoyGrillCommissaryController@getSummaryReport')
		->name('getSummaryReport')
		->middleware(['cashier']);

	//payment voucher form
	Route::get(
		'/lolo-pinoy-grill-commissary/payment-voucher-form', 
		'LoloPinoyGrillCommissaryController@paymentVoucherForm')
		->name('paymentVoucherFormLoloPinoyGril')
		->middleware(['cashier']);

	//save 
	Route::post('/lolo-pinoy-grill-commissary/payment-voucher-store', 
	'LoloPinoyGrillCommissaryController@paymentVoucherStore')
	->name('lolo-pinoy-grill-commissary.paymentVoucherStore')
	->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-commissary/payables/transaction-list',
		'LoloPinoyGrillCommissaryController@transactionList')
		->name('lolo-pinoy-grill-commissary.transactionList')
		->middleware(['cashier']);


	Route::get(
		'/lolo-pinoy-grill-commissary/printPayables/{id}',
		'LoloPinoyGrillCommissaryController@printPayables')
		->name('lolo-pinoy-grill-commissary.printPayables')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-payables-detail/{id}',
		'LoloPinoyGrillCommissaryController@editPayablesDetail')
		->name('editPayablesDetailLoloPinoyGrill')
		->middleware(['cashier']);

	Route::patch(
		'/lolo-pinoy-grill-commissary/payables/update-particulars/{id}',
		'LoloPinoyGrillCommissaryController@updateParticulars')
		->name('updateParticulars')
		->middleware(['cashier']);

	Route::patch(
		'/lolo-pinoy-grill-commissary/payables/updateP/{id}',
		'LoloPinoyGrillCommissaryController@updateP')
		->name('updateP')
		->middleware(['cashier']);

	Route::patch(
		'/lolo-pinoy-grill-commissary/payables/update-check/{id}',
		'LoloPinoyGrillCommissaryController@updateCheck')
		->name('updateCheck')
		->middleware(['cashier']);

	Route::patch(
		'/lolo-pinoy-grill-commissary/payables/update-cash/{id}',
		'LoloPinoyGrillCommissaryController@updateCash')
		->name('updateCash')
		->middleware(['cashier']);

	Route::patch(
		'/lolo-pinoy-grill-commissary/payables/update-details/{id}',
		'LoloPinoyGrillCommissaryController@updateDetails')
		->name('updateDetails')
		->middleware(['cashier']);
	
	Route::post(
		'/lolo-pinoy-grill-commissary/add-particulars/{id}',
		'LoloPinoyGrillCommissaryController@addParticulars')
		->name('lolo-pinoy-grill-commissary.addParticulars')
		->middleware(['cashier']);

	Route::post(
		'/lolo-pinoy-grill-commissary/add-payment/{id}',
		'LoloPinoyGrillCommissaryController@addPayment')
		->name('lolo-pinoy-grill-commissary.addPayment')
		->middleware(['cashier']);

	Route::patch(
		'/lolo-pinoy-grill-commissary/accept/{id}',
		'LoloPinoyGrillCommissaryController@accept')
		->name('lolo-pinoy-grill-commissary.accept')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-commissary/view-payables-details/{id}',
		'LoloPinoyGrillCommissaryController@viewPayableDetails')
		->name('lolo-pinoy-grill-commissary.viewPayableDetails')
		->middleware(['cashier']);


	//edit payment voucher
	Route::get('/lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-payment-voucher/{id}', 
	'LoloPinoyGrillCommissaryController@editPaymentVoucher')
	->name('lolo-pinoy-grill-commissary.editPaymentVoucher')
	->middleware(['cashier']);

	Route::patch('/lolo-pinoy-grill-commissary/update-payment-voucher/{id}', 
	'LoloPinoyGrillCommissaryController@updatePaymentVoucher')
	->name('lolo-pinoy-grill-commissary.updatePaymentVoucher')
	->middleware(['cashier']);

	Route::get('/lolo-pinoy-grill-commissary/add-new-lolo-pinoy-grill-payment-voucher/{id}', 
	'LoloPinoyGrillCommissaryController@addNewPaymentVoucher')
	->name('lolo-pinoy-grill-commissary.addNewPaymentVoucher')
	->middleware(['cashier']);

	Route::post('/lolo-pinoy-grill-commissary/add-new-payment-voucher-data/{id}', 
	'LoloPinoyGrillCommissaryController@addNewPaymentVoucherData')
	->name('lolo-pinoy-grill-commissary.addNewPaymentVoucherData')
	->middleware(['cashier']);

	Route::patch('/lolo-pinoy-grill-commissary/update-pv/{id}', 
	'LoloPinoyGrillCommissaryController@updatePV')
	->name('lolo-pinoy-grill-commissary.updatePV')
	->middleware(['cashier']);

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
		->name('paymentVoucherFormMrPotato')
		->middleware(['cashier']);

	Route::post(
		'/mr-potato/store-payment',
		'MrPotatoController@paymentVoucherStore')
		->name('mr-potato.paymentVoucherStore')
		->middleware(['cashier']);

	Route::get(
		'/mr-potato/payables/transaction-list',
		'MrPotatoController@transactionList')
		->name('mr-potato.transactionList')
		->middleware(['cashier']);

	Route::get(
		'/mr-potato/edit-mr-potato-payables-detail/{id}',
		'MrPotatoController@editPayablesDetail')
		->name('editPayablesDetailMrPotato')
		->middleware(['cashier']);

	Route::patch(
		'/mr-potato/payables/update-particulars/{id}',
		'MrPotatoController@updateParticulars')
		->name('updateParticulars')
		->middleware(['cashier']);
		
	Route::patch(
		'/mr-potato/payables/updateP/{id}',
		'MrPotatoController@updateP')
		->name('updateP')
		->middleware(['cashier']);

	Route::patch(
		'/mr-potato/payables/update-check/{id}',
		'MrPotatoController@updateCheck')
		->name('updateCheck')
		->middleware(['cashier']);

	Route::patch(
		'/mr-potato/payables/update-cash/{id}',
		'MrPotatoController@updateCash')
		->name('updateCash')
		->middleware(['cashier']);

	Route::patch(
		'/mr-potato/payables/update-details/{id}',
		'MrPotatoController@updateDetails')
		->name('updateDetails')
		->middleware(['cashier']);

	Route::post(
		'/mr-potato/add-particulars/{id}',
		'MrPotatoController@addParticulars')	
		->name('mr-potato.addParticulars')
		->middleware(['cashier']);

	Route::get(
		'/mr-potato/print-payables/{id}',
		'MrPotatoController@printPayables')
		->name('mr-potato.printPayables')
		->middleware(['cashier']);

	Route::post(
		'/mr-potato/add-payment/{id}',
		'MrPotatoController@addPayment')
		->name('mr-potato.addPayment')
		->middleware(['cashier']);

	Route::patch(
		'/mr-potato/accept/{id}',
		'MrPotatoController@accept')
		->name('mr-potato.accept')
		->middleware(['cashier']);

	Route::get(
		'/mr-potato/view-mr-potato-payables-details/{id}',
		'MrPotatoController@viewPayableDetails')
		->name('mr-potato.viewPayableDetails')
		->middleware(['cashier']);

	Route::get(
		'/mr-potato/suppliers',
		'MrPotatoController@supplier')
		->name('supplier')
		->middleware(['cashier']);

	Route::post(
		'/mr-potato/supplier/add',
		'MrPotatoController@addSupplier')
		->name('addSupplier')
		->middleware(['cashier']);

	Route::get(
		'/mr-potato/suppliers/view/{id}',
		'MrPotatoController@viewSupplier')
		->name('viweSupplier')
		->middleware(['cashier']);

	Route::get(
		'/mr-potato/supplier/print/{id}',
		'MrPotatoController@printSupplier')
		->name('printSupplier')
		->middleware(['cashier']);

	Route::get(
		'/mr-potato/summary-report',
		'MrPotatoController@summaryReport')
		->name('summaryReport')
		->middleware(['cashier']);

	Route::get(
		'/mr-potato/search-multiple-date',
		'MrPotatoController@getSummaryReportMultiple')
		->name('getSummaryReportMultiple')
		->middleware(['cashier']);

	Route::get(
		'/mr-potato/printMultipleSummary/{date}',
		'MrPotatoController@printMultipleSummary')
		->name('printMultipleSummary')
		->middleware(['cashier']);

	Route::get(
		'/mr-potato/summary-report/search-number-code',
		'MrPotatoController@searchNumberCode')
		->name('searchNumberCode')
		->middleware(['cashier']);

	Route::get(
		'/mr-potato/search',
		'MrPotatoController@search')
		->name('search')
		->middleware(['cashier']);

	Route::get(
		'/mr-potato/printSummary',
		'MrPotatoController@printSummary')
		->name('printSummaryMrPotato')
		->middleware(['cashier']);

	Route::get(
		'/mr-potato/search-date',
		'MrPotatoController@getSummaryReport')
		->name('getSummaryReport')
		->middleware(['cashier']);

	Route::get(
		'/mr-potato/printGetSummary/{date}',
		'MrPotatoController@printGetSummary')
		->name('printGetSummary')
		->middleware(['cashier']);

	Route::get(
		'/mr-potato/edit-mr-potato-payment-voucher/{id}',
		'MrPotatoController@editPaymentVoucher')
		->name('mr-potato.editPaymentVoucher')
		->middleware(['cashier']);

	Route::patch(
		'/mr-potato/update-payment-voucher/{id}',
		'MrPotatoController@updatePaymentVoucher')
		->name('mr-potato.updatePaymentVoucher')
		->middleware(['cashier']);

	Route::get(
		'/mr-potato/add-new-mr-potato-payment-voucher/{id}',
		'MrPotatoController@addNewPaymentVoucher')
		->name('mr-potato.addNewPaymentVoucher')
		->middleware(['cashier']);

	Route::post(
		'/mr-potato/add-new-payment-voucher-data/{id}',
		'MrPotatoController@addNewPaymentVoucherData')
		->name('mr-potato.addNewPaymentVoucherData')
		->middleware(['cashier']);

	Route::patch(
		'/mr-potato/update-pv/{id}',
		'MrPotatoController@updatePV')
		->name('mr-potato.updatePV')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/suppliers',
		'RibosBarController@supplier')
		->name('supplier')
		->middleware(['cashier']);

	Route::post(
		'/ribos-bar/supplier/add',
		'RibosBarController@addSupplier')
		->name('addSupplier')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/suppliers/view/{id}',
		'RibosBarController@viewSupplier')
		->name('viewSupplier')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/supplier/print/{id}',
		'RibosBarController@printSupplier')
		->name('printSupplier')
		->middleware(['cashier']);
	
	Route::get(
			'/ribos-bar/payment-voucher-form',
			'RibosBarController@paymentVoucherForm')
			->name('paymentVoucherFormRibosBar')
			->middleware(['cashier']);

	
	//store
	Route::post(
		'/ribos-bar/payment-voucher-store',
		'RibosBarController@paymentVoucherStore')
		->name('paymentVoucherStore')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/payables/transaction-list',
		'RibosBarController@transactionList')
		->name('transactionListRibosBar')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/edit-ribos-bar-payables-detail/{id}',
		'RibosBarController@editPayablesDetail')
		->name('editPayablesDetailRibosBar')
		->middleware(['cashier']);

	Route::patch(
		'/ribos-bar/payables/update-particulars/{id}',
		'RibosBarController@updateParticulars')
		->name('updateParticulars')
		->middleware(['cashier']);

	Route::patch(
		'/ribos-bar/payables/updateP/{id}',
		'RibosBarController@updateP')
		->name('updateP')
		->middleware(['cashier']);
	
	Route::patch(
		'/ribos-bar/payables/update-check/{id}',
		'RibosBarController@updateCheck')
		->name('updateCheck')
		->middleware(['cashier']);

	Route::patch(
		'/ribos-bar/payables/update-cash/{id}',
		'RibosBarController@updateCash')
		->name('updateCash')
		->middleware(['cashier']);

	Route::patch(
		'/ribos-bar/payables/update-details/{id}',
		'RibosBarController@updateDetails')
		->name('updateDetails')
		->middleware(['cashier']);
	
	Route::post(
		'/ribos-bar/add-particulars/{id}',
		'RibosBarController@addParticulars')
		->name('addParticulars')
		->middleware(['cashier']);

	Route::post(
		'/ribos-bar/add-payment/{id}',
		'RibosBarController@addPayment')
		->name('addPayment')
		->middleware(['cashier']);

	Route::patch(
		'/ribos-bar/accept/{id}',
		'RibosBarController@accept')
		->name('accept')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/view-payables-details/{id}',
		'RibosBarController@viewPayableDetails')
		->name('viewPayableDetails')
		->middleware(['cashier']);
	

	Route::get(
		'/ribos-bar/print-payables/{id}',
		'RibosBarController@printPayablesRibosBar')
		->name('ribos-bar.printPayablesRibosBar')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/edit-ribos-bar-payment-voucher/{id}',
		'RibosBarController@editPaymentVoucher')
		->name('ribos-bar.editPaymentVoucher')
		->middleware(['cashier']);

	Route::patch(
		'/ribos-bar/update-payment-voucher/{id}',
		'RibosBarController@updatePaymentVoucher')
		->name('ribos-bar.updatePaymentVoucher')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/add-new-ribos-bar-payment-voucher/{id}',
		'RibosBarController@addNewPaymentVoucher')
		->name('ribos-bar.addNewPaymentVoucher')
		->middleware(['cashier']);

	Route::post(
		'/ribos-bar/add-new-payment-voucher-data/{id}',
		'RibosBarController@addNewPaymentVoucherData')
		->name('ribos-bar.addNewPaymentVoucherData')
		->middleware(['cashier']);

	Route::patch(
		'/ribos-bar/update-pv/{id}',
		'RibosBarController@updatePV')
		->name('ribos-bar.updatePV')
		->middleware(['cashier']);


	Route::post(
		'/dno-personal/payment-voucher-store/',
		'DnoPersonalController@paymentVoucherStore')
		->name('dno-personal.paymentVoucherStore')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/suppliers',
		'DnoPersonalController@supplier')
		->name('supplier')
		->middleware(['cashier']);


	Route::post(
		'/dno-personal/supplier/add',
		'DnoPersonalController@addSupplier')
		->name('addSupplier')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/suppliers/view/{id}',
		'DnoPersonalController@viewSupplier')
		->name('viewSupplier')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/supplier/print/{id}',
		'DnoPersonalController@printSupplier')
		->name('printSupplier')
		->middleware(['cashier']);

	Route::get(
			'/dno-personal/payment-voucher-form',
			'DnoPersonalController@paymentVoucherForm')
		->name('paymentVoucherFormDNOPersonal')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/payables/transaction-list',
		'DnoPersonalController@transactionList')
		->name('dno-personal.transactionList')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/edit-dno-personal-payables-detail/{id}',
		'DnoPersonalController@editPayablesDetail')
		->name('editPayablesDetailDnoPersonal')
		->middleware(['cashier']);

	Route::patch(
		'/dno-personal/payables/update-particulars/{id}',
		'DnoPersonalController@updateParticulars')
		->name('updateParticulars')
		->middleware(['cashier']);

	Route::patch(
		'/dno-personal/payables/updateP/{id}',
		'DnoPersonalController@updateP')
		->name('updateP')
		->middleware(['cashier']);

	Route::patch(
		'/dno-personal/payables/update-check/{id}',
		'DnoPersonalController@updateCheck')
		->name('updateCheck')
		->middleware(['cashier']);

	Route::patch(
		'/dno-personal/payables/update-cash/{id}',
		'DnoPersonalController@updateCash')
		->name('updateCash')
		->middleware(['cashier']);

	Route::patch(
		'/dno-personal/payables/update-details-cc/{id}',
		'DnoPersonalController@updateDetailsCC')
		->name('updateDetailsCC')
		->middleware(['cashier']);

	Route::post(
		'/dno-personal/add-particulars/{id}',
		'DnoPersonalController@addParticulars')
		->name('dno-personal.addParticulars')
		->middleware(['cashier']);

	Route::post(
		'/dno-personal/add-payment/{id}',
		'DnoPersonalController@addPayment')
		->name('dno-personal.addPayment')
		->middleware(['cashier']);

	Route::patch(
		'/dno-personal/accept/{id}',
		'DnoPersonalController@accept')
		->name('dno-personal.accept')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/view-dno-personal-payables-details/{id}',
		'DnoPersonalController@viewPayableDetails')
		->name('viewPayableDetails')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/printPayables/{id}',
		'DnoPersonalController@printPayablesDnoPersonal')
		->name('dno-personal.printPayablesDnoPersonal')
		->middleware(['cashier']);
	
	Route::get(
		'/dno-resources-development/payment-voucher-form',
		'DnoResourcesDevelopmentController@paymentVoucherForm')
		->name('paymentVoucherFormDnoResources')
		->middleware(['cashier']);

	Route::post(
		'/dno-resources-development/payment-voucher-store',
		'DnoResourcesDevelopmentController@paymentVoucherStore')
		->name('dno-resources-development.paymentVoucherStore')
		->middleware(['cashier']);

	Route::get(
		'/dno-resources-development/payables/transaction-list',
		'DnoResourcesDevelopmentController@transactionList')
		->name('dno-resources-development.transactionList')
		->middleware(['cashier']);

	Route::get(
		'/dno-resources-development/edit-dno-resources-payables-detail/{id}',
		'DnoResourcesDevelopmentController@editPayablesDetail')
		->name('editPayablesDetailDnoResources')
		->middleware(['cashier']);

	Route::patch(
		'/dno-resources-development/payables/update-particulars/{id}',
		'DnoResourcesDevelopmentController@updateParticulars')
		->name('updateParticulars')
		->middleware(['cashier']);

	Route::patch(
		'/dno-resources-development/payables/updateP/{id}',
		'DnoResourcesDevelopmentController@updateP')
		->name('updateP')
		->middleware(['cashier']);

	Route::patch(
		'/dno-resources-development/payables/update-check/{id}',
		'DnoResourcesDevelopmentController@updateCheck')
		->name('updateCheck')
		->middleware(['cashier']);

	Route::patch(
		'/dno-resources-development/payables/update-cash/{id}',
		'DnoResourcesDevelopmentController@updateCash')
		->name('updateCash')
		->middleware(['cashier']);

	Route::patch(
		'/dno-resources-development/payables/update-details/{id}',
		'DnoResourcesDevelopmentController@updateDetails')
		->name('updateDetails')
		->middleware(['cashier']);

	Route::get(
		'/dno-resources-development/printSummary',
		'DnoResourcesDevelopmentController@printSummary')
		->name('printSummary')
		->middleware(['cashier']);

	Route::get(
		'/dno-resources-development/search-date',
		'DnoResourcesDevelopmentController@getSummaryReport')
		->name('getSummaryReport')
		->middleware(['cashier']);


	Route::get(
		'/dno-resources-development/printGetSummary/{date}',
		'DnoResourcesDevelopmentController@printGetSummary')
		->name('printGetSummary')
		->middleware(['cashier']);
	
	Route::post(
		'/dno-resources-developemtn/add-particulars/{id}',
		'DnoResourcesDevelopmentController@addParticulars')
		->name('dno-resources-development.addParticulars')
		->middleware(['cashier']);

	Route::post(
		'/dno-resources-development/add-payment/{id}',
		'DnoResourcesDevelopmentController@addPayment')
		->name('dno-resources-development.addPayment')
		->middleware(['cashier']);

	Route::patch(
		'/dno-resources-development/accept/{id}',
		'DnoResourcesDevelopmentController@accept')
		->name('dno-resources-development.accept')
		->middleware(['cashier']);

	Route::get(
		'/dno-resources-development/view-dno-resources-payables-details/{id}',
		'DnoResourcesDevelopmentController@viewPayableDetails')
		->name('viewPayableDetails')
		->middleware(['cashier']);

	Route::get(
		'/dno-resources-development/printPayables/{id}',
		'DnoResourcesDevelopmentController@printPayables')
		->name('dno-resources-development.printPayables')
		->middleware(['cashier']);


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
		->middleware(['user','auth', 'cashier']);
	
	Route::post(
		'/profile/store-create-user',
		'ProfileController@storeCreateUser')
		->name('profile.storeCreateUser')
		->middleware(['user','auth', 'cashier']);

		//route for summary reports
		Route::get(
			'/lolo-pinoy-lechon-de-cebu/summary-report',
			'LoloPinoyLechonDeCebuController@summaryReportPerDay')
			->name('summaryReportPerDay')
			->middleware(['cashier']);
	
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
			->name('searchNumberCode')
			->middleware(['cashier']);
	
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
		->name('destroySI')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/suppliers',
		'LoloPinoyLechonDeCebuController@supplier')
		->name('supplier')
		->middleware(['cashier']);

	Route::post(
		'/lolo-pinoy-lechon-de-cebu/supplier/add',
		'LoloPinoyLechonDeCebuController@addSupplier')
		->name('addSupplier')
		->middleware(['cashier']);

	//delete comissary RAW materials
	Route::delete('/lolo-pinoy-lechon-de-cebu/delete-raw-materials/{id}', 
	 'LoloPinoyLechonDeCebuController@destroyRawMaterial')
	 ->name('lolo-pinoy-lechon-de-cebu.destroyRawMaterial')
	 ->middleware(['cashier']);
	
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
		'/lolo-pinoy-grill-commissary/delete-data-billing-statement/{id}',
		'LoloPinoyGrillCommissaryController@destroyBillingDataStatement')
		->name('destroyBillingDataStatement');
		
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
	Route::get('/change-password', 'ChangePasswordController@index')->name('index');

	Route::patch('/change-password/update/{id}', 'ChangePasswordController@update')->name('update');

	//route for lolo pinoy lechon de cebu
	Route::get('lolo-pinoy-lechon-de-cebu', 
	'LoloPinoyLechonDeCebuController@index')
	->name('index')
	->middleware(['cashier']);

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
			->name('searchNumberCode')
			->middleware(['cashier']);
	
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
		->name('billingStatementFormLechonDecebu')
		->middleware(['cashier']);

	//
	Route::post('/lolo-pinoy-lechon-de-cebu/store-billing-statement', 
	'LoloPinoyLechonDeCebuController@storeBillingStatement')
	->name('lolo-pinoy-lechon-de-cebu.storeBillingStatement')
	->middleware(['cashier']);


	//route for lechon de cebu billing statement form edit
	Route::get(
		'/lolo-pinoy-lechon-de-cebu/edit-billing-statement/{id}', 
		'LoloPinoyLechonDeCebuController@editBillingStatement')
		->name('editBillingStatementLechonDeCebu')
		->middleware(['cashier']);

	//route for add new billing in lechon de cebu
	Route::post(
		'/lolo-pinoy-lechon-de-cebu/add-new-billing/{id}', 
		'LoloPinoyLechonDeCebuController@addNewBilling')
		->name('addNewBillingLechonDeCebu')
		->middleware(['cashier']);

	
	//route for billing statement lists
	Route::get(
		'/lolo-pinoy-lechon-de-cebu/billing-statement-lists', 
		'LoloPinoyLechonDeCebuController@billingStatementLists')
		->name('billingStatementListsLechonDeCebu')
		->middleware(['cashier']);

	//update billing statement 
	Route::patch(
		'/lolo-pinoy-lechon-de-cebu/update-billing/{id}', 
		'LoloPinoyLechonDeCebuController@updateBillingStatement')
		->name('updateBillingStatementLechonDeCebu')
		->middleware(['cashier']);

	//update billing statement info
	Route::patch(
		'/lolo-pinoy-lechon-de-cebu/update-billing-info/{id}', 
		'LoloPinoyLechonDeCebuController@updateBillingInfo')
		->name('lolo-pinoy-lechon-de-cebu.updateBillingInfo')
		->middleware(['cashier']);

	//view billing statement
	Route::get('/lolo-pinoy-lechon-de-cebu/view-billing-statement/{id}', 
	'LoloPinoyLechonDeCebuController@viewBillingStatement')
	->name('lolo-pinoy-lechon-de-cebu.viewBillingStatement')
	->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/view-per-accounts-billing-statement',
		'LoloPinoyLechonDeCebuController@viewPerAccountsBilling')
		->name('lolo-pinoy-lechon-de-cebu.viewPerAccountsBilling')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/billing-statement/view-ssps/{id}',
		'LoloPinoyLechonDeCebuController@viewSsps')
		->name('lolo-pinoy-lechon-de-cebu.viewSsps')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/printSsps/{id}',
		'LoloPinoyLechonDeCebuController@printSsps')
		->name('lolo-pinoy-lechon-de-cebu.printSsps')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/printBillingDelivery/{id}',
		'LoloPinoyLechonDeCebuController@printBillingDelivery')
		->name('lolo-pinoy-lechon-de-cebu.printBillingDelivery')
		->middleware(['cashier']);

	Route::get(
			'/lolo-pinoy-lechon-de-cebu/payables/transaction-list',
			'LoloPinoyLechonDeCebuController@transactionList')
			->name('lolo-pinoy-lechon-de-cebu.transactionList')
			->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/billing-statement/view-per-account-delivery-receipt/{id}',
		'LoloPinoyLechonDeCebuController@viewPerAccountDeliveryReceipt')
		->name('lolo-pinoy-lechon-de-cebu.viewPerAccountDeliveryReceipt')
		->middleware(['cashier']);

	//route for lechon de cebu statement of account
	Route::get('/lolo-pinoy-lechon-de-cebu/statement-of-account-form', 
	'LoloPinoyLechonDeCebuController@statementOfAccount')
	->name('lolo-pinoy-lechon-de-cebu.statementOfAccount')
	->middleware(['cashier']);

	//route for lechon de cebu statement of account store data
	Route::post('/lolo-pinoy-lechon-de-cebu/store-statement-account', 
	'LoloPinoyLechonDeCebuController@storeStatementAccount')
	->name('lolo-pinoy-lechon-de-cebu.storeStatementAccount')
	->middleware(['cashier']);

	//route for lechon de cebu statement of account lists
	Route::get('/lolo-pinoy-lechon-de-cebu/statement-of-account/lists', 
	'LoloPinoyLechonDeCebuController@statementOfAccountLists')
	->name('lolo-pinoy-lechon-de-cebu.statementOfAccountLists')
	->middleware(['cashier']);

	//edit for statement of account
	Route::get('/lolo-pinoy-lechon-de-cebu/edit-statement-of-account/{id}', 
	'LoloPinoyLechonDeCebuController@editStatementAccount')
	->name('lolo-pinoy-lechon-de-cebu.editStatementAccount')
	->middleware(['cashier']);

	//route for add new statement of account
	Route::get('/lolo-pinoy-lechon-de-cebu/add-new-statement-account/{id}', 
	'LoloPinoyLechonDeCebuController@addNewStatementAccount')
	->name('lolo-pinoy-lechon-de-cebu.addNewStatementAccount')
	->middleware(['cashier']);

	//route for add new statement of account
	Route::post('/lolo-pinoy-lechon-de-cebu/add-new-statement-data/{id}', 
	'LoloPinoyLechonDeCebuController@addNewStatementData')
	->name('lolo-pinoy-lechon-de-cebu.addNewStatementData')
	->middleware(['cashier']);


	//update add statement information
	Route::patch('lolo-pinoy-lechon-de-cebu/update-added-statement/{id}', 
	'LoloPinoyLechonDeCebuController@updateAddStatement')
	->name('lolo-pinoy-lechon-de-cebu.updateAddStatement')
	->middleware(['cashier']);

	

	//view statement of account
	Route::get('/lolo-pinoy-lechon-de-cebu/view-statement-account/{id}', 
	'LoloPinoyLechonDeCebuController@viewStatementAccount')
	->name('lolo-pinoy-lechon-de-cebu.viewStatementAccount')
	->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/printSOA/{id}',
		'LoloPinoyLechonDeCebuController@printSOA')
		->name('lolo-pinoy-lechon-de-cebu.printSOA')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/printSOAListsSsp',
		'LoloPinoyLechonDeCebuController@printSOAListsSsp')
		->name('printSOAListsSsp')
		->middleware(['cashier']);

	Route::get(
			'/lolo-pinoy-lechon-de-cebu/printSOAListsPo',
			'LoloPinoyLechonDeCebuController@printSOAListsPO')
		->name('printSOAListsPO')
		->middleware(['cashier']);

	//route for commissary stocks inventory
	Route::get(
		'/lolo-pinoy-lechon-de-cebu/commissary/stocks-inventory', 
		'LoloPinoyLechonDeCebuController@stocksInventory')
		->name('stocksInventory')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/printStocksInventory',
		'LoloPinoyLechonDeCebuController@printStocksInventory')
		->name('printStocksInventory')
		->middleware(['cashier']);


	Route::post(
		'/lolo-pinoy-lechon-de-cebu/add-payment/{id}',
		'LoloPinoyLechonDeCebuController@addPayment')
		->name('lolo-pinoy-lechon-de-cebu.addPayment')
		->middleware(['cashier']);

	Route::post(
		'/lolo-pinoy-lechon-de-cebu/add-particulars/{id}',
		'LoloPinoyLechonDeCebuController@addParticulars')
		->name('lolo-pinoy-lechon-de-cebu.addParticulars')
		->middleware(['cashier']);

	Route::patch(
		'/lolo-pinoy-lechon-de-cebu/accept/{id}',
		'LoloPinoyLechonDeCebuController@accept')
		->name('lolo-pinoy-lechon-de-cebu.accept')
		->middleware(['cashier']);


	//route for add new payment voucher data
	Route::post('/lolo-pinoy-lechon-de-cebu/add-new-payment-voucher-data/{id}', 
	'LoloPinoyLechonDeCebuController@addNewPaymentVoucherData')
	->name('lolo-pinoy-lechon-de-cebu.addNewPaymentVoucherData')
	->middleware(['cashier']);

	Route::patch('/lolo-pinoy-lechon-de-cebu/update-pv/{id}', 
	'LoloPinoyLechonDeCebuController@updatePV')
	->name('lolo-pinoy-lechon-de-cebu.updatePV')
	->middleware(['cashier']);

	//route for payment voucher cash vouchers
	Route::get('/lolo-pinoy-lechon-de-cebu/cash-vouchers', 
	'LoloPinoyLechonDeCebuController@cashVouchers')
	->name('lolo-pinoy-lechon-de-cebu.cashVouchers')
	->middleware(['cashier']);

	//route for payment voucher cheque vouchers
	Route::get('/lolo-pinoy-lechon-de-cebu/cheque-vouchers', 
	'LoloPinoyLechonDeCebuController@chequeVouchers')
	->name('lolo-pinoy-lechon-de-cebu.chequeVouchers')
	->middleware(['cashier']);

	//route for payment voucher view 
	Route::get('/lolo-pinoy-lechon-de-cebu/view-payment-voucher/{id}', 
	'LoloPinoyLechonDeCebuController@viewPaymentVoucher')
	->name('lolo-pinoy-lechon-de-cebu.viewPaymentVoucher')
	->middleware(['cashier']);

	//route for delivery receipt 
	Route::get(
		'/lolo-pinoy-lechon-de-cebu/delivery-receipt-form', 
		'LoloPinoyLechonDeCebuController@deliveryReceiptForm')
		->name('deliveryReceiptForm')
		->middleware(['cashier']);

	//route store delivery receipt
	Route::post('/lolo-pinoy-lechon-de-cebu/store-delivery-receipt', 
	'LoloPinoyLechonDeCebuController@storeDeliveryReceipt')
	->name('lolo-pinoy-lechon-de-cebu.storeDeliveryReceipt')
	->middleware(['cashier']);

	//route edit delivery receipt
	Route::get(
		'/lolo-pinoy-lechon-de-cebu/edit-delivery-receipt/{id}', 
		'LoloPinoyLechonDeCebuController@editDeliveryReceipt')
		->name('editDeliveryReceiptLechonDeCebu')
		->middleware(['cashier']);


	//route update delviery receipt
	Route::patch('/lolo-pinoy-lechon-de-cebu/update-delivery-receipt/{id}', 
	'LoloPinoyLechonDeCebuController@updateDeliveryReceipt')
	->name('lolo-pinoy-lechon-de-cebu.updateDeliveryReceipt')
	->middleware(['cashier']);

	//route for add new delivery receipt
	Route::post(
		'/lolo-pinoy-lechon-de-cebu/add-new-delivery-receipt-data/{id}', 
		'LoloPinoyLechonDeCebuController@addNewDeliveryReceiptData')
		->name('addNewDeliveryReceiptDataLechonDeCebu')
		->middleware(['cashier']);

	//route for delivery receipts lists
	Route::get('/lolo-pinoy-lechon-de-cebu/delivery-receipt/lists', 
	'LoloPinoyLechonDeCebuController@deliveryReceiptLists')
	->name('lolo-pinoy-lechon-de-cebu.deliveryReceiptLists')
	->middleware(['cashier']);

	//route for update delivery recipt add new
	Route::patch('/lolo-pinoy-lechon-de-cebu/update-dr/{id}', 
	'LoloPinoyLechonDeCebuController@updateDr')
	->name('lolo-pinoy-lechon-de-cebu.updateDr')
	->middleware(['cashier']);


	//route for view delivery receipt
	Route::get('/lolo-pinoy-lechon-de-cebu/view-delivery-receipt/{id}', 
	'LoloPinoyLechonDeCebuController@viewDeliveryReceipt')
	->name('lolo-pinoy-lechon-de-cebu.viewDeliveryReceipt')
	->middleware(['cashier']);

	//route for duplicate copy
	Route::get('/lolo-pinoy-lechon-de-cebu/duplicate-copy/{id}', 
	'LoloPinoyLechonDeCebuController@duplicateCopy')
	->name('lolo-pinoy-lechon-de-cebu.duplicateCopy')
	->middleware(['cashier']);

	//view duplicate copy
	Route::get('/lolo-pinoy-lechon-de-cebu/view-delivery-duplicate/{id}', 
	'LoloPinoyLechonDeCebuController@viewDeliveryDuplicate')
	->name('lolo-pinoy-lechon-de-cebu.viewDeliveryDuplicate')
	->middleware(['cashier']);

	//route for sales invoice form lechon de cebu
	Route::get('/lolo-pinoy-lechon-de-cebu/sales-invoice-form', 
	'LoloPinoyLechonDeCebuController@salesInvoiceForm')
	->name('lolo-pinoy-lechon-de-cebu.salesInvoiceForm')
	->middleware(['cashier']);

	Route::delete(
		'/lolo-pinoy-lechon-de-cebu/delete/SI/{id}',
		'LoloPinoyLechonDeCebuController@destroySI')
		->name('destroySI')
		->middleware(['cashier']);


	Route::get(
		'/lolo-pinoy-lechon-de-cebu/sales-per-outlet',
		'LoloPinoyLechonDeCebuController@salesInvoiceSalesPerOutlet')
		->name('lolo-pinoy-lechon-de-cebu.salesInvoiceSalesPerOutlet')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/sales-invoice/private-orders',
		'LoloPinoyLechonDeCebuController@privateOrders')
		->name('lolo-pinoy-lechon-de-cebu.privateOrders')
		->middleware(['cashier']);


	Route::get(
		'/lolo-pinoy-lechon-de-cebu/suppliers',
		'LoloPinoyLechonDeCebuController@supplier')
		->name('supplier')
		->middleware(['cashier']);

	Route::post(
		'/lolo-pinoy-lechon-de-cebu/supplier/add',
		'LoloPinoyLechonDeCebuController@addSupplier')
		->name('addSupplier')
		->middleware(['cashier']);

	//route for add sales invoice lechon de cebu
	Route::post('/lolo-pinoy-lechon-de-cebu/store-sales-invoice', 
	'LoloPinoyLechonDeCebuController@storeSalesInvoice')
	->name('lolo-pinoy-lechon-de-cebu.storeSalesInvoice')
	->middleware(['cashier']);

	//route for edit sales invoice lechon de cebu
	Route::get('/lolo-pinoy-lechon-de-cebu/edit-sales-invoice/{id}', 
	'LoloPinoyLechonDeCebuController@editSalesInvoice')
	->name('lolo-pinoy-lechon-de-cebu.editSalesInvoice')
	->middleware(['cashier']);

	//update edit sales invoice lechon de cebu
	Route::patch('/lolo-pinoy-lechon-de-cebu/update-sales-invoice/{id}', '
	LoloPinoyLechonDeCebuController@updateSalesInvoice')
	->name('lolo-pinoy-lechon-de-cebu.updateSalesInvoice')
	->middleware(['cashier']);

	//route for add new sales invoice lechon de cebu
	Route::get('/lolo-pinoy-lechon-de-cebu/add-new-sales-invoice/{id}', 
	'LoloPinoyLechonDeCebuController@addNewSalesInvoice')
	->name('lolo-pinoy-lechon-de-cebu.addNewSalesInvoice')
	->middleware(['cashier']);

	Route::post('/lolo-pinoy-lechon-de-cebu/add-new-sales-invoice-data/{id}', 
	'LoloPinoyLechonDeCebuController@addNewSalesInvoiceData')
	->name('lolo-pinoy-lechon-de-cebu.addNewSalesInvoiceData')
	->middleware(['cashier']);


	//update Sales invoice add new
	Route::patch('/lolo-pinoy-lechon-de-cebu/update-si/{id}', 
	'LoloPinoyLechonDeCebuController@updateSi')
	->name('lolo-pinoy-lechon-de-cebu.upodateSi')
	->middleware(['cashier']);


	//route for sales invoice view 
	Route::get('/lolo-pinoy-lechon-de-cebu/view-sales-invoice/{id}', 
	'LoloPinoyLechonDeCebuController@viewSalesInvoice')
	->name('lolo-pinoy-lechon-de-cebu.viewSalesInvoice')
	->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/printSalesInvoice/{id}',
		'LoloPinoyLechonDeCebuController@printSalesInvoice')
		->name('lolo-pinoy-lechon-de-cebu.printSalesInvoice')
		->middleware(['cashier']);

	//route for commissary RAW materials
	Route::get(
		'/lolo-pinoy-lechon-de-cebu/commissary/raw-materials',
		'LoloPinoyLechonDeCebuController@rawMaterials')
		->name('rawMaterials')
		->middleware(['cashier']);

	
	//route add commissary RAW materials
	Route::post(
		'/lolo-pinoy-lechon-de-cebu/commissary/add-raw-material',
		'LoloPinoyLechonDeCebuController@addRawMaterial')
		->name('addRawMaterial')
		->middleware(['cashier']);


	//update commissary RAW materials
	Route::patch(
		'/lolo-pinoy-lechon-de-cebu/commissary/update-raw-material/{id}',
		'LoloPinoyLechonDeCebuController@updateRawMaterial')
		->name('updateRawMaterial')
		->middleware(['cashier']);
	
	//route for view RAW material details
	Route::get(
		'/lolo-pinoy-lechon-de-cebu/view-raw-material-details/{id}',
		'LoloPinoyLechonDeCebuController@viewRawMaterialDetails')
		->name('lolo-pinoy-lechon-de-cebu.viewRawMaterialDetails')
		->middleware(['cashier']);

	//route for add delivery in RAW material
	Route::post(
		'/lolo-pinoy-lechon-de-cebu/add-req-stocks/{id}', 
		'LoloPinoyLechonDeCebuController@addDIRST')
		->name('addDIRST')
		->middleware(['cashier']);

	//route for request stock out RAW material
	Route::post('/lolo-pinoy-lechon-de-cebu/request-stock-out-raw-material/{id}', 
	'LoloPinoyLechonDeCebuController@requestStockOut')
	->name('lolo-pinoy-lechon-de-cebu.requestStockOut')
	->middleware(['cashier']);

	//route for view stock inventory
	Route::get('/lolo-pinoy-lechon-de-cebu/view-stock-inventory/{id}', 
	'LoloPinoyLechonDeCebuController@viewStockInventory')
	->name('lolo-pinoy-lechon-de-cebu.viewStockInventory')
	->middleware(['cashier']);

	//route for commissary inventory of stocks
	Route::get(
		'/lolo-pinoy-lechon-de-cebu/commissary/inventory-of-stocks', 
		'LoloPinoyLechonDeCebuController@inventoryOfStocks')
		->name('inventoryOfStocks')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-lechon-de-cebu/view-inventory-of-stocks/{id}',
		'LoloPinoyLechonDeCebuController@viewInventoryOfStocks')
		->name('lolo-pinoy-lechon-de-cebu.viewInventoryOfStocks')
		->middleware(['cashier']);

	Route::patch(
		'/lolo-pinoy-lechon-de-cebu/inventory-stock-update/{id}',
		'LoloPinoyLechonDeCebuController@inventoryStockUpdate')
		->name('lolo-pinoy-lechon-de-cebu.inventoryStockUpdate')
		->middleware(['cashier']);

	Route::put(
		'/dno-food-ventures/inventory-stock-update/{id}',
		'LoloPinoyLechonDeCebuController@inventoryStockUpdate')
		->name('inventoryStockUpdate')
		->middleware(['cashier']);
	


	//route for download PDF file
	Route::get('/lolo-pinoy-lechon-de-cebu/printDelivery/{id}', 
	'LoloPinoyLechonDeCebuController@printDelivery')
	->name('lolo-pinoy-lechon-de-cebu.printDelivery')
	->middleware(['cashier']);

	//print Duplicate delivery receipt
	Route::get('/lolo-pinoy-lechon-de-cebu/printDuplicateDelivery/{id}', 
	'LoloPinoyLechonDeCebuController@printDuplicateDelivery')
	->name('lolo-pinoy-lechon-de-cebu.printDuplicateDelivery')
	->middleware(['cashier']);

	//print PO
	Route::get('/lolo-pinoy-lechon-de-cebu/printPO/{id}', 
	'LoloPinoyLechonDeCebuController@printPO')
	->name('lolo-pinoy-lechon-de-cebu.printPO')
	->middleware(['cashier']);

	Route::get('/lolo-pinoy-lechon-de-cebu/printBillingStatement/{id}', 
	'LoloPinoyLechonDeCebuController@printBillingStatement')
	->name('lolo-pinoy-lechon-de-cebu.printBillingStatement')
	->middleware(['cashier']);

	Route::get('/lolo-pinoy-lechon-de-cebu/printPaymentVoucher/{id}', 
	'LoloPinoyLechonDeCebuController@printPaymentVoucher')
	->name('lolo-pinoy-lechon-de-cebu.printPaymentVoucher')
	->middleware(['cashier']);

	Route::patch(
		'/lolo-pinoy-lechon-de-cebu/s-account/{id}',
		'LoloPinoyLechonDeCebuController@sAccountUpdate')
		->name('sAccountUpdate')
		->middleware(['cashier']);

	//Lolo Pinoy Grill Commissary
	Route::get('/lolo-pinoy-grill-commissary', 
	'LoloPinoyGrillCommissaryController@index')
	->name('lolo-pinoy-grill-commissary.index')
	->middleware(['cashier']);

	//delivery receipt
	Route::get(
		'/lolo-pinoy-grill-commissary/delivery-receipt-form', 
		'LoloPinoyGrillCommissaryController@deliveryReceiptForm')
		->name('deliveryReceiptFormLoloPinoyGrill')
		->middleware(['cashier']);

	//store deivery receipt
	Route::post(
		'/lolo-pinoy-grill-commissary/store-delivery-receipt', 
		'LoloPinoyGrillCommissaryController@storeDeliveryReceipt')
		->name('lolo-pinoy-grill-commissary.storeDeliveryReceipt')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-commissary-delivery-receipt/{id}', 
		'LoloPinoyGrillCommissaryController@editDeliveryReceipt')
		->name('editDeliveryReceiptLoloPinoyGrillCommissary')
		->middleware(['cashier']);

	Route::patch('/lolo-pinoy-grill-commissary/update-delivery-receipt/{id}', 
	'LoloPinoyGrillCommissaryController@updateDeliveryReceipt')
	->name('lolo-pinoy-grill-commissary.updateDeliveryReceipt')
	->middleware(['cashier']);


	//save add new delivery receipt lolo pinoy grill 
	Route::post('/lolo-pinoy-grill-commissary/add-new-lolo-pinoy-grill-delivery-receipt-data/{id}', 
	'LoloPinoyGrillCommissaryController@addNewDeliveryReceiptData')
	->name('lolo-pinoy-grill-commissary.addNewDeliveryReceiptData')
	->middleware(['cashier']);

	//
	Route::patch('/lolo-pinoy-grill-commissary/update-dr/{id}', 
	'LoloPinoyGrillCommissaryController@updateDr')
	->name('lolo-pinoy-grill-commissary.updateDr')
	->middleware(['cashier']);


	//delivery receipt lists
	Route::get('/lolo-pinoy-grill-commissary/delivery-receipt/lists', 
	'LoloPinoyGrillCommissaryController@deliveryReceiptList')
	->name('lolo-pinoy-grill-commissary.deliveryReceiptList')
	->middleware(['cashier']);

	
	//view 
	Route::get(
		'/lolo-pinoy-grill-commissary/view-lolo-pinoy-grill-commissary-delivery-receipt/{id}', 
		'LoloPinoyGrillCommissaryController@viewDeliveryReceipt')
		->name('lolo-pinoy-grill-commissary.viewDeliveryReceipt')
		->middleware(['cashier']);


	Route::get(
		'/lolo-pinoy-grill-commissary/delivery-receipt/view-per-branch',
		'LoloPinoyGrillCommissaryController@viewPerBranch')
		->name('viewPerBranch')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-commissary/suppliers',
		'LoloPinoyGrillCommissaryController@supplier')
		->name('supplier')
		->middleware(['cashier']);

	Route::post(
			'/lolo-pinoy-grill-commissary/supplier/add',
			'LoloPinoyGrillCommissaryController@addSupplier')
			->name('addSupplier')
			->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-commissary/suppliers/view/{id}',
		'LoloPinoyGrillCommissaryController@viewSupplier')
		->name('viewSupplier')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-commissary/view-lolo-pinoy-grill-commissary-purchase-order/{id}',
		'LoloPinoyGrillCommissaryController@show')
		->name('show')
		->middleware(['cashier']);

	Route::delete(
		'/lolo-pinoy-grill-commissary/delete-purchase-order/{id}',
		'LoloPinoyGrillCommissaryController@destroyPO')
		->name('destroyPO')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-commissary/pintPO/{id}',
		'LoloPinoyGrillCommissaryController@printPO')
		->name('printPoLoloPinoyGrillCommissary')
		->middleware(['cashier']);


	
	//print delivery receipt lolo pinoy grill
	Route::get('/lolo-pinoy-grill-commissary/prntDeliveryReceipt/{id}', 
	'LoloPinoyGrillCommissaryController@printDelivery')
	->name('lolo-pinoy-grill-commissary.printDelivery')
	->middleware(['cashier']);

	//route for purchase order lolo pinoy grill
	Route::get('/lolo-pinoy-grill-commissary/purchase-order', 
	'LoloPinoyGrillCommissaryController@purchaseOrder')
	->name('lolo-pinoy-grill-commissary.purchaseOrder')
	->middleware(['cashier']);

	//store purchase order lolo pinoy grill
	Route::post('/lolo-pinoy-grill-commissary/store', 
	'LoloPinoyGrillCommissaryController@store')
	->name('lolo-pinoy-grill-commissary')
	->middleware(['cashier']);

	//edit purchase order lolo pinoy grill
	Route::get(
	'/lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-commissary-purchase-order/{id}', 
	'LoloPinoyGrillCommissaryController@edit')
	->name('editLoloPinoyGrill')
	->middleware(['cashier']);

	//update purchase order lolo pinoy grill
	Route::patch('/lolo-pinoy-grill-commissary/update/{id}', 
	'LoloPinoyGrillCommissaryController@update')
	->name('lolo-pinoy-grill-commissary.update')
	->middleware(['cashier']);


	//add new purchase order lolo pinoy grill
	Route::get('/lolo-pinoy-grill-commissary/add-new/{id}', 
	'LoloPinoyGrillCommissaryController@addNew')
	->name('lolo-pinoy-grill-commissary.addNew')
	->middleware(['cashier']);

	//store add new purchase order lolo pinoy grill
	Route::post('/lolo-pinoy-grill-commissary/add-new-purchase-order/{id}', 
	'LoloPinoyGrillCommissaryController@addNewPurchaseOrder')
	->name('lolo-pinoy-grill-commissary.addNewPurchaseOrder')
	->middleware(['cashier']);


	Route::patch('/lolo-pinoy-grill-commissary/update-po/{id}', 
	'LoloPinoyGrillCommissaryController@updatePo')
	->name('lolo-pinoy-grill-commissary.updatePo')
	->middleware(['cashier']);


	//lolo pinoy grill commissary purchase order lists
	Route::get('/lolo-pinoy-grill-commissary/purchase-order-lists', 
	'LoloPinoyGrillCommissaryController@purchaseOrderAllLists')
	->name('lolo-pinoy-grill-commissary.purchaseOrderAllLists')
	->middleware(['cashier']);

	//billing statement form lolo pinoy grill commissary
	Route::get(
		'/lolo-pinoy-grill-commissary/billing-statement-form', 
		'LoloPinoyGrillCommissaryController@billingStatementForm')
		->name('billingStatementFormLoloPinoyGrillCommissary')
		->middleware(['cashier']);

	//save billing statement form lolo pinoy grill commissary
	Route::post('/lolo-pinoy-grill-commissary/store-billing-statement', 
	'LoloPinoyGrillCommissaryController@storeBillingStatement')
	->name('lolo-pinoy-grill-commissary.storeBillingStatement')
	->middleware(['cashier']);


	//edit billing statement form lolo pinoy grill commissary
	Route::get(
		'/lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-commissary-billing-statement/{id}', 
		'LoloPinoyGrillCommissaryController@editBillingStatement')
		->name('editBillingStatementLpGrillComm')
		->middleware(['cashier']);

	Route::patch('/lolo-pinoy-grill-commissary/update-billing-info/{id}', 
	'LoloPinoyGrillCommissaryController@updateBillingInfo')
	->name('lolo-pinoy-grill-commissary.updateBillingInfo')
	->middleware(['cashier']);


	Route::post('/lolo-pinoy-grill-commissary/add-new-billing-data/{id}', 
	'LoloPinoyGrillCommissaryController@addNewBillingData')
	->name('lolo-pinoy-grill-commissary.addNewBillingData')
	->middleware(['cashier']);


	//billing statement lists
	Route::get(
		'/lolo-pinoy-grill-commissary/billing-statement-lists', 
		'LoloPinoyGrillCommissaryController@billingStatementLists')
		->name('billingStatementLists')
		->middleware(['cashier']);

	//view billing statement
	Route::get(
		'/lolo-pinoy-grill-commissary/view-lolo-pinoy-grill-billing-statement/{id}', 
		'LoloPinoyGrillCommissaryController@viewBillingStatement')
		->name('viewBillingStatementLoloPinoyGrill')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-commmissary/printBillingStatement/{id}',
		'LoloPinoyGrillCommissaryController@printBillingStatement')
		->name('printBillingStatementLoloPinoyGrill')
		->middleware(['cashier']);

	Route::delete(
		'/lolo-pinoy-grill-commissary/delete-billing-statement/{id}',
		'LoloPinoyGrillCommissaryController@destroyBillingStatement')
		->name('destroyBillingStatementLoloPinoyGrillCommissary')
		->middleware(['cashier']);

	
	//cash vouchers lolo pinoy grill
	Route::get('/lolo-pinoy-grill-commissary/cash-vouchers', 
	'LoloPinoyGrillCommissaryController@cashVouchers')
	->name('lolo-pinoy-grill-commissary.cashVouchers')
	->middleware(['cashier']);

	//cheque vouchers lolo pinoy grill
	Route::get('/lolo-pinoy-grill-commissary/cheque-vouchers', 
	'LoloPinoyGrillCommissaryController@chequeVouchers')
	->name('lolo-pinoy-grill-commissary.chequeVouchers')
	->middleware(['cashier']);

	//view payment voucher lolo pinoy grill
	Route::get('/lolo-pinoy-grill-commissary/view-lolo-pinoy-grill-payment-voucher/{id}', 
	'LoloPinoyGrillCommissaryController@viewPaymentVoucher')
	->name('lolo-pinoy-grill-commissary.viewPaymentVoucher')
	->middleware(['cashier']);

	//sales invoice lolo pinoy grill
	Route::get(
		'/lolo-pinoy-grill-commissary/sales-invoice-form', 
		'LoloPinoyGrillCommissaryController@salesInvoiceForm')
		->name('lolo-pinoy-grill-commissary.salesInvoiceForm')
		->middleware(['cashier']);

	Route::post('/lolo-pinoy-grill-commissary/store-sales-invoice', 
	'LoloPinoyGrillCommissaryController@storeSalesInvoice')
	->name('lolo-pinoy-grill-commissary.storeSalesInvoice')
	->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-sales-invoice/{id}', 
		'LoloPinoyGrillCommissaryController@editSalesInvoice')
		->name('editSalesInvoiceLpGrillCommissary')
		->middleware(['cashier']);

	Route::patch('/lolo-pinoy-grill-commissary/update-sales-invoice/{id}', 
	'LoloPinoyGrillCommissaryController@updateSalesInvoice')
	->name('lolo-pinoy-grill-commissary.updateSalesInvoice')
	->middleware(['cashier']);

	Route::get('/lolo-pinoy-grill-commissary/add-new-lolo-pinoy-grill-sales-invoice/{id}', 
	'LoloPinoyGrillCommissaryController@addNewSalesInvoice')
	->name('lolo-pinoy-grill-commissary.addNewSalesInvoice')
	->middleware(['cashier']);

	Route::post('/lolo-pinoy-grill-commissary/add-new-sales-invoice-data/{id}', 
	'LoloPinoyGrillCommissaryController@addNewSalesInvoiceData')
	->name('lolo-pinoy-grill-commissary.addNewSalesInvoiceData')
	->middleware(['cashier']);

	Route::patch('/lolo-pinoy-grill-commissary/update-si/{id}', 
	'LoloPinoyGrillCommissaryController@updateSi')
	->name('lolo-pinoy-grill-commissary.updateSi')
	->middleware(['cashier']);


	//view 
	Route::get('/lolo-pinoy-grill-commissary/view-lolo-pinoy-grill-sales-invoice/{id}', 
	'LoloPinoyGrillCommissaryController@viewSalesInvoice')
	->name('lolo-pinoy-grill-commissary.viewSalesInvoice')
	->middleware(['cashier']);


	//store statement of account
	Route::post('/lolo-pinoy-grill-commissary/store-statement-account', 
	'LoloPinoyGrillCommissaryController@storeStatementAccount')
	->name('lolo-pinoy-grill-commissary.storeStatementAccount')
	->middleware(['cashier']);

	//edit
	Route::get(
		'/lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-statement-of-account/{id}', 
		'LoloPinoyGrillCommissaryController@editStatementOfAccount')
		->name('editStatementOfAccount')
		->middleware(['cashier']);


	Route::get('/lolo-pinoy-grill-commissary/statement-of-account-lists', 
	'LoloPinoyGrillCommissaryController@statementOfAccountList')
	->name('lolo-pinoy-grill-commissary.statementOfAccountList')
	->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-commissary/printSOALists',
		'LoloPinoyGrillCommissaryController@printSOALists')
		->name('printSOALists')
		->middleware(['cashier']);

	Route::patch(
		'/lolo-pinoy-grill-commissary/s-account/{id}',
		'LoloPinoyGrillCommissaryController@sAccountUpdate')
		->name('sAccountUpdateLoloPinoyGrillCommissary')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-commissary/view-statement-account/{id}',
		'LoloPinoyGrillCommissaryController@viewStatementAccount')
		->name('viewStatementAccount')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-commissary/printSOA/{id}',
		'LoloPinoyGrillCommissaryController@printSOA')
		->name('printSOA')
		->middleware(['cashier']);

	//
	Route::get('/lolo-pinoy-grill-commissary/view-lolo-pinoy-grill-statement-account/{id}', 
	'LoloPinoyGrillCommissaryController@viewStatementAccount')
	->name('lolo-pinoy-grill-commissary.viewStatementAccount')
	->middleware(['cashier']);


	Route::get(
		'/lolo-pinoy-grill-commissary/printDelivery/{id}',
		'LoloPinoyGrillCommissaryController@printDelivery')
		->name('lolo-pinoy-grill-commissary.printDelivery')
		->middleware(['cashier']);

	//
	Route::get(
		'/lolo-pinoy-grill-commissary/commissary/raw-materials',
		'LoloPinoyGrillCommissaryController@rawMaterials')
		->name('rawMaterials')
		->middleware(['cashier']);

	Route::post(
		'/lolo-pinoy-grill-commissary/commissary/create-raw-materials',
		'LoloPinoyGrillCommissaryController@addRawMaterial')
		->name('addRawMaterial')
		->middleware(['cashier']);

	Route::put(
		'/lolo-pinoy-grill-commissary/commissary/update-raw-material/{id}',
		'LoloPinoyGrillCommissaryController@updateRawMaterial')
		->name('updateRawMaterial')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-commissary/printStockInventory',
		'LoloPinoyGrillCommissaryController@printStockInventory')
		->name('printStockInventory')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-commissary/commissary/stocks-inventory',
		'LoloPinoyGrillCommissaryController@stocksInventory')
		->name('stocksInventory')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-commissary/view-raw-material-details/{id}',
		'LoloPinoyGrillCommissaryController@viewRawMaterialDetails')
		->name('viewRawMaterialDetails')
		->middleware(['cashier']);

	
	Route::post(
		'/lolo-pinoy-grill-commissary/add-delivery-in-raw-material/{id}',
		'LoloPinoyGrillCommissaryController@addDIRST')
		->name('addDIRST')
		->middleware(['cashier']);


	Route::get(
		'/lolo-pinoy-grill-commissary/view-stock-inventory/{id}',
		'LoloPinoyGrillCommissaryController@viewStockInventory')
		->name('lolo-pinoy-grill-commissary.viewStockInventory')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-commissary/commissary/delivery-outlets',
		'LoloPinoyGrillCommissaryController@commissaryDeliveryOutlet')
		->name('commissaryDeliveryOutlet')
		->middleware(['cashier']);


	Route::get(
		'/lolo-pinoy-grill-commissary/commissary/inventory-of-stocks',
		'LoloPinoyGrillCommissaryController@inventoryOfStocks')
		->name('inventoryOfStocks')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-commissary/view-inventory-of-stocks/{id}',
		'LoloPinoyGrillCommissaryController@viewInventoryOfStocks')
		->name('viewInventoryOfStocks')
		->middleware(['cashier']);

	Route::patch(
		'/lolo-pinoy-grill-commissary/inventory-stock-update/{id}',
		'LoloPinoyGrillCommissaryController@inventoryStockUpdate')
		->name('inventoryStockUpdate')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-commissary/commissary/production',
		'LoloPinoyGrillCommissaryController@production')
		->name('lolo-pinoy-grill-commissary.production')
		->middleware(['cashier']);
	
	Route::get(
		'/lolo-pinoy-grill-commissary/petty-cash-list',
		'LoloPinoyGrillCommissaryController@pettyCashList')
		->name('lolo-pinoy-grill-commissary.pettyCashList')
		->middleware(['cashier']);

	Route::post(
		'/lolo-pinoy-grill-commissary/petty-cash/add',
		'LoloPinoyGrillCommissaryController@addPettyCash')
		->name('addPettyCashLoloPinoyGrill')
		->middleware(['cashier']);
	
	Route::get(
		'/lolo-pinoy-grill-commissary/edit-petty-cash/{id}',
		'LoloPinoyGrillCommissaryController@editPettyCash')
		->name('editPettyCashLoloPinoyGrill');

	Route::patch(
		'/lolo-pinoy-grill-commissary/update-petty-cash/{id}',
		'LoloPinoyGrillCommissaryController@updatePettyCash')
		->name('updatePettyCashLoloPinoyGrill')
		->middleware(['cashier']);

	Route::post(
		'/lolo-pinoy-grill-commissary/add-new-petty-cash/{id}',
		'LoloPinoyGrillCommissaryController@addNewPettyCash')
		->name('addNewPettyCashLoloPinoyGrill')
		->middleware(['cashier']);

	Route::patch(
		'/lolo-pinoy-grill-commissary/update-pc/{id}',
		'LoloPinoyGrillCommissaryController@updatePC')
		->name('updatePCLoloPinoyGrill')
		->middleware(['cashier']);

	Route::delete(
		'/lolo-pinoy-grill-commissary/petty-cash/delete/{id}',
		'LoloPinoyGrillCommissaryController@destroyPettyCash')
		->name('destroyPettyCashLoloPinoyGrill')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-commissary/utilities',
		'LoloPinoyGrillCommissaryController@utilities')
		->name('lolo-pinoy-grill-commissary.utilities')
		->middleware(['cashier']);

	Route::post(
		'/lolo-pinoy-grill-commissary/utilities/add-bill',
		'LoloPinoyGrillCommissaryController@addBills')
		->name('lolo-pinoy-grill-commissary.addBills')
		->middleware(['cashier']);
	
	Route::post(
		'/lolo-pinoy-grill-commissary/utilities/add-internet',
		'LoloPinoyGrillCommissaryController@addInternet')
		->name('lolo-pinoy-grill-commissary.addInternet')
		->middleware(['cashier']);
	
	Route::get(
		'/lolo-pinoy-grill-commissary/utilities/view-veco/{id}',
		'LoloPinoyGrillCommissaryController@viewBills')
		->name('lolo-pinoy-grill-commissary.viewBills')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-commissary/utilities/view-mcwd/{id}',
		'LoloPinoyGrillCommissaryController@viewBills')
		->name('lolo-pinoy-grill-commissary.viewBills')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-commissary/utilities/view-internet/{id}',
		'LoloPinoyGrillCommissaryController@viewBills')
		->name('lolo-pinoy-grill-commissary.viewBills')
		->middleware(['cashier']);



	Route::get(
		'/lolo-pinoy-grill-commissary/petty-cash/view/{id}',
		'LoloPinoyGrillCommissaryController@viewPettyCash')
		->name('lolo-pinoy-grill-commissary.viewPettyCash')
		->middleware(['cashier']);

	//Lolo Pinoy Grill Branches
	Route::get('/lolo-pinoy-grill-branches', 
	'LoloPinoyGrillBranchesController@index')
	->name('lolo-pinoy-grill-branches.index');

	
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
		->name('summaryReport')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-branches/search-multiple-date',
		'LoloPinoyGrillBranchesController@getSummaryReportMultiple')
		->name('getSummaryReportMultiple')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-branches/printMultipleSummary/{date}',
		'LoloPinoyGrillBranchesController@printMultipleSummary')
		->name('printMultipleSummary')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-branches/summary-report/search-number-code',
		'LoloPinoyGrillBranchesController@searchNumberCode')
		->name('searchNumberCode')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-branches/search',
		'LoloPinoyGrillBranchesController@search')
		->name('search')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-branches/printSummary',
		'LoloPinoyGrillBranchesController@printSummary')
		->name('printSummary')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-branches/printGetSummary/{date}',
		'LoloPinoyGrillBranchesController@printGetSummary')
		->name('printGetSummary')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-branches/search-date',
		'LoloPinoyGrillBranchesController@getSummaryReport')
		->name('getSummaryReport')
		->middleware(['cashier']);

	Route::post(
		'/lolo-pinoy-grill-branches/sales-form/login-branch',
		'LoloPinoyGrillBranchesController@loginSales')
		->name('loginSales');

	Route::get(
		'/lolo-pinoy-grill-branches/sales-form',
		'LoloPinoyGrillBranchesController@salesInvoiceForm')
		->name('salesInvoiceFormLoloPinoyGrillBranches');

	Route::get(
		'/lolo-pinoy-grill-branches/{type}/sales-form',
		'LoloPinoyGrillBranchesController@salesInvoiceFormBranch')
		->name('salesInvoiceFormBranch');

	Route::get(
		'/lolo-pinoy-grill-branches/transaction-list-all',
		'LoloPinoyGrillBranchesController@transactionListAll')
		->name('transactionListAll');

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

	Route::post(
		'/lolo-pinoy-grill-branches/add-senior/{id}',
		'LoloPinoyGrillBranchesController@addSenior')
		->name('addSeniorLpBranches');

	Route::get(
		'/lolo-pinoy-grill-branches/printReceipt/{id}',
		'LoloPinoyGrillBranchesController@printReceipt')
		->name('printReceiptLpBranches');

	Route::get(
		'/lolo-pinoy-grill-branches/transaction-list-details/{id}',
		'LoloPinoyGrillBranchesController@transactionListDetails')
		->name('transactionListDetailsLoloPinoyGrillBranches');

	Route::post(
		'/lolo-pinoy-grill-branches/voidItem/{id}',
		'LoloPinoyGrillBranchesController@voidItem')
		->name('voidItemBranches')
		->middleware(['cashier']);

	Route::post(
		'/lolo-pinoy-grill-branches/voidItemSecond/{id}',
		'LoloPinoyGrillBranchesController@voidItemSecond')
		->name('voidItemBranchesSecond')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-branches/petty-cash-list',
		'LoloPinoyGrillBranchesController@pettyCashList')
		->name('lolo-pinoy-grill-branches.pettyCashList')
		->middleware(['cashier']);

	Route::post(
		'/lolo-pinoy-grill-branches/petty-cash/add',
		'LoloPinoyGrillBranchesController@addPettyCash')
		->name('addPettyCashLoloPinoyGrillBranches')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-branches/petty-cash/view/{id}',
		'LoloPinoyGrillBranchesController@viewPettyCash')
		->name('lolo-pinoy-grill-branches.viewPettyCash')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-branches/edit-petty-cash/{id}',
		'LoloPinoyGrillBranchesController@editPettyCash')
		->name('editPettyCashLoloPinoyGrillBranches')
		->middleware(['cashier']);

	Route::patch(
		'/lolo-pinoy-grill-branches/update-petty-cash/{id}',
		'LoloPinoyGrillBranchesController@updatePettyCash')
		->name('updatePettyCashLoloPinoyGrillBranches')
		->middleware(['cashier']);

	Route::post(
		'/lolo-pinoy-grill-branches/add-new-petty-cash/{id}',
		'LoloPinoyGrillBranchesController@addNewPettyCash')
		->name('addNewPettyCashLoloPinoyGrillBranches')
		->middleware(['cashier']);

	Route::patch(
		'/lolo-pinoy-grill-branches/update-pc/{id}',
		'LoloPinoyGrillBranchesController@updatePC')
		->name('updatePCLoloPinoyGrillBranches')
		->middleware(['cashier']);

	Route::delete(
		'/lolo-pinoy-grill-branches/petty-cash/delete/{id}',
		'LoloPinoyGrillBranchesController@destroyPettyCash')
		->name('destroyPettyCash')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-branches/printPettyCash/{id}',
		'LoloPinoyGrillBranchesController@printPettyCash')
		->name('printPettyCashLoloPinoyGrillBranches')
		->middleware(['cashier']);
	
	Route::get(
		'/lolo-pinoy-grill-branches/utilities',
		'LoloPinoyGrillBranchesController@utilities')
		->name('lolo-pinoy-grill-branches.utilities')
		->middleware(['cashier']);

	Route::post(
		'/lolo-pinoy-grill-branches/utilities/add-bill',
		'LoloPinoyGrillBranchesController@addBills')
		->name('lolo-pinoy-grill-branches.addBills')
		->middleware(['cashier']);

	Route::post(
		'/lolo-pinoy-grill-branches/utilities/add-internet',
		'LoloPinoyGrillBranchesController@addInternet')
		->name('lolo-pinoy-grill-branches.addInternet')
		->middleware(['cashier']);

	Route::get(
		'/lolo-pinoy-grill-branches/utilities/view-veco/{id}',
		'LoloPinoyGrillBranchesController@viewBills')
		->name('lolo-pioy-grill-branches.viewBills')
		->middleware(['cashier']);
	
	Route::get(
		'/lolo-pinoy-grill-branches/utilities/view-mcwd/{id}',
		'LoloPinoyGrillBranchesController@viewBills')
		->name('viewBills')
		->middleware(['cashier']);
	
	Route::get(
			'/lolo-pinoy-grill-branches/utilities/view-internet/{id}',
			'LoloPinoyGrillBranchesController@viewBills')
			->name('viewBills')
			->middleware(['cashier']);
	
	Route::delete(
		'/lolo-pinoy-grill-branches/delete-utility/{id}',
		'LoloPinoyGrillBranchesController@destroyUtility')
		->name('destroyUtility')
		->middleware(['cashier']);

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

	Route::get(
		'/lolo-pinoy-grill-branches/store-stock/delivery-in-transaction',
		'LoloPinoyGrillBranchesController@deliveryInTransaction')
		->name('deliveryInTransactionLpGrillBranches');

	Route::post(
		'/lolo-pinoy-grill-branches/store-stock/login',
		'LoloPinoyGrillBranchesController@loginDeliveryTransaction')
		->name('loginDeliveryTransaction');

	Route::get(
		'/lolo-pinoy-grill-branches/{type}/delivery-in-transaction',
		'LoloPinoyGrillBranchesController@deliveryInTransactionBranch')
		->name('deliveryInTransactionBranch');

	Route::delete(
		'/lolo-pinoy-grill-branches/delivery-in-transaction/delete/{id}',
		'LoloPinoyGrillBranchesController@destroyDeliveryInTransaction')
		->name('destroyDeliveryInTransaction');

	Route::post(
		'/lolo-pinoy-grill-branches/store-delivery-in',
		'LoloPinoyGrillBranchesController@storeDeliveryIn')
		->name('storeDeliveryIn');

	Route::post(
		'/lolo-pinoy-grill-branches/store-stock/logout',
		'LoloPinoyGrillBranchesController@logoutDeliveryIn')
		->name('logoutDeliveryIn');

	Route::get(
		'/lolo-pinoy-grill-branches/store-stock/stock-status',
		'LoloPinoyGrillBranchesController@stockStatus')
		->name('stockStatus');

	Route::patch(
		'/lolo-pinoy-grill-branches/update-store-delivery-in/{id}',
		'LoloPinoyGrillBranchesController@updateDeliveryIn')
		->name('updateDeliveryIn');

	//Mr Potato
	Route::get('/mr-potato', 'MrPotatoController@index')
	->name('mr-potato.index')
	->middleware(['cashier']);

	//purchase order
	Route::get('/mr-potato/purchase-order', 
	'MrPotatoController@purchaseOrder')
	->name('mr-potato.purchaseOrder')
	->middleware(['cashier']);

	//save purchase order
	Route::post('/mr-potato/store', 
	'MrPotatoController@store')
	->name('mr-potato.store')
	->middleware(['cashier']);

	Route::get('/mr-potato/edit-mr-potato-purchase-order/{id}', 
	'MrPotatoController@edit')
	->name('mr-potato.edit')
	->middleware(['cashier']);

	Route::patch(
		'/mr-potato/update/{id}', 
		'MrPotatoController@update')
		->name('mr-potato.update')
		->middleware(['cashier']);

	//add new Po
	Route::post	(
		'/mr-potato/add-new/{id}', 
		'MrPotatoController@addNew')
		->name('mr-potato.addNew')
		->middleware(['cashier']);


	Route::get(
		'/mr-potato/purchase-order/printPO/{id}',
		'MrPotatoController@printPO')
		->name('mr-potato.printPO')
		->middleware(['cashier']);

	Route::post(
		'/mr-potato/add-new-purchase-order/{id}', 
		'MrPotatoController@addNewPurchaseOrder')
		->name('mr-potato.addNewPurchaseOrder')
		->middleware(['cashier']);

	Route::patch(
		'/mr-potato/update-po/{id}',
		'MrPotatoController@updatePo')
		->name('mr-potato.updatePo')
		->middleware(['cashier']);

	

	//purchase order lists
	Route::get(
		'/mr-potato/purchase-order-lists',
		'MrPotatoController@purchaseOrderAllLists')
		->name('mr-potato.purchaseOrderAllLists')
		->middleware(['cashier']);

	//view
	Route::get(
		'/mr-potato/view-mr-potato-purchase-order/{id}',
		'MrPotatoController@show')
		->name('mr-potato.show')
		->middleware(['cashier']);

	Route::get(
		'/mr-potato/delivery-receipt-form',
		'MrPotatoController@deliveryReceiptForm')
		->name('mr-potato.deliveryReceiptForm')
		->middleware(['cashier']);

	//store delivery receipt
	Route::post(
		'/mr-potato/store-delivery-receipt',
		'MrPotatoController@storeDeliveryReceipt')
		->name('mr-potato.storeDeliveryReceipt')
		->middleware(['cashier']);

	Route::get(
		'/mr-potato/edit-mr-potato-delivery-receipt/{id}',
		'MrPotatoController@editDeliveryReceipt')
		->name('editDeliveryReceiptMrPotato')
		->middleware(['cashier']);

	Route::patch(
		'/mr-potato/update-delivery-receipt/{id}',
		'MrPotatoController@updateDeliveryReceipt')
		->name('mr-potato.updateDeliveryReceipt')
		->middleware(['cashier']);

	Route::get(
		'/mr-potato/add-new-delivery-receipt/{id}',
		'MrPotatoController@addNewDelivery')
		->name('mr-potato.addNewDelivery')
		->middleware(['cashier']);

	Route::post(
		'/mr-potato/add-new-delivery-receipt-data/{id}',
		'MrPotatoController@addNewDeliveryReceiptData')
		->name('mr-potato.addNewDeliveryReceiptData')
		->middleware(['cashier']);

	Route::patch(
		'/mr-potato/update-dr/{id}',
		'MrPotatoController@updateDr')
		->name('mr-potato.updateDr')
		->middleware(['cashier']);

	Route::get(
		'/mr-potato/delivery-receipt-lists',
		'MrPotatoController@deliveryReceiptList')
		->name('deliveryReceiptList')
		->middleware(['cashier']);

	Route::get(
		'/mr-potato/view-mr-potato-delivery-receipt/{id}',
		'MrPotatoController@viewDeliveryReceipt')
		->name('mr-potato.viewDeliveryReceipt')
		->middleware(['cashier']);


	Route::get(
		'/mr-potato/billing-statement-form',
		'MrPotatoController@billingStatementForm')
		->name('billingStatementFormMrPotato')
		->middleware(['cashier']);

	Route::get(
		'/mr-potato/billing-statement-lists',
		'MrPotatoController@billingStatementList')
		->name('billingStatementList')
		->middleware(['cashier']);

	Route::post(
		'/mr-potato/store-billing-statement',
		'MrPotatoController@storeBillingStatement')
		->name('storeBillingStatement')
		->middleware(['cashier']);

	Route::get(
		'/mr-potato/cash-vouchers',
		'MrPotatoController@cashVouchers')
		->name('mr-potato.cashVouchers')
		->middleware(['cashier']);

	Route::get(
		'/mr-potato/cheque-vouchers',
		'MrPotatoController@chequeVouchers')
		->name('mr-potato.chequeVouchers')
		->middleware(['cashier']);

	//sales invoice
	Route::get(
		'/mr-potato/sales-invoice-form',
		'MrPotatoController@salesInvoiceForm')
		->name('mr-potato.salesInvoiceForm')
		->middleware(['cashier']);

	Route::post(
		'/mr-potato/store-sales-invoice',
		'MrPotatoController@storeSalesInvoice')
		->name('mr-potato.storeSalesInvoice')
		->middleware(['cashier']);

	Route::get(
		'/mr-potato/edit-mr-potato-sales-invoice/{id}',
		'MrPotatoController@editSalesInvoice')
		->name('editSalesInvoiceMrPotato')
		->middleware(['cashier']);

	Route::patch(
		'/mr-potato/update-sales-invoice/{id}',
		'MrPotatoController@updateSalesInvoice')
		->name('mr-potato.updateSalesInvoice')
		->middleware(['cashier']);

	Route::get(
		'/mr-potato/add-new-mr-potato-sales-invoice/{id}',
		'MrPotatoController@addNewSalesInvoice')
		->name('mr-potato.addNewSalesInvoice')
		->middleware(['cashier']);

	Route::post(
		'/mr-potato/add-new-sales-invoice-data/{id}',
		'MrPotatoController@addNewSalesInvoiceData')
		->name('mr-potato.addNewSalesInvoiceData')
		->middleware(['cashier']);

	Route::patch(
		'/mr-potato/update-si/{id}',
		'MrPotatoController@updateSi')
		->name('mr-potato.updateSi')
		->middleware(['cashier']);


	Route::get(
		'/mr-potato/view-mr-potato-sales-invoice/{id}',
		'MrPotatoController@viewSalesInvoice')
		->name('mr-potato.viewSalesInvoice')
		->middleware(['cashier']);

	Route::get(
		'/mr-potato/printDelivery/{id}',
		'MrPotatoController@printDelivery')
		->name('mr-potato.printDelivery')
		->middleware(['cashier']);

	Route::get(
		'/mr-potato/petty-cash-list',
		'MrPotatoController@pettyCashList')
		->name('mr-potato.pettyCashList')
		->middleware(['cashier']);

	Route::post(
		'/mr-potato/petty-cash/add',
		'MrPotatoController@addPettyCash')
		->name('addPettyCash')
		->middleware(['cashier']);
	
	Route::get(
		'/mr-potato/edit-petty-cash/{id}',
		'MrPotatoController@editPettyCash')
		->name('editPettyCashMrPotato')
		->middleware(['cashier']);

	Route::patch(
			'/mr-potato/update-petty-cash/{id}',
			'MrPotatoController@updatePettyCash')
			->name('updatePettyCash')
			->middleware(['cashier']);

	Route::post(
		'/mr-potato/add-new-petty-cash/{id}',
		'MrPotatoController@addNewPettyCash')
		->name('addNewPettyCash')
		->middleware(['cashier']);

	Route::patch(
		'/mr-potato/update-pc/{id}',
		'MrPotatoController@updatePC')
		->name('updatePC')
		->middleware(['cashier']);

	Route::delete(
		'/mr-potato/petty-cash/delete/{id}',
		'MrPotatoController@destroyPettyCash')
		->name('destroyPettyCash')
		->middleware(['cashier']);

	Route::get(
		'/mr-potato/petty-cash/view/{id}',
		'MrPotatoController@viewPettyCash')
		->name('viewPettyCashMrPotato')
		->middleware(['cashier']);

	Route::get(
		'/mr-potato/printPettyCash/{id}',
		'MrPotatoController@printPettyCash')
		->name('printPettyCash')
		->middleware(['cashier']);

	Route::get(
		'/mr-potato/utilities',
		'MrPotatoController@utilities')
		->name('mr-potato.utilities')
		->middleware(['cashier']);

	Route::post(
		'/mr-potato/utilities/add-bill',
		'MrPotatoController@addBills')
		->name('mr-potato.addBills')
		->middleware(['cashier']);
	
	Route::post(
		'/mr-potato/utilities/add-internet',
		'MrPotatoController@addInternet')
		->name('mr-potato.addInternet')
		->middleware(['cashier']);

	Route::get(
		'/mr-potato/utilities/view-veco/{id}',
		'MrPotatoController@viewBills')
		->name('mr-potato.viewBills')
		->middleware(['cashier']);
	
	Route::get(
		'/mr-potato/utilities/view-mcwd/{id}',
		'MrPotatoController@viewBills')
		->name('mr-potato.viewBills')
		->middleware(['cashier']);

	//Ribos Bar
	Route::get('/ribos-bar', 
	'RibosBarController@index')
	->name('ribos-bar.index')
	->middleware(['cashier']);

	Route::delete(
		'/ribos-bar/delete-transaction-list/{id}',
		'RibosBarController@destroyTransactionList')
		->name('ribos-bar.destroyTransactionList')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/delivery-receipt-form',
		'RibosBarController@deliveryReceiptForm')
		->name('ribos-bar.deliveryReceiptForm')
		->middleware(['cashier']);

	//store delivery receipt
	Route::post(
		'/ribos-bar/store-delivery-receipt',
		'RibosBarController@storeDeliveryReceipt')
		->name('ribos-bar.storeDeliveryReceipt')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/edit-ribos-bar-delivery-receipt/{id}',
		'RibosBarController@editDeliveryReceipt')
		->name('editDeliveryReceiptRibosBar')
		->middleware(['cashier']);

	Route::patch(
		'/ribos-bar/update-delivery-receipt/{id}',
		'RibosBarController@updateDeliveryReceipt')
		->name('ribos-bar.updateDeliveryReceipt')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/add-new-delivery-receipt/{id}',
		'RibosBarController@addNewDelivery')
		->name('ribos-bar.addNewDelivery')
		->middleware(['cashier']);

	Route::post(
		'/ribos-bar/add-new-delivery-receipt-data/{id}',
		'RibosBarController@addNewDeliveryReceiptData')
		->name('ribos-bar.addNewDeliveryReceiptData')
		->middleware(['cashier']);

	Route::patch(
		'/ribos-bar/update-dr/{id}',
		'RibosBarController@updateDr')
		->name('ribos-bar.updateDr')
		->middleware(['cashier']);



	Route::get(
		'/ribos-bar/delivery-receipt-lists',
		'RibosBarController@deliveryReceiptList')
		->name('ribos-bar.deliveryReceiptList')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/view-ribos-bar-delivery-receipt/{id}',
		'RibosBarController@viewDeliveryReceipt')
		->name('ribos-bar.viewDeliveryReceipt')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/printDelivery/{id}',
		'RibosBarController@printDelivery')
		->name('ribos-bar.printDelivery')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/purchase-order',
		'RibosBarController@purchaseOrder')
		->name('ribos-bar.purchaseOrder')
		->middleware(['cashier']);

	//store po 
	Route::post(
		'/ribos-bar/store',
		'RibosBarController@store')
		->name('ribos-bar.store')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/edit-ribos-bar-purchase-order/{id}',
		'RibosBarController@edit')
		->name('editRB')
		->middleware(['cashier']);

	Route::patch(
		'/ribos-bar/update/{id}',
		'RibosBarController@update')
		->name('ribos-bar.update');

	Route::post(
		'/ribos-bar/add-new/{id}',
		'RibosBarController@addNew')
		->name('ribos-bar.addNew')
		->middleware(['cashier']);

	Route::post(
		'/ribos-bar/add-new-purchase-order/{id}',
		'RibosBarController@addNewPurchaseOrder')
		->name('ribos-bar.addNewPurchaseOrder')
		->middleware(['cashier']);

	Route::patch(
		'/ribos-bar/update-po/{id}',
		'RibosBarController@updatePo')
		->name('ribos-bar.updatePo')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/purchase-order/printPO/{id}',
		'RibosBarController@printPO')
		->name('ribos-bar.printPO')
		->middleware(['cashier']);
	

	Route::get(
		'/ribos-bar/purchase-order-lists',
		'RibosBarController@purchaseOrderList')
		->name('ribos-bar.purchaseOrderList')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/view-ribos-bar-purchase-order/{id}',
		'RibosBarController@show')
		->name('ribos-bar.show')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/cash-vouchers',
		'RibosBarController@cashVoucher')
		->name('ribos-bar.cashVoucher')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/cheque-vouchers',
		'RibosBarController@chequeVoucher')
		->name('ribos-bar.chequeVoucher')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/view-ribos-bar-payment-voucher/{id}',
		'RibosBarController@viewPaymentVoucher')
		->name('ribos-bar.viewPaymentVoucher')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/summary-report',
		'RibosBarController@summaryReport')
		->name('summaryReportRB')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/search-multiple-date',
		'RibosBarController@getSummaryReportMultiple')
		->name('getSummaryReportMultiple')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/printMultipleSummary/{date}',
		'RibosBarController@printMultipleSummary')
		->name('printMultipleSummary')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/summary-report/search-number-code',
		'RibosBarController@searchNumberCode')
		->name('searchNumberCode')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/search',
		'RibosBarController@search')
		->name('search')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/printSummary',
		'RibosBarController@printSummary')
		->name('printSummary')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/search-date',
		'RibosBarController@getSummaryReport')
		->name('getSummaryReport')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/printGetSummary/{date}',
		'RibosBarController@printGetSummary')
		->name('printGetSummary')
		->middleware(['cashier']);

	//sales invoice 
	Route::get(
		'/ribos-bar/sales-invoice-form',
		'RibosBarController@salesInvoiceForm')
		->name('ribos-bar.salesInvoiceForm')
		->middleware(['cashier']);

	Route::post(
		'/ribos-bar/store-sales-invoice',
		'RibosBarController@storeSalesInvoice')
		->name('ribos-bar.storeSalesInvoice')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/edit-ribos-bar-sales-invoice/{id}',
		'RibosBarController@editSalesInvoice')
		->name('editSalesInvoiceRB')
		->middleware(['cashier']);

	Route::patch(
		'/ribos-bar/update-sales-invoice/{id}',
		'RibosBarController@updateSalesInvoice')
		->name('ribos-bar.updateSalesInvoice')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/add-new-ribos-bar-sales-invoice/{id}',
		'RibosBarController@addNewSalesInvoice')
		->name('ribos-bar.addNewSalesInvoice')
		->middleware(['cashier']);

	Route::post(
		'/ribos-bar/add-new-sales-invoice-data/{id}',
		'RibosBarController@addNewSalesInvoiceData')
		->name('ribos-bar.addNewSalesInvoiceData')
		->middleware(['cashier']);

	Route::patch(
		'/ribos-bar/update-si/{id}',
		'RibosBarController@updateSi')
		->name('ribos-bar.updateSi')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/view-ribos-bar-sales-invoice/{id}',
		'RibosBarController@viewSalesInvoice')
		->name('ribos-bar.viewSalesInvoice')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/billing-statement-form',
		'RibosBarController@billingStatementForm')
		->name('billingStatementFormRibosBar')
		->middleware(['cashier']);

	Route::post(
		'/ribos-bar/store-billing-statement',
		'RibosBarController@storeBillingStatement')
		->name('ribos-bar.storeBillingStatement')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/edit-ribos-bar-billing-statement/{id}',
		'RibosBarController@editBillingStatement')
		->name('editBillingStatementRibosBar')
		->middleware(['cashier']);

	Route::put(
		'/ribos-bar/update-billing-info/{id}',
		'RibosBarController@updateBillingInfo')
		->name('ribos-bar.updateBillingInfo')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/add-new-ribos-bar-billing/{id}',
		'RibosBarController@addNewBilling')
		->name('ribos-bar.addNewBilling')
		->middleware(['cashier']);

	Route::post(
		'/ribos-bar/add-new-billing-data/{id}',
		'RibosBarController@addNewBillingData')
		->name('ribos-bar.addNewBillingData')
		->middleware(['cashier']);


	Route::get(
		'/ribos-bar/billing-statement-lists',
		'RibosBarController@billingStatementLists')
		->name('ribos-bar.billingStatementLists')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/view-ribos-bar-billing-statement/{id}',
		'RibosBarController@viewBillingStatement')
		->name('ribos-bar.viewBillingStatement')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/statement-of-account-form',
		'RibosBarController@statementOfAccountForm')
		->name('ribos-bar.statementOfAccountForm')
		->middleware(['cashier']);

	Route::post(
		'/ribos-bar/store-statement-account',
		'RibosBarController@storeStatementAccount')
		->name('ribos-bar.storeStatementAccount')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/edit-ribos-bar-statement-of-account/{id}',
		'RibosBarController@editStatementOfAccount')
		->name('ribos-bar.editStatementAccount')
		->middleware(['cashier']);

	Route::patch(
		'/ribos-bar/update-statement-info/{id}',
		'RibosBarController@updateStatementInfo')
		->name('ribos-bar.updateStatementInfo')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/statement-of-account-lists',
		'RibosBarController@statementOfAccountList')
		->name('ribos-bar.statementOfAccountList')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/view-ribos-bar-statement-account/{id}',
		'RibosBarController@viewStatementAccount')
		->name('ribos-bar.viewStatementAccount')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/cashiers-form',
		'RibosBarController@cashiersForm')
		->name('ribos-bar.cashiersForm')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/edit-cashiers-report-inventory-list/{id}',
		'RibosBarController@editCashiersForm')
		->name('ribos-bar.editCashiersForm')
		->middleware(['cashier']);

	Route::post(
		'/ribos-bar/cashiers-store-form',
		'RibosBarController@cashiersFormStore')
		->name('ribos-bar.cashiersFormStore')
		->middleware(['cashier']);

	Route::patch(
		'/ribos-bar/update-cashiers-form/{id}',
		'RibosBarController@updateCashiersForm')
		->name('ribos-bar.updateCashiersForm')
		->middleware(['cashier']);

	Route::post(
		'/ribos-bar/add-cashiers-list/{id}',
		'RibosBarController@addCashiersList')
		->name('ribos-bar.addCashiersList')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/cashiers-report/inventory-list',
		'RibosBarController@cashiersInventoryList')
		->name('ribos-bar.cashiersInventoryList')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/cashiers-report/view-inventory-list/{id}',
		'RibosBarController@viewCashiersReportList')
		->name('ribos-bar.viewCashiersReportList')
		->middleware(['cashier']);

	Route::patch(
		'/ribos-bar/update-item/{id}',
		'RibosBarController@updateItem')
		->name('ribos-bar.updateItem')
		->middleware(['cashier']);


	Route::get(
		'/ribos-bar/cashiers-report/printCashiersReport/{id}',
		'RibosBarController@printCashiersReport')
		->name('ribos-bar.printCashiersReport')
		->middleware(['cashier']);

	Route::get(
		'ribos-bar/petty-cash-list',
		'RibosBarController@pettyCashList')
		->name('ribos-bar.pettyCashList')
		->middleware(['cashier']);

	Route::post(
		'/ribos-bar/petty-cash/add',
		'RibosBarController@addPettyCash')
		->name('addPettyCashRibosBar')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/edit-petty-cash/{id}',
		'RibosBarController@editPettyCash')
		->name('editPettyCashRibosBar')
		->middleware(['cashier']);

	Route::patch(
		'/ribos-bar/update-petty-cash/{id}',
		'RibosBarController@updatePettyCash')
		->name('updatePettyCashRibosBar')
		->middleware(['cashier']);

	Route::patch(
		'/ribos-bar/update-pc/{id}',
		'RibosBarController@updatePC')
		->name('updatePCRibosBar')
		->middleware(['cashier']);

	Route::post(
		'/ribos-bar/add-new-petty-cash/{id}',
		'RibosBarController@addNewPettyCash')
		->name('addNewPettyCashRibosBar')
		->middleware(['cashier']);

	Route::delete(
		'/ribos-bar/petty-cash/delete/{id}',
		'RibosBarController@destroyPettyCash')
		->name('destroyPettyCash')
		->middleware(['cashier']);
	
	Route::get(
		'/ribos-bar/utilities',
		'RibosBarController@utilities')
		->name('ribos-bar.utilities')
		->middleware(['cashier']);
	
	Route::post(
		'/ribos-bar/utilities/add-bill',
		'RibosBarController@addBills')
		->name('ribos-bar.addBills');
	
	Route::post(
		'/ribos-bar/utilities/add-internet',
		'RibosBarController@addInternet')
		->name('ribos-bar.addInternet')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/utilities/view-veco/{id}',
		'RibosBarController@viewBills')
		->name('ribos-bar.viewBills')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/utilities/view-mcwd/{id}',
		'RibosBarController@viewBills')
		->name('ribos-bar.viewBills')
		->middleware(['cashier']);
	
	Route::get(
		'/ribos-bar/utilities/view-internet/{id}',
		'RibosBarController@viewBills')
		->name('ribos-bar.viewBills')
		->middleware(['cashier']);
	
	Route::get(
		'/ribos-bar/petty-cash/view/{id}',
		'RibosBarController@viewPettyCash')
		->name('ribo-bar.viewPettyCash')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/printPettyCash/{id}',
		'RibosBarController@printPettyCash')
		->name('printPettyCashRibosBar')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/store-stock/raw-materials',
		'RibosBarController@rawMaterials')
		->name('ribos-bar.rawMaterials')
		->middleware(['cashier']);
	
	Route::post(
		'/ribos-bar/store-stock/raw-materials/add-raw',
		'RibosBarController@addRawMaterial')
		->name('ribos-bar.addRawMaterial')
		->middleware(['cashier']);

	Route::put(
		'/ribos-bar/store-stock/update-raw-material/{id}',
		'RibosBarController@updateRawMaterial')
		->name('updateRawMaterial')
		->middleware(['cashier']);
		
	Route::get(
		'/ribos-bar/store-stock/view-raw-material-details/{id}',
		'RibosBarController@viewRawMaterialDetails')
		->name('ribos-bar.viewRawMaterialDetails')
		->middleware(['cashier']);

	Route::post(
		'/ribos-bar/store-stock/add-delivery-in',
		'RibosBarController@addDeliveryIn')
		->name('ribos-bar.addDeliveryIn')
		->middleware(['cashier']);
	
	Route::post(
			'/ribos-bar/store-stock/request-stock-out',
			'RibosBarController@addDeliveryIn')
			->name('ribos-bar.addDeliveryIn')
			->middleware(['cashier']);
	
	Route::get(
		'/ribos-bar/store-stock/stocks-inventory',
		'RibosBarController@stocksInventory')
		->name('ribos-bar.stocksInventory')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/store-stock/delivery-outlets',
		'RibosBarController@deliveryOutlet')
		->name('ribos-bar.deliveryOutlet')
		->middleware(['cashier']);
	
	Route::get(
		'/ribos-bar/store-stock/view-stock-inventory/{id}',
		'RibosBarController@viewStockInventory')
		->name('ribos-bar.viewStockInventory')
		->middleware(['cashier']);

	Route::get(
		'/ribos-bar/store-stock/inventory-of-stocks',
		'RibosBarController@inventoryOfStocks')
		->name('ribos-bar.inventoryOfStocks')
		->middleware(['cashier']);
		
	Route::get(
		'/ribos-bar/store-stock/view-inventory-of-stocks/{id}',
		'RibosBarController@viewInventoryOfStocks')
		->name('ribos-bar.viewInventoryOfStocks')
		->middleware(['cashier']);

	Route::patch(
		'/ribos-bar/inventory-stock-update/{id}',
		'RibosBarController@inventoryStockUpdate')
		->name('ribos-bar.inventoryStockUpdate')
		->middleware(['cashier']);
		
	//DNO Personal
	Route::get('/dno-personal', 
	'DnoPersonalController@index')
	->name('dno-personal')
	->middleware(['cashier']);

	Route::get(
		'/dno-personal/summary-report',
		'DnoPersonalController@summaryReport')
		->name('summaryReport')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/printSummary',
		'DnoPersonalController@printSummary')
		->name('printSummary')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/search-date',
		'DnoPersonalController@getSummaryReport')
		->name('getSummaryReport')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/search-multiple-date',
		'DnoPersonalController@getSummaryReportMultiple')
		->name('getSummaryReportMultiple')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/printGetSummary/{date}',
		'DnoPersonalController@printGetSummary')
		->name('printGetSummary')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/printMultipleSummary/{date}',
		'DnoPersonalController@printMultipleSummary')
		->name('printMultipleSummary')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/summary-report/search-number-code',
		'DnoPersonalController@searchNumberCode')
		->name('searchNumberCode')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/search',
		'DnoPersonalController@search')
		->name('search')
		->middleware(['cashier']);

	Route::post(
		'/dno-personal/payment-voucher-store/',
		'DnoPersonalController@paymentVoucherStore')
		->name('dno-personal.paymentVoucherStore')
		->middleware(['cashier']);

	Route::get(
			'/dno-personal/payment-voucher-form',
			'DnoPersonalController@paymentVoucherForm')
		->name('paymentVoucherFormDNOPersonal')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/payables/transaction-list',
		'DnoPersonalController@transactionList')
		->name('dno-personal.transactionList')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/edit-dno-personal-payables-detail/{id}',
		'DnoPersonalController@editPayablesDetail')
		->name('editPayablesDetailDnoPersonal')
		->middleware(['cashier']);

	Route::patch(
		'/dno-personal/payables/update-details/{id}',
		'DnoPersonalController@updateDetails')
		->name('updateDetailsDnoPersonal')
		->middleware(['cashier']);
	
	
	Route::delete(
		'/dno-personal/delete-transaction-list/{id}',
		'DnoPersonalController@destroyTransactionList')
		->name('dno-personal.destroyTransactionList')
		->middleware(['cashier']);
	
	Route::delete(
			'/dno-personal/delete-property/{id}',
			'DnoPersonalController@destroyProperty')
			->name('dno-personal.destroyProperty')
			->middleware(['cashier']);

	Route::delete(
			'/dno-personal/credit-card/delete/{id}',
			'DnoPersonalController@destroyCreditCard')
			->name('dno-personal.destroyCreditCard')
			->middleware(['cashier']);
			
	Route::post(
		'/dno-personal/store-credit-card',
		'DnoPersonalController@storeCreditCard')
		->name('dno-pesonal.storeCreditCard')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/credit-card/ald-accounts',
		'DnoPersonalController@creditCardAccount')
		->name('dno-personal.creditCardAccount')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/credit-card/mod-accounts',
		'DnoPersonalController@creditCardAccount')
		->name('db-personal.creditCardAccount')
		->middleware(['cashier']);	

	Route::patch(
		'/dno-personal/credit-card/accounts/edit/{id}',
		'DnoPersonalController@editCreditCardAccount')
		->name('dno-personal.creditCardAccount')
		->middleware(['cashier']);

	Route::patch(
		'/dno-personal/credit-card/update/{id}',
		'DnoPersonalController@updateCard')
		->name('dno-personal.updateCard')
		->middleware(['cashier']);


	Route::get(
		'/dno-personal/credit-card/ald-accounts/transactions/{id}',
		'DnoPersonalController@cardTransaction')
		->name('dno-personal.cardTransaction')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/credit-card/ald-accounts/view/{id}',
		'DnoPersonalController@viewTransaction')
		->name('dno-personal.viewTransaction')
		->middleware(['cashier']);

	Route::get(
			'/dno-personal/credit-card/mod-accounts/view/{id}',
			'DnoPersonalController@viewTransaction')
			->name('dno-personal.viewTransaction')
			->middleware(['cashier']);

	Route::get(
		'/dno-personal/credit-card/mod-accounts/transactions/{id}',
		'DnoPersonalController@cardTransaction')
		->name('dno-personal.cardTransaction')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/personal-expenses/ald-accounts/transactions/{id}',
		'DnoPersonalController@personalTransaction')
		->name('dno-personal.personalTransaction')
		->middleware(['cashier']);
	
	Route::get(
		'/dno-personal/personal-expenses/mod-accounts/transactions/{id}',
		'DnoPersonalController@personalTransaction')
		->name('dno-personal.personalTransaction')
		->middleware(['cashier']);
	
	Route::get(
		'/dno-personal/personal-expenses/mod-accounts',
		'DnoPersonalController@index')
		->name('dno-personal.index')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/credit-card/account/printCardTransactions/{id}',
		'DnoPersonalController@printCardTransactions')
		->name('dno-personal.printCardTransactions')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/personal-account/printPersonalTransactions/{id}',
		'DnoPersonalController@printPersonalTransactions')
		->name('dno-personal.printPersonalTransactions')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/cebu-properties',
		'DnoPersonalController@properties')
		->name('dno-personal.properties')
		->middleware(['cashier']);

	Route::patch(
		'/dno-personal/properties/update-property/{id}',
		'DnoPersonalController@updateProperty')
		->name('dno-personal.updateProperty')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/manila-properties',
		'DnoPersonalController@properties')
		->name('dno-personal.properties')
		->middleware(['cashier']);

	Route::post(
		'/dno-personal/store-properties',
		'DnoPersonalController@storeProperties')
		->name('dno-personal.storeProperties')
		->middleware(['cashier']);
		
	
	Route::get(
		'/dno-personal/cebu-properties/view/{id}',
		'DnoPersonalController@viewProperties')
		->name('dno-personal.viewProperties')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/cebu-properties/view-service-provider/{id}',
		'DnoPersonalController@viewServiceProvider')
		->name('dno-personal.viewServiceProvider')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/manila-properties/view/{id}',
		'DnoPersonalController@viewProperties')
		->name('dno-personal.viewProperties')
		->middleware(['cashier']);

	Route::post(
		'/dno-personal/properties/add-bill',
		'DnoPersonalController@addOtherBills')
		->name('dno-personal.addOtherBills')
		->middleware(['cashier']);
	
	Route::post(
		'/dno-personal/properties/add-pldt',
		'DnoPersonalController@addCommunications')
		->name('addPLDT')
		->middleware(['cashier']);

	Route::post(
		'/dno-personal/properties/add-globe',
		'DnoPersonalController@addCommunications')
		->name('addGlobe')
		->middleware(['cashier']);

	Route::post(
		'/dno-personal/properties/add-smart',
		'DnoPersonalController@addCommunications')
		->name('addSmart')
		->middleware(['cashier']);

	Route::post(
		'/dno-persona/properties/add-skycable',
		'DnoPersonalController@addSky')
		->name('dno-personal.addSky')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/cebu-properties/view-skycable/{id}',
		'DnoPersonalController@viewBills')
		->name('dno-personal.viewBills')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/cebu-properties/view-veco/{id}',
		'DnoPersonalController@viewBills')
		->name('dno-personal.viewBills')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/cebu-properties/view-mcwd/{id}',
		'DnoPersonalController@viewBills')
		->name('viewBills')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/cebu-properties/view-pldt/{id}',
		'DnoPersonalController@viewBills')
		->name('viewBills')
		->middleware(['cashier']);
	
	Route::get(
			'/dno-personal/cebu-properties/view-globe/{id}',
			'DnoPersonalController@viewBills')
			->name('viewBills')
			->middleware(['cashier']);

	Route::get(
			'/dno-personal/manila-properties/view-veco/{id}',
			'DnoPersonalController@viewBills')
			->name('viewBills')
			->middleware(['cashier']);

	Route::get(
		'/dno-personal/manila-properties/view-meralco/{id}',
		'DnoPersonalController@viewBills')
		->name('viewBills')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/manila-properties/view-mcwd/{id}',
		'DnoPersonalController@viewBills')
		->name('viewBills')
		->middleware(['cashier']);
	
	Route::get(
			'/dno-personal/manila-properties/view-pldt/{id}',
			'DnoPersonalController@viewBills')
			->name('viewBills')
			->middleware(['cashier']);
	
	Route::get(
				'/dno-personal/manila-properties/view-globe/{id}',
				'DnoPersonalController@viewBills')
				->name('viewBills')
				->middleware(['cashier']);
	
	Route::get(
			'/dno-personal/manila-properties/view-skycable/{id}',
			'DnoPersonalController@viewBills')
			->name('viewBills')
			->middleware(['cashier']);


	Route::patch(
		'/dno-personal/properties/update/{id}',
		'DnoPersonalController@updateProperties')
		->name('updteProperties')
		->middleware(['cashier']);

	Route::patch(
		'/dno-personal/properties/update-pldt/{id}',
		'DnoPersonalController@updatePldt')
		->name('dno-personal.updatePLDT')
		->middleware(['cashier']);

	Route::patch(
		'/dno-personal/properties/update-globe/{id}',
		'DnoPersonalController@updateGlobe')
		->name('updateGlobe')
		->middleware(['cashier']);

	Route::patch(
		'/dno-personal/properties/update-skycable/{id}',
		'DnoPersonalController@updateSky')
		->name('dno-personal.updateSky')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/vehicles',
		'DnoPersonalController@vehicles')
		->name('dno-personal.vehicles')
		->middleware(['cashier']);

	Route::patch(
		'/dno-personal/vehicles/update-vehicle/{id}',
		'DnoPersonalController@vehicleUpdate')
		->name('dno-personal.vehicleUpdate')
		->middleware(['cashier']);

	Route::delete(
			'/dno-perosonal/vehicles/delete/{id}',
			'DnoPersonalController@destroyVehicles')
			->name('dno-personal.destroyVehicles')
			->middleware(['cashier']);

	Route::post(
		'/dno-personal/vehicles/store-vehicles',
		'DnoPersonalController@storeVehicles')
		->name('dno-personal.storeVehicles')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/vehicles/view/{id}',
		'DnoPersonalController@viewVehicle')
		->name('dno-personal.viewVehicle')
		->middleware(['cashier']);

	Route::post(
		'/dno-personal/vehicles/store-document/{id}',
		'DnoPersonalController@storeDocument')
		->name('dno-personal.storeDocument')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/vehicles/or-list/{id}',
		'DnoPersonalController@viewDocumentList')
		->name('dno-personal.viewDocumentList')
		->middleware(['cashier']);
	
	Route::get(
		'/dno-personal/vehicles/pms-list/{id}',
		'DnoPersonalController@viewDocumentList')
		->name('dno-personal.viewDocumentList')
		->middleware(['cashier']);
	
	Route::post(
		'/dno-personal/vehicles/store-pms/{id}',
		'DnoPersonalController@storePMSDocument')
		->name('dno-personal.storePMSDocument')
		->middleware(['cashier']);

	//do ajax call	
	Route::get(
		'/dno-personal/get-data/{id}',
		'DnoPersonalController@getData')
		->name('dno-personal.getData')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/get-cebu-properties/{id}',
		'DnoPersonalController@getCebuProp')
		->name('dno-personal.getCebuProp')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/petty-cash-list',
		'DnoPersonalController@pettyCashList')
		->name('dno-personal.pettyCashList')
		->middleware(['cashier']);

	Route::post(
		'/dno-personal/petty-cash/add',
		'DnoPersonalController@addPettyCash')
		->name('addPettyCash')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/edit-petty-cash/{id}',
		'DnoPersonalController@editPettyCash')
		->name('editPettyCash')
		->middleware(['cashier']);

	Route::post(
		'/dno-personal/petty-cash/add-new/{id}',
		'DnoPersonalController@addNewPettyCash')
		->name('addNewPettyCash')
		->middleware(['cashier']);
	
	Route::get(
		'/dno-personal/petty-cash/view/{id}',
		'DnoPersonalController@viewPettyCash')
		->name('dno-personal.viewPettyCash')
		->middleware(['cashier']);
	
	Route::get(
		'/dno-personal/petty-cash/print/{id}',
		'DnoPersonalController@printPettyCash')
		->name('printPettyCash')
		->middleware(['cashier']);

	Route::patch(
		'/dno-personal/petty-cash/update/{id}',
		'DnoPersonalController@updatePettyCash')
		->name('updatePettyCash')
		->middleware(['cashier']);

	Route::patch(
		'/dno-personal/petty-cash/updatePC/{id}',
		'DnoPersonalController@updatePC')
		->name('updatePC')
		->middleware(['cashier']);

	Route::delete(
		'/dno-personal/petty-cash/delete/{id}',
		'DnoPersonalController@destroyPettyCash')
		->name('destroyPettyCash')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/receivables-form',
		'DnoPersonalController@receivableForm')
		->name('receivableFormDno')
		->middleware(['cashier']);

	Route::post(
		'/dno-personal/receivables/store-receivables',
		'DnoPersonalController@storeReceivables')
		->name('storeReceivablesDnoPersonal')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/receivables/edit/{id}',
		'DnoPersonalController@editReceivables')
		->name('editReceivablesDnoPersonal')
		->middleware(['cashier']);

	Route::post(
		'/dno-personal/receivables/add-receivables/{id}',
		'DnoPersonalController@addReceivables')
		->name('addReceivablesDnoPersonal')
		->middleware(['cashier']);

	Route::patch(
		'/dno-personal/receivables/update-r/{id}',
		'DnoPersonalController@updateR')
		->name('updateRDnoPersonal')
		->middleware(['cashier']);

	Route::delete(
		'/dno-personal/receivables/delete/{id}',
		'DnoPersonalController@destroyReceivables')
		->name('destroyReceivablesDnoPersonal')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/receivables/list',
		'DnoPersonalController@receivableList')
		->name('receivableListDnoPersonal')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal-controller/receivables/payments/{id}',
		'DnoPersonalController@receivablePayment')
		->name('receivablePaymentDnoPersonal')
		->middleware(['cashier']);

	Route::patch(
		'/dno-personal/receivables/paid/{id}',
		'DnoPersonalController@paid')
		->name('padiDnoPersonal')
		->middleware(['cashier']);

	Route::get(
		'/dno-personal/receivables/view/{id}',
		'DnoPersonalController@viewReceivable')
		->name('viewReceivableDnoPersonal')
		->middleware(['cashier']);

	//DNO food ventures
	Route::get(
		'/dno-food-ventures',
		'DnoFoodVenturesController@index')
		->name('dno-food-ventures')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/delivery-receipt-form',
		'DnoFoodVenturesController@deliveryReceiptForm')
		->name('deliveryReceiptFormDnoFoodVentures')
		->middleware(['cashier']);

	Route::post(
		'/dno-food-ventures/store-delivery-receipt',
		'DnoFoodVenturesController@storeDeliveryReceipt')
		->name('storeDeliveryReceiptDnoFoodVenuturs')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/{id}/edit-dno-food-ventures',
		'DnoFoodVenturesController@editDeliveryReceipt')
		->name('DnoFoodVentures.editDeliveryReceipt')
		->middleware(['cashier']);

	Route::put(
		'/dno-food-ventures/{id}/update-delivery-receipt',
		'DnoFoodVenturesController@updateDeliveryReceipt')
		->name('DnoFoodVenturesController.updateDeliveryReceipt')
		->middleware(['cashier']);

	Route::post(
		'/dno-food-ventures/{id}/add-new-delivery-receipt-data',
		'DnoFoodVenturesController@addNewDeliveryReceiptData')
		->name('DnoFoodVenturesController.addNewDeliveryReceiptData')
		->middleware(['cashier']);

	Route::delete(
		'/dno-food-ventures/delete-delivery-receipt/{id}',
		'DnoFoodVenturesController@destroyDeliveryReceipt')
		->name('destroyDeliveryReceipt')
		->middleware(['cashier']);
	
	
	Route::get(
		'dno-food-ventures/delete/DR/{id}',
		'DnoFoodVenturesController@destroyDR')
		->name('destroyDRDnoFoodVentures')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/delivery-receipt/lists',
		'DnoFoodVenturesController@deliveryReceiptList')
		->name('deliveryReceiptList')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/{id}/view-dno-food-ventures-delivery-receipt',
		'DnoFoodVenturesController@viewDeliveryReceipt')
		->name('viewDeliveryReceipt')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/{id}/printDelivery',
		'DnoFoodVenturesController@printDelivery')
		->name('printDelivery')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/billing-statement-form',
		'DnoFoodVenturesController@billingStatementForm')
		->name('billingStatementForm')
		->middleware(['cashier']);

	Route::post(
		'/dno-food-ventures/store-billing-statement',
		'DnoFoodVenturesController@storeBillingStatement')
		->name('storeBillingStatement')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/{id}/edit-billing-statement',
		'DnoFoodVenturesController@editBillingStatement')
		->name('editBillingStatementDnoFoodVentures')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/billing-statement-lists',
		'DnoFoodVenturesController@billingStatementLists')
		->name('billingStatementListsDnoFoodVentures')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/{id}/view-billing-statement',
		'DnoFoodVenturesController@viewBillingStatement')
		->name('viewBillingStatementDnoFoodVenture')
		->middleware(['cashier']);


	Route::post(
		'/dno-food-ventures/{id}/add-new-billing-data',
		'DnoFoodVenturesController@addNewBillingData')
		->name('addNewBillingDataDnoFoodVentures')
		->middleware(['cashier']);

	Route::delete(
		'/dno-food-ventures/delete-data-billing-statement/{id}',
		'DnoFoodVenturesController@destroyBillingDataStatement')
		->name('destroyBillingDataStatement')
		->middleware(['cashier']);

	Route::delete(
		'/dno-food-ventures/delete-billing-statement/{id}',
		'DnoFoodVenturesController@destroyBillingStatement')
		->name('destroyBillingStatement')
		->middleware(['cashier']);

	Route::put(
		'/dno-food-ventures/{id}/update-billing-info',
		'DnoFoodVenturesController@updateBillingInfo')
		->name('updateBillingInfoDnoFoodVentures')
		->middleware(['cashier']);


	Route::get(
		'/dno-food-ventures/sales-invoice-form',
		'DnoFoodVenturesController@salesInvoiceForm')
		->name('salesInvoiceForm')
		->middleware(['cashier']);

	Route::post(
		'/dno-food-ventures/store-sales-invoice',
		'DnoFoodVenturesController@storeSalesInvoice')
		->name('storeSalesInvoice')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/{id}/edit-sales-invoice',
		'DnoFoodVenturesController@editSalesInvoice')
		->name('editSalesInvoiceDnoFoodVentures')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/{id}/view-sales-invoice',
		'DnoFoodVenturesController@viewSalesInvoice')
		->name('viewSalesInvoice')
		->middleware(['cashier']);
		
	Route::post(
		'/dno-food-ventures/add-new-sales-invoice-data/{id}',
		'DnoFoodVenturesController@addNewSalesInvoiceData')
		->name('addNewSalesInvoiceData')
		->middleware(['cashier']);

	Route::put(
		'/dno-food-ventures/{id}/update-si',
		'DnoFoodVenturesController@updateSi')
		->name('updateSi')
		->middleware(['cashier']);

	Route::put(
		'/dno-food-ventures/{id}/update-sales-invoice',
		'DnoFoodVenturesController@updateSalesInvoice')
		->name('updateSalesInvoiceDnoFoodVentures')
		->middleware(['cashier']);

	Route::delete(
		'/dno-food-ventures/delete-sales-invoice/{id}',
		'DnoFoodVenturesController@destroySalesInvoice')
		->name('destroySalesInvoice')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/petty-cash-list',
		'DnoFoodVenturesController@pettyCashList')
		->name('pettyCashList')
		->middleware(['cashier']);

	Route::post(
		'/dno-food-ventures/petty-cash/add',
		'DnoFoodVenturesController@addPettyCash')
		->name('addPettyCash')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/{id}/edit-petty-cash/',
		'DnoFoodVenturesController@editPettyCash')
		->name('editPettyCashDnoFoodVentures')
		->middleware(['cashier']);

	Route::put(
		'/dno-food-ventures/{id}/update-petty-cash',
		'DnoFoodVenturesController@updatePettyCash')
		->name('updatePettyCash')
		->middleware(['cashier']);

	Route::post(
		'/dno-food-ventures/{id}/add-new-petty-cash',
		'DnoFoodVenturesController@addNewPettyCash')
		->name('addNewPettyCash')
		->middleware(['cashier']);

	Route::put(
		'/dno-food-ventures/{id}/update-pc',
		'DnoFoodVenturesController@updatePC')
		->name('updatePC')
		->middleware(['cashier']);

	Route::delete(
		'/dno-food-ventures/petty-cash/delete/{id}',
		'DnoFoodVenturesController@destroyPettyCash')
		->name('destroyPettyCash')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/petty-cash/{id}/view',
		'DnoFoodVenturesController@viewPettyCash')
		->name('viewPettyCash')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/{id}/printPettyCash',
		'DnoFoodVenturesController@printPettyCash')
		->name('printPettyCash')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/statement-of-account/lists',
		'DnoFoodVenturesController@statementOfAccountLists')
		->name('statementOfAccountLists')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/{id}/edit-statement-of-account/',
		'DnoFoodVenturesController@editStatementAccount')
		->name('editStatementAccountDnoFoodVentures')
		->middleware(['cashier']);

	Route::put(
		'/dno-food-ventures/s-account/{id}',
		'DnoFoodVenturesController@sAccountUpdate')
		->name('sAccountUpdate')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/{id}/view-statement-account/',
		'DnoFoodVenturesController@viewStatementAccount')
		->name('viewStatementAccount')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/{id}/printSOA',
		'DnoFoodVenturesController@printSOA')
		->name('printSOA')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/printSOAListSO',
		'DnoFoodVenturesController@printSOAListSO')
		->name('printSOAListSO')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/printSOAListsDR',
		'DnoFoodVenturesController@printSOAListsDR')
		->name('printSOAListsDR')
		->middleware(['cashier']);
		
	Route::get(
		'/dno-food-ventures/commissary/raw-materials',
		'DnoFoodVenturesController@rawMaterials')
		->name('rawMaterials')
		->middleware(['cashier']);

	Route::post(
		'/dno-food-ventures/commissary/create-raw-materials',
		'DnoFoodVenturesController@addRawMaterial')
		->name('addRawMaterial')
		->middleware(['cashier']);


	Route::put(
		'/dno-food-ventures/commissary/update-raw-material/{id}',
		'DnoFoodVenturesController@updateRawMaterial')
		->name('updateRawMaterial')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/view-raw-material-details/{id}',
		'DnoFoodVenturesController@viewRawMaterialDetails')
		->name('viewRawMaterialDetailsDnoFoodVentures')
		->middleware(['cashier']);


	Route::get(
		'/dno-food-ventures/commissary/stocks-inventory',
		'DnoFoodVenturesController@stocksInventory')
		->name('stocksInventory')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/commissary/delivery-outlets',
		'DnoFoodVenturesController@commissaryDeliveryOutlet')
		->name('commissaryDeliveryOutlet')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/commissary/inventory-of-stocks',
		'DnoFoodVenturesController@inventoryOfStocks')
		->name('inventoryOfStocks')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/view-inventory-of-stocks/{id}',
		'DnoFoodVenturesController@viewInventoryOfStocks')
		->name('viewInventoryOfStocks')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/purchase-order',
		'DnoFoodVenturesController@purchaseOrder')
		->name('purchaseOrderDnoFoodVenture')
		->middleware(['cashier']);

	Route::post(
		'/dno-food-ventures/store',
		'DnoFoodVenturesController@store')
		->name('storeDnoFoodVentures')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/{id}/edit',
		'DnoFoodVenturesController@edit')
		->name('editDnoFoodVentures')
		->middleware(['cashier']);

	Route::post(
		'/dno-food-ventures/add-new-purchase-order/{id}',
		'DnoFoodVenturesController@addNewPurchaseOrder')
		->name('addNewPurchaseOrderDnoFoodVentures')
		->middleware(['cashier']);

	Route::put(
		'/dno-food-ventures/update-po/{id}',
		'DnoFoodVenturesController@updatePo')
		->name('updatePoDnoFoodVentures')
		->middleware(['cashier']);

	Route::delete(
		'/dno-food-ventures/delete/{id}',
		'DnoFoodVenturesController@destroy')
		->name('destroy')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/purchase-order-lists',
		'DnoFoodVenturesController@purchaseOrderList')
		->name('purchaseOrderList')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/{id}/view',
		'DnoFoodVenturesController@show')
		->name('show')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/printPO/{id}',
		'DnoFoodVenturesController@printPO')
		->name('printPO')
		->middleware(['cashier']);

	Route::delete(
		'/dno-food-ventures/delete/PO/{id}',
		'DnoFoodVenturesController@destroyPO')
		->name('destroyPO')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/payment-voucher-form',
		'DnoFoodVenturesController@paymentVoucherForm')
		->name('paymentVoucherFormDNOfoodventures')
		->middleware(['cashier']);

	Route::post(
		'/dno-food-ventures/store-payment-voucher',
		'DnoFoodVenturesController@paymentVoucherStore')
		->name('paymentVoucherStore')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/edit-payables-detail/{id}',
		'DnoFoodVenturesController@editPayablesDetail')
		->name('editPayablesDetailDNOFoodVentures')
		->middleware(['cashier']);

	Route::patch(
		'/dno-food-ventures/payables/update-particulars/{id}',
		'DnoFoodVenturesController@updateParticulars')
		->name('updateParticulars')
		->middleware(['cashier']);

	Route::patch(
		'/dno-food-ventures/payables/updateP/{id}',
		'DnoFoodVenturesController@updateP')
		->name('updateP')
		->middleware(['cashier']);

	Route::patch(
		'/dno-food-ventures/payables/update-check/{id}',
		'DnoFoodVenturesController@updateCheck')
		->name('updateCheck')
		->middleware(['cashier']);

	Route::patch(
		'/dno-food-ventures/payables/update-cash/{id}',
		'DnoFoodVenturesController@updateCash')
		->name('updateCash')
		->middleware(['cashier']);

	Route::patch(
		'/dno-food-ventures/payables/update-details/{id}',
		'DnoFoodVenturesController@updateDetails')
		->name('updateDetails')
		->middleware(['cashier']);

	Route::post(
		'/dno-food-ventures/add-payment/{id}',
		'DnoFoodVenturesController@addPayment')
		->name('addPayment')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/summary-report',
		'DnoFoodVenturesController@summaryReport')
		->name('summaryReport')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/search-multiple-date',
		'DnoFoodVenturesController@getSummaryReportMultiple')
		->name('getSummaryReportMultiple')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/printMultipleSummary/{date}',
		'DnoFoodVenturesController@printMultipleSummary')
		->name('printMultipleSummary')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/summary-report/search-number-code',
		'DnoFoodVenturesController@searchNumberCode')
		->name('searchNumberCode')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/search',
		'DnoFoodVenturesController@search')
		->name('search')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/search-date',
		'DnoFoodVenturesController@getSummaryReport')
		->name('getSummaryReport')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/printSummary',
		'DnoFoodVenturesController@printSummary')
		->name('printSummary')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/printGetSummary/{date}',
		'DnoFoodVenturesController@printGetSummary')
		->name('printGetSummary')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/payables/transaction-list',
		'DnoFoodVenturesController@transactionList')
		->name('transactionList')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/view-payables-details/{id}',
		'DnoFoodVenturesController@viewPayableDetails')
		->name('viewPayableDetails')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/printPayables/{id}',
		'DnoFoodVenturesController@printPayables')
		->name('printPayables')
		->middleware(['cashier']);

	Route::post(
		'/dno-food-ventures/add-particular/{id}',
		'DnoFoodVenturesController@addParticulars')
		->name('addParticularsDNOFoodVentures')
		->middleware(['cashier']);

	Route::patch(
			'/dno-food-ventures/accept/{id}',
			'DnoFoodVenturesController@accept')
			->name('accept')
			->middleware(['cashier']);

	Route::delete(
		'/dno-food-ventures/delete-transaction-list/{id}',
		'DnoFoodVenturesController@destroyTransactionList')
		->name('destroyTransactionList')
		->middleware(['cashier']);


	Route::get(
		'/dno-food-ventures/suppliers',
		'DnoFoodVenturesController@supplier')
		->name('supplier')
		->middleware(['cashier']);
	
	Route::post(
		'/dno-food-ventures/supplier/add',
		'DnoFoodVenturesController@addSupplier')
		->name('addSupplier')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/suppliers/view/{id}',
		'DnoFoodVenturesController@viewSupplier')
		->name('viewSupplier')
		->middleware(['cashier']);

	Route::get(
		'/dno-food-ventures/supplier/print/{id}',
		'DnoFoodVenturesController@printSupplier')
		->name('printSupplier')
		->middleware(['cashier']);

	//DNO resources and devlopment corp
	Route::get(
		'/dno-resources-development',
		'DnoResourcesDevelopmentController@index')
		->name('dno-resources-development')
		->middleware(['cashier']);

	Route::get(
		'/dno-resources-development/summary-report',
		'DnoResourcesDevelopmentController@summaryReport')
		->name('summaryReport')
		->middleware(['cashier']);

	Route::get(
		'/dno-resources-development/search-multiple-date',
		'DnoResourcesDevelopmentController@getSummaryReportMultiple')
		->name('getSummaryReportMultiple')
		->middleware(['cashier']);


	Route::get(
		'/dno-resources-development/printMultipleSummary/{date}',
		'DnoResourcesDevelopmentController@printMultipleSummary')
		->name('printMultipleSummary')
		->middleware(['cashier']);

	
	Route::get(
		'/dno-resources-development/summary-report/search-number-code',
		'DnoResourcesDevelopmentController@searchNumberCode')
		->name('searchNumberCode')
		->middleware(['cashier']);

	Route::get(
		'/dno-resources-development/search',
		'DnoResourcesDevelopmentController@search')
		->name('search')
		->middleware(['cashier']);
	
	Route::get(
		'/dno-resources-development/purchase-order',
		'DnoResourcesDevelopmentController@purchaseOrder')
		->name('purchaseOrder')
		->middleware(['cashier']);

	Route::post(
		'/dno-resources-development/store',
		'DnoResourcesDevelopmentController@store')
		->name('store')
		->middleware(['cashier']);
	
	Route::get(
		'/dno-resources-development/edit-dno-resources-purchase-order/{id}',
		'DnoResourcesDevelopmentController@edit')
		->name('edit')
		->middleware(['cashier']);

	Route::post(
		'/dno-resources-development/add-new/{id}',
		'DnoResourcesDevelopmentController@addNew')
		->name('addNew')
		->middleware(['cashier']);

	Route::patch(
		'/dno-resources-development/update-po/{id}',
		'DnoResourcesDevelopmentController@updatePo')
		->name('dno-resources-development.updatePo')
		->middleware(['cashier']);



	Route::get(
		'/dno-resources-development/purchase-order-lists',
		'DnoResourcesDevelopmentController@purchaseOrderList')
		->name('purchaseOrderList')
		->middleware(['cashier']);

	Route::delete(
		'/dno-resources-development/delete/{id}',
		'DnoResourcesDevelopmentController@destroy')
		->name('destroy')
		->middleware(['cashier']);

	Route::get(
		'/dno-resources-development/view-dno-resources-purchase-order/{id}',
		'DnoResourcesDevelopmentController@show')
		->name('show')
		->middleware(['cashier']);

	Route::get(
		'/dno-resources-development/printPo/{id}',
		'DnoResourcesDevelopmentController@printPO')
		->name('printPoDnoResources')
		->middleware(['cashier']);

	Route::get(
		'/dno-resources-development/delivery-form',
		'DnoResourcesDevelopmentController@deliveryForm')
		->name('deliveryForm')
		->middleware(['cashier']);
	
	Route::post(
		'/dno-resources-development/store-delivery-transaction',
		'DnoResourcesDevelopmentController@addDeliveryTransaction')
		->name('addDeliveryTransaction')
		->middleware(['cashier']);

	Route::get(
		'/dno-resources-development/edit-delivery-transaction/{id}',
		'DnoResourcesDevelopmentController@editDeliveryTransaction')
		->name('editDeliveryTransaction')
		->middleware(['cashier']);

	Route::post(
		'/dno-resources-development/add-delivery-transaction/{id}',
		'DnoResourcesDevelopmentController@addDelivery')
		->name('addDelivery')
		->middleware(['cashier']);

	Route::patch(
		'/dno-resources-development/update-dt/{id}',
		'DnoResourcesDevelopmentController@updateDT')
		->name('updateDT')
		->middleware(['cashier']);
	
	Route::delete(
		'/dno-resources-development/delivery-transaction/delete/{id}',
		'DnoResourcesDevelopmentController@destroyDeliveryTransaction')
		->name('destroyDeliveryTransaction')
		->middleware(['cashier']);

	Route::get(
		'/dno-resources-development/delivery-transaction/records',
		'DnoResourcesDevelopmentController@deliveryRecords')
		->name('deliveryRecords')
		->middleware(['cashier']);

	Route::get(
		'/dno-resources-development/view-dno-resources-delivery-transaction/{id}',
		'DnoResourcesDevelopmentController@viewDeliveryTransaction')
		->name('viewDeliveryTransaction')
		->middleware(['cashier']);

	Route::get(
		'/dno-resources-development/billing-statement-form',
		'DnoResourcesDevelopmentController@billingStatementForm')
		->name('billingStatementFormDnoResourcesDevelopment')
		->middleware(['cashier']);

	Route::post(
		'/dno-resources-development/store-billing-statement',
		'DnoResourcesDevelopmentController@storeBillingStatement')
		->name('storeBillingStatement')
		->middleware(['cashier']);

	Route::get(
		'/dno-resources-development/{id}/edit-billing-statement',
		'DnoResourcesDevelopmentController@editBillingStatement')
		->name('editBillingStatementDnoResourcesDevelopment')
		->middleware(['cashier']);

	Route::put(
		'/dno-resources-development/{id}/update-billing-info',
		'DnoResourcesDevelopmentController@updateBillingInfo')
		->name('updateBillingInfo')
		->middleware(['cashier']);

	Route::post(
		'/dno-resources-development/{id}/add-new-billing',
		'DnoResourcesDevelopmentController@addNewBilling')
		->name('addNewBilling')
		->middleware(['cashier']);

	Route::delete(
		'/dno-resources-development/delete-data-billing-statement/{id}',
		'DnoResourcesDevelopmentController@destroyBillingDataStatement')
		->name('destroyBillingDataStatement')
		->middleware(['cashier']);

	Route::get(
		'/dno-resources-development/billing-statement-lists',
		'DnoResourcesDevelopmentController@billingStatementList')
		->name('billingStatementList')
		->middleware(['cashier']);

	Route::get(
		'/dno-resources-development/{id}/view-billing-statement',
		'DnoResourcesDevelopmentController@viewBillingStatement')
		->name('viewBillingStatement')
		->middleware(['cashier']);

	Route::get(
		'/dno-resources-development/{id}/printBillingStatement',
		'DnoResourcesDevelopmentController@printBillingStatement')
		->name('printBillingStatement')
		->middleware(['cashier']);

	Route::get(
		'/dno-resources-development/statement-of-account/lists',
		'DnoResourcesDevelopmentController@statementOfAccountLists')
		->name('statementOfAccountLists')
		->middleware(['cashier']);

	Route::get(
		'/dno-resources-development/{id}/edit-statement-of-account',
		'DnoResourcesDevelopmentController@editStatementAccount')
		->name('editStatementAccountDnoResourcesDevelopment')
		->middleware(['cashier']);

	Route::put(
		'/dno-resources-development/s-account/{id}',
		'DnoResourcesDevelopmentController@sAccountUpdate')
		->name('sAccountUpdate')
		->middleware(['cashier']);

	Route::get(
		'/dno-resources-development/{id}/view-statement-account',
		'DnoResourcesDevelopmentController@viewStatementAccount')
		->name('viewStatementAccount')
		->middleware(['cashier']);

	Route::get(
		'/dno-resources-development/{id}/printSOA',
		'DnoResourcesDevelopmentController@printSOA')
		->name('printSOA')
		->middleware(['cashier']);

	Route::delete(
		'/dno-resources-development/delete-billing-statement/{id}',
		'DnoResourcesDevelopmentController@destroyBillingStatement')
		->name('destroyBillingStatement')
		->middleware(['cashier']);

	Route::get(
		'/dno-resources-development/printSOALists',
		'DnoResourcesDevelopmentController@printSOALists')
		->name('printSOALists')
		->middleware(['cashier']);

	Route::get(
		'/dno-resources-development/petty-cash-list',
		'DnoResourcesDevelopmentController@pettyCashList')
		->name('pettyCashList')
		->middleware(['cashier']);

	Route::post(
		'/dno-resources-development/petty-cash/add',
		'DnoResourcesDevelopmentController@addPettyCash')
		->name('addPettyCash')
		->middleware(['cashier']);

	Route::get(
		'/dno-resources-development/{id}/edit-petty-cash/',
		'DnoResourcesDevelopmentController@editPettyCash')
		->name('editPettyCashDnoResourcesDevelopment')
		->middleware(['cashier']);

	Route::put(
		'/dno-resources-development/{id}/update-petty-cash',
		'DnoResourcesDevelopmentController@updatePettyCash')
		->name('updatePettyCash')
		->middleware(['cashier']);

	Route::post(
		'/dno-resources-development/{id}/add-new-petty-cash',
		'DnoResourcesDevelopmentController@addNewPettyCash')
		->name('addNewPettyCash')
		->middleware(['cashier']);

	Route::put(
		'/dno-resources-development/{id}/updatePC',
		'DnoResourcesDevelopmentController@updatePC')
		->name('updatePC')
		->middleware(['cashier']);

	Route::delete(
		'/dno-resources-development/petty-cash/delete/{id}',
		'DnoResourcesDevelopmentController@destroyPettyCash')
		->name('destroyPettyCash')
		->middleware(['cashier']);

	Route::get(
		'/dno-resources-development/petty-cash/{id}/view',
		'DnoResourcesDevelopmentController@viewPettyCash')
		->name('viewPettyCash')
		->middleware(['cashier']);

	Route::get(
		'/dno-resources-development/{id}/printPettyCash',
		'DnoResourcesDevelopmentController@printPettyCash')
		->name('printPettyCash')
		->middleware(['cashier']);

			
	Route::get(
		'/dno-resources-development/suppliers',
		'DnoResourcesDevelopmentController@supplier')
		->name('supplier')
		->middleware(['cashier']);

	Route::post(
		'/dno-resources-development/supplier/add',
		'DnoResourcesDevelopmentController@addSupplier')
		->name('addSupplier')
		->middleware(['cashier']);

	Route::get(
		'/dno-resources-development/suppliers/view/{id}',
		'DnoResourcesDevelopmentController@viewSupplier')
		->name('viewSupplier')
		->middleware(['cashier']);

	Route::get(
		'/dno-resources-development/supplier/print/{id}',
		'DnoResourcesDevelopmentController@printSupplier')
		->name('printSupplier')
		->middleware(['cashier']);

	//Dong Fang Corporation
	Route::get(
		'/dong-fang-corporation',
		'DongFangCorporationController@index')
		->name('index')
		->middleware(['cashier']);

	Route::get(
		'/dong-fang-corporation/payment-voucher-form',
		'DongFangCorporationController@paymentVoucherForm')
		->name('paymentVoucherFormDongFang')
		->middleware(['cashier']);
	
	Route::post(
		'/dong-fang-corporation/payment-voucher-store',
		'DongFangCorporationController@paymentVoucherStore')
		->name('paymentVoucherStoreDongFang')
		->middleware(['cashier']);

	Route::get(
		'/dong-fang-corporation/edit-dong-fang-payables-detail/{id}',
		'DongFangCorporationController@editPayablesDetail')
		->name('editPayablesDetailDongFang')
		->middleware(['cashier']);

	Route::patch(
		'/dong-fang-corporation/payables/update-particulars/{id}',
		'DongFangCorporationController@updateParticulars')
		->name('updateParticulars')
		->middleware(['cashier']);

	Route::patch(
		'/dong-fang-corporation/payables/updateP/{id}',
		'DongFangCorporationController@updateP')
		->name('updateP')
		->middleware(['cashier']);

	Route::patch(
		'/dong-fang-corporation/payables/update-check/{id}',
		'DongFangCorporationController@updateCheck')
		->name('updateCheck')
		->middleware(['cashier']);

	Route::patch(
		'/dong-fang-corporation/payables/update-cash/{id}',
		'DongFangCorporationController@updateCash')
		->name('updateCash')
		->middleware(['cashier']);

	Route::patch(
		'/dong-fang-corporation/payables/update-details/{id}',
		'DongFangCorporationController@updateDetails')
		->name('updateDetails')
		->middleware(['cashier']);
	
	Route::patch(
		'/dong-fang-corporation/accept/{id}',
		'DongFangCorporationController@accept')
		->name('acceptDongFang')
		->middleware(['cashier']);

	Route::post(
		'/dong-fang-corporation/add-payment/{id}',
		'DongFangCorporationController@addPayment')
		->name('addPayment')
		->middleware(['cashier']);

	Route::post(
		'/dong-fang-corportaion/add-particulars/{id}',
		'DongFangCorporationController@addParticulars')
		->name('addParticulars')
		->middleware(['cashier']);
	
	Route::get(
		'/dong-fang-corporation/payables/transaction-list',
		'DongFangCorporationController@transactionList')
		->name('transactionList')
		->middleware(['cashier']);

	Route::get(
		'/dong-fang-corporation/view-dong-fang-payables-details/{id}',
		'DongFangCorporationController@viewPayableDetails')
		->name('viewPayableDetailsDongFang')
		->middleware(['cashier']);

	Route::get(
		'/dong-fang-corporation/printPayables/{id}',
		'DongFangCorporationController@printPayablesDongFang')
		->name('printPayablesDongFang')
		->middleware(['cashier']);

	Route::get(
		'/dong-fang-corporation/summary-report',
		'DongFangCorporationController@summaryReport')
		->name('summaryReport')
		->middleware(['cashier']);

	Route::get(
		'/dong-fang-corporation/search-multiple-date',
		'DongFangCorporationController@getSummaryReportMultiple')
		->name('getSummaryReportMultiple')
		->middleware(['cashier']);

	Route::get(
		'/dong-fang-corporation/printMultipleSummary/{date}',
		'DongFangCorporationController@printMultipleSummary')
		->name('printMultipleSummary')
		->middleware(['cashier']);

	Route::get(
		'/dong-fang-corporation/summary-report/search-number-code',
		'DongFangCorporationController@searchNumberCode')
		->name('searchNumberCode')
		->middleware(['cashier']);

	Route::get(
		'/dong-fang-corporation/search',
		'DongFangCorporationController@search')
		->name('search')
		->middleware(['cashier']);

	Route::get(
		'/dong-fang-corporation/printSummary',
		'DongFangCorporationController@printSummary')
		->name('printSummary')
		->middleware(['cashier']);

	Route::get(
		'/dong-fang-corporation/search-date',
		'DongFangCorporationController@getSummaryReport')
		->name('getSummaryReport')
		->middleware(['cashier']);

	Route::get(
		'/dong-fang-corporation/printGetSummary/{date}',
		'DongFangCorporationController@printGetSummary')
		->name('printGetSummary')
		->middleware(['cashier']);

	Route::delete(
		'/dong-fang-corporation/delete-transaction-list/{id}',
		'DongFangCorporationController@destroyTransaction')
		->name('destroyTransaction')
		->middleware(['cashier']);

	Route::get(
		'/dong-fang-corporation/purchase-order',
		'DongFangCorporationController@purchaseOrder')
		->name('purchaseOrderDongFang')
		->middleware(['cashier']);

	Route::post(
		'/dong-fang-corporation/store',
		'DongFangCorporationController@store')
		->name('storeDongFang')
		->middleware(['cashier']);

	Route::get(
		'/dong-fang-corporation/edit/{id}',
		'DongFangCorporationController@edit')
		->name('editDongFang')
		->middleware(['cashier']);

	Route::post(
		'/dong-fang-corporation/add-new/{id}',
		'DongFangCorporationController@addNew')
		->name('addNewDongFang')
		->middleware(['cashier']);

	Route::patch(
		'/dong-fang-corporation/update-po/{id}',
		'DongFangCorporationController@updatePo')
		->name('updatePoDongFang')
		->middleware(['cashier']);

	Route::patch(
		'/dong-fang-corporation/update/po/{id}',
		'DongFangCorporationController@update')
		->name('updateDongFang')
		->middleware(['cashier']);

	Route::delete(
		'/dong-fang-corporation/delete/{id}',
		'DongFangCorporationController@destroy')
		->name('destroy')
		->middleware(['cashier']);

	Route::delete(
		'/dong-fang-corporation/delete/PO/{id}',
		'DongFangCorporationController@destroyPO')
		->name('destroyPO')
		->middleware(['cashier']);

	Route::get(
		'/dong-fang-corporation/purchase-order-lists',
		'DongFangCorporationController@purchaseOrderList')
		->name('purchaseOrderListDongFang')
		->middleware(['cashier']);

	Route::get(
		'/dong-fang-corporation/view-dong-fang-purchase-order/{id}',
		'DongFangCorporationController@show')
		->name('show')
		->middleware(['cashier']);

	Route::get(
		'/dong-fang-corporation/printPO/{id}',
		'DongFangCorporationController@printPO')
		->name('printPODongFang');


	Route::get(
		'/dong-fang-corporation/billing-statement-form',
		'DongFangCorporationController@billingStatementForm')
		->name('billingStatementFormDongFang')
		->middleware(['cashier']);
	
	Route::post(
		'/dong-fang-corporation/store-billing-statement',
		'DongFangCorporationController@storeBillingStamtement')
		->name('storeBillingStatementDongFang')
		->middleware(['cashier']);

	Route::get(
		'/dong-fang-corporation/edit-billing-statment/{id}',
		'DongFangCorporationController@editBillingStatement')
		->name('editBillingStatementDongFang')
		->middleware(['cashier']);

	Route::post(
		'/dong-fang-corporation/add-new-billing-statment/{id}',
		'DongFangCorporationController@addNewBillingStatement')
		->name('addNewBillingStatementDongFang')
		->middleware(['cashier']);

	Route::patch(
		'/dong-fang-corporation/update-bl/{id}',
		'DongFangCorporationController@updateBL')
		->name('updateBLDongFang')
		->middleware(['cashier']);

	Route::delete(
		'/dong-fang-corporation/billing-statement/delete/{id}',
		'DongFangCorporationController@destroyBillingStatment')
		->name('destroyBillingStatmentDongFang')
		->middleware(['cashier']);

	Route::get(
		'/dong-fang-corporation/billing-statement/list',
		'DongFangCorporationController@billingStatementList')
		->name('billingStatementListDongFang')
		->middleware(['cashier']);

	Route::get(
		'/dong-fang-corporation/view-billing-statement/{id}',
		'DongFangCorporationController@viewBillingStatement')
		->name('viewBillingStatementDongFang')
		->middleware(['cashier']);

	Route::get(
		'/dong-fang-corporation/petty-cash-list',
		'DongFangCorporationController@pettyCashList')
		->name('pettyCashListDongFang')
		->middleware(['cashier']);

	Route::post(
		'/dong-fang-corporation/petty-cash/add',
		'DongFangCorporationController@addPettyCash')
		->name('addPettyCash')
		->middleware(['cashier']);

	Route::get(
		'/dong-fang-corporation/edit-petty-cash/{id}',
		'DongFangCorporationController@editPettyCash')
		->name('editPettyCashDongFang')
		->middleware(['cashier']);

	Route::patch(
		'/dong-fang-corporation/update/{id}',
		'DongFangCorporationController@updatePC')
		->name('updatePCDongFang')
		->middleware(['cashier']);

	Route::post(
		'/dong-fang-corporation/add-new-petty-cash/{id}',
		'DongFangCorporationController@addNewPettyCash')
		->name('addNewPettyCashDongFang')
		->middleware(['cashier']);

	Route::patch(
		'/dong-fang-corporation/update-petty-cash/{id}',
		'DongFangCorporationController@updatePettyCash')
		->name('updatePettycashDongFang')
		->middleware(['cashier']);

	Route::delete(
		'/dong-fang-corporation/petty-cash/delete/{id}',
		'DongFangCorporationController@destroyPettyCash')
		->name('destroyPettyCash')
		->middleware(['cashier']);

	Route::get(
		'/dong-fang-corporation/petty-cash/view/{id}',
		'DongFangCorporationController@viewPettyCash')
		->name('viewPettyCash')
		->middleware(['cashier']);

	Route::get(
		'/dong-fang-corporation/printPettyCash/{id}',
		'DongFangCorporationController@printPettyCash')
		->name('printPettyCash')
		->middleware(['cashier']);


	Route::get(
		'/dong-fang-corporation/suppliers',
		'DongFangCorporationController@supplier')
		->name('supplier')
		->middleware(['cashier']);

	Route::post(
		'/dong-fang-corporation/supplier/add',
		'DongFangCorporationController@addSupplier')
		->name('addSupplier')
		->middleware(['cashier']);

	Route::get(
		'/dong-fang-corporation/suppliers/view/{id}',
		'DongFangCorporationController@viewSupplier')
		->name('viewSupplier')
		->middleware(['cashier']);

	Route::get(
		'/dong-fang-corporation/supplier/print/{id}',
		'DongFangCorporationController@printSupplier')
		->name('printSupplier')
		->middleware(['cashier']);

	//WLG Corporation
	Route::get(
		'/wlg-corporation',
		'WlgCorporationController@index')
		->name('indexWlg')
		->middleware(['cashier']);
	
	Route::get(
		'/wlg-corporation/pro-forma-invoice/lists',
		'WlgCorporationController@index')
		->name('indexProFormaWlg')
		->middleware(['cashier']);
	
	Route::get(
		'/wlg-corporation/commercial-invoice/lists',
		'WlgCorporationController@index')
		->name('indexCommercialInvoice')
		->middleware(['cashier']);

	Route::get(
		'/wlg-corporation/quotation-invoice/lists',
		'WlgCorporationController@index')
		->name('indexQuotation')
		->middleware(['cashier']);
	
	Route::get(
		'/wlg-corporation/packing-list/lists',
		'WlgCorporationController@index')
		->name('indexPackingList')
		->middleware(['cashier']);
		
	Route::get(
		'/wlg-corporation/payment-voucher-form',
		'WlgCorporationController@paymentVoucherForm')
		->name('paymentVoucherFormWlg')
		->middleware(['cashier']);

	Route::post(
		'/wlg-corporation/payment-voucher-store',
		'WlgCorporationController@paymentVoucherStore')
		->name('paymentVoucherStoreWlg')
		->middleware(['cashier']);

	Route::get(
		'/wlg-corporation/edit-wlg-corporation-payables-detail/{id}',
		'WlgCorporationController@editPayablesDetail')
		->name('editPayablesDetailWlg')
		->middleware(['cashier']);

	Route::patch(
		'/wlg-corporation/payables/update-particulars/{id}',
		'WlgCorporationController@updateParticulars')
		->name('updateParticulars')
		->middleware(['cashier']);

	Route::patch(
		'/wlg-corporation/payables/updateP/{id}',
		'WlgCorporationController@updateP')
		->name('updateP')
		->middleware(['cashier']);

	Route::patch(
		'/wlg-corporation/payables/update-check/{id}',
		'WlgCorporationController@updateCheck')
		->name('updateCheck')
		->middleware(['cashier']);

	Route::patch(
		'/wlg-corporation/payables/update-cash/{id}',
		'WlgCorporationController@updateCash')
		->name('updateCash')
		->middleware(['cashier']);

	Route::patch(
		'/wlg-corporation/payables/update-details/{id}',
		'WlgCorporationController@updateDetails')
		->name('updateDetails')
		->middleware(['cashier']);

	Route::post(
		'/wlg-corporation/add-particulars/{id}',
		'WlgCorporationController@addParticulars')
		->name('addParticularsWlg')
		->middleware(['cashier']);

	Route::patch(
		'/wlg-corporation/accept/{id}',
		'WlgCorporationController@accept')
		->name('acceptWlg')
		->middleware(['cashier']);

	Route::post(
		'/wlg-corporation/add-payment/{id}',
		'WlgCorporationController@addPayment')
		->name('addPaymentWlg')
		->middleware(['cashier']);
	
	Route::get(
		'/wlg-corporation/payables/transaction-list',
		'WlgCorporationController@transactionList')
		->name('transactionListWlg')
		->middleware(['cashier']);

	Route::delete(
		'/wlg-corporation/delete-transaction-list/{id}',
		'WlgCorporationController@destroyTransaction')
		->name('destroyTransactionWlg')
		->middleware(['cashier']);

	Route::get(
		'/wlg-corporation/view-wlg-corporation-payables-details/{id}',
		'WlgCorporationController@viewPayableDetails')
		->name('viewPayableDetailsWlg')
		->middleware(['cashier']);

	Route::get(
		'/wlg-corporation/printPayables/{id}',
		'WlgCorporationController@printPayablesWlg')
		->name('printPayablesWlg')
		->middleware(['cashier']);

	Route::get(
		'/wlg-corporation/summary-report',
		'WlgCorporationController@summaryReport')
		->name('summaryReport')
		->middleware(['cashier']);

	Route::get(
		'/wlg-corporation/search-multiple-date',
		'WlgCorporationController@getSummaryReportMultiple')
		->name('getSummaryReportMultiple')
		->middleware(['cashier']);

	Route::get(
		'/wlg-corporation/printMultipleSummary/{date}',
		'WlgCorporationController@printMultipleSummary')
		->name('printMultipleSummary')
		->middleware(['cashier']);

	Route::get(
		'/wlg-corporation/summary-report/search-number-code',
		'WlgCorporationController@searchNumberCode')
		->name('searchNumberCode')
		->middleware(['cashier']);

	Route::get(
		'/wlg-corporation/search',
		'WlgCorporationController@search')
		->name('search')
		->middleware(['cashier']);

	Route::get(
		'/wlg-corporation/printSummary',
		'WlgCorporationController@printSummary')
		->name('printSummary')
		->middleware(['cashier']);

	Route::get(
		'/wlg-corporation/search-date',
		'WlgCorporationController@getSummaryReport')
		->name('getSummaryReport')
		->middleware(['cashier']);

	Route::get(
		'/wlg-corporation/printGetSummary/{date}',
		'WlgCorporationController@printGetSummary')
		->name('printGetSummary')
		->middleware(['cashier']);

	Route::get(
		'/wlg-corporation/purchase-order',
		'WlgCorporationController@purchaseOrderForm')
		->name('purchaseOrderFormWlg')
		->middleware(['cashier']);

	Route::post(
		'/wlg-corporation/store',
		'WlgCorporationController@store')
		->name('storeWlg')
		->middleware(['cashier']);

	Route::get(
		'/wlg-corporation/edit-wlg-corporation-purchase-order/{id}',
		'WlgCorporationController@edit')
		->name('editWlg')
		->middleware(['cashier']);

	Route::post(
		'/wlg-corporation/add-new-particulars/{id}',
		'WlgCorporationController@addNewParticulars')
		->name('addNewParticularsWlg')
		->middleware(['cashier']);
	
	Route::patch(
		'/wlg-corporation/update-po/{id}',
		'WlgCorporationController@updatePo')
		->name('updatePoWlg')
		->middleware(['cashier']);

	Route::delete(
		'/wlg-corporation/delete/{id}',
		'WlgCorporationController@destroy')
		->name('destroyWlg')
		->middleware(['cashier']);

	Route::get(
		'/wlg-corporation/purchase-order-lists',
		'WlgCorporationController@purchaseOrderAllLists')
		->name('purchaseOrderAllListsWlg')
		->middleware(['cashier']);
	
	Route::get(
		'/wlg-corporation/view-wlg-corporation-purchase-order/{id}',
		'WlgCorporationController@show')
		->name('showWlg')
		->middleware(['cashier']);
	
	Route::get(
		'/wlg-corporation/printPurchaseOrder/{id}',
		'WlgCorporationController@printPO')
		->name('printPOWlg')
		->middleware(['cashier']);

	Route::get(
		'/wlg-corporation/petty-cash-list',
		'WlgCorporationController@pettyCashList')
		->name('pettyCashList')
		->middleware(['cashier']);

	Route::post(
		'/wlg-corporation/petty-cash/add',
		'WlgCorporationController@addPettyCash')
		->name('addPettyCashWlg')
		->middleware(['cashier']);

	Route::get(
		'/wlg-corporation/edit-petty-cash/{id}',
		'WlgCorporationController@editPettyCash')
		->name('editPettyCashWLG')
		->middleware(['cashier']);

	Route::patch(
		'/wlg-corporation/update-petty-cash/{id}',
		'WlgCorporationController@updatePettyCash')
		->name('updatePettyCashWLG')
		->middleware(['cashier']);

	Route::post(
		'/wlg-corporation/add-new-petty-cash/{id}',
		'WlgCorporationController@addNewPettyCash')
		->name('addNewPettyCashWLG')
		->middleware(['cashier']);

	Route::delete(
		'/wlg-corporation/petty-cash/delete/{id}',
		'WlgCorporationController@destroyPettyCash')
		->name('destroyPettyCash')
		->middleware(['cashier']);

	Route::get(
		'/wlg-corporation/petty-cash/view/{id}',
		'WlgCorporationController@viewPettyCash')
		->name('viewPettyCashWLG')
		->middleware(['cashier']);

	Route::get(
		'/wlg-corporaton/printPettyCash/{id}',
		'WlgCorporationController@printPettyCash')
		->name('printPettyCash')
		->middleware(['cashier']);
		
	Route::get(
		'/wlg-corporation/invoice-form',
		'WlgCorporationController@invoiceForm')
		->name('invoiceFormWlg')
		->middleware(['cashier']);

	Route::get(
			'/wlg-corporation/pro-forma-invoice',
			'WlgCorporationController@invoiceForm')
			->name('invoiceFormProForma')
			->middleware(['cashier']);

	Route::get(
		'/wlg-corporation/commercial-invoice',
		'WlgCorporationController@invoiceForm')
		->name('invoiceFormCommercial')
		->middleware(['cashier']);

	Route::get(
		'/wlg-corporation/quotation-invoice',
		'WlgCorporationController@invoiceForm')
		->name('invoiceFormQuotation')
		->middleware(['cashier']);
	
	Route::get(
		'/wlg-corporation/packing-list',
		'WlgCorporationController@invoiceForm')
		->name('invoiceFormPackingList')
		->middleware(['cashier']);

	Route::post(
		'/wlg-corporation/add-invoice',
		'WlgCorporationController@addInvoice')
		->name('addInvoiceWlg')
		->middleware(['cashier']);

	Route::post(
		'/wlg-corporation/add-pro-forma-invoice',
		'WlgCorporationController@addProFormaInvoice')
		->name('addProFormaInvoiceWlf')
		->middleware(['cashier']);

	Route::post(
		'/wlg-corporation/add-commercial-invoice',
		'WlgCorporationController@addCommercialInvoice')
		->name('addCommercialInvoiceWlg')
		->middleware(['cashier']);

	
	Route::post(
		'/wlg-corporation/add-quotation-invoice',
		'WlgCorporationController@addQuotationInvoice')
		->name('addQuotationInvoiceWlg')
		->middleware(['cashier']);
	
	Route::post(
		'/wlg-corporation/add-packing-list',
		'WlgCorporationController@addPackingList')
		->name('addPackingListWlg')
		->middleware(['cashier']);

	Route::get(
		'/wlg-corporation/edit-invoice/{id}',
		'WlgCorporationController@editInvoice')
		->name('editInvoiceWlg')
		->middleware(['cashier']);

	Route::get(
		'/wlg-corporation/edit-pro-forma-invoice/{id}',
		'WlgCorporationController@editInvoiceProForma')
		->name('editInvoiceProForma')
		->middleware(['cashier']);

	Route::get(
		'/wlg-corporation/edit-commercial-invoice/{id}',
		'WlgCorporationController@editCommercialInvoice')
		->name('editCommercialInvoiceWlg')
		->middleware(['cashier']);

	Route::get(
		'/wlg-corporation/edit-quotation-invoice/{id}',
		'WlgCorporationController@editQuotationInvoice')
		->name('editQuotationInvoiceWlg')
		->middleware(['cashier']);

	Route::get(
		'/wlg-corporation/edit-packing-list/{id}',
		'WlgCorporationController@editPackingList')
		->name('editPackingListWlg')
		->middleware(['cashier']);
	
	Route::post(
		'/wlg-corporation/add-new/{id}',
		'WlgCorporationController@addNewInvoice')
		->name('addNewInvoiceWlg')
		->middleware(['cashier']);
	
	Route::post(
		'/wlg-corporation/add-new-pro-forma/{id}',
		'WlgCorporationController@addNewInvoiceProForma')
		->name('addNewInvoiceProFormaWlg')
		->middleware(['cashier']);

	Route::post(
		'/wlg-corporation/add-new-commerical-invoice/{id}',
		'WlgCorporationController@addNewCommercialInvoice')
		->name('addNewCommercialInvoiceWlg')
		->middleware(['cashier']);
	
	Route::post(
		'/wlg-corporation/add-new-quotation-invoice/{id}',
		'WlgCorporationController@addNewQuotation')
		->name('addNewQuotationWlg')
		->middleware(['cashier']);
	
	Route::post(
		'/wlg-corporation/add-new-packing-list/{id}',
		'WlgCorporationController@addNewPackingList')
		->name('addNewPackingListWlg')
		->middleware(['cashier']);
	

	Route::patch(
		'/wlg-corporation/update-invoice/{id}',
		'WlgCorporationController@updateIF')
		->name('updateIFWlg')
		->middleware(['cashier']);

	Route::patch(
		'/wlg-corporation/update-invoice-pro-forma/{id}',
		'WlgCorporationController@updateProForma')
		->name('updateProFormaWlg')
		->middleware(['cashier']);

	Route::patch(
		'/wlg-corporation/update-commercial-invoice/{id}',
		'WlgCorporationController@updateCommercialInvoice')
		->name('updateCommercialInvoiceWlg')
		->middleware(['cashier']);

	Route::patch(
		'/wlg-corporation/update-quotation-invoice/{id}',
		'WlgCorporationController@updateQuotation')
		->name('updateQuotationWlg')
		->middleware(['cashier']);
	
	Route::patch(
		'/wlg-corporation/update-packing-list/{id}',
		'WlgCorporationController@updatePackingList')
		->name('updatePackingListWlg')
		->middleware(['cashier']);
	
	Route::delete(
		'/wlg-corporation/invoice/delete/{id}',
		'WlgCorporationController@destroyInvoice')
		->name('destroyInvoiceWlg')
		->middleware(['cashier']);

	Route::get(
		'/wlg-corporation/view-invoice/{id}',
		'WlgCorporationController@viewInvoice')
		->name('viewInvoiceWlg')
		->middleware(['cashier']);

	Route::get(
		'/wlg-corporation/view-pro-forma-invoice/{id}',
		'WlgCorporationController@viewInvoice')
		->name('viewInvoiceProForma')
		->middleware(['cashier']);

	Route::get(
		'/wlg-corporation/view-commercial-invoice/{id}',
		'WlgCorporationController@viewInvoice')
		->name('viewInvoiceCommercialInvoice')
		->middleware(['cashier']);

	Route::get(
		'/wlg-corporation/view-quotation-invoice/{id}',
		'WlgCorporationController@viewInvoice')
		->name('viewInvoiceQuotation')
		->middleware(['cashier']);

	Route::get(
		'/wlg-corporation/view-packing-list/{id}',
		'WlgCorporationController@viewInvoice')
		->name('viewInvoicePackingList')
		->middleware(['cashier']);


	Route::get(
		'/wlg-corporation/suppliers',
		'WlgCorporationController@supplier')
		->name('supplier')
		->middleware(['cashier']);

	Route::post(
		'/wlg-corporation/supplier/add',
		'WlgCorporationController@addSupplier')
		->name('addSupplier')
		->middleware(['cashier']);

	Route::get(
		'/wlg-corporation/suppliers/view/{id}',
		'WlgCorporationController@viewSupplier')
		->name('viewSupplier')
		->middleware(['cashier']);

	Route::get(
		'/wlg-corporation/supplier/print/{id}',
		'WlgCorporationController@printSupplier')
		->name('printSupplier')
		->middleware(['cashier']);

	//DINO Industrial Corporation
	Route::get(
		'/dino-industrial-corporation',
		'DinoIndustrialCorporationController@index')
		->name('indexDino')
		->middleware(['cashier']);

	Route::get(
		'/dino-industrial-corporation/payment-voucher-form',
		'DinoIndustrialCorporationController@paymentVoucherForm')
		->name('paymentVoucherFormDinoIndustrial')
		->middleware(['cashier']);

	Route::post(
		'/dino-industrial-corporation/payment-voucher-store',
		'DinoIndustrialCorporationController@paymentVoucherStore')
		->name('paymentVoucherStoreDinoIndustrial')
		->middleware(['cashier']);

	Route::get(
		'/dino-industrial-corporation/edit-dino-industrial-payables-detail/{id}',
		'DinoIndustrialCorporationController@editPayablesDetail')
		->name('editPayablesDetailDinoIndustrial')
		->middleware(['cashier']);

	Route::patch(
		'/dino-industrial-corporation/payables/update-particulars/{id}',
		'DinoIndustrialCorporationController@updateParticulars')
		->name('updateParticulars')
		->middleware(['cashier']);

	Route::patch(
		'/dino-industrial-corporation/payables/updateP/{id}',
		'DinoIndustrialCorporationController@updateP')
		->name('updateP')
		->middleware(['cashier']);

	Route::patch(
		'/dino-industrial-corporation/payables/update-check/{id}',
		'DinoIndustrialCorporationController@updateCheck')
		->name('updateCheck')
		->middleware(['cashier']);

	Route::patch(
		'/dino-industrial-corporation/payables/update-cash/{id}',
		'DinoIndustrialCorporationController@updateCash')
		->name('updateCash')
		->middleware(['cashier']);

	Route::patch(
		'/dino-industrial-corporation/payables/update-details/{id}',
		'DinoIndustrialCorporationController@updateDetails')
		->name('updateDetails')
		->middleware(['cashier']);

	Route::get(
		'/dino-industrial-corporation/view-dino-industrial-payables-details/{id}',
		'DinoIndustrialCorporationController@viewPayableDetails')
		->name('viewPayableDetails')
		->middleware(['cashier']);

	Route::get(
		'/dino-industrial-corporation/printPayables/{id}',
		'DinoIndustrialCorporationController@printPayables')
		->name('printPayables')
		->middleware(['cashier']);
	
	Route::get(
		'/dino-industrial-corporation/payables/transaction-list',
		'DinoIndustrialCorporationController@transactionList')
		->name('transactionListDinoIndustrial')
		->middleware(['cashier']);

	Route::delete(
		'/dino-industrial-corporation/delete-transaction-list/{id}',
		'DinoIndustrialCorporationController@destroyTransactionList')
		->name('destroyTransactionList')
		->middleware(['cashier']);
	
	Route::get(
		'/dino-industrial-corporation/summary-report',
		'DinoIndustrialCorporationController@summaryReport')
		->name('summaryReport')
		->middleware(['cashier']);

	Route::get(
		'/dino-industrial-corporation/search-multiple-date',
		'DinoIndustrialCorporationController@getSummaryReportMultiple')
		->name('getSummaryReportMultiple')
		->middleware(['cashier']);

	Route::get(
		'/dino-industrial-corporation/printMultipleSummary/{date}',
		'DinoIndustrialCorporationController@printMultipleSummary')
		->name('printMultipleSummary')
		->middleware(['cashier']);

	Route::get(
		'/dino-industrial-corporation/summary-report/search-number-code',
		'DinoIndustrialCorporationController@searchNumberCode')
		->name('searchNumberCode')
		->middleware(['cashier']);

	Route::get(
		'/dino-industrial-corporation/search',
		'DinoIndustrialCorporationController@search')
		->name('search')
		->middleware(['cashier']);

	Route::get(
		'/dino-industrial-corporation/printSummary',
		'DinoIndustrialCorporationController@printSummary')
		->name('printSummary')
		->middleware(['cashier']);

	Route::get(
		'/dino-industrial-corporation/search-date',
		'DinoIndustrialCorporationController@getSummaryReport')
		->name('getSummaryReport')
		->middleware(['cashier']);

	Route::get(
		'/dino-industrial-corporation/printGetSummary/{date}',
		'DinoIndustrialCorporationController@printGetSummary')
		->name('printGetSummary')
		->middleware(['cashier']);

	Route::post(
		'/dino-industrial-corporation/add-particulars/{id}',
		'DinoIndustrialCorporationController@addParticulars')
		->name('addParticularsDinoIndustrial')
		->middleware(['cashier']);

	Route::post(
		'/dino-industrial-corporation/add-payment/{id}',
		'DinoIndustrialCorporationController@addPayment')
		->name('addPaymentDinoIndustrial')
		->middleware(['cashier']);

	Route::patch(
		'/dino-industrial-corporation/accept/{id}',
		'DinoIndustrialCorporationController@accept')
		->name('acceptDinoIndustrial')
		->middleware(['cashier']);

	Route::get(
		'/dino-industrial-corporation/suppliers',
		'DinoIndustrialCorporationController@supplier')
		->name('supplier')
		->middleware(['cashier']);

	Route::post(
		'/dino-industrial-corporation/supplier/add',
		'DinoIndustrialCorporationController@addSupplier')
		->name('addSupplier')
		->middleware(['cashier']);

	Route::get(
		'/dino-industrial-corporation/suppliers/view/{id}',
		'DinoIndustrialCorporationController@viewSupplier')
		->name('viewSupplier')
		->middleware(['cashier']);

	Route::get(
		'/dino-industrial-corporation/supplier/print/{id}',
		'DinoIndustrialCorporationController@printSupplier')
		->name('printSupplier')
		->middleware(['cashier']);

	/*********************************************
	 * LOCAL GROUND
	 * 
	 */
	Route::get(
		'/local-ground',
		'LocalGroundController@index')
		->name('index')
		->middleware(['cashier']);

	Route::get(
		'/local-ground/payment-voucher-form',
		'LocalGroundController@paymentVoucherForm')
		->name('paymentVoucherForm')
		->middleware(['cashier']);

	Route::post(
		'/local-ground/payment-voucher-store',
		'LocalGroundController@paymentVoucherStore')
		->name('paymentVoucherStoreLocalGround')
		->middleware(['cashier']);

	Route::get(
		'/local-ground/edit-local-ground-payables-details/{id}',
		'LocalGroundController@editPayablesDetail')
		->name('editPayablesDetailLocalGround')
		->middleware(['cashier']);

	Route::patch(
		'/local-ground/payables/update-particulars/{id}',
		'LocalGroundController@updateParticulars')
		->name('updateParticulars')
		->middleware(['cashier']);

	Route::patch(
		'/local-ground/payables/updateP/{id}',
		'LocalGroundController@updateP')
		->name('updateP')
		->middleware(['cashier']);

	Route::patch(
		'/local-ground/payables/update-check/{id}',
		'LocalGroundController@updateCheck')
		->name('updateCheck')
		->middleware(['cashier']);

	Route::patch(
		'/local-ground/payables/update-cash/{id}',
		'LocalGroundController@updateCash')
		->name('updateCash')
		->middleware(['cashier']);

	Route::patch(
		'/local-ground/payables/update-details/{id}',
		'LocalGroundController@updateDetails')
		->name('updateDetails')
		->middleware(['cashier']);

	Route::post(
		'/local-ground/add-payment/{id}',
		'LocalGroundController@addPayment')
		->name('addPaymentLocalGround')
		->middleware(['cashier']);

	Route::post(
		'/local-ground/add-particulars/{id}',
		'LocalGroundController@addParticulars')
		->name('addParticularsLocalGround')
		->middleware(['cashier']);

	Route::patch(
		'/local-ground/accept/{id}',
		'LocalGroundController@accept')
		->name('acceptLocalGround')
		->middleware(['cashier']);

	Route::get(
		'/local-ground/payables/transaction-list',
		'LocalGroundController@transactionList')
		->name('transactionList')
		->middleware(['cashier']);

	Route::delete(
		'/local-ground/delete-transaction-list/{id}',
		'LocalGroundController@destroyTransaction')
		->name('destroyTransaction')
		->middleware(['cashier']);

	Route::get(
		'/local-ground/view-local-ground-payables-details/{id}',
		'LocalGroundController@viewPayableDetails')
		->name('viewPayableDetailsLocalGround')
		->middleware(['cashier']);

	Route::get(
		'/local-ground/printPayables/{id}',
		'LocalGroundController@printPayables')
		->name('printPayablesLocalGround')
		->middleware(['cashier']);

	Route::get(
		'/local-ground/summary-report',
		'LocalGroundController@summaryReport')
		->name('summaryReport')
		->middleware(['cashier']);

	Route::get(
		'/local-ground/search-date',
		'LocalGroundController@getSummaryReport')
		->name('getSummaryReport')
		->middleware(['cashier']);

	Route::get(
		'/local-ground/printSummary',
		'LocalGroundController@printSummary')
		->name('printSummary')
		->middleware(['cashier']);

	Route::get(
		'/local-ground/search-multiple-date',
		'LocalGroundController@getSummaryReportMultiple')
		->name('getSummaryReportMultiple')
		->middleware(['cashier']);

	Route::get(
		'/local-ground/printMultipleSummary/{date}',
		'LocalGroundController@printMultipleSummary')
		->name('printMultipleSummary')
		->middleware(['cashier']);

	Route::get(
		'/local-ground/printGetSummary/{date}',
		'LocalGroundController@printGetSummary')
		->name('printGetSummary')
		->middleware(['cashier']);


	Route::get(
		'/local-ground/suppliers',
		'LocalGroundController@supplier')
		->name('supplier')
		->middleware(['cashier']);

	Route::post(
		'/local-ground/supplier/add',
		'LocalGroundController@addSupplier')
		->name('addSupplier')
		->middleware(['cashier']);

	Route::get(
		'/local-ground/suppliers/view/{id}',
		'LocalGroundController@viewSupplier')
		->name('viewSupplier')
		->middleware(['cashier']);

	Route::get(
		'/local-ground/supplier/print/{id}',
		'LocalGroundController@printSupplier')
		->name('printSupplier')
		->middleware(['cashier']);

	/*
	/ DNO HOLDINGS & CO
	/
	*/

	Route::get(
		'/dno-holdings-co',
		'DnoHoldingsCoController@index')
		->name('indexDnoHolding')
		->middleware(['cashier']);

	Route::get(
		'/dno-holdings-co/purchase-order',
		'DnoHoldingsCoController@purchaseOrder')
		->name('purchaseOrder')
		->middleware(['cashier']);

	Route::post(
		'/dno-holdings-co/store',
		'DnoHoldingsCoController@store')
		->name('store')
		->middleware(['cashier']);

	Route::get(
		'/dno-holdings-co/{id}/edit',
		'DnoHoldingsCoController@edit')
		->name('editDnoHoldingsCo')
		->middleware(['cashier']);
		

	Route::post(
		'/dno-holdings-co/{id}/add-new-purchase',
		'DnoHoldingsCoController@addNewPurchaseOrder')
		->name('addNewPurchaseOrder')
		->middleware(['cashier']);

	Route::put(
		'/dno-holdings-co/{id}/update-po',
		'DnoHoldingsCoController@updatePo')
		->name('updatePo')
		->middleware(['cashier']);

	Route::delete(
		'/dno-holings-co/delete/{id}',
		'DnoHoldingsCoController@destroy')
		->name('destroy')
		->middleware(['cashier']);

	Route::get(
		'/dno-holdings-co/purchase-order-lists',
		'DnoHoldingsCoController@purchaseOrderList')
		->name('purchaseOrderList')
		->middleware(['cashier']);

	Route::delete(
		'/dno-holdings-co/delete/PO/{id}',
		'DnoHoldingsCoController@destroyPO')
		->name('destroyPO')
		->middleware(['cashier']);

	Route::get(
		'/dno-holdings-co/{id}/view',
		'DnoHoldingsCoController@show')
		->name('show')
		->middleware(['cashier']);

	Route::get(
		'/dno-holdings-co/{id}/printPO',
		'DnoHoldingsCoController@printPO')
		->name('printPO')
		->middleware(['cashier']);

	Route::get(
		'/dno-holdings-co/petty-cash-list',
		'DnoHoldingsCoController@pettyCashList')
		->name('pettyCashList')
		->middleware(['cashier']);

	Route::post(
		'/dno-holdings-co/petty-cash/add',
		'DnoHoldingsCoController@addPettyCash')
		->name('addPettyCash')
		->middleware(['cashier']);

	Route::get(
		'/dno-holdings-co/{id}/edit-petty-cash/',
		'DnoHoldingsCoController@editPettyCash')
		->name('editPettyCashDnoHoldingsCo')
		->middleware(['cashier']);

	Route::delete(
		'/dno-holdings-co/petty-cash/delete/{id}',
		'DnoHoldingsCoController@destroyPettyCash')
		->name('destroyPettyCash')
		->middleware(['cashier']);

	Route::put(
		'/dno-holdings-co/{id}/update-pc',
		'DnoHoldingsCoController@updatePC')
		->name('updatePC')
		->middleware(['cashier']);

	Route::post(
		'/dno-holdings-co/{id}/add-new-petty-cash',
		'DnoHoldingsCoController@addNewPettyCash')
		->name('addNewPettyCash')
		->middleware(['cashier']);

	Route::put(
		'/dno-holdings-co/{id}/update-petty-cash',
		'DnoHoldingsCoController@updatePettyCash')
		->name('updatePettyCash')
		->middleware(['cashier']);

	Route::get(
		'/dno-holdings-co/petty-cash/{id}/view',
		'DnoHoldingsCoController@viewPettyCash')
		->name('viewPettyCash')
		->middleware(['cashier']);

	Route::get(
		'/dno-holdings-co/petty-cash/{id}/print',
		'DnoHoldingsCoController@printPettyCash')
		->name('printPettyCash')
		->middleware(['cashier']);

	Route::get(
		'/dno-holdings-co/billing-statement-form',
		'DnoHoldingsCoController@billingStatementForm')
		->name('billingStatementForm')
		->middleware(['cashier']);
	
	Route::post(
		'/dno-holdings-co/store-billing-statement',
		'DnoHoldingsCoController@storeBillingStatement')
		->name('storeBillingStatement')
		->middleware(['cashier']);

	Route::get(
		'/dno-holdings-co/{id}/edit-billing-statement',
		'DnoHoldingsCoController@editBillingStatement')
		->name('editBillingStatementDnoHoldingsCo')
		->middleware(['cashier']);

	Route::put(
		'/dno-holdings-co/{id}/update-billing-info',
		'DnoHoldingsCoController@updateBillingInfo')
		->name('updateBillingInfoDnoHoldingsCo')
		->middleware(['cashier']);

	Route::post(
		'/dno-holdings-co/{id}/add-new-billing',
		'DnoHoldingsCoController@addNewBilling')
		->name('addNewBilling')
		->middleware(['cashier']);

	Route::delete(
		'/dno-holdings-co/delete-data-billing-statement/{id}',
		'DnoHoldingsCoController@destroyBillingDataStatement')
		->name('destroyBillingDataStatement')
		->middleware(['cashier']);

	Route::get(
		'/dno-holdings-co/billing-statement-lists',
		'DnoHoldingsCoController@billingStatementList')
		->name('billingStatementList')
		->middleware(['cashier']);

	Route::delete(
		'/dno-holdings-co/delete-billing-statement/{id}',
		'DnoHoldingsCoController@destroyBillingStatement')
		->name('destroyBillingStatement')
		->middleware(['cashier']);

	Route::get(
		'/dno-holdings-co/{id}/view-billing-statement/',
		'DnoHoldingsCoController@viewBillingStatement')
		->name('viewBillingStatement')
		->middleware(['cashier']);

	Route::get(
		'/dno-holdings-co/{id}/printBillingStatement',
		'DnoHoldingsCoController@printBillingStatement')
		->name('printBillingStatement')
		->middleware(['cashier']);

	Route::get(
		'/dno-holdings-co/statement-of-account/lists',
		'DnoHoldingsCoController@statementOfAccountLists')
		->name('statementOfAccountLists')
		->middleware(['cashier']);

	Route::get(
		'/dno-holdings-co/{id}/edit-statement-of-account/',
		'DnoHoldingsCoController@editStatementAccount')
		->name('editStatementAccount')
		->middleware(['cashier']);

	Route::get(
		'/dno-holdings-co/printSOAList',
		'DnoHoldingsCoController@printSOAList')
		->name('printSOAList')
		->middleware(['cashier']);

	Route::put(
		'/dno-holdings-co/s-account/{id}',
		'DnoHoldingsCoController@sAccountUpdate')
		->name('sAccountUpdate')
		->middleware(['cashier']);

	Route::get(
		'/dno-holdings-co/{id}/view-statement-account/',
		'DnoHoldingsCoController@viewStatementAccount')
		->name('viewStatementAccount')
		->middleware(['cashier']);

	Route::get(
		'/dno-holdings-co/{id}/printSOA',
		'DnoHoldingsCoController@printSOA')
		->name('printSOA')
		->middleware(['cashier']);


	Route::get(
		'/dno-holdings-co/payment-voucher-form',
		'DnoHoldingsCoController@paymentVoucherForm')
		->name('paymentVoucherFormDnoHoldingsCo')
		->middleware(['cashier']);

	Route::post(
		'/dno-holdings-co/payment-voucher-store',
		'DnoHoldingsCoController@paymentVoucherStore')
		->name('paymentVoucherStoreDnoHoldingsCo')
		->middleware(['cashier']);


	Route::get(
		'/dno-holdings-co/edit-dno-holdings-co-payable-detail/{id}',
		'DnoHoldingsCoController@editPayablesDetail')
		->name('editPayablesDetailDnoHoldingsCo')
		->middleware(['cashier']);

	Route::post(
		'/dno-holdings-co/add-payment/{id}',
		'DnoHoldingsCoController@addPayment')
		->name('addPaymentDnoHoldingsCo')
		->middleware(['cashier']);

	Route::post(
		'/dno-holdings-co/add-particulars/{id}',
		'DnoHoldingsCoController@addParticulars')
		->name('addParticularsDnoHoldingsCo')
		->middleware(['cashier']);

	Route::patch(
		'/dno-holdings-co/payables/update-particulars/{id}',
		'DnoHoldingsCoController@updateParticulars')
		->name('updateParticulars')
		->middleware(['cashier']);

	Route::patch(
		'/dno-holdings-co/payables/updateP/{id}',
		'DnoHoldingsCoController@updateP')
		->name('updateP')
		->middleware(['cashier']);

	Route::patch(
		'/dno-holdings-co/payables/update-check/{id}',
		'DnoHoldingsCoController@updateCheck')
		->name('updateCheck')
		->middleware(['cashier']);

	Route::patch(
		'/dno-holdings-co/payables/update-cash/{id}',
		'DnoHoldingsCoController@updateCash')
		->name('updateCash')
		->middleware(['cashier']);

	Route::patch(
		'/dno-holdings-co/payables/update-details/{id}',
		'DnoHoldingsCoController@updateDetails')
		->name('updateDetails')
		->middleware(['cashier']);

	Route::patch(
		'/dno-holdings-co/accept/{id}',
		'DnoHoldingsCoController@accept')
		->name('acceptDnoHoldingsCo')
		->middleware(['cashier']);

	Route::get(
		'/dno-holdings-co/payables/transaction-list',
		'DnoHoldingsCoController@transactionList')
		->name('transactionListDnoHoldingsCo')
		->middleware(['cashier']);

	Route::get(
		'/dno-holdings-co/view-payables-details/{id}',
		'DnoHoldingsCoController@viewPayableDetails')
		->name('viewPayableDetailsDnoHoldings')
		->middleware(['cashier']);

	Route::get(
		'/dno-holdings-co/print-payables/{id}',
		'DnoHoldingsCoController@printPayablesDnoHoldingsCo')
		->name('printPayablesDnoHoldingsCo')
		->middleware(['cashier']);

	Route::delete(
		'/dno-holdings-co/delete-transaction-list/{id}',
		'DnoHoldingsCoController@destroyTransactionList')
		->name('destroyTransactionList')
		->middleware(['cashier']);


	Route::get(
		'/dno-holdings-co/suppliers',
		'DnoHoldingsCoController@supplier')
		->name('supplier')
		->middleware(['cashier']);

	Route::post(
		'/dno-holdings-co/supplier/add',
		'DnoHoldingsCoController@addSupplier')
		->name('addSupplier')
		->middleware(['cashier']);

	Route::get(
		'/dno-holdings-co/suppliers/view/{id}',
		'DnoHoldingsCoController@viewSupplier')
		->name('viewSupplier')
		->middleware(['cashier']);


	Route::get(
		'/dno-holdings-co/supplier/print/{id}',
		'DnoHoldingsCoController@printSupplier')
		->name('printSupplier')
		->middleware(['cashier']);

	Route::get(
		'/dno-holdings-co/summary-report/search-number-code',
		'DnoHoldingsCoController@searchNumberCode')
		->name('searchNumberCode')
		->middleware(['cashier']);

	Route::get(
		'/dno-holdings-co/search',
		'DnoHoldingsCoController@search')
		->name('search')
		->middleware(['cashier']);

	Route::get(
		'/dno-holdings-co/summary-report',
		'DnoHoldingsCoController@summaryReport')
		->name('summaryReport')
		->middleware(['cashier']);

	Route::get(
		'/dno-holdings-co/search-date',
		'DnoHoldingsCoController@getSummaryReport')
		->name('getSummaryReport')
		->middleware(['cashier']);

	Route::get(
		'/dno-holdings-co/search-multiple-date',
		'DnoHoldingsCoController@getSummaryReportMultiple')
		->name('getSummaryReportMultiple')
		->middleware(['cashier']);

	Route::get(
		'/dno-holdings-co/printSummary',
		'DnoHoldingsCoController@printSummary')
		->name('printSummary')
		->middleware(['cashier']);

	Route::get(
		'/dno-holdings-co/printMultipleSummary/{date}',
		'DnoHoldingsCoController@printMultipleSummary')
		->name('printMultipleSummary')
		->middleware(['cashier']);


	/**
	 * 
	 * DNO FOUNDATION INC
	 * 
	 */
	Route::get(
		'/dno-foundation-inc',
		'DnoFoundationIncController@index')
		->name('index')
		->middleware(['cashier']);

	Route::get(
		'/dno-foundation-inc/purchase-order',
		'DnoFoundationIncController@purchaseOrder')
		->name('purchaseOrder')
		->middleware(['cashier']);

	Route::post(
		'/dno-foundation-inc/store',
		'DnoFoundationIncController@store')
		->name('store')
		->middleware(['cashier']);

	Route::get(
		'/dno-foundation-inc/{id}/edit',
		'DnoFoundationIncController@edit')
		->name('editDnoFoundationInc')
		->middleware(['cashier']);

	Route::put(
		'/dno-foundation-inc/{id}/update',
		'DnoFoundationIncController@update')
		->name('update')
		->middleware(['cashier']);

	Route::post(
		'/dno-foundation-inc/{id}/add-new-purchase-order',
		'DnoFoundationIncController@addNewPurchaseOrder')
		->name('addNewPurchaseOrder')
		->middleware(['cashier']);

	Route::put(
		'/dno-foundation-inc/{id}/update-po',
		'DnoFoundationIncController@updatePo')
		->name('updatePo')
		->middleware(['cashier']);
	
	Route::delete(
		'/dno-foundation-inc/delete/{id}',
		'DnoFoundationIncController@destroy')
		->name('destroy')
		->middleware(['cashier']);

	Route::get(
		'/dno-foundation-inc/purchase-order-lists',
		'DnoFoundationIncController@purchaseOrderList')
		->name('purchaseOrderList')
		->middleware(['cashier']);
	
	Route::get(
		'/dno-foundation-inc/{id}/view',
		'DnoFoundationIncController@show')
		->name('show')
		->middleware(['cashier']);

	Route::get(
		'/dno-foundation-inc/{id}/printPO',
		'DnoFoundationIncController@printPO')
		->name('printPO')
		->middleware(['cashier']);

	Route::delete(
		'/dno-foundation-inc/delete/PO/{id}',
		'DnoFoundationIncController@destroyPO')
		->name('destroyPO')
		->middleware(['cashier']);

	Route::get(
		'/dno-foundation-inc/petty-cash-list',
		'DnoFoundationIncController@pettyCashList')
		->name('pettyCashList')
		->middleware(['cashier']);

	Route::post(
		'/dno-foundation-inc/petty-cash/add',
		'DnoFoundationIncController@addPettyCash')
		->name('addPettyCash')
		->middleware(['cashier']);

	Route::get(
		'/dno-foundation-inc/{i}/edit-petty-cash/',
		'DnoFoundationIncController@editPettyCash')
		->name('editPettyCashDnoFoundationInc')
		->middleware(['cashier']);

	Route::put(
		'/dno-foundation-inc/{id}/update-petty-cash',
		'DnoFoundationIncController@updatePettyCash')
		->name('updatePettyCash')
		->middleware(['cashier']);

	Route::post(
		'/dno-foundation-inc/{id}/add-new-petty-cash',
		'DnoFoundationIncController@addNewPettyCash')
		->name('addNewPettyCash')
		->middleware(['cashier']);

	Route::put(
		'/dno-foundation-inc/{id}/updatePC',
		'DnoFoundationIncController@updatePC')
		->name('updatePC')
		->middleware(['cashier']);

	Route::delete(
		'/dno-foundation-inc/petty-cash/delete/{id}',
		'DnoFoundationIncController@destroyPettyCash')
		->name('destroyPettyCash')
		->middleware(['cashier']);

	Route::get(
		'/dno-foundation-inc/petty-cash/{id}/view',
		'DnoFoundationIncController@viewPettyCash')
		->name('viewPettyCash')
		->middleware(['cashier']);

	Route::get(
		'/dno-foundation-inc/petty-cash/{id}/print',
		'DnoFoundationIncController@printPettyCash')
		->name('printPettyCash')
		->middleware(['cashier']);

	Route::get(
		'/dno-foundation-inc/billing-statement-form',
		'DnoFoundationIncController@billingStatementForm')
		->name('billingStatementFormDnoFoundationInc')
		->middleware(['cashier']);

	Route::post(
		'/dno-foundation-inc/store-billing-statement',
		'DnoFoundationIncController@storeBillingStatement')
		->name('storeBillingStatement')
		->middleware(['cashier']);

	Route::get(
		'/dno-foundation-inc/{id}/edit-billing-statement',
		'DnoFoundationIncController@editBillingStatement')
		->name('editBillingStatementDnoFoundationInc')
		->middleware(['cashier']);

	Route::put(
		'/dno-foundation-inc/{id}/update-billing-info',
		'DnoFoundationIncController@updateBillingInfo')
		->name('updateBillingInfo')
		->middleware(['cashier']);

	Route::post(
		'/dno-foundation-inc/{id}/add-new-billing',
		'DnoFoundationIncController@addNewBilling')
		->name('addNewBilling')
		->middleware(['cashier']);

	Route::delete(
		'/dno-foundation-inc/delete-data-billing-statement/{id}',
		'DnoFoundationIncController@destroyBillingDataStatement')
		->name('destroyBillingDataStatement')
		->middleware(['cashier']);


	Route::delete(
		'/dno-foundation-inc/delete-billing-statement/{id}',
		'DnoFoundationIncController@destroyBillingStatement')
		->name('destroyBillingStatement')
		->middleware(['cashier']);

	Route::get(
		'/dno-foundation-inc/billing-statement-lists',
		'DnoFoundationIncController@billingStatementList')
		->name('billingStatementList')
		->middleware(['cashier']);

	Route::get(
		'/dno-foundation-inc/{id}/view-billing-statement/',
		'DnoFoundationIncController@viewBillingStatement')
		->name('viewBillingStatement')
		->middleware(['cashier']);

	Route::get(
		'/dno-foundation-inc/{id}/printBillingStatement',
		'DnoFoundationIncController@printBillingStatement')
		->name('printBillingStatement')
		->middleware(['cashier']);

	Route::get(
		'/dno-foundation-inc/statement-of-account/lists',
		'DnoFoundationIncController@statementOfAccountLists')
		->name('statementOfAccountLists')
		->middleware(['cashier']);

	Route::get(
		'/dno-foundation-inc/{id}/edit-statement-of-account/',
		'DnoFoundationIncController@editStatementAccount')
		->name('editStatementAccount')
		->middleware(['cashier']);

	Route::get(
		'/dno-foundation-inc/printSOAList',
		'DnoFoundationIncController@printSOAList')
		->name('printSOAList')
		->middleware(['cashier']);

	Route::put(
		'/dno-foundation-inc/s-account/{id}',
		'DnoFoundationIncController@sAccountUpdate')
		->name('sAccountUpdate')
		->middleware(['cashier']);

	Route::get(
		'/dno-foundation-inc/{id}/view-statement-account/',
		'DnoFoundationIncController@viewStatementAccount')
		->name('viewStatementAccount')
		->middleware(['cashier']);

	Route::get(
		'/dno-foundation-inc/{id}/printSOA',
		'DnoFoundationIncController@printSOA')
		->name('printSOA')
		->middleware(['cashier']);

		
		
	Route::get(
		'/dno-foundation-inc/payment-voucher-form',
		'DnoFoundationIncController@paymentVoucherForm')
		->name('paymentVoucherFormDnoFoundationInc')
		->middleware(['cashier']);

	Route::post(
		'/dno-foundation-inc/payment-voucher-store',
		'DnoFoundationIncController@paymentVoucherStore')
		->name('paymentVoucherStore')
		->middleware(['cashier']);

	Route::get(
		'/dno-foundation-inc/edit-dno-foundation-inc-payable-detail/{id}',
		'DnoFoundationIncController@editPayablesDetail')
		->name('editPayablesDetailDnoFoundation')
		->middleware(['cashier']);

	Route::post(
		'/dno-foundation-inc/add-payment/{id}',
		'DnoFoundationIncController@addPayment')
		->name('addPayment')
		->middleware(['cashier']);

	Route::post(
		'/dno-foundation-inc/add-particulars/{id}',
		'DnoFoundationIncController@addParticulars')
		->name('addParticulars')
		->middleware(['cashier']);

	Route::patch(
		'/dno-foundation-inc/accept/{id}',
		'DnoFoundationIncController@accept')
		->name('accept')
		->middleware(['cashier']);

	Route::patch(
		'/dno-foundation-inc/payables/update-particulars/{id}',
		'DnoFoundationIncController@updateParticulars')
		->name('updateParticulars')
		->middleware(['cashier']);
	
	Route::patch(
		'/dno-foundation-inc/payables/updateP/{id}',
		'DnoFoundationIncController@updateP')
		->name('updateP')
		->middleware(['cashier']);

	Route::patch(
		'/dno-foundation-inc/payables/update-check/{id}',
		'DnoFoundationIncController@updateCheck')
		->name('updateCheck')
		->middleware(['cashier']);

	Route::patch(
		'/dno-foundation-inc/payables/update-cash/{id}',
		'DnoFoundationIncController@updateCash')
		->name('updateCash')
		->middleware(['cashier']);

	Route::patch(
		'/dno-foundation-inc/payables/update-details/{id}',
		'DnoFoundationIncController@updateDetails')
		->name('updateDetails')
		->middleware(['cashier']);

	Route::get(
		'/dno-foundation-inc/payables/transaction-list',
		'DnoFoundationIncController@transactionList')
		->name('transactionList')
		->middleware(['cashier']);

	Route::get(
		'/dno-foundation-inc/view-payables-details/{id}',
		'DnoFoundationIncController@viewPayableDetails')
		->name('viewPayableDetails');

	Route::get(
		'/dno-foundation-inc/print-payables/{id}',
		'DnoFoundationIncController@printPayablesDnoFoundationInc')
		->name('printPayablesDnoFoundationInc')
		->middleware(['cashier']);

	Route::get(
		'/dno-foundation-inc/suppliers',
		'DnoFoundationIncController@supplier')
		->name('supplier')
		->middleware(['cashier']);

	Route::post(
		'/dno-foundation-inc/supplier/add',
		'DnoFoundationIncController@addSupplier')
		->name('addSupplier')
		->middleware(['cashier']);

	Route::get(
		'/dno-foundation-inc/suppliers/view/{id}',
		'DnoFoundationIncController@viewSupplier')
		->name('viewSupplier')
		->middleware(['cashier']);

	Route::get(
		'/dno-foundation-inc/summary-report',
		'DnoFoundationIncController@summaryReport')
		->name('summaryReport')
		->middleware(['cashier']);

	Route::get(
		'/dno-foundation-inc/search-date',
		'DnoFoundationIncController@getSummaryReport')
		->name('getSummaryReport')
		->middleware(['cashier']);

	Route::get(
		'/dno-foundation-inc/search-multiple-date',
		'DnoFoundationIncController@getSummaryReportMultiple')
		->name('getSummaryReportMultiple')
		->middleware(['cashier']);

	Route::get(
		'/dno-foundation-inc/summary-report/search-number-code',
		'DnoFoundationIncController@searchNumberCode')
		->name('searchNumberCode')
		->middleware(['cashier']);

	Route::get(
		'/dno-foundation-inc/search',
		'DnoFoundationIncController@search')
		->name('search')
		->middleware(['cashier']);

	Route::get(
		'/dno-foundation-inc/printSummary',
		'DnoFoundationIncController@printSummary')
		->name('printSummary')
		->middleware(['cashier']);

	Route::get(
		'/dno-foundation-inc/printGetSummary/{date}',
		'DnoFoundationIncController@printGetSummary')
		->name('printGetSummary')
		->middleware(['cashier']);

	Route::get(
		'/dno-foundation-inc/printMultipleSummary/{date}',
		'DnoFoundationIncController@printMultipleSummary')
		->name('printMultipleSummary')
		->middleware(['cashier']);

	/*
	*
	* WIMPYS FOOD EXPRESS INC
	*
	*/

	Route::get(
		'/wimpys-food-express',
		'WimpysFoodExpressController@index')
		->name('index')
		->middleware(['cashier']);

	Route::get(
		'/wimpys-food-express/billing-statement-form',
		'WimpysFoodExpressController@billingStatementForm')
		->name('billingStatementFormWimpysFoodExp')
		->middleware(['cashier']);

	Route::post(
		'/wimpys-food-express/store-billing-statement',
		'WimpysFoodExpressController@storeBillingStatement')
		->name('storeBillingStatement')
		->middleware(['cashier']);

	Route::get(
		'/wimpys-food-express/{id}/edit-billing-statement',
		'WimpysFoodExpressController@editBillingStatement')
		->name('editBillingStatementWimpysFoodExp')
		->middleware(['cashier']);

	Route::post(
		'/wimpys-food-express/{id}/add-new-billing',
		'WimpysFoodExpressController@addNewBilling')
		->name('addNewBilling')
		->middleware(['cashier']);

	Route::put(
		'/wimpys-food-express/{id}/update-billing-info',
		'WimpysFoodExpressController@updateBillingInfo')
		->name('updateBillingInfo')
		->middleware(['cashier']);

	Route::delete(
		'/wimpys-food-express/delete-data-billing-statement/{id}',
		'WimpysFoodExpressController@destroyBillingDataStatement')
		->name('destroyBillingDataStatement')
		->middleware(['cashier']);

	Route::get(
		'/wimpys-food-express/billing-statement-lists',
		'WimpysFoodExpressController@billingStatementList')
		->name('billingStatementList')
		->middleware(['cashier']);

	Route::get(
		'/wimpys-food-express/{id}/view-billing-statement/',
		'WimpysFoodExpressController@viewBillingStatement')
		->name('viewBillingStatement')
		->middleware(['cashier']);

	Route::get(
		'/wimpys-food-express/{id}/printBillingStatement',
		'WimpysFoodExpressController@printBillingStatement')
		->name('printBillingStatement')
		->middleware(['cashier']);

	Route::get(
		'/wimpys-food-express/statement-of-account/lists',
		'WimpysFoodExpressController@statementOfAccountLists')
		->name('statementOfAccountLists')
		->middleware(['cashier']);

	Route::get(
		'/wimpys-food-express/{id}/edit-statement-of-account',
		'WimpysFoodExpressController@editStatementAccount')
		->name('editStatementAccount')
		->middleware(['cashier']);

	Route::put(
		'/wimpys-food-express/s-account/{id}',
		'WimpysFoodExpressController@sAccountUpdate')
		->name('sAccountUpdate')
		->middleware(['cashier']);

	Route::get(
		'/wimpys-food-express/{id}/view-statement-account',
		'WimpysFoodExpressController@viewStatementAccount')
		->name('viewStatementAccount')
		->middleware(['cashier']);

	Route::get(
		'/wimpys-food-express/{id}/printSOA',
		'WimpysFoodExpressController@printSOA')
		->name('printSOA')
		->middleware(['cashier']);

	Route::get(
		'/wimpys-food-express/printSOAList',
		'WimpysFoodExpressController@printSOAList')
		->name('printSOAList')
		->middleware(['cashier']);

	Route::get(
		'/wimpys-food-express/payment-voucher-form',
		'WimpysFoodExpressController@paymentVoucherForm')
		->name('paymentVoucherFormWimpys')
		->middleware(['cashier']);

	Route::post(
		'/wimpys-food-express/payment-voucher-store',
		'WimpysFoodExpressController@paymentVoucherStore')
		->name('paymentVoucherStoreWimpysFoodExpress')
		->middleware(['cashier']);

	Route::get(
		'/wimpys-food-express/{id}/edit-wimpys-food-express-payables-detail',
		'WimpysFoodExpressController@editPayablesDetail')
		->name('editPayablesDetailWimpysFoodExpress')
		->middleware(['cashier']);

	Route::post(
		'/wimpys-food-express/{id}/add-particulars',
		'WimpysFoodExpressController@addParticulars')
		->name('addParticularsWimpysFoodExpress')
		->middleware(['cashier']);

	Route::post(
		'/wimpys-food-exppress/{id}/add-payment',
		'WimpysFoodExpressController@addPayment')
		->name('addPaymentWimpysFoodExpress')
		->middleware(['cashier']);

	Route::put(
		'/wimpys-food-express/payables/update-cash/{id}',
		'WimpysFoodExpressController@updateCash')
		->name('updateCash')
		->middleware(['cashier']);

	Route::put(
		'/wimpys-food-express/payables/update-check/{id}',
		'WimpysFoodExpressController@updateCheck')
		->name('updateCheck')
		->middleware(['cashier']);

	Route::put(
		'/wimpys-food-express/payables/updateP/{id}',
		'WimpysFoodExpressController@updateP')
		->name('updateP')
		->middleware(['cashier']);

	Route::put(
		'/wimpys-food-express/payables/update-particulars/{id}',
		'WimpysFoodExpressController@updateParticulars')
		->name('updateParticulars')
		->middleware(['cashier']);

	Route::put(
		'/wimpys-food-express/payables/update-details/{id}',
		'WimpysFoodExpressController@updateDetails')
		->name('updateDetails')
		->middleware(['cashier']);

	Route::put(
		'/wimpys-food-express/{id}/accept',
		'WimpysFoodExpressController@accept')
		->name('acceptWimpysFoodExpress')
		->middleware(['cashier']);

	Route::get(
		'/wimpys-food-express/payables/transaction-list',
		'WimpysFoodExpressController@transactionList')
		->name('transactionList')
		->middleware(['cashier']);

	Route::get(
		'/wimpys-food-express/{id}/view-wimpys-food-express-payables-detail',
		'WimpysFoodExpressController@viewPayableDetails')
		->name('viewPayableDetailsWimpysFoodExpress')
		->middleware(['cashier']);

	Route::delete(
		'/wimpys-food-express/delete-transaction-list/{id}',
		'WimpysFoodExpressController@destroyTransactionList')
		->name('destroyTransactionList')
		->middleware(['cashier']);

	Route::get(
		'/wimpys-food-express/{id}/printPayables',
		'WimpysFoodExpressController@printPayables')
		->name('printPayables')
		->middleware(['cashier']);

	Route::get(
		'/wimpys-food-express/suppliers',
		'WimpysFoodExpressController@supplier')
		->name('supplier')
		->middleware(['cashier']);

	Route::post(
		'/wimpys-food-express/supplier/add',
		'WimpysFoodExpressController@addSupplier')
		->name('addSupplier')
		->middleware(['cashier']);

	Route::get(
		'/wimpys-food-express/suppliers/{id}/view',
		'WimpysFoodExpressController@viewSupplier')
		->name('viewSupplier')
		->middleware(['cashier']);

	Route::get(
		'/wimpys-food-express/supplier/{id}/print',
		'WimpysFoodExpressController@printSupplier')
		->name('printSupplier')
		->middleware(['cashier']);

	Route::get(
		'/wimpys-food-express/purchase-order',
		'WimpysFoodExpressController@purchaseOrder')
		->name('purchaseOrder')
		->middleware(['cashier']);

	Route::post(
		'/wimpys-food-express/store',
		'WimpysFoodExpressController@store')
		->name('store')
		->middleware(['cashier']);

	Route::get(
		'/wimpys-food-express/{id}/edit',
		'WimpysFoodExpressController@edit')
		->name('editWimpysFoodExpress')
		->middleware(['cashier']);

	Route::post(
		'/wimpys-food-express/{id}/add-new-purchase-order',
		'WimpysFoodExpressController@addNewPurchaseOrder')
		->name('addNewPurchaseOrder')
		->middleware(['cashier']);

	Route::put(
		'/wimpys-food-express/{id}/update-po',
		'WimpysFoodExpressController@updatePo')
		->name('updatePo')
		->middleware(['cashier']);

	Route::delete(
		'/wimpys-food-express/delete/{id}',
		'WimpysFoodExpressController@destroy')
		->name('destroy')
		->middleware(['cashier']);

	Route::get(
		'/wimpys-food-express/purchase-order-lists',
		'WimpysFoodExpressController@purchaseOrderList')
		->name('purchaseOrderList')
		->middleware(['cashier']);

	Route::get(
		'/wimpys-food-express/{id}/view',
		'WimpysFoodExpressController@show')
		->name('show')
		->middleware(['cashier']);

	Route::get(
		'/wimpys-food-express/{id}/printPo',
		'WimpysFoodExpressController@printPO')
		->name('printPO')
		->middleware(['cashier']);

	Route::delete(
		'/wimpys-food-express/delete/PO/{id}',
		'WimpysFoodExpressController@destroyPO')
		->name('destroyPO')
		->middleware(['cashier']);
});



