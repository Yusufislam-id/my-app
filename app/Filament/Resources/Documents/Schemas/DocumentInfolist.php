<?php

namespace App\Filament\Resources\Documents\Schemas;

use App\Models\Document;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DocumentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('company.name')
                    ->label('Company'),
                TextEntry::make('created_by')
                    ->numeric(),
                TextEntry::make('nama_lengkap'),
                TextEntry::make('deskripsi')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('surat_pengajuan_rumah')
                    ->placeholder('-'),
                TextEntry::make('dokumen_ktp')
                    ->placeholder('-'),
                TextEntry::make('dokumen_kk')
                    ->placeholder('-'),
                TextEntry::make('dokumen_npwp')
                    ->placeholder('-'),
                TextEntry::make('surat_keterangan_kerja')
                    ->placeholder('-'),
                TextEntry::make('slip_gaji_3bulan')
                    ->placeholder('-'),
                TextEntry::make('rekening_koran_3bulan')
                    ->placeholder('-'),
                TextEntry::make('surat_keterangan_usaha')
                    ->placeholder('-'),
                TextEntry::make('neraca_keuangan_6bulan')
                    ->placeholder('-'),
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
                    ->visible(fn (Document $record): bool => $record->trashed()),
            ]);
    }
}
