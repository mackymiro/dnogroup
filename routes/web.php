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
	Route::post('lolo-pinoy-lechon-de-cebu/update/{id}', 'LoloPinoyLechonDeCebuController@update')->name('lolo-pinoy-lechon-de-cebu.update');

	//route for add new in lechon de cebu purchase order
	Route::get('lolo-pinoy-lechon-de-cebu/add-new/{id}', 'LoloPinoyLechonDeCebuController@addNew')->name('lolo-pinoy-lechon-de-cebu.addNew');

	//save add new purchase order 
	Route::post('lolo-pinoy-lechon-de-cebu/add-new-purchase-order/{id}', 'LoloPinoyLechonDeCebuController@addNewPurchaseOrder')->name('lolo-pinoy-lechon-de-cebu.addNewPurchaseOrder');

	//view purchase order lechon de cebu
	Route::get('lolo-pinoy-lechon-de-cebu/view/{id}', 'LoloPinoyLechonDeCebuController@show')->name('lolo-pinoy-lechon-de-cebu.show');

	//delete for lechon de cebu purchase order
	Route::delete('/lolo-pinoy-lechon-de-cebu/delete/{id}', 'LoloPinoyLechonDeCebuController@destroy')->name('lolo-pinoy-lechon-de-cebu.destroy');

	//
	Route::post('/lolo-pinoy-lechon-de-cebu/update-po/{id}', 'LoloPinoyLechonDeCebuController@updatePo')->name('lolo-pinoy-lechon-de-cebu.updatePo');

	//route for lechon de cebu billing statement form
	Route::get('/lolo-pinoy-lechon-de-cebu/billing-statement-form', 'LoloPinoyLechonDeCebuController@billingStatementForm')->name('lolo-pinoy-lechon-de-cebu.billingStatementForm');

	//
	Route::post('/lolo-pinoy-lechon-de-cebu/store-billing-statement', 'LoloPinoyLechonDeCebuController@storeBillingStatement')->name('lolo-pinoy-lechon-de-cebu.storeBillingStatement');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
