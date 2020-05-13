<?php
declare(strict_types=1);

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

Route::get('/uploads/{id}/{file_name}', 'AccessFileController@file');
Route::get('/file/{token}', 'AccessFileController@token')->name('token.link');

Route::prefix('/user')->name('user.')->middleware('auth')->group(function () {
    Route::resource('file', 'User\FileController');

    Route::get('/report', 'User\ReportController@index')->name('report.index');
});

Route::get('/', 'HomeController@index');

Auth::routes();
