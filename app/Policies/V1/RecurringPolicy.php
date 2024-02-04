<?php

namespace App\Policies\V1;

use App\Models\Recurring;
use App\Models\User;

class RecurringPolicy
{

    /**
     * Determine whether the user can update the model.
     */
    public function show(User $user, Recurring $recurring): bool
    {
        return $this->recurringBelongsToUser($user, $recurring);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Recurring $recurring): bool
    {
        return $this->recurringBelongsToUser($user, $recurring);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Recurring $recurring): bool
    {
        return $this->recurringBelongsToUser($user, $recurring);
    }

    private function recurringBelongsToUser(User $user, Recurring $recurring): bool
    {
        return $recurring->user_id == $user->id;
    }
}
