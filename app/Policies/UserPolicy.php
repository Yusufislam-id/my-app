<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        // Super Admin dan Founder bisa melihat list users
        return $user->isSuperAdmin() || $user->isFounder();
    }

    public function view(User $user, User $model): bool
    {
        // Super Admin bisa lihat semua users
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Founder bisa lihat semua users
        if ($user->isFounder()) {
            return true;
        }

        // User lain hanya bisa lihat user dari PT sendiri
        return $user->company_id === $model->company_id;
    }

    public function create(User $user): bool
    {
        // Hanya Super Admin yang bisa membuat user
        return $user->isSuperAdmin();
    }

    public function update(User $user, User $model): bool
    {
        // Hanya Super Admin yang bisa update user
        return $user->isSuperAdmin();
    }

    public function delete(User $user, User $model): bool
    {
        // Hanya Super Admin yang bisa delete user
        return $user->isSuperAdmin();
    }
}

