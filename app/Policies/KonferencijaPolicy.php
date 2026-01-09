<?php

namespace App\Policies;

use App\Models\Konferencija;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class KonferencijaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, ?Konferencija $konferencija): bool
    {
        return true;
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
    public function update(User $user, Konferencija $konferencija): bool
    {
        return $user -> id === $konferencija -> kreator ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Konferencija $konferencija): bool
    {
        return $user -> id === $konferencija -> kreator ? true : false;

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Konferencija $konferencija): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Konferencija $konferencija): bool
    {
        return false;
    }

    public function updateStatus(User $user, Konferencija $konferencija): bool
    {
        // example rules:
        return $user->toAdmin()->exists() and $konferencija -> kreator != $user -> id;
    }
}
