<?php

namespace App\Policies;

use App\Models\Contracts;
use App\Models\User;
use App\Models\FinancialInstitutions;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContractsPolicy
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
        if ($this->requestUserIsInstitution($user)) return true;

        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Contracts  $contracts
     * @return mixed
     */
    public function view(User $user, Contracts $contracts)
    {
        if (!$this->requestUserIsInstitution($user)){
            return $user->entity_id == $contracts->accounts->clients_id;
        }
        return ($contracts->accounts->financial_institutions_id == $user->entity_id);

    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->requestUserIsInstitution($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Contracts  $contracts
     * @return mixed
     */
    public function update(User $user, Contracts $contracts)
    {
        if (!$this->requestUserIsInstitution($user)){
            return ($user->entity_id == $contracts->accounts->clients_id && $contracts->hiring_date == null);
        }
        return ($contracts->accounts->financial_institutions_id == $user->entity_id && $contracts->hiring_date == null);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Contracts  $contracts
     * @return mixed
     */
    public function delete(User $user, Contracts $contracts)
    {
        if (!$this->requestUserIsInstitution($user)){
            return false;
        }
        return ($contracts->accounts->financial_institutions_id == $user->entity_id && $contracts->hiring_date == null);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Contracts  $contracts
     * @return mixed
     */
    public function restore(User $user, Contracts $contracts)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Contracts  $contracts
     * @return mixed
     */
    public function forceDelete(User $user, Contracts $contracts)
    {
        return false;
    }

    private function requestUserIsInstitution($user)
    {
        return $user->entity_type == FinancialInstitutions::class;
    }
}
