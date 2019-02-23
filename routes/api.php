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
Route::post('/expression', 'ExpressionController@create')->name('create-expression');
Route::put('/expression/{expressionId}', 'ExpressionController@update')->name('update-expression');
Route::delete('/expression/{expressionId}', 'ExpressionController@delete')->name('delete-expression');