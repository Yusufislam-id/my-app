<?php

namespace App\Filament\Resources\Companies\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class CompaniesTable
{
    public static function configure(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('name')
                ->label('Nama Perusahaan')
                ->searchable()
                ->sortable(),
            
            TextColumn::make('code')
                ->label('Kode')
                ->searchable()
                ->sortable()
                ->badge(),
            
            IconColumn::make('is_active')
                ->label('Status')
                ->boolean()
                ->sortable(),
            
            TextColumn::make('users_count')
                ->label('Jumlah User')
                ->counts('users')
                ->sortable(),
            
            TextColumn::make('documents_count')
                ->label('Jumlah Dokumen')
                ->counts('documents')
                ->sortable(),
            
            TextColumn::make('created_at')
                ->label('Dibuat')
                ->dateTime('d M Y H:i')
                ->sortable()
                // ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->filters([
            TernaryFilter::make('is_active')
                ->label('Status')
                ->placeholder('Semua')
                ->trueLabel('Aktif')
                ->falseLabel('Tidak Aktif'),
        ])
        ->actions([
            ViewAction::make(),
            EditAction::make(),
        ])
        ->bulkActions([
            BulkActionGroup::make([
                DeleteBulkAction::make(),
            ]),
        ]);
    }
}
