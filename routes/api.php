<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('login')->group(function () {
    Route::post('', 'Auth\AuthController@login')->name('api-login');
});

Route::middleware(['jwt.verify'])->prefix('events')->group(function () {
    Route::get('', 'Tasks\TasksController@index')->name('tasks-list');
    Route::post('', 'Tasks\TasksController@create')->name('create-task');
    Route::prefix('{id}')->group(function () {
        Route::get('', 'Tasks\TasksController@view')->name('view-task');
        Route::put('', 'Tasks\TasksController@edit')->name('edit-task');
        Route::patch('', 'Tasks\TasksController@edit')->name('edit-task');
        Route::delete('', 'Tasks\TasksController@delete')->name('delete-task');
    });
});

Route::post('file/upload', 'Files\FilesController@upload')->name('upload-file');