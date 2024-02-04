<?php

namespace App\Policies\V1;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
  
    /**
     * Determine whether the user can update the model.
     */
    public function show(User $user, Category $category): bool
    {
        return $this->categoryBelongsToUser($user, $category);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Category $category): bool
    {
        return $this->categoryBelongsToUser($user, $category);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Category $category): bool
    {
        return $this->categoryBelongsToUser($user, $category);
    }

    private function categoryBelongsToUser(User $user, Category $category): bool
    {
        return $category->user_id == $user->id;
    }

}
