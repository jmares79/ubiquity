<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/expressions', 'ExpressionController@fetchAll')->name('get-expressions');
Route::get('/expression/{id}', 'ExpressionController@fetchBy')->where(['id' => '[0-9]+'])->name('get-expression');
Route::post('/expression', 'ExpressionController@create')->name('create-expression');
Route::put('/expression/{id}', 'ExpressionController@update')->where(['id' => '[0-9]+'])->name('update-expression');
Route::delete('/expression/{id}', 'ExpressionController@delete')->where(['id' => '[0-9]+'])->name('delete-expression');