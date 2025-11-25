<?php

namespace App\Filament\Resources\ApplicationSettings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ApplicationSettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('application_fee')
                    ->numeric()
                    ->label(__('forms.application_fee'))
                    ->sortable(),
                TextColumn::make('yearly_fee')
                    ->numeric()
                    ->sortable()
                    ->label(__('forms.yearly_fee')),
                TextColumn::make('security_fee')
                    ->numeric()
                    ->sortable()
                    ->label(__('forms.security_fee')),
                TextColumn::make('security_fee_refund')
                    ->numeric()
                    ->sortable()
                    ->label(__('forms.security_fee_refund')),
                TextColumn::make('app_expire_date')
                    ->date()
                    ->sortable()
                    ->label(__('forms.app_expire_date')),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
