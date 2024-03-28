<?php

namespace App\Policies\V1;

use App\Models\EquityStatement;
use App\Models\User;

class EquityStatementPolicy
{

    /**
     * Determine whether the user can update the model.
     */
    public function show(User $user, EquityStatement $equityStatement): bool
    {
        return $this->equityStatementBelongsToUser($user, $equityStatement);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, EquityStatement $equityStatement): bool
    {
        return $this->equityStatementBelongsToUser($user, $equityStatement);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, EquityStatement $equityStatement): bool
    {
        return $this->equityStatementBelongsToUser($user, $equityStatement);
    }

    private function equityStatementBelongsToUser(User $user, EquityStatement $equityStatement): bool
    {
        return $equityStatement->user_id == $user->id;
    }

}
