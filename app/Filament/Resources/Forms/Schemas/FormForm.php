<?php

namespace App\Filament\Resources\Forms\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FormForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('pt_id')
                    ->required()
                    ->numeric(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('type')
                    ->required(),
                TextInput::make('title')
                    ->required(),
                TextInput::make('data')
                    ->required(),
                TextInput::make('status')
                    ->required()
                    ->default('draft'),
            ]);
    }
}
