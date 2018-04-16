<?php

namespace App\Policies;

use App\User;
use App\Payment;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the payment.
     *
     * @param  \App\User $actor
     * @return bool
     */
    public function index(User $actor)
    {
        return $actor->hasAnyPermission([
            'index payments',
            'index my payments',
        ]);
    }

    /**
     * Determine whether the user can view the payment.
     *
     * @param  \App\User $actor
     * @param  \App\Payment $payment
     * @return bool
     */
    public function view(User $actor, Payment $payment)
    {
        return $payment->user_id == $actor->id || $actor->hasPermissionTo('update payments');
    }

    /**
     * Determine whether the user can create payments.
     *
     * @param  \App\User $actor
     * @return bool
     */
    public function create(User $actor)
    {
        return $actor->hasPermissionTo('create payment');
    }

    /**
     * Determine whether the user can update the payment.
     *
     * @param  \App\User $actor
     * @param  \App\Payment $payment
     * @return bool
     */
    public function update(User $actor, Payment $payment)
    {
        return $actor->hasPermissionTo('update payments');
    }

    /**
     * Determine whether the user can delete the payment.
     *
     * @param  \App\User $actor
     * @param  \App\Payment $payment
     * @return bool
     */
    public function delete(User $actor, Payment $payment)
    {
        return $actor->hasPermissionTo('update payments');
    }
}
