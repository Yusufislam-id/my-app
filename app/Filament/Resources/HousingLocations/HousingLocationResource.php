<?php

namespace App\Filament\Resources\HousingLocations;

use App\Filament\Resources\HousingLocations\Pages\CreateHousingLocation;
use App\Filament\Resources\HousingLocations\Pages\EditHousingLocation;
use App\Filament\Resources\HousingLocations\Pages\ListHousingLocations;
use App\Filament\Resources\HousingLocations\Pages\ViewHousingLocation;
use App\Filament\Resources\HousingLocations\Schemas\HousingLocationForm;
use App\Filament\Resources\HousingLocations\Schemas\HousingLocationInfolist;
use App\Filament\Resources\HousingLocations\Tables\HousingLocationsTable;
use App\Models\HousingLocation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HousingLocationResource extends Resource
{
    protected static ?string $model = HousingLocation::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $navigationLabel = 'Lokasi Perumahan';

    protected static string|\UnitEnum|null $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return HousingLocationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return HousingLocationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HousingLocationsTable::configure($table);
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
            'index' => ListHousingLocations::route('/'),
            'create' => CreateHousingLocation::route('/create'),
            'view' => ViewHousingLocation::route('/{record}'),
            'edit' => EditHousingLocation::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function canViewAny(): bool
    {
        $user = auth()->user();
        return $user->isSuperAdmin() ||
               $user->isFounder() || 
               $user->isDirektur() || 
               $user->isKomisaris() ||
               $user->isAdminPemberkasan() ||
               $user->isAdminKeuangan();
    }
}
