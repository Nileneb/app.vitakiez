<?php

namespace App\Policies;

use App\Models\CaseModel;
use App\Models\User;

class CasePolicy
{
    /**
     * Determine whether the user can view the case.
     */
    public function view(User $user, CaseModel $case): bool
    {
        // User can view if case belongs to their active WG or they created it
        return $case->wg_id === $user->active_wg_id || $case->created_by_user_id === $user->id;
    }

    /**
     * Determine whether the user can update the case.
     */
    public function update(User $user, CaseModel $case): bool
    {
        // User can update if case belongs to their active WG or they created it
        return $case->wg_id === $user->active_wg_id || $case->created_by_user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the case.
     */
    public function delete(User $user, CaseModel $case): bool
    {
        // Only creator can delete
        return $case->created_by_user_id === $user->id;
    }
}
