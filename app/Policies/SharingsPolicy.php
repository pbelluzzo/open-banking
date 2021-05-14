<?php

namespace App\Policies;

use App\Models\Sharings;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SharingsPolicy
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
     * @param  \App\Models\Sharings  $sharings
     * @return mixed
     */
    public function view(User $user, Sharings $sharings)
    {
        if (requestUserIsClient()){
            return $user->entity_id == $sharings->clients_id;
        }
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return !requestUserIsClient();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sharings  $sharings
     * @return mixed
     */
    public function update(User $user, Sharings $sharings)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sharings  $sharings
     * @return mixed
     */
    public function delete(User $user, Sharings $sharings)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sharings  $sharings
     * @return mixed
     */
    public function restore(User $user, Sharings $sharings)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sharings  $sharings
     * @return mixed
     */
    public function forceDelete(User $user, Sharings $sharings)
    {
        return false;
    }
}
