<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;

class DocumentPolicy
{
    public function viewAny(User $user): bool
    {
        // Semua user yang terautentikasi bisa melihat list dokumen
        return true;
    }

    public function view(User $user, Document $document): bool
    {
        // Super Admin bisa lihat semua dokumen
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Founder bisa lihat semua dokumen
        if ($user->isFounder()) {
            return true;
        }

        // User lain hanya bisa lihat dokumen dari PT sendiri
        return $user->company_id === $document->company_id;
    }

    public function create(User $user): bool
    {
        // Super Admin bisa membuat dokumen
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Hanya Admin Pemberkasan yang bisa membuat dokumen
        return $user->isAdminPemberkasan();
    }

    public function update(User $user, Document $document): bool
    {
        // Super Admin bisa update semua dokumen
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Hanya Admin Pemberkasan dari PT yang sama yang bisa update
        return $user->isAdminPemberkasan() && 
               $user->company_id === $document->company_id;
    }

    public function delete(User $user, Document $document): bool
    {
        // Super Admin bisa delete semua dokumen
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Hanya Admin Pemberkasan dari PT yang sama yang bisa delete
        return $user->isAdminPemberkasan() && 
               $user->company_id === $document->company_id;
    }
}