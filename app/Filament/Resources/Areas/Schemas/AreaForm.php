<?php

namespace App\Filament\Resources\Areas\Schemas;

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
                Textarea::make('description')
                    ->label(__('forms.description'))
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
