<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function (){

    /*dashboard routes start*/
    Route::get('/dashboard', 'HomeController@index')->name('dashboard');
    /*dashboard routes end*/

    /*category routes start*/
    Route::get('category','Admin\CategoryController@index')->name('category');
    Route::get('category/getData','Admin\CategoryController@getData')->name('category.getData');
    Route::get('category/create','Admin\CategoryController@create')->name('category.create');
    Route::post('category/store','Admin\CategoryController@store')->name('category.store');
    Route::get('category/edit/{id}','Admin\CategoryController@edit')->name('category.edit');
    Route::post('category/update/{id}','Admin\CategoryController@update')->name('category.update');
    Route::delete('category/destroy/{id}','Admin\CategoryController@destroy')->name('category.destroy');
    /*category routes end*/

    /*products routes start*/
    Route::get('products','Admin\ProductController@index')->name('products');
    Route::get('products/getData','Admin\ProductController@getData')->name('products.getData');
    Route::get('products/create','Admin\ProductController@create')->name('products.create');
    Route::post('products/store','Admin\ProductController@store')->name('products.store');
    Route::get('products/edit/{id}','Admin\ProductController@edit')->name('products.edit');
    Route::post('products/update/{id}','Admin\ProductController@update')->name('products.update');
    Route::delete('products/destroy/{id}','Admin\ProductController@destroy')->name('products.destroy');

    Route::get('products/publish_change/{id}','Admin\ProductController@publish_change')->name('products.publish_change');
    Route::get('products/feature_change/{id}','Admin\ProductController@feature_change')->name('products.feature_change');
    Route::get('products/new_arrival_change/{id}','Admin\ProductController@new_arrival_change')->name('products.new_arrival_change');
    /*products routes end*/


    /*product gallery image route start*/
    Route::get('product_gallery/{id}','Admin\ProductImageGalleryController@index')->name('product_gallery');
    Route::get('gallery_image','Admin\ProductImageGalleryController@gallery_image')->name('gallery_image');
    Route::get('gallery_image_create/{id}','Admin\ProductImageGalleryController@galleryImageCreate')->name('gallery_image_create');
    Route::post('gallery_image_store/{id}','Admin\ProductImageGalleryController@galleryImageStore')->name('gallery_image_store');
    Route::post('image_delete', 'Admin\ProductImageGalleryController@image_delete')->name('image_delete');
    Route::get('product_gallery/edit/{id}','Admin\ProductImageGalleryController@edit')->name('gallery_image_edit');
    Route::post('gallery_image_update/{id}','Admin\ProductImageGalleryController@galleryImageUpdate')->name('gallery_image_update');
    Route::delete('product_gallery/gallery_image_destroy/{id}','Admin\ProductImageGalleryController@galleryImageDestroy')->name('gallery_image_destroy');
    /*product gallery image route end*/


    /*product stock route start*/
    Route::get('product_stock','Admin\ProductStockController@index')->name('product_stock');
    Route::get('product_stock/getData','Admin\ProductStockController@getData')->name('product_stock.getData');
    Route::get('product_stock/create','Admin\ProductStockController@create')->name('product_stock.create');
    Route::post('product_stock/store','Admin\ProductStockController@store')->name('product_stock.store');
    Route::get('product_stock/edit/{id}','Admin\ProductStockController@edit')->name('product_stock.edit');
    Route::post('product_stock/update/{id}','Admin\ProductStockController@update')->name('product_stock.update');
    Route::delete('product_stock/destroy/{id}','Admin\ProductStockController@destroy')->name('product_stock.destroy');
    /*product stock route end*/


    /*products slider route start*/
    Route::get('slider','Admin\ProductSliderController@index')->name('slider');
    Route::get('slider/getData','Admin\ProductSliderController@getData')->name('slider.getData');
    Route::get('slider/create','Admin\ProductSliderController@create')->name('slider.create');
    Route::post('slider/store','Admin\ProductSliderController@store')->name('slider.store');
    Route::get('slider/edit/{id}','Admin\ProductSliderController@edit')->name('slider.edit');
    Route::post('slider/update/{id}','Admin\ProductSliderController@update')->name('slider.update');
    Route::delete('slider/destroy/{id}','Admin\ProductSliderController@destroy')->name('slider.destroy');
    /*products slider route end*/


    /*user routes start*/
    Route::get('user','Admin\UserController@index')->name('user');
    Route::get('user/getData','Admin\UserController@getData')->name('user.getData');
    Route::get('user/create','Admin\UserController@create')->name('user.create');
    Route::post('user/store','Admin\UserController@store')->name('user.store');
    Route::get('user/edit/{id}','Admin\UserController@edit')->name('user.edit');
    Route::post('user/update/{id}','Admin\UserController@update')->name('user.update');
    Route::delete('user/destroy/{id}','Admin\UserController@destroy')->name('user.destroy');

    Route::get('profile','Admin\UserController@profile')->name('profile');
    Route::post('profile_update','Admin\UserController@profileUpdate')->name('profile_update');
    Route::get('change_password','Admin\UserController@ChangePassword')->name('change_password');
    Route::post('password_update','Admin\UserController@updatePassword')->name('password_update');
    /*user routes end*/

});


