<?php

namespace App\Filament\Widgets;

use App\Models\Company;
use App\Models\Document;
use App\Models\FinancialReport;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $user = auth()->user();

        if (! $user) {
            return [];
        }

        // Founder melihat semua data
        if ($user->isFounder()) {
            return [
                Stat::make('Total Perusahaan', Company::count())
                    ->description('Perusahaan terdaftar')
                    ->descriptionIcon('heroicon-m-building-office')
                    ->color('success'),
                Stat::make('Total Pengguna', User::count())
                    ->description('Pengguna aktif')
                    ->descriptionIcon('heroicon-m-users')
                    ->color('info'),
                Stat::make('Total Dokumen', Document::count())
                    ->description('Dokumen pemberkasan')
                    ->descriptionIcon('heroicon-m-document-text')
                    ->color('warning'),
                Stat::make('Total Laporan', FinancialReport::count())
                    ->description('Laporan keuangan')
                    ->descriptionIcon('heroicon-m-chart-bar')
                    ->color('primary'),
            ];
        }

        // Direktur dan Komisaris melihat data PT sendiri
        if ($user->isDirektur() || $user->isKomisaris()) {
            return [
                Stat::make('Dokumen Pemberkasan', Document::where('company_id', $user->company_id)->count())
                    ->description('Total dokumen')
                    ->descriptionIcon('heroicon-m-document-text')
                    ->color('warning'),
                Stat::make('Laporan Keuangan', FinancialReport::where('company_id', $user->company_id)->count())
                    ->description('Total laporan')
                    ->descriptionIcon('heroicon-m-chart-bar')
                    ->color('primary'),
                Stat::make('Dokumen Disetujui', Document::where('company_id', $user->company_id)
                    ->where('status', 'approved')
                    ->count())
                    ->description('Dokumen approved')
                    ->descriptionIcon('heroicon-m-check-circle')
                    ->color('success'),
                Stat::make('Laporan Disetujui', FinancialReport::where('company_id', $user->company_id)
                    ->where('status', 'approved')
                    ->count())
                    ->description('Laporan approved')
                    ->descriptionIcon('heroicon-m-check-circle')
                    ->color('success'),
            ];
        }

        // Admin Pemberkasan
        if ($user->isAdminPemberkasan()) {
            return [
                Stat::make('Dokumen Saya', Document::where('company_id', $user->company_id)->count())
                    ->description('Total dokumen')
                    ->descriptionIcon('heroicon-m-document-text')
                    ->color('primary'),
                Stat::make('Draft', Document::where('company_id', $user->company_id)
                    ->where('status', 'draft')
                    ->count())
                    ->description('Dokumen draft')
                    ->descriptionIcon('heroicon-m-document')
                    ->color('gray'),
                Stat::make('Diajukan', Document::where('company_id', $user->company_id)
                    ->where('status', 'submitted')
                    ->count())
                    ->description('Dokumen diajukan')
                    ->descriptionIcon('heroicon-m-arrow-up-tray')
                    ->color('warning'),
                Stat::make('Disetujui', Document::where('company_id', $user->company_id)
                    ->where('status', 'approved')
                    ->count())
                    ->description('Dokumen approved')
                    ->descriptionIcon('heroicon-m-check-circle')
                    ->color('success'),
            ];
        }

        // Admin Keuangan
        if ($user->isAdminKeuangan()) {
            return [
                Stat::make('Laporan Saya', FinancialReport::where('company_id', $user->company_id)->count())
                    ->description('Total laporan')
                    ->descriptionIcon('heroicon-m-chart-bar')
                    ->color('primary'),
                Stat::make('Draft', FinancialReport::where('company_id', $user->company_id)
                    ->where('status', 'draft')
                    ->count())
                    ->description('Laporan draft')
                    ->descriptionIcon('heroicon-m-document')
                    ->color('gray'),
                Stat::make('Diajukan', FinancialReport::where('company_id', $user->company_id)
                    ->where('status', 'submitted')
                    ->count())
                    ->description('Laporan diajukan')
                    ->descriptionIcon('heroicon-m-arrow-up-tray')
                    ->color('warning'),
                Stat::make('Disetujui', FinancialReport::where('company_id', $user->company_id)
                    ->where('status', 'approved')
                    ->count())
                    ->description('Laporan approved')
                    ->descriptionIcon('heroicon-m-check-circle')
                    ->color('success'),
            ];
        }

        return [];
    }
}
