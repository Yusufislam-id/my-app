<?php

namespace App\Filament\Resources\Pts\Pages;

use App\Filament\Resources\Pts\PtResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPts extends ListRecords
{
    protected static string $resource = PtResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
