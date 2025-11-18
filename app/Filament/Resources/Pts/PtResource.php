<?php

namespace App\Filament\Resources\Pts;

use App\Filament\Resources\Pts\Pages\CreatePt;
use App\Filament\Resources\Pts\Pages\EditPt;
use App\Filament\Resources\Pts\Pages\ListPts;
use App\Filament\Resources\Pts\Schemas\PtForm;
use App\Filament\Resources\Pts\Tables\PtsTable;
use App\Models\Pt;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PtResource extends Resource
{
    protected static ?string $model = Pt::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return PtForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PtsTable::configure($table);
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
            'index' => ListPts::route('/'),
            'create' => CreatePt::route('/create'),
            'edit' => EditPt::route('/{record}/edit'),
        ];
    }
}
