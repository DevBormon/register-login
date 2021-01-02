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

Route::get('/login', 'LoginController@index')->name('login');
Route::get('/register', 'RegisterController@index')->name('register');
Route::get('/users', 'HomeController@index')->name('users');
Route::post('register', 'RegisterController@store');
Route::post('login', 'LoginController@login');

Route::get('/buyer', 'BuyerController@index');
Route::get('/seller', 'SellerController@index');

Route::post('logout', 'LoginController@logout')->name('logout');