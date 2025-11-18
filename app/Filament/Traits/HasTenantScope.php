<?php
// app/Filament/Traits/HasTenantScope.php

namespace App\Filament\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pt;

trait HasTenantScope
{
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // Founder bisa melihat semua data
        if (auth()->user()->hasRole('founder')) {
            return $query;
        }

        // User biasa hanya bisa melihat data PT-nya sendiri
        return $query->where('pt_id', auth()->user()->pt_id);
    }

    public static function canCreate(): bool
    {
        // Founder tidak bisa create data untuk PT tertentu
        if (auth()->user()->hasRole('founder')) {
            return false;
        }

        return parent::canCreate();
    }
}
