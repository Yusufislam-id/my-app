<?php

namespace App\Filament\Resources\DailyReports\Schemas;

use App\Models\HousingLocation;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DailyReportForm
{
    public static function configure(Schema $schema): Schema
    {
        $user = auth()->user();
        
        return $schema
            ->components([
                Section::make('Informasi Laporan')
                    ->schema([
                        Select::make('housing_location_id')
                            ->label('Nama Lokasi Perumahan')
                            ->options(
                                HousingLocation::when(
                                    !$user->isSuperAdmin(),
                                    fn ($query) => $query->where('company_id', $user->company_id)
                                )
                                    ->where('is_active', true)
                                    ->pluck('name', 'id')
                            )
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live(),
                        
                        Select::make('report_type')
                            ->label('Jenis Laporan')
                            ->options([
                                'daily_report' => 'Daily Report Westhom',
                                'control_report' => 'Control Report',
                                'rekap_subsidi' => 'Rekap Proyek Subsidi',
                                'rekap_premio' => 'Rekap Proyek Premio',
                            ])
                            ->required()
                            ->live(),
                        
                        DatePicker::make('report_date')
                            ->label('Tanggal Laporan')
                            ->required()
                            ->default(now())
                            ->native(false),
                        
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

                Section::make('Upload File Excel')
                    ->schema([
                        FileUpload::make('file_path')
                            ->label('File Laporan (Excel)')
                            ->disk('local')
                            ->directory('daily-reports')
                            ->acceptedFileTypes([
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                'application/vnd.oasis.opendocument.spreadsheet'
                            ])
                            ->maxSize(10240)
                            ->required()
                            ->downloadable()
                            ->openable()
                            ->helperText('Upload file Excel (.xls, .xlsx). Maksimal 10MB'),
                        
                        Textarea::make('notes')
                            ->label('Catatan')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
