<?php

namespace App\Policies\V1;

use App\Models\Expense;
use App\Models\User;

class ExpensePolicy
{

    /**
     * Determine whether the user can update the model.
     */
    public function show(User $user, Expense $expense): bool
    {
        return $this->expenseBelongsToUser($user, $expense);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Expense $expense): bool
    {
        return $this->expenseBelongsToUser($user, $expense);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Expense $expense): bool
    {
        return $this->expenseBelongsToUser($user, $expense);
    }

    private function expenseBelongsToUser(User $user, Expense $expense): bool
    {
        return $expense->user_id == $user->id;
    }

}
