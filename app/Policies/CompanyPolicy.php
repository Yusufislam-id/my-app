<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;

class CompanyPolicy
{
    public function viewAny(User $user): bool
    {
        // Hanya Super Admin dan Founder yang bisa lihat menu Companies
        return $user->isSuperAdmin() || $user->isFounder();
    }

    public function view(User $user, Company $company): bool
    {
        return $user->isSuperAdmin() || $user->isFounder();
    }

    public function create(User $user): bool
    {
        return $user->isSuperAdmin() || $user->isFounder();
    }

    public function update(User $user, Company $company): bool
    {
        return $user->isSuperAdmin() || $user->isFounder();
    }

    public function delete(User $user, Company $company): bool
    {
        return $user->isSuperAdmin() || $user->isFounder();
    }

    public function restore(User $user, Company $company): bool
    {
        return $user->isSuperAdmin() || $user->isFounder();
    }

    public function forceDelete(User $user, Company $company): bool
    {
        return $user->isSuperAdmin();
    }
}
