<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'company_id',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    // Helper methods untuk cek role
    public function isFounder(): bool
    {
        return $this->role === 'founder';
    }

    public function isDirektur(): bool
    {
        return $this->role === 'direktur';
    }

    public function isKomisaris(): bool
    {
        return $this->role === 'komisaris';
    }

    public function isAdminPemberkasan(): bool
    {
        return $this->role === 'admin_pemberkasan';
    }

    public function isAdminKeuangan(): bool
    {
        return $this->role === 'admin_keuangan';
    }

    public function canAccessCompany(int $companyId): bool
    {
        // Founder bisa akses semua PT
        if ($this->isFounder()) {
            return true;
        }

        // Role lain hanya bisa akses PT sendiri
        return $this->company_id === $companyId;
    }

    public function canManageDocuments(): bool
    {
        return $this->isAdminPemberkasan();
    }

    public function canManageFinancialReports(): bool
    {
        return $this->isAdminKeuangan();
    }
}