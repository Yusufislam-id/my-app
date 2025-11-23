<?php

namespace App\Filament\Resources\ProjectFinances;

use App\Filament\Resources\ProjectFinances\Pages\CreateProjectFinance;
use App\Filament\Resources\ProjectFinances\Pages\EditProjectFinance;
use App\Filament\Resources\ProjectFinances\Pages\ListProjectFinances;
use App\Filament\Resources\ProjectFinances\Pages\ViewProjectFinance;
use App\Filament\Resources\ProjectFinances\Schemas\ProjectFinanceForm;
use App\Filament\Resources\ProjectFinances\Schemas\ProjectFinanceInfolist;
use App\Filament\Resources\ProjectFinances\Tables\ProjectFinancesTable;
use App\Models\ProjectFinance;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProjectFinanceResource extends Resource
{
    protected static ?string $model = ProjectFinance::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationLabel = 'Keuangan Proyek';

    protected static string|\UnitEnum|null $navigationGroup = 'Admin Keuangan (Form Baru)';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return ProjectFinanceForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProjectFinanceInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProjectFinancesTable::configure($table);
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
            'index' => ListProjectFinances::route('/'),
            'create' => CreateProjectFinance::route('/create'),
            'view' => ViewProjectFinance::route('/{record}'),
            'edit' => EditProjectFinance::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        $user = auth()->user();
        return $user->isSuperAdmin() || $user->isAdminKeuangan();
    }

    public static function canViewAny(): bool
    {
        return true; // Semua user bisa lihat
    }
}
