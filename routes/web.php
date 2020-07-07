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
    Route::resource('/users', 'UsersController')->except(['show']);
    Route::get('/users/{user}/change-password', 'UsersController@changePasswordView');
    Route::patch('/users/{user}/change-password', 'UsersController@changePassword');
    // Profiles
    Route::resource('/profiles', 'ProfilesController')->except(['show', 'edit', 'update']);
    Route::get('/profiles/{profile}/tickets-completed', 'ProfilesController@ticketsCompleted');
    // Tickets
    Route::get('/tickets', 'TicketsController@index');
    Route::get('/tickets/created', 'TicketsController@created');
    Route::get('/tickets/created-and-completed', 'TicketsController@createdAndCompleted');
    Route::get('/tickets/create', 'TicketsController@create');
    Route::post('/tickets', 'TicketsController@store');
    Route::get('/tickets/{ticket}', 'TicketsController@show');
    Route::patch('/tickets/{ticket}/update-status', 'TicketUpdatesController@updateStatus');
    Route::patch('/tickets/{ticket}/update-respondent', 'TicketUpdatesController@updateRespondent');
    Route::patch('/tickets/{ticket}/update-profile', 'TicketUpdatesController@updateProfile');
    // Interactions
    Route::get('/tickets/{ticket}/interactions/create', 'InteractionsController@create');
    Route::post('/tickets/{ticket}/interactions', 'InteractionsController@store');
    // File upload and download
    Route::post('/upload', 'AttachmentsController@upload');
    Route::post('/upload-csv', 'AttachmentsController@uploadCsv');
    // Protestos
    Route::get('/protestos', 'ProtestoController@index')->name('protestos.index');
    Route::get('/protestos/remessa', 'ProtestoController@remessaView')->name('protestos.remessa');
    Route::post('/protestos/remessa', 'ProtestoController@send')->name('remessa.send');
});

Auth::routes();
