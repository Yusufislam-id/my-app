<?php

namespace App\Policies;

use App\Models\HousingLocation;
use App\Models\User;

class HousingLocationPolicy
{
    public function viewAny(User $user): bool
    {
        // Semua user bisa lihat menu Lokasi Perumahan
        return true;
    }

    public function view(User $user, HousingLocation $housingLocation): bool
    {
        // Super Admin dan Founder bisa lihat semua
        if ($user->isSuperAdmin() || $user->isFounder()) {
            return true;
        }

        // User lain hanya bisa lihat lokasi dari PT sendiri
        return $user->company_id === $housingLocation->company_id;
    }

    public function create(User $user): bool
    {
        // Super Admin, Founder, Direktur, dan Komisaris bisa create
        return true;
    }

    public function update(User $user, HousingLocation $housingLocation): bool
    {
        // Super Admin dan Founder bisa update semua
        if ($user->isSuperAdmin() || $user->isFounder()) {
            return true;
        }

        // Direktur, Komisaris, Admin Pemberkasan dan Keuangan bisa update lokasi PT sendiri
        if (($user->isDirektur() || $user->isKomisaris() || $user->isAdminPemberkasan() || $user->isAdminKeuangan()) &&
            $user->company_id === $housingLocation->company_id
        ) {
            return true;
        }

        return false;
    }

    public function delete(User $user, HousingLocation $housingLocation): bool
    {
        // Super Admin dan Founder bisa delete semua
        if ($user->isSuperAdmin() || $user->isFounder()) {
            return true;
        }

        //  Direktur, Komisaris, Admin Pemberkasan dan Keuangan bisa delete lokasi PT sendiri
        if (($user->isDirektur() || $user->isKomisaris() || $user->isAdminPemberkasan() || $user->isAdminKeuangan()) &&
            $user->company_id === $housingLocation->company_id
        ) {
            return true;
        }

        return false;
    }

    public function restore(User $user, HousingLocation $housingLocation): bool
    {
        return $user->isSuperAdmin() || $user->isFounder();
    }

    public function forceDelete(User $user, HousingLocation $housingLocation): bool
    {
        return $user->isSuperAdmin();
    }
}
