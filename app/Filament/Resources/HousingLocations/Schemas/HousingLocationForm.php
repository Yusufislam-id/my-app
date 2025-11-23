<?php

namespace App\Filament\Resources\HousingLocations\Schemas;

use App\Models\Company;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HousingLocationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Lokasi')
                    ->schema([
                        Select::make('company_id')
                            ->label('Perusahaan')
                            ->options(Company::where('is_active', true)->pluck('name', 'id'))
                            ->required()
                            ->searchable()
                            ->preload()
                            ->default(fn () => auth()->user()->isFounder() ? null : auth()->user()->company_id)
                            ->disabled(fn () => !auth()->user()->isFounder())
                            ->dehydrated(),
                        
                        TextInput::make('name')
                            ->label('Nama Lokasi Perumahan')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Perumahan Griya Asri'),
                        
                        TextInput::make('code')
                            ->label('Kode Lokasi')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50)
                            ->placeholder('Contoh: GRA-001')
                            ->alphaDash(),
                        
                        Textarea::make('address')
                            ->label('Alamat')
                            ->rows(3)
                            ->columnSpanFull(),
                        
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }
}
