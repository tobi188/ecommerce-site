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

Route::get('iphone', function(){
    
});
Route::get('home', 'PageController@getIndex')->name('home');

Route::post('AddCart/{id}', 'CartController@addCart')->name('AddCart');
Route::post('buyNow/{id}', 'PageController@buyNow')->name('buyNow');

Route::get('updateCart', 'CartController@updateCart')->name('updateCart');

Route::get('deleteCart', 'CartController@deleteCart')->name('deleteCart');

Route::get('checkCart', 'PageController@checkCart')->name('checkCart');

Route::get('ProductDetail/{id}', 'PageController@getProductDetail')->name('ProductDetail');

Route::get('test', 'PageController@test')->name('test');

Route::get('login', 'PageController@login')->name('login');

Route::post('login', 'PageController@postLogin')->name('postLogin');


Route::get('logout', 'PageController@logout')->name('logout');

Route::get('register', 'PageController@register')->name('register');
Route::post('register','PageController@postRegister')->name('postRegister');

Route::get('user-page', 'PageController@viewUserInfo')->name('user-page');
Route::post('user-page', 'PageController@changeUserInfo')->name('user-page');

Route::get('productList/{id}', 'PageController@product_list')->name('productList');

Route::get('buy', 'PageController@gotoBuy')->name('buy');
Route::post('bought', 'PageController@paymentHandler')->name('bought');

Route::post('buyNow/{id}/{quantity}', 'PageController@buyNow_paymentHandler')->name('buyNow');


Route::post('secure', 'PageController@secure')->name('secure');


Route::post('search', 'PageController@search')->name('search');





