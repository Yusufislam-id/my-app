<?php

namespace App\Filament\Resources\FinancialReports;

use App\Filament\Resources\FinancialReports\Pages\CreateFinancialReport;
use App\Filament\Resources\FinancialReports\Pages\EditFinancialReport;
use App\Filament\Resources\FinancialReports\Pages\ListFinancialReports;
use App\Filament\Resources\FinancialReports\Pages\ViewFinancialReport;
use App\Filament\Resources\FinancialReports\Schemas\FinancialReportForm;
use App\Filament\Resources\FinancialReports\Schemas\FinancialReportInfolist;
use App\Filament\Resources\FinancialReports\Tables\FinancialReportsTable;
use App\Models\FinancialReport;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FinancialReportResource extends Resource
{
    protected static ?string $model = FinancialReport::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Manajemen Data';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationLabel = 'Laporan Keuangan';

    public static function form(Schema $schema): Schema
    {
        return FinancialReportForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FinancialReportInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FinancialReportsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFinancialReports::route('/'),
            'create' => CreateFinancialReport::route('/create'),
            'view' => ViewFinancialReport::route('/{record}'),
            'edit' => EditFinancialReport::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
