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
    Route::get('/users/{user}/edit', 'UsersController@edit');
    Route::patch('/users/{user}', 'UsersController@update');
    Route::get('/users/{user}/change-password', 'UsersController@changePasswordView');
    Route::patch('/users/{user}/change-password', 'UsersController@changePassword');
    // Profiles
    Route::get('/profiles', 'ProfilesController@index');
    Route::get('/profiles/create', 'ProfilesController@create');
    Route::post('/profiles', 'ProfilesController@store');
    // Tickets
    Route::get('/tickets', 'TicketsController@index');
    Route::get('/tickets/created', 'TicketsController@created');
    Route::get('/tickets/create', 'TicketsController@create');
    Route::post('/tickets', 'TicketsController@store');
    Route::get('/tickets/{ticket}', 'TicketsController@show');
    Route::patch('/tickets/{ticket}/update-status', 'TicketUpdatesController@updateStatus');
    Route::patch('/tickets/{ticket}/update-respondent', 'TicketUpdatesController@updateRespondent');
    Route::patch('/tickets/{ticket}/update-profile', 'TicketUpdatesController@updateProfile');
    // Interactions
    Route::get('/tickets/{ticket}/interactions/create', 'InteractionsController@create');
    Route::post('/tickets/{ticket}/interactions', 'InteractionsController@store');
});

Auth::routes();
