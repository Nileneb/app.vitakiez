<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Wg;

class WgPolicy
{
    /**
     * Determine whether the user can view the wg.
     */
    public function view(User $user, Wg $wg): bool
    {
        return $user->id === $wg->owner_user_id;
    }

    /**
     * Determine whether the user can update the wg.
     */
    public function update(User $user, Wg $wg): bool
    {
        return $user->id === $wg->owner_user_id;
    }

    /**
     * Determine whether the user can delete the wg.
     */
    public function delete(User $user, Wg $wg): bool
    {
        return $user->id === $wg->owner_user_id;
    }
}
