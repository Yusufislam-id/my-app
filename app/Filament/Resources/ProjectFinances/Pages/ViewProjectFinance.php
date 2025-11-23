<?php

namespace App\Filament\Resources\ProjectFinances\Pages;

use App\Filament\Resources\ProjectFinances\ProjectFinanceResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewProjectFinance extends ViewRecord
{
    protected static string $resource = ProjectFinanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
