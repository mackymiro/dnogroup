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

});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
