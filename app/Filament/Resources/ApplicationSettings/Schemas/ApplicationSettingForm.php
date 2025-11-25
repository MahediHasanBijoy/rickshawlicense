<?php

namespace App\Filament\Resources\ApplicationSettings\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ApplicationSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('application_fee')
                    ->required()
                    ->label(__('forms.application_fee'))
                    ->formatStateUsing(fn ($state) => \App\Helpers\Helper::en2bn($state))
                    ->dehydrateStateUsing(fn ($state) => \App\Helpers\Helper::bn2en($state)),
                TextInput::make('daily_fee')
                    ->required()
                    ->label(__('forms.daily_fee'))
                    ->formatStateUsing(fn ($state) => \App\Helpers\Helper::en2bn($state))
                    ->dehydrateStateUsing(fn ($state) => \App\Helpers\Helper::bn2en($state)),
                TextInput::make('yearly_fee')
                    ->required()
                    ->label(__('forms.yearly_fee'))
                    ->formatStateUsing(fn ($state) => \App\Helpers\Helper::en2bn($state))
                    ->dehydrateStateUsing(fn ($state) => \App\Helpers\Helper::bn2en($state)),
                TextInput::make('security_fee')
                    ->required()
                    ->label(__('forms.security_fee'))
                    ->formatStateUsing(fn ($state) => \App\Helpers\Helper::en2bn($state))
                    ->dehydrateStateUsing(fn ($state) => \App\Helpers\Helper::bn2en($state)),
                TextInput::make('security_fee_refund')
                    ->required()
                    ->label(__('forms.security_fee_refund'))
                    ->formatStateUsing(fn ($state) => \App\Helpers\Helper::en2bn($state))
                    ->dehydrateStateUsing(fn ($state) => \App\Helpers\Helper::bn2en($state)),
                DatePicker::make('app_expire_date')
                    ->required()
                    ->label(__('forms.app_expire_date')),
            ]);
    }
}
