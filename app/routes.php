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
	Route::get('admin/korisnicke-postavke', ['as' => 'admin-user-settings', 'uses' => 'UserController@showUserSettings']);
	Route::post('admin/korisnicke-postavke/spremi', ['as' => 'admin-user-settings-update', 'uses' => 'UserController@updateUserSettings']);
	Route::post('admin/korisnicke-postavke/dodaj', ['as' => 'admin-user-settings-add', 'uses' => 'UserController@addNewUser']);
	Route::post('admin/korisnicke-postavke/obrisi', ['as' => 'admin-user-settings-delete', 'uses' => 'UserController@deleteUser']);

	//cage football - caffe bar - image gallery
	Route::get('admin/cage-football', ['as' => 'admin-cage-football', 'uses' => 'PagesController@showCageFootballAdmin']);
	Route::post('admin/cage-football', ['as' => 'admin-cage-football-post', 'uses' => 'PagesController@updateCageFootball']);
	Route::get('admin/caffe-bar', ['as' => 'admin-caffe-bar', 'uses' => 'PagesController@showCaffeBarAdmin']);
	Route::post('admin/caffe-bar', ['as' => 'admin-caffe-bar-post', 'uses' => 'PagesController@updateCaffeBar']);
	Route::post('admin/gallery-image-delete', ['as' => 'admin-gallery-image-delete', 'uses' => 'PagesController@deleteGalleryImage']);
	Route::post('admin/gallery-image-set-primary', ['as' => 'admin-gallery-image-set-primary', 'uses' => 'PagesController@setPrimaryGalleryImage']);

	//news portal
	Route::get('admin/portal', ['as' => 'admin-portal', 'uses' => 'NewsController@showNewsPortalAdmin']);
	Route::post('admin/portal/gallery-image-delete', ['as' => 'admin-portal-gallery-image-delete', 'uses' => 'NewsController@deleteNewsGalleryImage']);
	Route::get('admin/portal/dodaj', ['as' => 'admin-portal-add', 'uses' => 'NewsController@showNewNewsForm']);
	Route::post('admin/portal/dodaj', ['as' => 'admin-portal-addPost', 'uses' => 'NewsController@addNewNews']);
	Route::get('admin/portal/pregled/{slug}', ['as' => 'admin-portal-show', 'uses' => 'NewsController@showNewsAdmin'])->where(['slug' => '[\w\-šđčćžŠĐČĆŽ]+']);
	Route::get('admin/portal/izmjena/{slug}', ['as' => 'admin-portal-edit', 'uses' => 'NewsController@showNewsEditForm'])->where(['slug' => '[\w\-šđčćžŠĐČĆŽ]+']);
	Route::post('admin/portal/izmjena/{slug}', ['as' => 'admin-portal-editPost', 'uses' => 'NewsController@updateNews'])->where(['slug' => '[\w\-šđčćžŠĐČĆŽ]+']);
	Route::get('admin/portal/brisanje/{slug}', ['as' => 'admin-portal-delete', 'uses' => 'NewsController@deleteNews'])->where(['slug' => '[\w\-šđčćžŠĐČĆŽ]+']);

	//gallery
	Route::get('admin/galerija', ['as' => 'admin-gallery', 'uses' => 'GalleryController@showGalleryAdmin']);
	Route::post('admin/galerija/dodaj', ['as' => 'admin-gallery-add', 'uses' => 'GalleryController@uploadToGallery']);
	Route::post('admin/galerija/brisanje', ['as' => 'admin-gallery-delete', 'uses' => 'GalleryController@deleteGalleryFile']);

	//shop
	Route::get('admin/shop', ['as' => 'admin-shop', 'uses' => 'ProductController@showShopAdmin']);
	Route::get('admin/shop/kategorije', ['as' => 'admin-shop-categories', 'uses' => 'ProductController@showShopCategoriesAdmin']);
	Route::post('admin/shop/kategorije', ['as' => 'admin-shop-categoriesPost', 'uses' => 'ProductController@addProductCategories']);
	Route::get('admin/shop/category-sort', ['as' => 'admin-shop-sort', 'uses' => 'ProductController@sortProductsByCategory']);
	Route::post('admin/shop/kategorije/brisanje', ['as' => 'admin-shop-categories-deletePost', 'uses' => 'ProductController@deleteProductCategories']);
	Route::post('admin/shop/kategorije/izmjena', ['as' => 'admin-shop-categories-editPost', 'uses' => 'ProductController@editProductCategories']);
	Route::get('admin/shop/proizvod/dodaj', ['as' => 'admin-shop-product-add', 'uses' => 'ProductController@showNewProductForm']);
	Route::post('admin/shop/proizvod/dodaj', ['as' => 'admin-shop-product-addPost', 'uses' => 'ProductController@addNewProduct']);
	Route::get('admin/shop/proizvod/pregled/{slug}', ['as' => 'admin-shop-product-show', 'uses' => 'ProductController@showProductAdmin'])->where(['slug' => '[\w\-šđčćžŠĐČĆŽ]+']);
	Route::get('admin/shop/proizvod/brisanje/{slug}', ['as' => 'admin-shop-product-delete', 'uses' => 'ProductController@deleteProduct'])->where(['slug' => '[\w\-šđčćžŠĐČĆŽ]+']);
	Route::get('admin/shop/proizvod/izmjena/{slug}', ['as' => 'admin-shop-product-edit', 'uses' => 'ProductController@showProductEditForm'])->where(['slug' => '[\w\-šđčćžŠĐČĆŽ]+']);
	Route::post('admin/shop/proizvod/izmjena', ['as' => 'admin-shop-product-editPost', 'uses' => 'ProductController@updateProduct']);


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

Route::get('portal', ['as' => 'portal', 'uses' => 'NewsController@showNewsPortal']);
Route::get('portal/sort', ['as' => 'portal-sort', 'uses' => 'NewsController@showSortedNews']);
Route::get('portal/pregled/{slug}', ['as' => 'portal-show', 'uses' => 'NewsController@showNews'])->where(['slug' => '[\w\-šđčćžŠĐČĆŽ]+']);
Route::get('portal/tag/{slug}', ['as' => 'portal-tag', 'uses' => 'NewsController@showNewsByTag'])->where(['slug' => '[\w\-šđčćžŠĐČĆŽ]+']);
Route::get('tagovi', ['as' => 'tags', 'uses' => 'PublicController@showTags']);

Route::get('cage-football', ['as' => 'cage-football', 'uses' => 'PagesController@showCageFootball']);
Route::get('caffe-bar', ['as' => 'caffe-bar', 'uses' => 'PagesController@showCaffeBar']);

Route::get('galerija', ['as' => 'gallery', 'uses' => 'GalleryController@showGallery']);

Route::post('kontakt', ['as' => 'kontaktPost', 'uses' => 'PublicController@sendMail']);
Route::get('kontakt', ['as' => 'kontakt', 'uses' => 'PublicController@showContact']);

Route::get('o-nama', ['as' => 'o-nama', 'uses' => 'PublicController@showAboutUs']);

Route::get('/', ['as' => 'home', 'uses' => 'PublicController@showHome']);