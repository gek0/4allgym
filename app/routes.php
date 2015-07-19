<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/**
 * admin area
 */
Route::group(['before' => 'auth'], function() {
	Route::get('admin', function(){
		return Redirect::to('admin/pocetna');
	});
	Route::get('admin/pocetna', ['as' => 'admin', 'uses' => 'AdminController@showHome']);

	//user settings
	Route::get('admin/korisnicke-postavke', ['as' => 'admin-user-settings', 'uses' => 'AdminController@showUserSettings']);
	Route::post('admin/korisnicke-postavke/spremi', ['as' => 'admin-user-settings-update', 'uses' => 'AdminController@updateUserSettings']);
	Route::post('admin/korisnicke-postavke/dodaj', ['as' => 'admin-user-settings-add', 'uses' => 'AdminController@addNewUser']);


});

/**
 * logout from admin area
 */
Route::get('logout', function(){
	Auth::logout();
	return Redirect::to('/');
});

Route::post('login', ['as' => 'loginPost', 'uses' => 'LoginController@checkLogin']);
Route::get('login', ['as' => 'login', 'uses' => 'LoginController@showLogin']);

/**
 * public area
 */

Route::post('kontakt', ['as' => 'kontaktPost', 'uses' => 'PublicController@sendMail']);
Route::get('kontakt', ['as' => 'kontakt', 'uses' => 'PublicController@showContact']);

Route::get('o-nama', ['as' => 'o-nama', 'uses' => 'PublicController@showAboutUs']);

Route::get('/', ['as' => 'home', 'uses' => 'PublicController@showHome']);