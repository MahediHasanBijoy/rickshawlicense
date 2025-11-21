<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('forms.applicant_name'))
                    ->required(),
                TextInput::make('email')
                    ->label(__('forms.email'))
                    ->email()
                    ->required(),
                Select::make('department_id')
                    ->label(__('forms.department'))
                    ->relationship('department', 'department_name')
                    ->createOptionForm(function (Schema $schema) {
                        return $schema->components([
                            TextInput::make('department_name')
                                ->label(__('forms.department_name'))
                                ->required(),
                        ]);
                    })
                    ->searchable()
                    ->preload()
                    ->nullable(),
                Select::make('designation_id')
                    ->label(__('forms.designation'))
                    ->relationship('designation', 'designation_name')
                    ->createOptionForm(function (Schema $schema) {
                        return $schema->components([
                            TextInput::make('designation_name')
                                ->label(__('forms.designation_name'))
                                ->required(),
                        ]);
                    })
                    ->searchable()
                    ->preload()
                    ->nullable(),
                Select::make('roles')
                    ->label(__('forms.role'))
                    ->multiple()
                    ->relationship('roles', 'name')
                    ->preload()
                    ->required(),
                // DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->required(),
            ]);
    }
}
