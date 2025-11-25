<?php

namespace App\Filament\Resources\ProjectFinances\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProjectFinancesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('housingLocation.name')
                    ->label('Lokasi Perumahan')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('finance_type')
                    ->label('Jenis')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'laporan_keuangan' => 'Lap. Keuangan',
                        'petty_cash' => 'Petty Cash',
                        'data_pembayaran' => 'Data Pembayaran',
                        'sp3k_konsumen' => 'SP3K',
                        'pencairan_kpr' => 'Pencairan KPR',
                        'biaya_material_tenaga' => 'Material & Tenaga',
                        default => $state,
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'laporan_keuangan' => 'primary',
                        'petty_cash' => 'warning',
                        'data_pembayaran' => 'info',
                        'sp3k_konsumen' => 'success',
                        'pencairan_kpr' => 'danger',
                        'biaya_material_tenaga' => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('report_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('total_amount')
                    ->label('Nominal')
                    ->money('IDR')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('company.name')
                    ->label('Perusahaan')
                    ->searchable()
                    ->sortable()
                    ->visible(fn() => auth()->user()->isFounder() || auth()->user()->isSuperAdmin())
                    ->toggleable(),

                TextColumn::make('creator.name')
                    ->label('Dibuat Oleh')
                    ->searchable()
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

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('finance_type')
                    ->label('Jenis Laporan')
                    ->options([
                        'laporan_keuangan' => 'Laporan Keuangan',
                        'petty_cash' => 'Petty Cash',
                        'data_pembayaran' => 'Data Pembayaran',
                        'sp3k_konsumen' => 'SP3K Konsumen',
                        'pencairan_kpr' => 'Pencairan KPR',
                        'biaya_material_tenaga' => 'Material & Tenaga',
                    ]),

                SelectFilter::make('housing_location_id')
                    ->label('Lokasi Perumahan')
                    ->relationship('housingLocation', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'submitted' => 'Diajukan',
                        'reviewed' => 'Direview',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                    ]),

                Filter::make('report_date')
                    ->form([
                        DatePicker::make('from')
                            ->label('Dari Tanggal'),
                        DatePicker::make('until')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('report_date', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('report_date', '<=', $date),
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
            })
            ->defaultSort('report_date', 'desc');
    }
}
