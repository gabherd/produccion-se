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
    return view('dashboard');
})->name('home')->middleware('auth');

Route::get('/paros-maquina', function () {
    return view('machine-stop');
})->name('stop')->middleware('auth');

//dashboard
Route::get('qtyMachineStoped', '\App\Http\Controllers\DashboardController@getQtyMachineStoped')
	->name('qtyMachineStoped')->middleware('auth');

//Cantidad de paros por maquina
Route::get('qtyStopedByMachine', '\App\Http\Controllers\DashboardController@getQtyStopedByMachine')
	->name('qtyStopedByMachine')->middleware('auth');

//obtine el nombre del setup 
Route::get('getNameResponsable', '\App\Http\Controllers\DashboardController@getNameResponsable')
	->name('getNameResponsable')->middleware('auth');

//Machine stop
Route::get('stopMachine', '\App\Http\Controllers\MachineStopController@getStopMachine')
	->name('stopMachine')->middleware('auth');

Route::get('employee', '\App\Http\Controllers\MachineStopController@getEmployee')
	->name('employee')->middleware('auth');

Route::get('machine', '\App\Http\Controllers\MachineStopController@getMachine')
	->name('machine')->middleware('auth');

Route::post('employee', '\App\Http\Controllers\MachineStopController@storeEmployee')
	->name('save-employee')->middleware('auth');

Route::resource("paros", '\App\Http\Controllers\MachineStopController')
	->names('stops')->middleware('auth');