<?php

namespace App\Filament\Resources\FinancialReports\Schemas;

use App\Models\FinancialReport;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class FinancialReportInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('company.name')
                    ->label('Company'),
                TextEntry::make('created_by')
                    ->numeric(),
                TextEntry::make('periode'),
                TextEntry::make('laporan_keuangan_pt')
                    ->placeholder('-'),
                TextEntry::make('laporan_data_konsumen')
                    ->placeholder('-'),
                TextEntry::make('sp3k')
                    ->placeholder('-'),
                TextEntry::make('pengisian_data_myob')
                    ->placeholder('-'),
                TextEntry::make('laporan_keuangan')
                    ->placeholder('-'),
                TextEntry::make('laporan_kas_lapangan')
                    ->placeholder('-'),
                TextEntry::make('laporan_kas_pt')
                    ->placeholder('-'),
                TextEntry::make('catatan')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (FinancialReport $record): bool => $record->trashed()),
            ]);
    }
}
