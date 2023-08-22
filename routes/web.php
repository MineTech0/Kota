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

    Route::get('/files/create', 'FileController@create')->name('files.create')->middleware('permission:access_management');
    Route::get('/files', 'FileController@index')->name('files');
    Route::get('/files/{file}/token/{token}', 'FileController@download');

    Route::get('/notes/create', 'NoteController@create')->name('notes.create')->middleware('permission:access_management');
    Route::get('/notes/{note}', 'NoteController@show');

    Route::get('/groups', 'GroupController@index')->name('groups');

    Route::get('/user/groups', 'GroupController@userGroups')->name('user.groups')->middleware('permission:see_own_group_expenses');

    Route::get('/feedback', 'FeedbackController@create')->name('feedback');
    Route::post('/feedback', 'FeedbackController@store');

    Route::get('/equipment/available/{id}', 'EquipmentController@available')->name('available.equipment');

    Route::get('/equipment', 'EquipmentController@index')->name('index.equipment')->middleware('permission:see_equipment');
    Route::get('/equipment/create', 'EquipmentController@create')->name('create.equipment')->middleware('permission:add_edit_delete_equipment');
    Route::get('/equipment/{equipment}/edit', 'EquipmentController@edit')->name('edit.equipment')->middleware('permission:add_edit_delete_equipment');
    Route::post('/equipment', 'EquipmentController@store')->name('store.equipment')->middleware('permission:add_edit_delete_equipment');
    Route::put('/equipment/{equipment}', 'EquipmentController@update')->name('update.equipment')->middleware('permission:add_edit_delete_equipment');

    Route::get('/loan', 'LoanController@create')->name('create.loan');
    Route::get('/loan/{loan}', 'LoanController@show')->name('show.loan');
    Route::post('/loan', 'LoanController@store')->name('store.loan');
    Route::delete('/loan/{loan}', 'LoanController@destroy')->name('delete.loan');
    
    Route::get('/loan/accept/{loan}', 'LoanController@accept')->middleware('permission:accept_loan');
    Route::patch('/loan/{loan}', 'LoanController@update')->name('update.loan')->middleware('permission:accept_loan');

    Route::post('/kitchenBooking', 'KitchenBookingController@store')->name('kitchenBooking.store');

    //managenent routes
    Route::middleware('can:access_management')->group(function () {

        Route::get('/management', 'ManagementController@index')->name('management');

        Route::get('/invite', 'InviteController@create')->name('create.invite');
        Route::post('/invite', 'InviteController@store')->name('store.invite');
        Route::post('/invite/resend', 'InviteController@reSend')->name('resend.invite');
        Route::delete('/invite/{invite}', 'InviteController@destroy')->name('destroy.invite');

        Route::get('/feedback/{feedback}/attachment', 'FeedbackController@attachment');
        Route::get('/feedback/{feedback}', 'FeedbackController@show');

        Route::patch('/users/{user}/roles', 'UserController@updateRoles')->name('update.user.roles')->middleware('permission:assign_delete_user_role');
        Route::get('users', 'UserController@index')->name('index.users');
        Route::delete('/users/{user}', 'UserController@destroy')->name('destroy.user')->middleware('permission:delete_user');

        Route::post('/groups', 'GroupController@store')->name('store.group');
        Route::get('/groups/create', 'GroupController@create')->name('create.group');
        Route::get('/groups/{group}/edit', 'GroupController@edit')->name('edit.group');
        Route::put('/groups/{group}', 'GroupController@update')->name('update.group');
        Route::delete('/groups/{group}', 'GroupController@destroy')->name('destroy.group');

        Route::get('/notes', 'NoteController@index')->name('notes.index');
        Route::get('/notes/{note}/edit', 'NoteController@edit')->name('notes.edit');
        Route::put('/notes/{note}', 'NoteController@update');
        Route::delete('/notes/{note}', 'NoteController@destroy');
        Route::post('/notes', 'NoteController@store')->name('notes.store');

        Route::post('/files', 'FileController@store')->name('files.store');

        Route::get('/expenses', 'ExpenseController@index')->name('expenses.index')->middleware('permission:see_group_expenses');
        Route::get('/expenses/create', 'ExpenseController@create')->name('expenses.create')->middleware('permission:add_group_expense');
        Route::post('/expenses/group', 'ExpenseController@storeGroup')->name('expenses.storeGroup')->middleware('permission:add_group_expense');
        Route::delete('/expenses/{expense}', 'ExpenseController@destroy')->name('expenses.destroy')->middleware('permission:delete_edit_group_expense');
    });
});
