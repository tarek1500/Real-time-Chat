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

Route::post('login', 'Api\AuthController@login');
Route::post('register', 'Api\AuthController@register');

Route::post('token/check', 'Api\AuthController@checkToken');
Route::post('token/refresh', 'Api\AuthController@refreshToken');

Route::group(['middleware' => ['auth:api']], function () {
	Route::get('logout', 'Api\AuthController@logout');

	Route::get('user', 'Api\UserController@getUser');
	Route::get('users', 'Api\UserController@getAllUsers');

	Route::post('chat/show', 'Api\ChatController@getChat');
	Route::post('chat/send', 'Api\ChatController@sendChat');

	Route::post('pm/send', 'Api\PrivateMessageController@sendMessage');
	Route::get('pm/inbox', 'Api\PrivateMessageController@getInbox');
	Route::get('pm/outbox', 'Api\PrivateMessageController@getOutbox');
	Route::post('pm/show', 'Api\PrivateMessageController@showMessage');
});