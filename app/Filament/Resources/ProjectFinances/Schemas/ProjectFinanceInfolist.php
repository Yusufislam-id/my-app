<?php

namespace App\Filament\Resources\ProjectFinances\Schemas;

use App\Models\ProjectFinance;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProjectFinanceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('housingLocation.name')
                    ->label('Lokasi Perumahan')
                    ->placeholder('-'),
                TextEntry::make('finance_type')
                    ->label('Jenis Laporan Keuangan')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'laporan_keuangan' => 'Laporan Keuangan',
                        'petty_cash' => 'Petty Cash',
                        'data_pembayaran' => 'Data Pembayaran',
                        'sp3k_konsumen' => 'SP3K Konsumen',
                        'pencairan_kpr' => 'Pencairan KPR Konsumen',
                        'biaya_material_tenaga' => 'Biaya Material & Tenaga Bangunan Proyek',
                        default => $state,
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'laporan_keuangan' => 'primary',
                        'petty_cash' => 'warning',
                        'data_pembayaran' => 'info',
                        'sp3k_konsumen' => 'success',
                        'pencairan_kpr' => 'danger',
                        'biaya_material_tenaga' => 'gray',
                        default => 'gray',
                    }),
                TextEntry::make('report_date')
                    ->label('Tanggal Laporan')
                    ->date('d M Y')
                    ->placeholder('-'),
                TextEntry::make('total_amount')
                    ->label('Total Nominal')
                    ->money('IDR')
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'draft' => 'Draft',
                        'submitted' => 'Diajukan',
                        'reviewed' => 'Direview',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'submitted' => 'warning',
                        'reviewed' => 'info',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),
                TextEntry::make('laporan_keuangan_file')
                    ->label('Laporan Keuangan')
                    ->placeholder('-'),
                TextEntry::make('petty_cash_file')
                    ->label('Petty Cash')
                    ->placeholder('-'),
                TextEntry::make('data_konsumen_file')
                    ->label('Data Konsumen')
                    ->placeholder('-'),
                TextEntry::make('data_pembayaran_file')
                    ->label('Data Pembayaran')
                    ->placeholder('-'),
                TextEntry::make('data_konsumen_reject_file')
                    ->label('Data Konsumen Reject')
                    ->placeholder('-'),
                TextEntry::make('sp3k_dokumen_file')
                    ->label('SP3K Dokumen')
                    ->placeholder('-'),
                TextEntry::make('pencairan_kpr_file')
                    ->label('Pencairan KPR Konsumen')
                    ->placeholder('-'),
                TextEntry::make('biaya_material_tenaga_file')
                    ->label('Biaya Material & Tenaga Bangunan Proyek')
                    ->placeholder('-'),
                TextEntry::make('notes')
                    ->label('Catatan Tambahan')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('company.name')
                    ->label('Perusahaan')
                    ->visible(fn () => auth()->user()->isFounder())
                    ->placeholder('-'),
                TextEntry::make('creator.name')
                    ->label('Dibuat Oleh')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label('Diupdate')
                    ->dateTime('d M Y H:i')
                    ->placeholder('-'),
            ]);
    }
}
