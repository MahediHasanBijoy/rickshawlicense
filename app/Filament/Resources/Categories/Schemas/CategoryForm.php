<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('category_name')
                    ->label(__('forms.category_name'))
                    ->required(),
                Textarea::make('description')
                    ->label(__('forms.description'))
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
