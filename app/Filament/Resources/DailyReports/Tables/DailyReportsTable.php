<?php

namespace App\Filament\Resources\DailyReports\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DailyReportsTable
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
                
                TextColumn::make('report_type')
                    ->label('Jenis Laporan')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'daily_report' => 'Daily Report',
                        'control_report' => 'Control Report',
                        'rekap_subsidi' => 'Rekap Subsidi',
                        'rekap_premio' => 'Rekap Premio',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'daily_report' => 'primary',
                        'control_report' => 'info',
                        'rekap_subsidi' => 'success',
                        'rekap_premio' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),
                
                TextColumn::make('report_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
                
                TextColumn::make('company.name')
                    ->label('Perusahaan')
                    ->searchable()
                    ->sortable()
                    ->visible(fn () => auth()->user()->isFounder())
                    ->toggleable(),
                
                TextColumn::make('creator.name')
                    ->label('Dibuat Oleh')
                    ->searchable()
                    ->toggleable(),
                
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'draft' => 'Draft',
                        'submitted' => 'Diajukan',
                        'reviewed' => 'Direview',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'submitted' => 'warning',
                        'reviewed' => 'info',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                
                IconColumn::make('file_path')
                    ->label('File')
                    ->boolean()
                    ->getStateUsing(fn ($record) => !empty($record->file_path)),
                
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('report_type')
                    ->label('Jenis Laporan')
                    ->options([
                        'daily_report' => 'Daily Report Westhom',
                        'control_report' => 'Control Report',
                        'rekap_subsidi' => 'Rekap Proyek Subsidi',
                        'rekap_premio' => 'Rekap Proyek Premio',
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
                                fn (Builder $query, $date): Builder => $query->whereDate('report_date', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('report_date', '<=', $date),
                            );
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()
                    ->visible(fn () => auth()->user()->isAdminPemberkasan()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn () => auth()->user()->isAdminPemberkasan()),
                ]),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                $user = auth()->user();
                
                if (!$user->isFounder()) {
                    $query->where('company_id', $user->company_id);
                }
            })
            ->defaultSort('report_date', 'desc');
    }
}
