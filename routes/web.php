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

Auth::routes();

//Guarded routes
Route::middleware('auth')->group(function () {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/files', 'FileController@index')->name('files');
    Route::get('/files/{file}/token/{token}', 'FileController@download');

    Route::get('/notes/create', 'NoteController@create')->name('notes.create');
    Route::post('/notes', 'NoteController@store')->name('notes.store');
    Route::get('/notes/{note}', 'NoteController@show');
    
    Route::get('/groups', 'GroupController@index')->name('groups');
    
    Route::get('/management', 'ManagementController@index')->name('management');

    Route::get('/feedback', 'FeedbackController@create')->name('feedback');
    Route::post('/feedback', 'FeedbackController@store');
    Route::get('/feedback/{feedback}/attachment', 'FeedbackController@attachment');
    Route::get('/feedback/{feedback}', 'FeedbackController@show');
});