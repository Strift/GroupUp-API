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

Route::group(['middleware' => ['auth:api', 'cors']], function() {

	Route::get('/users', 'UsersController@list')->middleware('can:list,App\User');
	Route::get('/users/{user}', 'UsersController@view')->middleware('can:view,user');

});
