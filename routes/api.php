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

// Registration and Authentication routes
Route::post('/register', 'Api\RegisterController@register');

// Routes requiring authentication
Route::group(['middleware' => ['auth:api', 'cors']], function() {

	Route::get('/users', 'Api\UsersController@list')->middleware('can:list,App\User');
	Route::get('/users/{user}', 'Api\UsersController@view')->middleware('can:view,user');
	Route::delete('/users/{user}', 'Api\UsersController@delete')->middleware('can:delete,user');

});
