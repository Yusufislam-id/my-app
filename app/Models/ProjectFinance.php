<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ProjectFinance extends Model
{

    protected $fillable = [
        'company_id',
        'housing_location_id',
        'created_by',
        'finance_type',
        'report_date',
        'laporan_keuangan_file',
        'petty_cash_file',
        'data_konsumen_file',
        'data_pembayaran_file',
        'data_konsumen_reject_file',
        'sp3k_dokumen_file',
        'pencairan_kpr_file',
        'biaya_material_tenaga_file',
        'total_amount',
        'notes',
        'status',
    ];

    protected $casts = [
        'report_date' => 'date',
        'total_amount' => 'decimal:2',
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
    public function getFileUrl(string $field): ?string
    {
        if (!$this->$field) {
            return null;
        }

        return Storage::disk('local')->url($this->$field);
    }

    // Helper method untuk cek apakah file ada
    public function hasFile(string $field): bool
    {
        return !empty($this->$field) && Storage::disk('local')->exists($this->$field);
    }

    // Get finance type label
    public function getFinanceTypeLabel(): string
    {
        return match($this->finance_type) {
            'laporan_keuangan' => 'Laporan Keuangan',
            'petty_cash' => 'Petty Cash',
            'data_pembayaran' => 'Data Pembayaran',
            'sp3k_konsumen' => 'SP3K Konsumen',
            'pencairan_kpr' => 'Pencairan KPR Konsumen',
            'biaya_material_tenaga' => 'Biaya Material & Tenaga Bangunan',
            default => $this->finance_type,
        };
    }

    // Daftar field file berdasarkan tipe
    public static function getFileFieldsByType(string $type): array
    {
        return match($type) {
            'laporan_keuangan' => ['laporan_keuangan_file'],
            'petty_cash' => ['petty_cash_file'],
            'data_pembayaran' => ['data_konsumen_file', 'data_pembayaran_file', 'data_konsumen_reject_file'],
            'sp3k_konsumen' => ['sp3k_dokumen_file'],
            'pencairan_kpr' => ['pencairan_kpr_file'],
            'biaya_material_tenaga' => ['biaya_material_tenaga_file'],
            default => [],
        };
    }

    // Delete all files when finance is deleted
    protected static function booted(): void
    {
        static::deleting(function (ProjectFinance $finance) {
            $fields = [
                'laporan_keuangan_file',
                'petty_cash_file',
                'data_konsumen_file',
                'data_pembayaran_file',
                'data_konsumen_reject_file',
                'sp3k_dokumen_file',
                'pencairan_kpr_file',
                'biaya_material_tenaga_file',
            ];

            foreach ($fields as $field) {
                if ($finance->hasFile($field)) {
                    Storage::disk('local')->delete($finance->$field);
                }
            }
        });
    }

    // Scope untuk filter berdasarkan company
    public function scopeForCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    // Scope untuk filter berdasarkan finance type
    public function scopeOfType($query, $type)
    {
        return $query->where('finance_type', $type);
    }
}