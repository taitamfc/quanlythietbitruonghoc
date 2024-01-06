<?php

namespace App\Policies;

use App\Models\AdminPost;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AdminPostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('AdminPost_viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AdminPost $adminPost)
    {
        return $user->hasPermission('AdminPost_view');

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->hasPermission('AdminPost_create');

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AdminPost $adminPost)
    {
        return $user->hasPermission('AdminPost_update');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AdminPost $adminPost)
    {
        return $user->hasPermission('AdminPost_delete');

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, AdminPost $adminPost)
    {
        return $user->hasPermission('AdminPost_restore');

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, AdminPost $adminPost)
    {
        return $user->hasPermission('AdminPost_forceDelete');

    }
    public function trash(User $user)
    {
        return $user->hasPermission('AdminPost_trash');
    }
}