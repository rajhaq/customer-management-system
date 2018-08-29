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
    return view('welcome');
});

Auth::routes();


Route::resource('/app/guest','GuestController');
Route::resource('/app/room','RoomController');
Route::resource('/app/booking','BookingController');
Route::get('/app/bookingFinder/{date}', 'BookingController@bookingFinder');
Route::get('/app/admin', 'HomeController@admin')->name('admin');

Route::get('/home', 'HomeController@index')->name('home');
Route::any('{slug}', [
    'uses' => 'HomeController@index',
 ])->where('slug', '([A-z\d-\/_.]+)?');
