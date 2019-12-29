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

Auth::routes(); // no needed

Route::get('/home', 'HomeController@index')->name('home');


// API routes define

// Route::group(["prefix" => 'api/v1'], function(){

// 	// GET /values
// 	Route::get('/values', 'DoctorController@index')->name('doctor_list');

// 	// POST /values
// 	Route::post('/values', 'DoctorController@store')->name('doctor_store');
// });