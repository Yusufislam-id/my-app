<?php

namespace App\Filament\Resources\FinancialReports\Pages;

use App\Filament\Resources\FinancialReports\FinancialReportResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFinancialReport extends CreateRecord
{
    protected static string $resource = FinancialReportResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Set company_id from user if not super_admin, otherwise use selected value
        if (!auth()->user()->isSuperAdmin()) {
            $data['company_id'] = auth()->user()->company_id;
        }
        $data['created_by'] = auth()->id();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Laporan keuangan berhasil dibuat';
    }
}
