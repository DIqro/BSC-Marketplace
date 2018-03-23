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

Route::group(['middleware' => 'auth'], function(){
	Route::resource('products', 'ProductController', ['except' => ['index', 'show']]);
	Route::post('/product-comment/{id}', 'ProductCommentController@store');
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile/{id?}', 'HomeController@profile');
Route::get('/verify/{token}/{id}', 'Auth\RegisterController@verify_register');
Route::resource('products', 'ProductController', ['only' => ['index', 'show']]);