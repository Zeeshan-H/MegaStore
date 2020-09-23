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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['as' => 'admin.', 'middleware'=>['auth', 'admin'], 'prefix'=> 'admin'], function() {
    Route::get('/dashboard', 'App\Http\Controllers\AdminController@index')->name('dashboard');
    Route::resource('product', 'App\Http\Controllers\ProductController');
    Route::resource('category', 'App\Http\Controllers\CategoryController');
    Route::resource('profiles', 'App\Http\Controllers\ProfileController');

    Route::get('profile/states/{id?}', 'App\Http\Controllers\ProfileController@getStates')->name('profile.states');
    Route::get('profile/cities/{id?}', 'App\Http\Controllers\ProfileController@getCities')->name('profile.cities');

});

Route::group(['as' => 'cart.', 'prefix' => 'cart'], function () {
	Route::get('/', 'App\Http\Controllers\ProductController@cart')->name('all');
	Route::post('/remove/{product}', 'App\Http\Controllers\ProductController@removeProduct')->name('remove');
	Route::post('/update/{product}', 'App\Http\Controllers\ProductController@updateProduct')->name('update');

});


Route::group(['as' => 'products.', 'prefix'=>'products'], function() {

    Route::get('/', 'App\Http\Controllers\ProductController@show')->name('all');
    Route::get('/{product}', 'App\Http\Controllers\ProductController@single')->name('single');
    Route::get('/addToCart/{product}', 'App\Http\Controllers\ProductController@addToCart')->name('addToCart');
});

 Route::resource('/checkout', 'App\Http\Controllers\OrderController');




