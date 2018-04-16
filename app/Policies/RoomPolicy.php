<?php

namespace App\Policies;

use App\CreativeRoom;
use App\CreativeroomUser;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RoomPolicy
{
    use HandlesAuthorization;

    /**
     * @var int
     */
    private $roomLimit = 50;

    /**
     * @var int
     */
    private $fileLimit = 100;

    /**
     * Determine whether the user can index rooms.
     *
     * @param  User  $actor
     * @return bool
     */
    public function index(User $actor)
    {
        return $actor->hasAnyPermission([
            'index rooms',
            'index my rooms',
        ]);
    }

    /**
     * Determine whether the user can view the room.
     *
     * @param  User  $actor
     * @param  CreativeRoom  $room
     * @return bool
     */
    public function view(User $actor, CreativeRoom $room)
    {
        if ($actor->isAdmin()) {
            return true;
        }

        $users = $room->creativeroomUsers()->where('state', 1)->get();
        return $room->user_id == $actor->id ||
            $actor->hasAnyPermission(['update rooms']) ||
            ($users && $users->contains('user_id', $actor->id)) ||
            $room->creativeroomUsers()->where('user_id', $actor->id)->exists();
    }

    /**
     * Determine whether the user can create rooms.
     *
     * @param  User  $actor
     * @return bool
     */
    public function create(User $actor)
    {
        //TODO count number rooms have created by user
        $roomsCount = CreativeRoom::where('user_id', $actor->id)
            ->doesntHave('proposal')
            ->count();

        return $roomsCount < $this->roomLimit;
    }

    /**
     * Determine whether the user can create rooms.
     *
     * @param  User  $actor
     * @return bool
     */
    public function show(User $actor, CreativeRoom $room)
    {
        if ($actor->isAdmin()) {
            return true;
        }
        $users = $room->creativeroomUsers()->where('state', 1)->get();
        return $users->contains('user_id', $actor->id);
    }

    /**
     * Determine whether the user can update the room.
     *
     * @param  User  $actor
     * @param  CreativeRoom  $room
     * @return bool
     */
    public function update(User $actor, CreativeRoom $room)
    {
        if ($actor->isAdmin()) {
            return true;
        }

        return $room->user_id == $actor->id
            || $actor->hasAnyPermission(['update rooms']);
    }

    /**
     * Determine whether the user can delete the room.
     *
     * @param  User  $actor
     * @param  CreativeRoom  $room
     * @return bool
     */
    public function delete(User $actor, CreativeRoom $room)
    {
        if ($actor->isAdmin()) {
            return true;
        }
        return $room->user_id == $actor->id ||
            $actor->hasAnyPermission(['delete rooms']) ||
            ($room->creativeroomUsers && $room->creativeroomUsers->contains('user_id', $actor->id)) ||
            $room->creativeroomUsers()->where('user_id', $actor->id)->exists();
    }

    /**
     * Determine who can add user to the room.
     *
     * @param  User  $actor
     * @param  CreativeRoom $room
     * @return bool
     */
    public function addUser(User $actor, CreativeRoom $room)
    {
        $usersCount = \App\CreativeroomUser::where('creativeroom_id', $room->id)
            ->where('state', 1)->count();

        if ($usersCount >= config('const.c_base_user_limit')) {
            return false;
        }

        if ($actor->isAdmin()) {
            return true;
        }
        return $room->user_id == $actor->id ||
            $actor->hasAnyPermission(['manage rooms']) ||
            $room->creativeroomUsers()
                ->where('user_id', $actor->id)
                ->where('role', CreativeroomUser::MASTER_ROLE)
                ->exists();
    }

    /**
     * Determine who can remove user from the room.
     *
     * @param  User  $actor
     * @param  CreativeRoom $room
     * @return bool
     */
    public function removeUser(User $actor, CreativeRoom $room)
    {
        if ($actor->isAdmin()) {
            return true;
        }

        return $room->user_id == $actor->id ||
            $room->creativeroomUsers()
                ->where('user_id', $actor->id)
                ->where('role', CreativeroomUser::MASTER_ROLE)
                ->exists();
    }

    /**
     * Authorize user can access room via admin role
     */
    public function admin(User $user)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine which user can update file
     */
    public function upload(User $actor, CreativeRoom $room)
    {
        /**
         * Not use 2018-03-07
         */

        /* $filesCount = \App\ProjectFile::where('creativeroom_id', $room->id)
            ->count();

        if ($filesCount >= $this->fileLimit) {
            return false;
        }  */

        if ($actor->isAdmin()) {
            return true;
        }

        //TODO Count files
        return $room->user_id == $actor->id ||
            $actor->hasAnyPermission(['upload project files']) ||
            $room->creativeroomUsers()->where('user_id', $actor->id)->exists();
    }
}
