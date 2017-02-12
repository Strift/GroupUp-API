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

Route::group(['middleware' => 'cors'], function() {

	// Registration and Authentication routes
	Route::post('/register', 'Api\RegisterController@register');
	Route::post('/login', 'Api\LoginController@login');

	// Routes requiring authentication
	Route::group(['middleware' => 'auth:api'], function() {

		// Users API
		Route::get('/users', 'Api\UsersController@list')->middleware('can:list,App\User');
		Route::get('/users/{user}', 'Api\UsersController@view')->middleware('can:view,user');
		Route::delete('/users/{user}', 'Api\UsersController@delete')->middleware('can:delete,user');

		// Friends API
		Route::get('/users/{owner}/friends', 'Api\FriendsController@list')->middleware('can:listFriends,owner');
		Route::post('/users/{owner}/friends', 'Api\FriendsController@add')->middleware('can:addFriend,owner');
		Route::delete('/users/{owner}/friends', 'Api\FriendsController@remove')->middleware('can:removeFriend,owner');

	});

});
