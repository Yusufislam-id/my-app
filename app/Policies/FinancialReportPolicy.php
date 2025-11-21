<?php

namespace App\Policies;

use App\Models\FinancialReport;
use App\Models\User;

class FinancialReportPolicy
{
    public function viewAny(User $user): bool
    {
        // Semua user yang terautentikasi bisa melihat list laporan
        return true;
    }

    public function view(User $user, FinancialReport $report): bool
    {
        // Founder bisa lihat semua laporan
        if ($user->isFounder()) {
            return true;
        }

        // User lain hanya bisa lihat laporan dari PT sendiri
        return $user->company_id === $report->company_id;
    }

    public function create(User $user): bool
    {
        // Hanya Admin Keuangan yang bisa membuat laporan
        return $user->isAdminKeuangan();
    }

    public function update(User $user, FinancialReport $report): bool
    {
        // Hanya Admin Keuangan dari PT yang sama yang bisa update
        return $user->isAdminKeuangan() && 
               $user->company_id === $report->company_id;
    }

    public function delete(User $user, FinancialReport $report): bool
    {
        // Hanya Admin Keuangan dari PT yang sama yang bisa delete
        return $user->isAdminKeuangan() && 
               $user->company_id === $report->company_id;
    }
}