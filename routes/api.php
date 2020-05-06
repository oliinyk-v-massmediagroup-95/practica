<?php

use Illuminate\Http\Request;
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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/login', 'Api\LoginController@login');

Route::middleware('auth:api')->prefix('/user')->name('api.user.')->group(function () {
    Route::post('/link/create', 'Api\LinkController@create')->name('link.create');

    Route::prefix('/file')->group(function () {
        Route::get('/get/{id}', 'Api\FileController@get')->name('file.get');
        Route::post('/set', 'Api\FileController@set')->name('file.set');
        Route::post('/delete/{id}', 'Api\FileController@delete')->name('file.delete');
    });
});
