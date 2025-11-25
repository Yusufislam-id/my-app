<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        // Hanya Super Admin yang bisa lihat menu Users
        return $user->isSuperAdmin();
    }

    public function view(User $user, User $model): bool
    {
        return $user->isSuperAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function update(User $user, User $model): bool
    {
        return $user->isSuperAdmin();
    }

    public function delete(User $user, User $model): bool
    {
        // Tidak bisa delete diri sendiri
        if ($user->id === $model->id) {
            return false;
        }

        return $user->isSuperAdmin();
    }

    public function restore(User $user, User $model): bool
    {
        return $user->isSuperAdmin();
    }

    public function forceDelete(User $user, User $model): bool
    {
        // Tidak bisa force delete diri sendiri
        if ($user->id === $model->id) {
            return false;
        }

        return $user->isSuperAdmin();
    }
}
