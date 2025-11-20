<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'created_by',
        'nama_lengkap',
        'deskripsi',
        'surat_pengajuan_rumah',
        'dokumen_ktp',
        'dokumen_kk',
        'dokumen_npwp',
        'surat_keterangan_kerja',
        'slip_gaji_3bulan',
        'rekening_koran_3bulan',
        'surat_keterangan_usaha',
        'neraca_keuangan_6bulan',
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
            'surat_pengajuan_rumah' => 'Surat Pengajuan Rumah',
            'dokumen_ktp' => 'Dokumen KTP',
            'dokumen_kk' => 'Dokumen KK',
            'dokumen_npwp' => 'Dokumen NPWP',
            'surat_keterangan_kerja' => 'Surat Keterangan Kerja',
            'slip_gaji_3bulan' => 'Slip Gaji 3 Bulan Terakhir',
            'rekening_koran_3bulan' => 'Rekening Koran 3 Bulan Terakhir',
            'surat_keterangan_usaha' => 'Surat Keterangan Usaha',
            'neraca_keuangan_6bulan' => 'Neraca Keuangan 6 Bulan Terakhir',
        ];
    }

    // Delete all files when document is deleted
    protected static function booted(): void
    {
        static::deleting(function (Document $document) {
            foreach (self::getFileFields() as $field => $label) {
                if ($document->hasFile($field)) {
                    Storage::delete($document->$field);
                }
            }
        });
    }
}