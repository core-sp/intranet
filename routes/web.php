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

Route::group(['middleware' => 'auth'], function(){
    Route::get('/', 'HomeController@index');
    // Users
    Route::get('/users', 'UsersController@index');
    Route::get('/users/create', 'UsersController@create');
    Route::post('/users', 'UsersController@store');
    // Profiles
    Route::get('/profiles', 'ProfilesController@index');
    Route::get('/profiles/create', 'ProfilesController@create');
    Route::post('/profiles', 'ProfilesController@store');
    // Tickets
    Route::get('/tickets', 'TicketsController@index');
    Route::get('/tickets/create', 'TicketsController@create');
    Route::post('/tickets', 'TicketsController@store');
    Route::get('/tickets/{ticket}', 'TicketsController@show');
    Route::patch('/tickets/{ticket}', 'TicketsController@update');
    // Interactions
    Route::get('/tickets/{ticket}/interactions/create', 'InteractionsController@create');
    Route::post('/tickets/{ticket}/interactions', 'InteractionsController@store');
});

Auth::routes();
