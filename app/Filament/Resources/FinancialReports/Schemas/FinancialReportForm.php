<?php

namespace App\Filament\Resources\FinancialReports\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class FinancialReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('company_id')
                    ->relationship('company', 'name')
                    ->required(),
                TextInput::make('created_by')
                    ->required()
                    ->numeric(),
                TextInput::make('periode')
                    ->required(),
                TextInput::make('laporan_keuangan_pt'),
                TextInput::make('laporan_data_konsumen'),
                TextInput::make('sp3k'),
                TextInput::make('pengisian_data_myob'),
                TextInput::make('laporan_keuangan'),
                TextInput::make('laporan_kas_lapangan'),
                TextInput::make('laporan_kas_pt'),
                Textarea::make('catatan')
                    ->columnSpanFull(),
                Select::make('status')
                    ->options([
            'draft' => 'Draft',
            'submitted' => 'Submitted',
            'reviewed' => 'Reviewed',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
        ])
                    ->default('draft')
                    ->required(),
            ]);
    }
}
