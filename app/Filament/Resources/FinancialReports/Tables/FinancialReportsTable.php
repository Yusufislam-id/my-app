<?php

namespace App\Filament\Resources\FinancialReports\Tables;

use App\Models\FinancialReport;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\TextInput;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class FinancialReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('periode')
                    ->label('Periode')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),
                TextColumn::make('company.name')
                    ->label('Perusahaan')
                    ->searchable()
                    ->sortable()
                    ->visible(fn() => auth()->user()->isFounder() || auth()->user()->isSuperAdmin()),
                TextColumn::make('creator.name')
                    ->label('Dibuat Oleh')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'draft' => 'Draft',
                        'submitted' => 'Diajukan',
                        'reviewed' => 'Direview',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        default => $state,
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'draft' => 'gray',
                        'submitted' => 'warning',
                        'reviewed' => 'info',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                IconColumn::make('has_files')
                    ->label('File')
                    ->boolean()
                    ->getStateUsing(function (FinancialReport $record): bool {
                        return (bool) (
                            $record->laporan_keuangan_pt
                            || $record->laporan_data_konsumen
                            || $record->sp3k
                            || $record->pengisian_data_myob
                            || $record->laporan_keuangan
                            || $record->laporan_kas_lapangan
                            || $record->laporan_kas_pt
                        );
                    })
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'submitted' => 'Diajukan',
                        'reviewed' => 'Direview',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                    ]),
                SelectFilter::make('company_id')
                    ->label('Perusahaan')
                    ->relationship('company', 'name')
                    ->searchable()
                    ->preload()
                    ->visible(fn() => auth()->user()->isFounder() || auth()->user()->isSuperAdmin()),
                Filter::make('periode')
                    ->form([
                        TextInput::make('periode')
                            ->label('Cari Periode')
                            ->placeholder('Contoh: 2024-01'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['periode'] ?? null,
                            fn(Builder $query, $periode): Builder => $query->where('periode', 'like', "%{$periode}%"),
                        );
                    }),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make()
                    ->visible(fn() => auth()->user()->isAdminKeuangan() || auth()->user()->isSuperAdmin()),
                DeleteAction::make()
                    ->visible(fn() => auth()->user()->isAdminKeuangan() || auth()->user()->isSuperAdmin()),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn() => auth()->user()->isAdminKeuangan() || auth()->user()->isSuperAdmin()),
                ]),
            ])
            ->modifyQueryUsing(function (Builder $query): void {
                $user = auth()->user();

                if (!($user->isFounder() || $user->isSuperAdmin())) {
                    $query->where('company_id', $user->company_id);
                }
            });
    }
}
