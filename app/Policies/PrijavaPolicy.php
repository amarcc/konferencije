<?php

namespace App\Policies;

use App\Models\Konferencija;
use App\Models\Prijava;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PrijavaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Prijava $prijava): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Prijava $prijava): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ?string $prijava): bool
    {
        return $user ? true : false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Prijava $prijava): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Prijava $prijava): bool
    {
        return false;
    }
}
