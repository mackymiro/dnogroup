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

	//delete for lechon de cebu purchase order
	Route::delete('/lolo-pinoy-lechon-de-cebu/delete/{id}', 'LoloPinoyLechonDeCebuController@destroy')->name('lolo-pinoy-lechon-de-cebu.destroy');

	//delete for lechon de cebu billint statement
	Route::delete('/lolo-pinoy-lechon-de-cebu/delete-billing-statement/{id}', 'LoloPinoyLechonDeCebuController@destroyBillingStatement')->name('lolo-pinoy-lechon-de-cebu.destroyBillingStatement');

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

	//update statement of account info
	Route::patch('/lolo-pinoy-lechon-de-cebu/update-statement-info/{id}', 'LoloPinoyLechonDeCebuController@updateStatementInfo')->name('lolo-pinoy-lechon-de-cebu.updateStatementInfo');

	//update add statement information
	Route::patch('lolo-pinoy-lechon-de-cebu/update-added-statement/{id}', 'LoloPinoyLechonDeCebuController@updateAddStatement')->name('lolo-pinoy-lechon-de-cebu.updateAddStatement');

	//delete statement of account
	Route::delete('/lolo-pinoy-lechon-de-cebu/delete-statement-account/{id}', 'LoloPinoyLechonDeCebuController@destroyStatementAddAccount')->name('lolo-pinoy-lechon-de-cebu.deleteStatementAddAccount');

	//view statement of account
	Route::get('/lolo-pinoy-lechon-de-cebu/view-statement-account/{id}', 'LoloPinoyLechonDeCebuController@viewStatementAccount')->name('lolo-pinoy-lechon-de-cebu.viewStatementAccount');

	//route for commissary stocks inventory
	Route::get('/lolo-pinoy-lechon-de-cebu/commissary/stocks-inventory', 'LoloPinoyLechonDeCebuController@stocksInventory')->name('lolo-pinoy-lechon-de-cebu.stocksInventory');


	//route for payment vouchers
	Route::get('/lolo-pinoy-lechon-de-cebu/payment-voucher-form', 'LoloPinoyLechonDeCebuController@paymentVoucherForm')->name('lolo-pinoy-lechon-de-cebu.paymentVoucherForm');

	//route for payment vouchers store
	Route::post('/lolo-pinoy-lechon-de-cebu/payment-voucher-store', 'LoloPinoyLechonDeCebuController@paymentVoucherStore')->name('lolo-pinoy-lechon-de-cebu.paymnentVoucherStore');


	//route for edit payment vouchers
	Route::get('/lolo-pinoy-lechon-de-cebu/edit-payment-voucher/{id}', 'LoloPinoyLechonDeCebuController@editPaymentVoucher')->name('lolo-pinoy-lechon-de-cebu.editPaymentVoucher');

	//route update payment vouhcer
	Route::patch('/lolo-pinoy-lechon-de-cebu/update-payment-voucher/{id}', 'LoloPinoyLechonDeCebuController@updatePaymentVoucher')->name('lolo-pinoy-lechon-de-cebu.updatePaymentVoucher');

	//Route for add new payment voucher
	Route::get('/lolo-pinoy-lechon-de-cebu/add-new-payment-voucher/{id}', 'LoloPinoyLechonDeCebuController@addNewPaymentVoucher')->name('lolo-pinoy-lechon-de-cebu.addNewPaymentVoucher');

	//route for add new payment voucher data
	Route::post('/lolo-pinoy-lechon-de-cebu/add-new-payment-voucher-data/{id}', 'LoloPinoyLechonDeCebuController@addNewPaymentVoucherData')->name('lolo-pinoy-lechon-de-cebu.addNewPaymentVoucherData');

	Route::patch('/lolo-pinoy-lechon-de-cebu/update-pv/{id}', 'LoloPinoyLechonDeCebuController@updatePV')->name('lolo-pinoy-lechon-de-cebu.updatePV');

	Route::delete('/lolo-pinoy-lechon-de-cebu/delete-payment-voucher/{id}', 'LoloPinoyLechonDeCebuController@destroyPaymentVoucher')->name('lolo-pinoy-lechon-de-cebu.destroyPaymentVoucher');

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
	Route::get('/lolo-pinoy-lechon-de-cebu/edit-delivery-receipt/{id}', 'LoloPinoyLechonDeCebuController@editDeliveryReceipt')->name('lolo-pinoy-lechon-de-cebu.editDeliveryReceipt');


	//route update delviery receipt
	Route::patch('/lolo-pinoy-lechon-de-cebu/update-delivery-receipt/{id}', 'LoloPinoyLechonDeCebuController@updateDeliveryReceipt')->name('lolo-pinoy-lechon-de-cebu.updateDeliveryReceipt');

	//route for add new delivery receipt
	Route::get('/lolo-pinoy-lechon-de-cebu/add-new-delivery-receipt/{id}', 'LoloPinoyLechonDeCebuController@addNewDeliveryReceipt')->name('lolo-pinoy-lechon-de-cebu.addNewDelivertReceipt');

	Route::post('/lolo-pinoy-lechon-de-cebu/add-new-delivery-receipt-data/{id}', 'LoloPinoyLechonDeCebuController@addNewDeliveryReceiptData')->name('lolo-pinoy-lechon-de-cebu.addNewDeliveryReceiptData');

	//route for delivery receipts lists
	Route::get('/lolo-pinoy-lechon-de-cebu/delivery-receipt/lists', 'LoloPinoyLechonDeCebuController@deliveryReceiptLists')->name('lolo-pinoy-lechon-de-cebu.deliveryReceiptLists');

	//route for update delivery recipt add new
	Route::patch('/lolo-pinoy-lechon-de-cebu/update-dr/{id}', 'LoloPinoyLechonDeCebuController@updateDr')->name('lolo-pinoy-lechon-de-cebu.updateDr');

	//route for delete delivery receipt
	Route::delete('/lolo-pinoy-lechon-de-cebu/delete-delivery-receipt/{id}', 'LoloPinoyLechonDeCebuController@destroyDeliveryReceipt')->name('lolo-pinoy-lechon-de-cebu.destroyDeliveryReceipt');

	//route for view delivery receipt
	Route::get('/lolo-pinoy-lechon-de-cebu/view-delivery-receipt/{id}', 'LoloPinoyLechonDeCebuController@viewDeliveryReceipt')->name('lolo-pinoy-lechon-de-cebu.viewDeliveryReceipt');

	//route for duplicate copy
	Route::get('/lolo-pinoy-lechon-de-cebu/duplicate-copy/{id}', 'LoloPinoyLechonDeCebuController@duplicateCopy')->name('lolo-pinoy-lechon-de-cebu.duplicateCopy');

	//view duplicate copy
	Route::get('/lolo-pinoy-lechon-de-cebu/view-delivery-duplicate/{id}', 'LoloPinoyLechonDeCebuController@viewDeliveryDuplicate')->name('lolo-pinoy-lechon-de-cebu.viewDeliveryDuplicate');

	//route for sales invoice form lechon de cebu
	Route::get('/lolo-pinoy-lechon-de-cebu/sales-invoice-form', 'LoloPinoyLechonDeCebuController@salesInvoiceForm')->name('lolo-pinoy-lechon-de-cebu.salesInvoiceForm');

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

	//route for delete sales invoice 
	Route::delete('/lolo-pinoy-lechon-de-cebu/delete-sales-invoice/{id}', 'LoloPinoyLechonDeCebuController@destroySalesInvoice')->name('lolo-pinoy-lechon-de-cebu.destroySalesInvoice');

	//route for sales invoice view 
	Route::get('/lolo-pinoy-lechon-de-cebu/view-sales-invoice/{id}', 'LoloPinoyLechonDeCebuController@viewSalesInvoice')->name('lolo-pinoy-lechon-de-cebu.viewSalesInvoice');

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

	//delete comissary RAW materials
	Route::delete('/lolo-pinoy-lechon-de-cebu/delete-raw-materials/{id}', 'LoloPinoyLechonDeCebuController@destroyRawMaterial')->name('lolo-pinoy-lechon-de-cebu.destroyRawMaterial');

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

	//route for commissary production
	Route::get('/lolo-pinoy-lechon-de-cebu/commissary/production', 'LoloPinoyLechonDeCebuController@commissaryProduction')->name('lolo-pinoy-lechon-de-cebu.commissaryProduction');

	//route for commissary delivery outlets
	Route::get('/lolo-pinoy-lechon-de-cebu/commissary/delivery-outlets', 'LoloPinoyLechonDeCebuController@commissaryDeliveryOutlet')->name('lolo-pinoy-lechon-de-cebu.commissaryDeliveryOutlet');

	//route for commissary sales of outlets
	Route::get('/lolo-pinoy-lechon-de-cebu/commissary/sales-of-outlets', 'LoloPinoyLechonDeCebuController@salesOfOutlet')->name('lolo-pinoy-lechon-de-cebu.salesOfOutlet');

	//route for commissary inventory of stocks
	Route::get('/lolo-pinoy-lechon-de-cebu/commissary/inventory-of-stocks', 'LoloPinoyLechonDeCebuController@inventoryOfStocks')->name('lolo-pinoy-lechon-de-cebu.inventoryOfStocks');

	//route for download PDF file
	Route::get('/lolo-pinoy-lechon-de-cebu/printDelivery/{id}', 'LoloPinoyLechonDeCebuController@printDelivery')->name('lolo-pinoy-lechon-de-cebu.printDelivery');

	//print Duplicate delivery receipt
	Route::get('/lolo-pinoy-lechon-de-cebu/printDuplicateDelivery/{id}', 'LoloPinoyLechonDeCebuController@printDuplicateDelivery')->name('lolo-pinoy-lechon-de-cebu.printDuplicateDelivery');

	//print PO
	Route::get('/lolo-pinoy-lechon-de-cebu/printPO/{id}', 'LoloPinoyLechonDeCebuController@printPO')->name('lolo-pinoy-lechon-de-cebu.printPO');

	//Lolo Pinoy Grill Commissary
	Route::get('/lolo-pinoy-grill-commissary', 'LoloPinoyGrillCommissaryController@index')->name('lolo-pinoy-grill-commissary.index');


	//Lolo Pinoy Grill Branches
	Route::get('/lolo-pinoy-grill-branches', 'LoloPinoyGrillBranchesController@index')->name('lolo-pinoy-grill-branches.index');

	//Mr Potato
	Route::get('/mr-potato', 'MrPotatoController@index')->name('mr-potato.index');


	//Ribos Bar
	Route::get('/ribos-bar', 'RibosBarController@index')->name('ribos-bar.index');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
