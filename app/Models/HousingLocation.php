<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class HousingLocation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'name',
        'code',
        'address',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function dailyReports(): HasMany
    {
        return $this->hasMany(DailyReport::class);
    }

    public function projectFinances(): HasMany
    {
        return $this->hasMany(ProjectFinance::class);
    }

    // Scope untuk lokasi aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk lokasi berdasarkan company
    public function scopeForCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }
}