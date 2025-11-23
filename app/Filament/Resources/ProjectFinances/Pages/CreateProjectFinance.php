<?php

namespace App\Filament\Resources\ProjectFinances\Pages;

use App\Filament\Resources\ProjectFinances\ProjectFinanceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProjectFinance extends CreateRecord
{
    protected static string $resource = ProjectFinanceResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = auth()->user()->company_id;
        $data['created_by'] = auth()->id();
        
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Keuangan proyek berhasil dibuat';
    }
}
