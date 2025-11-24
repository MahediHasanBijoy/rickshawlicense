<?php

namespace App\Filament\Resources\Areas\Schemas;

use Dom\Text;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AreaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('area_name')
                    ->label(__('forms.area_name'))
                    ->required(),
                TextInput::make('start_number')
                    ->label(__('forms.start_number'))
                    ->numeric()
                    ->required(),
                TextInput::make('end_number')
                    ->label(__('forms.end_number'))
                    ->numeric()
                    ->required(),
                Textarea::make('description')
                    ->label(__('forms.description'))
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
