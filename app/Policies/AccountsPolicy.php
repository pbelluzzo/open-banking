<?php

namespace App\Policies;

use App\Models\Accounts;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Accounts  $accounts
     * @return mixed
     */
    public function view(User $user, Accounts $accounts)
    {
        if(requestUserIsInstitution($user)) return true;
        if($accounts->clients_id == $user->entity_id) return true;
        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return requestUserIsInstitution($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Accounts  $accounts
     * @return mixed
     */
    public function update(User $user, Accounts $accounts)
    {
        return (requestUserIsInstitution($user) && $accounts->financial_institutions_id == $user->entity_id);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Accounts  $accounts
     * @return mixed
     */
    public function delete(User $user, Accounts $accounts)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Accounts  $accounts
     * @return mixed
     */
    public function restore(User $user, Accounts $accounts)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Accounts  $accounts
     * @return mixed
     */
    public function forceDelete(User $user, Accounts $accounts)
    {
        return false;
    }

    private function requestUserIsInstitution($user)
    {
        return $user->entity_type == FinancialInstitutions::class;
    }
}
