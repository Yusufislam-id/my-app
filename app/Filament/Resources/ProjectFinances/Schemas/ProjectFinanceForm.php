<?php

namespace App\Filament\Resources\ProjectFinances\Schemas;

use App\Models\HousingLocation;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProjectFinanceForm
{
    public static function configure(Schema $schema): Schema
    {
        $user = auth()->user();

        return $schema
            ->components([
                Section::make('Informasi Umum')
                    ->schema([
                        Select::make('housing_location_id')
                            ->label('Nama Lokasi Perumahan')
                            ->options(
                                HousingLocation::where('company_id', $user->company_id)
                                    ->where('is_active', true)
                                    ->pluck('name', 'id')
                            )
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live(),

                        Select::make('finance_type')
                            ->label('Jenis Laporan Keuangan')
                            ->options([
                                'laporan_keuangan' => 'Laporan Keuangan',
                                'petty_cash' => 'Petty Cash',
                                'data_pembayaran' => 'Data Pembayaran',
                                'sp3k_konsumen' => 'SP3K Konsumen',
                                'pencairan_kpr' => 'Pencairan KPR Konsumen',
                                'biaya_material_tenaga' => 'Biaya Material & Tenaga Bangunan Proyek',
                            ])
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn ($set) => $set('total_amount', null)),

                        DatePicker::make('report_date')
                            ->label('Tanggal Laporan')
                            ->required()
                            ->default(now())
                            ->native(false),

                        TextInput::make('total_amount')
                            ->label('Total Nominal (Opsional)')
                            ->numeric()
                            ->prefix('Rp')
                            ->step(0.01)
                            ->maxLength(15),

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
                            ->visible(fn () => auth()->user()->isFounder() ||
                                auth()->user()->isDirektur() ||
                                auth()->user()->isKomisaris()),
                    ])
                    ->columns(2),

                // LAPORAN KEUANGAN
                Section::make('Upload File')
                    ->schema([
                        FileUpload::make('laporan_keuangan_file')
                            ->label('Laporan Keuangan')
                            ->disk('local')
                            ->directory('project-finances/laporan-keuangan')
                            ->acceptedFileTypes(['application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                            ->maxSize(10240)
                            ->downloadable()
                            ->openable(),
                    ])
                    ->visible(fn ($get) => $get('finance_type') === 'laporan_keuangan'),

                // PETTY CASH
                Section::make('Upload File')
                    ->schema([
                        FileUpload::make('petty_cash_file')
                            ->label('Petty Cash')
                            ->disk('local')
                            ->directory('project-finances/petty-cash')
                            ->acceptedFileTypes(['application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                            ->maxSize(10240)
                            ->downloadable()
                            ->openable(),
                    ])
                    ->visible(fn ($get) => $get('finance_type') === 'petty_cash'),

                // DATA PEMBAYARAN
                Section::make('Upload File Data Pembayaran')
                    ->schema([
                        FileUpload::make('data_konsumen_file')
                            ->label('Data Konsumen')
                            ->disk('local')
                            ->directory('project-finances/data-konsumen')
                            ->acceptedFileTypes(['application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                            ->maxSize(10240)
                            ->downloadable()
                            ->openable(),

                        FileUpload::make('data_pembayaran_file')
                            ->label('Data Pembayaran')
                            ->disk('local')
                            ->directory('project-finances/data-pembayaran')
                            ->acceptedFileTypes(['application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                            ->maxSize(10240)
                            ->downloadable()
                            ->openable(),

                        FileUpload::make('data_konsumen_reject_file')
                            ->label('Data Konsumen Reject')
                            ->disk('local')
                            ->directory('project-finances/data-konsumen-reject')
                            ->acceptedFileTypes(['application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                            ->maxSize(10240)
                            ->downloadable()
                            ->openable(),
                    ])
                    ->columns(3)
                    ->visible(fn ($get) => $get('finance_type') === 'data_pembayaran'),

                // SP3K KONSUMEN
                Section::make('Upload File')
                    ->schema([
                        FileUpload::make('sp3k_dokumen_file')
                            ->label('SP3K Dokumen')
                            ->disk('local')
                            ->directory('project-finances/sp3k')
                            ->acceptedFileTypes(['application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                            ->maxSize(10240)
                            ->downloadable()
                            ->openable(),
                    ])
                    ->visible(fn ($get) => $get('finance_type') === 'sp3k_konsumen'),

                // PENCAIRAN KPR
                Section::make('Upload File')
                    ->schema([
                        FileUpload::make('pencairan_kpr_file')
                            ->label('Pencairan KPR Konsumen')
                            ->disk('local')
                            ->directory('project-finances/pencairan-kpr')
                            ->acceptedFileTypes(['application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                            ->maxSize(10240)
                            ->downloadable()
                            ->openable(),
                    ])
                    ->visible(fn ($get) => $get('finance_type') === 'pencairan_kpr'),

                // BIAYA MATERIAL & TENAGA
                Section::make('Upload File')
                    ->schema([
                        FileUpload::make('biaya_material_tenaga_file')
                            ->label('Biaya Material & Tenaga Bangunan Proyek')
                            ->disk('local')
                            ->directory('project-finances/material-tenaga')
                            ->acceptedFileTypes(['application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                            ->maxSize(10240)
                            ->downloadable()
                            ->openable(),
                    ])
                    ->visible(fn ($get) => $get('finance_type') === 'biaya_material_tenaga'),

                Section::make('Catatan')
                    ->schema([
                        Textarea::make('notes')
                            ->label('Catatan Tambahan')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }
}
