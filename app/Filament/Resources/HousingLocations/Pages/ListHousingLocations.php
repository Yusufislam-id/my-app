<?php

namespace App\Filament\Resources\HousingLocations\Pages;

use App\Filament\Resources\HousingLocations\HousingLocationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHousingLocations extends ListRecords
{
    protected static string $resource = HousingLocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
