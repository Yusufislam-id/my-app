<?php

namespace App\Filament\Resources\DailyReports\Pages;

use App\Filament\Resources\DailyReports\DailyReportResource;
use App\Models\HousingLocation;
use Filament\Resources\Pages\CreateRecord;

class CreateDailyReport extends CreateRecord
{
    protected static string $resource = DailyReportResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // If super_admin, get company_id from the selected housing location
        if (auth()->user()->isSuperAdmin()) {
            $housingLocation = HousingLocation::find($data['housing_location_id']);
            if ($housingLocation) {
                $data['company_id'] = $housingLocation->company_id;
            }
        } else {
            // Otherwise use user's company_id
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
        return 'Laporan harian berhasil dibuat';
    }
}
