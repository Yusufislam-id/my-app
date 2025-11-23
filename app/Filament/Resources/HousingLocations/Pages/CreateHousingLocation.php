<?php

namespace App\Filament\Resources\HousingLocations\Pages;

use App\Filament\Resources\HousingLocations\HousingLocationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateHousingLocation extends CreateRecord
{
    protected static string $resource = HousingLocationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Auto-set company_id from authenticated user if not a founder (safety net)
        if (!auth()->user()->isFounder() && !isset($data['company_id'])) {
            $data['company_id'] = auth()->user()->company_id;
        }
        
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Lokasi perumahan berhasil dibuat';
    }
}
