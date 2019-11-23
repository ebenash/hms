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

Route::get('/', function () {
    return redirect('dashboard');
});

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');


Route::post('/guests/store', 'GuestsController@store');
Route::post('/roomtypes/store', 'RoomTypesController@store');
Route::post('/reservations/store', 'RoomsController@store');
Route::post('/rooms/store', 'GuestsController@store');
Route::post('/payments/store', 'PaymentsController@store');
Route::resource('guests','GuestsController');
Route::resource('rooms','RoomsController');
Route::resource('reservations','ReservationsController');
Route::resource('roomtypes','RoomTypesController');
Route::resource('payments','PaymentsController');