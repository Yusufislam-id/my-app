<?php

namespace App\Filament\Resources\Documents\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class DocumentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company.name')
                    ->searchable(),
                TextColumn::make('created_by')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('nama_lengkap')
                    ->searchable(),
                TextColumn::make('surat_pengajuan_rumah')
                    ->searchable(),
                TextColumn::make('dokumen_ktp')
                    ->searchable(),
                TextColumn::make('dokumen_kk')
                    ->searchable(),
                TextColumn::make('dokumen_npwp')
                    ->searchable(),
                TextColumn::make('surat_keterangan_kerja')
                    ->searchable(),
                TextColumn::make('slip_gaji_3bulan')
                    ->searchable(),
                TextColumn::make('rekening_koran_3bulan')
                    ->searchable(),
                TextColumn::make('surat_keterangan_usaha')
                    ->searchable(),
                TextColumn::make('neraca_keuangan_6bulan')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
