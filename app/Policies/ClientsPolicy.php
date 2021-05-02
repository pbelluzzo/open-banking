<?php

namespace App\Policies;

use App\Models\Clients;
use App\Models\User;
use App\Models\FinancialInstitutions;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Builder;

class ClientsPolicy
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
        if(!$this->requestUserIsInstitution($user)){
            return false;
        }
        return ($this->clientHasAccountInInstitution($user, Clients::class));
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Clients  $clients
     * @return mixed
     */
    public function view(User $user, Clients $clients)
    {
        if($this->requestUserIsInstitution($user)){
            return ($this->clientHasAccountInInstitution($user,$clients));
        }
        return $clients->id == $user->entity_id;
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
     * @param  \App\Models\Clients  $clients
     * @return mixed
     */
    public function update(User $user, Clients $clients)
    {   
        if($this->requestUserIsInstitution($user)){
            return ($this->clientHasAccountInInstitution($user,$clients));
        }
        return $clients->id == $user->entity_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Clients  $clients
     * @return mixed
     */
    public function delete(User $user, Clients $clients)
    {
        if($this->requestUserIsInstitution($user)){
            return ($this->clientHasAccountInInstitution($user,$clients));
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Clients  $clients
     * @return mixed
     */
    public function restore(User $user, Clients $clients)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Clients  $clients
     * @return mixed
     */
    public function forceDelete(User $user, Clients $clients)
    {
        //
    }

    private function requestUserIsInstitution($user)
    {
        return $user->entity_type == FinancialInstitutions::class;
    }

    private function clientHasAccountInInstitution($user, $clients)
    {
        return $clients::whereHas('accounts', function ( Builder $query) use($user) {
            $query->where('accounts.financial_institutions_id', '=', $user->entity_id);
        })->exists();
    }
}
