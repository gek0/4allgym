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
	Route::post('admin/korisnicke-postavke/obrisi', ['as' => 'admin-user-settings-delete', 'uses' => 'AdminController@deleteUser']);

	//cage football
	Route::get('admin/cage-football', ['as' => 'admin-cage-football', 'uses' => 'AdminController@showCageFootball']);
	Route::post('admin/cage-football', ['as' => 'admin-cage-football-post', 'uses' => 'AdminController@updateCageFootball']);

	//caffe bar
	Route::get('admin/caffe-bar', ['as' => 'admin-caffe-bar', 'uses' => 'AdminController@showCaffeBar']);
	Route::post('admin/caffe-bar', ['as' => 'admin-caffe-bar-post', 'uses' => 'AdminController@updateCaffeBar']);

	//cage football and caffe bar image gallery
	Route::post('admin/gallery-image-delete', ['as' => 'admin-gallery-image-delete', 'uses' => 'AdminController@deleteGalleryImage']);
	Route::post('admin/gallery-image-set-primary', ['as' => 'admin-gallery-image-set-primary', 'uses' => 'AdminController@setPrimaryGalleryImage']);

	//news portal
	Route::get('admin/portal', ['as' => 'admin-portal', 'uses' => 'AdminController@showNewsPortal']);
	Route::post('admin/portal/gallery-image-delete', ['as' => 'admin-portal-gallery-image-delete', 'uses' => 'AdminController@deleteNewsGalleryImage']);
	Route::get('admin/portal/dodaj', ['as' => 'admin-portal-add', 'uses' => 'AdminController@showNewNewsForm']);
	Route::post('admin/portal/dodaj', ['as' => 'admin-portal-addPost', 'uses' => 'AdminController@addNewNews']);
	Route::get('admin/portal/pregled/{slug}', ['as' => 'admin-portal-show', 'uses' => 'AdminController@showNews'])->where(['slug' => '[\w\-šđčćžŠĐČĆŽ]+']);
	Route::get('admin/portal/izmjena/{slug}', ['as' => 'admin-portal-edit', 'uses' => 'AdminController@showNewsEditForm'])->where(['slug' => '[\w\-šđčćžŠĐČĆŽ]+']);
	Route::post('admin/portal/izmjena/{slug}', ['as' => 'admin-portal-editPost', 'uses' => 'AdminController@updateNews'])->where(['slug' => '[\w\-šđčćžŠĐČĆŽ]+']);
	Route::get('admin/portal/brisanje/{slug}', ['as' => 'admin-portal-delete', 'uses' => 'AdminController@deleteNews'])->where(['slug' => '[\w\-šđčćžŠĐČĆŽ]+']);


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