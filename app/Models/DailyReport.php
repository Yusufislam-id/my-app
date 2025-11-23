<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class DailyReport extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'housing_location_id',
        'created_by',
        'report_type',
        'report_date',
        'file_path',
        'notes',
        'status',
    ];

    protected $casts = [
        'report_date' => 'date',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function housingLocation(): BelongsTo
    {
        return $this->belongsTo(HousingLocation::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Helper method untuk mendapatkan URL file
    public function getFileUrl(): ?string
    {
        if (!$this->file_path) {
            return null;
        }

        return Storage::disk('local')->url($this->file_path);
    }

    // Helper method untuk cek apakah file ada
    public function hasFile(): bool
    {
        return !empty($this->file_path) && Storage::disk('local')->exists($this->file_path);
    }

    // Get report type label
    public function getReportTypeLabel(): string
    {
        return match($this->report_type) {
            'daily_report' => 'Daily Report Westhom',
            'control_report' => 'Control Report',
            'rekap_subsidi' => 'Rekap Proyek Subsidi',
            'rekap_premio' => 'Rekap Proyek Premio',
            default => $this->report_type,
        };
    }

    // Delete file when report is deleted
    protected static function booted(): void
    {
        static::deleting(function (DailyReport $report) {
            if ($report->hasFile()) {
                Storage::disk('local')->delete($report->file_path);
            }
        });
    }

    // Scope untuk filter berdasarkan company
    public function scopeForCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    // Scope untuk filter berdasarkan report type
    public function scopeOfType($query, $type)
    {
        return $query->where('report_type', $type);
    }
}