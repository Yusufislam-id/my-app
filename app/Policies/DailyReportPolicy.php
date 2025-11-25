<?php

namespace App\Policies;

use App\Models\DailyReport;
use App\Models\User;

class DailyReportPolicy
{
    public function viewAny(User $user): bool
    {
        // Semua user kecuali Admin Keuangan bisa lihat menu
        return !$user->isAdminKeuangan();
    }

    public function view(User $user, DailyReport $dailyReport): bool
    {
        // Super Admin dan Founder bisa lihat semua laporan
        if ($user->isSuperAdmin() || $user->isFounder()) {
            return true;
        }
        // Admin Keuangan tidak bisa lihat laporan harian
        if ($user->isAdminKeuangan()) {
            return false;
        }


        // User lain hanya bisa lihat laporan dari PT sendiri
        return $user->company_id === $dailyReport->company_id;
    }

    public function create(User $user): bool
    {
        // Hanya Super Admin dan Admin Pemberkasan yang bisa membuat laporan
        return $user->isSuperAdmin() || $user->isAdminPemberkasan();
    }

    public function update(User $user, DailyReport $dailyReport): bool
    {
        // Super Admin bisa update semua
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Admin Pemberkasan hanya bisa update laporan dari PT yang sama
        return $user->isAdminPemberkasan() &&
            $user->company_id === $dailyReport->company_id;
    }

    public function delete(User $user, DailyReport $dailyReport): bool
    {
        // Super Admin bisa delete semua
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Admin Pemberkasan hanya bisa delete laporan dari PT yang sama
        return $user->isAdminPemberkasan() &&
            $user->company_id === $dailyReport->company_id;
    }

    public function restore(User $user, DailyReport $dailyReport): bool
    {
        return $user->isSuperAdmin() ||
            ($user->isAdminPemberkasan() && $user->company_id === $dailyReport->company_id);
    }

    public function forceDelete(User $user, DailyReport $dailyReport): bool
    {
        return $user->isSuperAdmin();
    }
}
