<?php

namespace App\Filament\Resources\ProjectFinances\Pages;

use App\Filament\Resources\ProjectFinances\ProjectFinanceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProjectFinances extends ListRecords
{
    protected static string $resource = ProjectFinanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(fn () => static::getResource()::canCreate()),
        ];
    }
}
