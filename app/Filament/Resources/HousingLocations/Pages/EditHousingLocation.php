<?php

namespace App\Filament\Resources\HousingLocations\Pages;

use App\Filament\Resources\HousingLocations\HousingLocationResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditHousingLocation extends EditRecord
{
    protected static string $resource = HousingLocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Prevent non-founders from changing company_id
        if (!auth()->user()->isFounder()) {
            $data['company_id'] = $this->record->company_id;
        }
        
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
