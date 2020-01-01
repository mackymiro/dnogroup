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

});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
