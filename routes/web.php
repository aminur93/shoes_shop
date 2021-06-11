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

    /*products routes end*/

});


