<?php

namespace App\Policies;

use App\User;
use App\Project;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list the projects.
     *
     * @param User $actor
     * @return bool
     */
    public function index(User $actor)
    {
        return true;
    }

    /**
     * Determine whether the user can view the project.
     *
     * @param  \App\User $actor
     * @param  \App\Project $project
     * @return mixed
     */
    public function view(User $actor, Project $project)
    {
        return true;
    }

    /**
     * Determine whether the user can view the project message.
     *
     * @param  \App\User $actor
     * @param  \App\Project $project
     * @return mixed
     */
    public function viewMessage(User $actor, Project $project)
    {
        return $actor->isAdmin() || $actor->id == $project->user_id
            || $actor->proposals()->where([
                'offer' => 1,
                'project_id' => $project->id
            ])->count();
    }

    /**
     * Determine whether the user can create normal projects.
     *
     * @param  \App\User $actor
     * @return mixed
     */
    public function create(User $actor)
    {
        return $actor->hasPermissionTo('create projects');
    }

    /**
     * Determine whether the user can create prime projects.
     *
     * @param  \App\User $actor
     * @return mixed
     */
    public function createPrime(User $actor)
    {
        return $actor->hasPermissionTo('create prime projects');
    }

    /**
     * Determine whether the user can update the project.
     *
     * @param  \App\User $actor
     * @param  \App\Project $project
     * @return mixed
     */
    public function update(User $actor, Project $project)
    {
        return ($project->user_id == $actor->id || $actor->hasPermissionTo('update projects'))
            && $project->status < $project->statuses['public'];
    }

    /**
     * Determine whether the user can delete the project.
     *
     * @param  \App\User $actor
     * @param  \App\Project $project
     * @return mixed
     */
    public function delete(User $actor, Project $project)
    {
        return $project->user_id == $actor->id || $actor->hasPermissionTo('delete projects');
    }

    /**
     * Determine whether the user can cancel the project.
     *
     * @param  \App\User $actor
     * @param  \App\Project $project
     * @return mixed
     */
    public function cancel(User $actor, Project $project)
    {
        return $project->user_id == $actor->id && $project->canCancel();
    }

    /**
     * Determine whether the user can propose the project.
     *
     * @param  \App\User $actor
     * @return mixed
     */
    public function propose(User $actor, Project $project)
    {
        return $actor->isCreator() && $actor->id != $project->user_id
            && $project->status == $project->statuses['public'];
    }

    /**
     * Determine whether the user can close the project admin.
     *
     * @param  \App\User $actor
     * @return mixed
     */
    public function admin(User $actor)
    {
        return $actor->isAdmin();
    }

    /**
     * Determine whether user can choose proposals
     *
     * @param User $actor
     * @param Project $project
     *
     * @return bool
     */
    public function chooseProposal(User $actor, Project $project)
    {
        return $project->status <= $project->statuses['public']
            && $actor->id == $project->user_id;
    }


    /**
     * Determine whether user can accept proposals
     *
     * @param User $actor
     * @param Project $project
     *
     * @return bool
     */
    public function acceptProposal(User $actor, Project $project)
    {
        /**
         * @var int
         */
        $poroposalOffered = $project->proposals()
            ->where('offer', 1)->count();

        if ($actor->hasRole('prime-client')) {
            return  $poroposalOffered < 6;
        }

        return $poroposalOffered < 1;
    }

    /**
     * Determine whether the user can finish the project.
     *
     * @param  \App\User $actor
     * @param  \App\Project $project
     * @return mixed
     */
    public function finish(User $actor, Project $project)
    {
        return ($project->user_id == $actor->id || $actor->hasPermissionTo('update projects'))
            && $project->status == $project->statuses['checking'];
    }

    /**
     * Determine whether the user can finish the project.
     *
     * @param  \App\User $actor
     * @param  \App\Project $project
     * @return mixed
     */
     public function download(User $actor, Project $project)
     {
         if ($project->status == $project->statuses['cancel']) {
             return false;
         }

         return ($project->status == $project->statuses['delivered']
            && $actor->id == $project->user_id);
     }

     /**
      * Determine who can change project state
      *
      * @param User $actor
      * @param Project $project
      *
      * @return bool
      */
     public function changeState(User $actor, Project $project)
     {
         return $actor->hasRole('admin');
     }

     /**
      * Determine who can show offeredProposal
      *
      * @param User $actor
      * @param Project $project
      *
      * @return bool
      */
     public function showOfferedProposal(User $actor, Project $project)
     {
         if ($project->status == $project->statuses['cancel']) {
             return false;
         }

         return $project->status >= $project->statuses['pending']
            && $actor->hasRole('admin')
            && $project->offeredProposal();
     }

     /**
      * Determine which project can delivery
      *
      * @param User $actor
      * @param Project $project
      * @return mixed
      */
     public function delivery(User $actor, Project $project)
     {
         return $project->status == $project->statuses['pending']
            && $actor->hasRole('admin')
            && $project->offeredProposal();
     }

     /**
      * Determine who can approval project
      *
      * @param User $actor
      */
     public function approval(User $actor)
     {
         return $actor->hasRole('admin');
     }

     /**
      * Determine which project can approal and send mail
      *
      * @param User $actor
      * @param Project $project
      * @return mixed
      */
     public function public(User $actor, Project $project)
     {
         if (!$actor->hasRole('admin')) {
             return false;
         }

         return $project->status == $project->statuses['registered']
            || $project->status == $project->statuses['paid'];
     }

     /**
      * Determine which project can approal and send mail
      *
      * @param User $actor
      * @param Project $project
      * @return mixed
      */
     public function creatorAcceptance(User $actor, Project $project)
     {
         if ($project->isPrime()) {
             return false;
         }

         $proposal = $project->offeredProposal();
         if (!$proposal) {
             return false;
         }

         return $actor->isCreator() && ($project->status == $project->statuses['started']
            || $project->status == $project->statuses['pending'])
            && $project->user_id != $actor->id
            && $proposal->user_id == $actor->id;
     }

     public function creatorOperationAcceptance(User $actor, Project $project)
     {
         if (!$actor->isCreator()) {
             return false;
         }

         $proposal = $project->operationCreatorProposal();

         return $proposal;
     }

     /**
      * Determine which project can approal and send mail
      *
      * @param User $actor
      * @param Project $project
      * @return mixed
      */
     public function adminAcceptance(User $actor, Project $project)
     {
         return $actor->isAdmin() && $project->isStatus('pending');
     }

     /**
      * Determine which project can approal and send mail
      *
      * @param User $actor
      * @param Project $project
      * @return mixed
      */
     public function showPrimeProposals(User $actor, Project $project)
     {
         return $project->is_prime && $project->user_id == $actor->id;
     }

     /**
      * Choose prime proposals
      */
     public function selectProposals(User $actor, Project $project)
     {
         $selectedProposals = \App\Proposal::where('state', '<>', 0)
             ->whereHas('project', function($query) {
                 $query->where('is_prime', 1)
                     ->where('user_id', auth()->id());
             })->whereMonth('updated_at', date('m'))
             ->whereYear('updated_at', date('Y'))->count();

        return $selectedProposals <= 6 && $project->user_id == auth()->id();
     }
}
