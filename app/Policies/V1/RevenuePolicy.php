<?php

namespace App\Policies\V1;

use App\Models\Revenue;
use App\Models\User;

class RevenuePolicy
{

        /**
     * Determine whether the user can update the model.
     */
    public function show(User $user, Revenue $revenue): bool
    {
        return $this->revenueBelongsToUser($user, $revenue);
    }

    
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Revenue $revenue): bool
    {
        return $this->revenueBelongsToUser($user, $revenue);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Revenue $revenue): bool
    {
        return $this->revenueBelongsToUser($user, $revenue);
    }
    

    private function revenueBelongsToUser(User $user, Revenue $revenue): bool
    {
        return $revenue->user_id == $user->id;
    }

}
