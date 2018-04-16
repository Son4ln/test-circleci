<?php

namespace App\Policies;

use App\User;
use App\Project;
use App\ProjectFile;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectFilePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list all project files.
     *
     * @param User $actor
     * @param CreativeRoom $room
     * @return bool
     */
    public function index(User $actor, CreativeRoom $room = null)
    {
        if ($room === null) {
            return false;
        }

        return $room->user_id == $actor->id ||
            $actor->hasAnyPermission(['view projects', 'delete project files']) ||
            $room->creativeroomUsers()->where('user_id', $actor->id)->exists();
    }

    /**
     * Determine whether the user can view/download the project file.
     *
     * @param  User  $actor
     * @param  ProjectFile  $file
     * @return mixed
     */
    public function view(User $actor, ProjectFile $file)
    {
        if ($file->user_id == $actor->id) {
            return true;
        }

        return $this->index($actor, $file->room ?? $file->room()->first());
    }

    /**
     * Determine whether the user can create/upload project files.
     *
     * @param  User  $actor
     * @param  CreativeRoom $room
     * @return mixed
     */
    public function create(User $actor, CreativeRoom $room = null)
    {
        if ($room === null) {
            return false;
        }

        return $room->user_id == $actor->id ||
            $actor->hasAnyPermission(['upload project files']) ||
            $room->creativeroomUsers()->where('user_id', $actor->id)->exists();
    }

    /**
     * Determine whether the user can update the project file.
     *
     * @param  \App\User  $actor
     * @param  \App\ProjectFile  $projectFile
     * @return mixed
     */
    public function update(User $actor, ProjectFile $projectFile)
    {
        // TODO: change permission
        return $projectFile->user_id == $actor->id;
    }

    /**
     * Determine whether the user can delete the project file.
     *
     * @param  User  $actor
     * @param  ProjectFile  $file
     * @return mixed
     */
    public function delete(User $actor, ProjectFile $file)
    {
        return $file->user_id == $actor->id || $actor->isAdmin();
        //
        // $room = $file->room ?? $file->room()->first();
        // if ($room === null) {
        //     return false;
        // }

        // return $room->user_id == $actor->id;
            // || $actor->hasAnyPermission(['delete project files'])
            // || $room->creativeroomUsers()->where('user_id', $actor->id)->exists();
    }
}
