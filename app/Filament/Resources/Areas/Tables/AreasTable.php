<?php

namespace App\Filament\Resources\Areas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AreasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('area_name')
                    ->label(__('forms.area_name')),
                TextColumn::make('start_number')
                    ->label(__('forms.start_number'))
                    ->formatStateUsing(fn ($state) => \App\Helpers\Helper::en2bn($state)),
                TextColumn::make('end_number')
                    ->label(__('forms.end_number'))
                    ->formatStateUsing(fn ($state) => \App\Helpers\Helper::en2bn($state)),  
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
