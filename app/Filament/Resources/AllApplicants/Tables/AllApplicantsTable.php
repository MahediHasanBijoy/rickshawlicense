<?php

namespace App\Filament\Resources\AllApplicants\Tables;

use App\Helpers\Helper;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AllApplicantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('application_number')
                    ->label('আবেদন নং')
                    ->searchable(),
                TextColumn::make('applicant_name')
                    ->label(__('forms.applicant_name'))
                    ->searchable(),
                TextColumn::make('guardian_name')
                    ->label(__('forms.guardian_name'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('nid_no')
                    ->label(__('forms.nid_no'))
                    ->formatStateUsing(fn($state)=> Helper::en2bn($state))
                    ->searchable(),
                TextColumn::make('category.category_name')
                    ->label(__('forms.category_name'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('phone')
                    ->label(__('forms.phone'))
                     ->formatStateUsing(fn($state)=> Helper::en2bn($state))
                    ->searchable(),
                TextColumn::make('bank_name')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label(__('forms.bank_name'))
                    ->searchable(),
                TextColumn::make('pay_order_no')
                    ->label(__('forms.pay_order_no'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('amount')
                    ->label(__('forms.amount'))
                    ->searchable(),
                TextColumn::make('order_date')
                    ->label(__('forms.order_date'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->date()
                    ->sortable(),
                TextColumn::make('applicaton_date')
                    ->label(__('forms.applicaton_date'))
                    ->date()
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('forms.status'))
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'confirmed',
                        'success' => 'approved',
                        'danger' => 'unselected',
                    ])
                    ->sortable(),
                TextColumn::make('confirmed_by')
                    ->label(__('forms.confirmed_by'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('approved_by')
                    ->label(__('forms.area_name'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
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
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
