<?php

namespace App\Filament\Resources\Designations\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class DesignationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('designation_name')
                    ->label(__('forms.designation_name'))
                    ->required(),
                Textarea::make('description')
                    ->label(__('forms.description'))
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
