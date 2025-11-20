<?php

namespace App\Filament\Resources\Documents\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Umum')
                    ->schema([
                        TextInput::make('nama_lengkap')
                            ->label('Nama Lengkap')
                            ->maxLength(255)
                            ->required(),

                        Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->columnSpanFull(),

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
                
                Section::make('Dokumen Pribadi')
                    ->schema([
                        FileUpload::make('dokumen_ktp')
                            ->label('Dokumen KTP')
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                            ->maxSize(5120)
                            ->directory('documents/ktp')
                            ->downloadable()
                            ->openable()
                            ->previewable(),

                        FileUpload::make('dokumen_kk')
                            ->label('Dokumen KK')
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                            ->maxSize(5120)
                            ->directory('documents/kk')
                            ->downloadable()
                            ->openable()
                            ->previewable(),

                        FileUpload::make('dokumen_npwp')
                            ->label('Dokumen NPWP')
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                            ->maxSize(5120)
                            ->directory('documents/npwp')
                            ->downloadable()
                            ->openable()
                            ->previewable(),
                    ])
                    ->columns(3)
                    ->collapsible(),
                
                Section::make('Dokumen Pekerjaan')
                    ->schema([
                        FileUpload::make('surat_keterangan_kerja')
                            ->label('Surat Keterangan Kerja')
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                            ->maxSize(5120)
                            ->directory('documents/surat-kerja')
                            ->downloadable()
                            ->openable()
                            ->previewable(),

                        FileUpload::make('slip_gaji_3bulan')
                            ->label('Slip Gaji 3 Bulan Terakhir')
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                            ->maxSize(5120)
                            ->directory('documents/slip-gaji')
                            ->downloadable()
                            ->openable()
                            ->previewable(),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Dokumen Keuangan')
                    ->schema([
                        FileUpload::make('rekening_koran_3bulan')
                            ->label('Rekening Koran 3 Bulan Terakhir')
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                            ->maxSize(5120)
                            ->directory('documents/rekening-koran')
                            ->downloadable()
                            ->openable()
                            ->previewable(),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Dokumen Usaha')
                    ->schema([
                        FileUpload::make('surat_keterangan_usaha')
                            ->label('Surat Keterangan Usaha')
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                            ->maxSize(5120)
                            ->directory('documents/surat-usaha')
                            ->downloadable()
                            ->openable()
                            ->previewable(),
                        
                        FileUpload::make('neraca_keuangan_6bulan')
                            ->label('Neraca Keuangan 6 Bulan Terakhir')
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                            ->maxSize(5120)
                            ->directory('documents/neraca')
                            ->downloadable()
                            ->openable()
                            ->previewable(),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Dokumen Pengajuan')
                    ->schema([
                        FileUpload::make('surat_pengajuan_rumah')
                            ->label('Surat Pengajuan Rumah')
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                            ->maxSize(5120)
                            ->directory('documents/pengajuan')
                            ->downloadable()
                            ->openable()
                            ->previewable(),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
}
}