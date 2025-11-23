<?php

namespace App\Filament\Resources\DailyReports\Schemas;

use App\Models\DailyReport;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DailyReportInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('housingLocation.name')
                    ->label('Lokasi Perumahan'),
                
                TextEntry::make('report_type')
                    ->label('Jenis Laporan')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'daily_report' => 'Daily Report Westhom',
                        'control_report' => 'Control Report',
                        'rekap_subsidi' => 'Rekap Proyek Subsidi',
                        'rekap_premio' => 'Rekap Proyek Premio',
                        default => $state,
                    }),
                
                TextEntry::make('report_date')
                    ->label('Tanggal Laporan')
                    ->date('d M Y'),
                
                TextEntry::make('company.name')
                    ->label('Perusahaan')
                    ->visible(fn () => auth()->user()->isFounder()),
                
                TextEntry::make('creator.name')
                    ->label('Dibuat Oleh'),
                
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
                
                TextEntry::make('file_path')
                    ->label('File Laporan')
                    ->placeholder('-'),
                
                TextEntry::make('notes')
                    ->label('Catatan')
                    ->placeholder('-')
                    ->columnSpanFull(),
                
                TextEntry::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->placeholder('-'),
                
                TextEntry::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->placeholder('-'),
            ]);
    }
}
