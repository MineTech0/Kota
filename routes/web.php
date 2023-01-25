<?php

use Illuminate\Support\Facades\Auth;
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
    return redirect('/home');
});
Route::get('/register', function () {
    return abort(404);
});
Auth::routes();

//register route
Route::get('/user/create/{token}', 'UserController@create')->name('create.user')->middleware('signed');
//Guarded routes
Route::middleware('auth')->group(function () {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/files/create', 'FileController@create')->name('files.create')->middleware('can:access_management');
    Route::get('/files', 'FileController@index')->name('files');
    Route::get('/files/{file}/token/{token}', 'FileController@download');

    Route::get('/notes/create', 'NoteController@create')->name('notes.create')->middleware('can:access_management');
    Route::get('/notes/{note}', 'NoteController@show');
    
    Route::get('/groups', 'GroupController@index')->name('groups');

    Route::get('/feedback', 'FeedbackController@create')->name('feedback');
    Route::post('/feedback', 'FeedbackController@store');

    Route::get('/equipment/available/{id}', 'EquipmentController@available')->name('available.equipment');
    
    Route::get('/loan', 'LoanController@create')->name('create.loan');
    Route::get('/loan/{loan}', 'LoanController@show')->name('show.loan');
    Route::post('/loan', 'LoanController@store')->name('store.loan');
    Route::delete('/loan/{loan}', 'LoanController@destroy')->name('delete.loan');

    Route::get('/contact/group/{group}', 'GroupController@contact')->name('group.contact');

    Route::post('/kitchenBooking', 'KitchenBookingController@store')->name('kitchenBooking.store');

    //managenent routes
    Route::middleware('can:access_management')->group(function () { 

        Route::get('/management', 'ManagementController@index')->name('management');

        Route::get('/invite', 'InviteController@create')->name('create.invite');
        Route::post('/invite', 'InviteController@store')->name('store.invite');
        Route::patch('/invite/{invite}', 'InviteController@reSend')->name('resend.invite');

        Route::get('/feedback/{feedback}/attachment', 'FeedbackController@attachment');
        Route::get('/feedback/{feedback}', 'FeedbackController@show');

        Route::get('/user/{user}', 'UserController@show')->name('show.user');
        Route::delete('/user/{user}/role/{role}', 'UserController@destroyRole')->name('deleteRole.user');
        Route::patch('/user/{id}', 'UserController@update')->name('update.user');

        Route::get('/equipment', 'EquipmentController@index')->name('index.equipment');
        Route::get('/equipment/create', 'EquipmentController@create')->name('create.equipment');
        Route::get('/equipment/{equipment}/edit', 'EquipmentController@edit')->name('edit.equipment');
        Route::post('/equipment', 'EquipmentController@store')->name('store.equipment');
        Route::put('/equipment/{equipment}', 'EquipmentController@update')->name('update.equipment');

        Route::post('/groups', 'GroupController@store')->name('store.group');
        Route::get('/groups/create', 'GroupController@create')->name('create.group');
        Route::get('/groups/{group}/edit','GroupController@edit')->name('edit.group');
        Route::put('/groups/{group}','GroupController@update')->name('update.group');
        Route::delete('/groups/{group}','GroupController@destroy')->name('destroy.group');

        Route::get('/notes', 'NoteController@index')->name('notes.index');
        Route::get('/notes/{note}/edit', 'NoteController@edit')->name('notes.edit');
        Route::put('/notes/{note}', 'NoteController@update');
        Route::delete('/notes/{note}', 'NoteController@destroy');
        Route::post('/notes', 'NoteController@store')->name('notes.store');

        Route::get('/loan/accept/{loan}', 'LoanController@accept');
        Route::patch('/loan/{loan}', 'LoanController@update')->name('update.loan');

        Route::post('/files', 'FileController@store')->name('files.store');

        Route::get('/expenses', 'ExpenseController@index')->name('expenses.index');
        Route::get('/expenses/create', 'ExpenseController@create')->name('expenses.create');
    
        
    });
});

