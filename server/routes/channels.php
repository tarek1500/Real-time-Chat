<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.{sender}.{receiver}', function ($user) {
	return $user->only(['id', 'name']);
});

Broadcast::channel('pm.{receiver}', function ($user, $receiver) {
	return (int) $user->id === (int) $receiver;
});