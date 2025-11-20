<?php

namespace App\Filament\Resources\Departments\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class DepartmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('department_name')
                    ->label(__('forms.department_name'))
                    ->required(),
                Textarea::make('description')
                    ->label(__('forms.description'))
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
