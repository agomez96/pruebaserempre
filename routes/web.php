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
    return view('auth/login');
});

Auth::routes();

Route::get('/home', 'ClientController@index')->name('home');
Route::post('/changeverify', 'Auth\RegisterController@verifyUserT')->name('verify');
Route::resource("cities", "CitiesController")->parameters(["cities"=>"city"]);
Route::resource("clients", "ClientController")->parameters(["clients"=>"client"]);
Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser');
Route::get('/ajax-cities', 'CitiesController@selectcities');
