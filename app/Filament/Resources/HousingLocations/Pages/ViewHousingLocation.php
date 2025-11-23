<?php

namespace App\Filament\Resources\HousingLocations\Pages;

use App\Filament\Resources\HousingLocations\HousingLocationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewHousingLocation extends ViewRecord
{
    protected static string $resource = HousingLocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
