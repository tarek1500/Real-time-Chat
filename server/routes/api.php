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

Route::post('register', 'Api\UserController@register');

Route::group(['middleware' => ['auth:api']], function () {
	Route::get('user', 'Api\UserController@getUser');
	Route::get('users', 'Api\UserController@getAllUsers');

	Route::post('chat/show', 'Api\ChatController@getChat');
	Route::post('chat/send', 'Api\ChatController@sendChat');
});