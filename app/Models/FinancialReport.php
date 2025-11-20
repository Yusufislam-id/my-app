<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class FinancialReport extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'created_by',
        'periode',
        'laporan_keuangan_pt',
        'laporan_data_konsumen',
        'sp3k',
        'pengisian_data_myob',
        'laporan_keuangan',
        'laporan_kas_lapangan',
        'laporan_kas_pt',
        'catatan',
        'status',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
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

        return Storage::url($this->$field);
    }

    // Helper method untuk cek apakah file ada
    public function hasFile(string $field): bool
    {
        return !empty($this->$field) && Storage::exists($this->$field);
    }

    // Daftar semua field file
    public static function getFileFields(): array
    {
        return [
            'laporan_keuangan_pt' => 'Laporan Keuangan PT',
            'laporan_data_konsumen' => 'Laporan Data Konsumen',
            'sp3k' => 'SP3K',
            'pengisian_data_myob' => 'Pengisian Data MYOB',
            'laporan_keuangan' => 'Laporan Keuangan',
            'laporan_kas_lapangan' => 'Laporan Kas Lapangan',
            'laporan_kas_pt' => 'Laporan Kas PT',
        ];
    }

    // Delete all files when report is deleted
    protected static function booted(): void
    {
        static::deleting(function (FinancialReport $report) {
            foreach (self::getFileFields() as $field => $label) {
                if ($report->hasFile($field)) {
                    Storage::delete($report->$field);
                }
            }
        });
    }
}