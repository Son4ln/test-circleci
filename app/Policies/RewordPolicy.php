<?php

namespace App\Policies;

use App\User;
use App\Reword;
use Illuminate\Auth\Access\HandlesAuthorization;

class RewordPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the reword.
     *
     * @param  \App\User  $user
     * @param  \App\Reword  $reword
     * @return mixed
     */
    public function view(User $user, Reword $reword)
    {
        //
    }

    /**
     * Determine whether the user can create rewords.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the reword.
     *
     * @param  \App\User  $user
     * @param  \App\Reword  $reword
     * @return mixed
     */
    public function update(User $user, Reword $reword)
    {
        return $user->id == $reword->reword_user_id && $reword->status == 0;
    }

    /**
     * Determine whether the user can delete the reword.
     *
     * @param  \App\User  $user
     * @param  \App\Reword  $reword
     * @return mixed
     */
    public function delete(User $user, Reword $reword)
    {
        //
    }
}
