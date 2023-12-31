<?php

namespace App\Policies;

use Modules\AdminUser\app\Models\Group;
// use Modules\AdminUser\app\Models\User;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GroupPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('Group_viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Group $group)
    {
        return $user->hasPermission('Group_view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->hasPermission('Group_create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Group $group)
    {
        return $user->hasPermission('Group_update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Group $group)
    {
        return $user->hasPermission('Group_delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Group $group)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Group $group)
    {
        //
    }
}
