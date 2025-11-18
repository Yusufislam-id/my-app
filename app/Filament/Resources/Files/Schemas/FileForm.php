<?php

namespace App\Filament\Resources\Files\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FileForm
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
                TextInput::make('form_id')
                    ->numeric(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('original_name')
                    ->required(),
                TextInput::make('path')
                    ->required(),
                TextInput::make('mime_type')
                    ->required(),
                TextInput::make('size')
                    ->required()
                    ->numeric(),
                TextInput::make('disk')
                    ->required()
                    ->default('local'),
            ]);
    }
}
