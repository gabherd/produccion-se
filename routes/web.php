<?php

use Illuminate\Support\Facades\Route;

//VISTAS
Route::get('/', function () {
    return view('dashboard');
})->name('home')->middleware('auth');

Route::get('/paros-maquina', function () {
    return view('machine-stop');
})->name('stop')->middleware('auth');



/* --------- Dashboard --------- */
	//Cantidad de maquinas paradas actualmente
	Route::get('machineNotRepaired', '\App\Http\Controllers\DashboardController@getQtyMachineStoped')
		->name('machineNotRepaired')->middleware('auth');

	//Cantidad de paros por maquina
	Route::get('qtyStopedByMachine', '\App\Http\Controllers\DashboardController@getQtyStopedByMachine')
		->name('qtyStopedByMachine')->middleware('auth');

	//obtine el nombre del setup 
	Route::get('getNameResponsable', '\App\Http\Controllers\DashboardController@getNameResponsable')
		->name('getNameResponsable')->middleware('auth');

	//total de horas que se detuvo una maquina
	Route::get('totalHourStoped', '\App\Http\Controllers\DashboardController@getTotalHourStoped')
		->name('totalHourStoped')->middleware('auth');		

/* --------- PAROS DE MAQUINA --------- */
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