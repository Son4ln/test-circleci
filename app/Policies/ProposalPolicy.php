<?php

namespace App\Policies;

use App\User;
use App\Proposal;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProposalPolicy
{
    use HandlesAuthorization;

    /**
     * Determine who can update proposals.
     *
     * @param  \App\User  $user
     * @param  \App\Proposal
     * @return bool
     */
    public function update(User $user, Proposal $proposal)
    {
        return $user->id == $proposal->user_id;
    }

    /**
     * Determine who can delete proposals.
     *
     * @param  \App\User  $user
     * @param  \App\Proposal
     * @return bool
     */
    public function delete(User $user, Proposal $proposal)
    {
        return $user->id == $proposal->user_id;
    }

    /**
     * Determine who can view proposals.
     *
     * @param  \App\User  $user
     * @param  \App\Proposal
     * @return bool
     */
    public function view(User $user, Proposal $proposal)
    {
        $project = \App\Project::select('id', 'user_id')->findOrFail($proposal->project_id);

        return $user->id == $proposal->user_id || $project->user_id == $user->id;
    }

    /**
     * Determine who can acceptance proposals.
     *
     * @param  \App\User  $user
     * @param  \App\Proposal
     * @return bool
     */
    public function acceptance(User $user, Proposal $proposal)
    {
        return $proposal->user_id == $user->id || $proposal->state == $proposal->states['started'];
    }

    /**
     * Determine who can acceptance proposals.
     *
     * @param  \App\User  $user
     * @param  \App\Proposal
     * @return bool
     */
    public function adminAcceptance(User $user, Proposal $proposal)
    {
        return $user->isAdmin() && $proposal->state == $proposal->states['pending'];
    }

    /**
     * Determine who can acceptance proposals.
     *
     * @param  \App\User  $user
     * @param  \App\Proposal
     * @return bool
     */
     public function clientAcceptance(User $user, Proposal $proposal)
     {
         return $user->isClient() && $proposal->state == $proposal->states['checking'];
     }
}
