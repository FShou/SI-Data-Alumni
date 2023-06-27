<?php

namespace App\Policies;

use App\Models\Alumni;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AlumniPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //

        return $user->hasRole(['Admin','Alumni']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Alumni $alumni): bool
    {
        //
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Alumni $alumni): bool
    {
        //
        $admin = $user->hasRole('Admin');
        $owner = $user['id'] == $alumni['id_user'];
        return $admin || $owner;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Alumni $alumni): bool
    {
        //
        return $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Alumni $alumni): bool
    {
        //
        return $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Alumni $alumni): bool
    {
        //
        return $user->hasRole('Admin');
    }
}
