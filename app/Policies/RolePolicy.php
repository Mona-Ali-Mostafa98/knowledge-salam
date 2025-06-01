<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_role');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Role $role): bool
    {
        return $user->can('view_role');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_role');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Role $role): bool
    {
        return $user->can('update_role');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Role $role): bool
    {
        return $user->can('delete_role');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_role');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Role $role): bool
    {
        return $user->can('{{ ForceDelete }}');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('{{ ForceDeleteAny }}');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Role $role): bool
    {
        return $user->can('{{ Restore }}');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('{{ RestoreAny }}');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Role $role): bool
    {
        return $user->can('{{ Replicate }}');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('{{ Reorder }}');
    }

    /**
     * Determine whether the user can review.
     */
    public function review(User $user, Role $role): bool
    {
        return $user->can('review_role');
    }

    /**
     * Determine whether the user can review any.
     */
    public function reviewAny(User $user): bool
    {
        return $user->can('{{ review_any_role }}');
    }

    /**
     * Determine whether the user can approve.
     */
    public function approve(User $user, Role $role): bool
    {
        return $user->can('approve_role');
    }

    /**
     * Determine whether the user can approve any.
     */
    public function approveAny(User $user): bool
    {
        return $user->can('approve_any_role');
    }

    /**
     * Determine whether the user can publish.
     */
    public function publish(User $user, Role $role): bool
    {
        return $user->can('publish_role');
    }

    /**
     * Determine whether the user can publish any.
     */
    public function publishAny(User $user): bool
    {
        return $user->can('publish_any_role');
    }

    /**
     * Determine whether the user can reject.
     */
    public function reject(User $user, Role $role): bool
    {
        return $user->can('reject_role');
    }

    /**
     * Determine whether the user can reject any.
     */
    public function rejectAny(User $user): bool
    {
        return $user->can('reject_any_role');
    }

    /**
     * Determine whether the user can export.
     */
    public function export(User $user, Role $role): bool
    {
        return $user->can('export_role');
    }

    /**
     * Determine whether the user can export any.
     */
    public function exportAny(User $user): bool
    {
        return $user->can('export_any_role');
    }
}
