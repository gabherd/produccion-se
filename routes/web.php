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
    return view('home');
})->middleware('auth');

Route::get('stopMachine', '\App\Http\Controllers\HomeController@getStopMachine')
	->name('stopMachine')->middleware('auth');

Route::get('employee', '\App\Http\Controllers\HomeController@getEmployee')
	->name('employee')->middleware('auth');

Route::get('machine', '\App\Http\Controllers\HomeController@getMachine')
	->name('machine')->middleware('auth');

Route::post('employee', '\App\Http\Controllers\HomeController@storeEmployee')
	->name('save-employee')->middleware('auth');

Route::resource("paros", '\App\Http\Controllers\HomeController')
	->names('stops')->middleware('auth');