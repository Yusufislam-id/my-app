<?php

namespace App\Filament\Resources\Documents\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class DocumentForm
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
                TextInput::make('nama_lengkap')
                    ->required(),
                Textarea::make('deskripsi')
                    ->columnSpanFull(),
                TextInput::make('surat_pengajuan_rumah'),
                TextInput::make('dokumen_ktp'),
                TextInput::make('dokumen_kk'),
                TextInput::make('dokumen_npwp'),
                TextInput::make('surat_keterangan_kerja'),
                TextInput::make('slip_gaji_3bulan'),
                TextInput::make('rekening_koran_3bulan'),
                TextInput::make('surat_keterangan_usaha'),
                TextInput::make('neraca_keuangan_6bulan'),
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
