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
    if (intval($user->id) === intval($id)) {
        if (config('broadcasting.default') === 'pusher') {
            return [
                'id' => $user->id,
                'name' => $user->name,
            ];
        }

        return true;
    }

    return false;
});

Broadcast::channel('room.{roomId}', function ($user, $roomId) {
    if ($user->canJoinRoom($roomId)) {
        if (config('broadcasting.default') === 'pusher') {
            return [
                'id' => $user->id,
                'name' => $user->name,
            ];
        }

        return true;
    }

    return false;
});

Broadcast::channel('room.{roomId}.{userId}', function ($user, $roomId, $userId) {
    if ($user->canJoinRoom($roomId)
        && ($user->id == $userId || $user->hasRole('admin'))) {
        if (config('broadcasting.default') === 'pusher') {
            return [
                'id' => $user->id,
                'name' => $user->name,
            ];
        }

        return true;
    }

    return false;
});
