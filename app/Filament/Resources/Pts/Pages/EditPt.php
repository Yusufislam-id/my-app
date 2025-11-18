<?php

namespace App\Filament\Resources\Pts\Pages;

use App\Filament\Resources\Pts\PtResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPt extends EditRecord
{
    protected static string $resource = PtResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
