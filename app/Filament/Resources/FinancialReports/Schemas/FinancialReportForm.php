<?php

namespace App\Filament\Resources\FinancialReports\Schemas;

use App\Models\Company;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FinancialReportForm
{
    public static function configure(Schema $schema): Schema
    {
        $user = auth()->user();

        return $schema
            ->components([
                Section::make('Informasi Periode')
                    ->schema([
                        Select::make('company_id')
                            ->label('Perusahaan')
                            ->options(
                                Company::pluck('name', 'id')
                            )
                            ->required(fn() => $user->isSuperAdmin())
                            ->searchable()
                            ->preload()
                            ->visible(fn() => $user->isSuperAdmin()),

                        TextInput::make('periode')
                            ->label('Periode')
                            ->required()
                            ->placeholder('Contoh: 2024-01 atau Q1-2024')
                            ->maxLength(50),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'draft' => 'Draft',
                                'submitted' => 'Submitted',
                                'reviewed' => 'Reviewed',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                            ])
                            ->default('draft')
                            ->required()
                            ->visible(fn() => auth()->user()->isFounder()
                                || auth()->user()->isDirektur()
                                || auth()->user()->isKomisaris()),
                        Textarea::make('catatan')
                            ->label('Catatan')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('Laporan PT')
                    ->schema([
                        FileUpload::make('laporan_keuangan_pt')
                            ->label('Laporan Keuangan PT')
                            ->acceptedFileTypes([
                                'application/pdf',
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            ])
                            ->maxSize(10240)
                            ->directory('financial-reports/pt')
                            ->downloadable()
                            ->openable(),
                        FileUpload::make('laporan_kas_pt')
                            ->label('Laporan Kas PT')
                            ->acceptedFileTypes([
                                'application/pdf',
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            ])
                            ->maxSize(10240)
                            ->directory('financial-reports/kas-pt')
                            ->downloadable()
                            ->openable(),
                    ])
                    ->columns(2)
                    ->collapsible(),
                Section::make('Laporan Konsumen & SP3K')
                    ->schema([
                        FileUpload::make('laporan_data_konsumen')
                            ->label('Laporan Data Konsumen')
                            ->acceptedFileTypes([
                                'application/pdf',
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            ])
                            ->maxSize(10240)
                            ->directory('financial-reports/konsumen')
                            ->downloadable()
                            ->openable(),
                        FileUpload::make('sp3k')
                            ->label('SP3K')
                            ->acceptedFileTypes([
                                'application/pdf',
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            ])
                            ->maxSize(10240)
                            ->directory('financial-reports/sp3k')
                            ->downloadable()
                            ->openable(),
                    ])
                    ->columns(2)
                    ->collapsible(),
                Section::make('Data MYOB & Laporan Umum')
                    ->schema([
                        FileUpload::make('pengisian_data_myob')
                            ->label('Pengisian Data MYOB')
                            ->acceptedFileTypes([
                                'application/pdf',
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            ])
                            ->maxSize(10240)
                            ->directory('financial-reports/myob')
                            ->downloadable()
                            ->openable(),
                        FileUpload::make('laporan_keuangan')
                            ->label('Laporan Keuangan')
                            ->acceptedFileTypes([
                                'application/pdf',
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            ])
                            ->maxSize(10240)
                            ->directory('financial-reports/keuangan')
                            ->downloadable()
                            ->openable(),
                    ])
                    ->columns(2)
                    ->collapsible(),
                Section::make('Laporan Kas Lapangan')
                    ->schema([
                        FileUpload::make('laporan_kas_lapangan')
                            ->label('Laporan Kas Lapangan')
                            ->acceptedFileTypes([
                                'application/pdf',
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            ])
                            ->maxSize(10240)
                            ->directory('financial-reports/kas-lapangan')
                            ->downloadable()
                            ->openable(),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
    }
}
