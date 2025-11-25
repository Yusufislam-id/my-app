<?php

namespace App\Policies;

use App\Models\ProjectFinance;
use App\Models\User;

class ProjectFinancePolicy
{
    public function viewAny(User $user): bool
    {
        // Semua user kecuali Admin Pemberkasan bisa lihat menu
        return !$user->isAdminPemberkasan();
    }

    public function view(User $user, ProjectFinance $projectFinance): bool
    {
        // Super Admin bisa lihat semua laporan
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Founder bisa lihat semua laporan
        if ($user->isFounder()) {
            return true;
        }

        // User lain hanya bisa lihat dari PT sendiri
        return $user->company_id === $projectFinance->company_id;
    }

    public function create(User $user): bool
    {
        // Super Admin bisa membuat laporan
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Hanya Admin Keuangan yang bisa membuat laporan
        return $user->isAdminKeuangan();
    }

    public function update(User $user, ProjectFinance $projectFinance): bool
    {
        // Super Admin bisa update semua laporan
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Hanya Admin Keuangan dari PT yang sama yang bisa update
        return $user->isAdminKeuangan() &&
            $user->company_id === $projectFinance->company_id;
    }

    public function delete(User $user, ProjectFinance $projectFinance): bool
    {
        // Super Admin bisa delete semua
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Admin Keuangan hanya bisa delete dari PT yang sama
        return $user->isAdminKeuangan() &&
            $user->company_id === $projectFinance->company_id;
    }

    public function restore(User $user, ProjectFinance $projectFinance): bool
    {
        return $user->isSuperAdmin() ||
            ($user->isAdminKeuangan() && $user->company_id === $projectFinance->company_id);
    }

    public function forceDelete(User $user, ProjectFinance $projectFinance): bool
    {
        return $user->isSuperAdmin();
    }
}
