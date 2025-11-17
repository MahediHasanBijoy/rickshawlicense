<?php

namespace App\Filament\Resources\Applicants\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ApplicantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // TextColumn::make('area.area_name')
                //     ->label(__('forms.area_name'))
                //     ->searchable(),
                // TextColumn::make('category.category_name')
                //     ->label(__('forms.category_name'))
                    // ->searchable(),
                TextColumn::make('applicant_name')
                    ->label(__('forms.applicant_name'))
                    ->searchable(),
                TextColumn::make('guardian_name')
                    ->label(__('forms.guardian_name'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('nid_no')
                    ->label(__('forms.nid_no'))
                    ->searchable(),
                // TextColumn::make('email')
                //     ->label(__('forms.email'))
                //     ->searchable(),
                TextColumn::make('phone')
                    ->label(__('forms.phone'))
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
                    ->date()
                    ->sortable(),
                TextColumn::make('applicaton_date')
                    ->label(__('forms.applicaton_date'))
                    ->date()
                    ->sortable(),
                // TextColumn::make('confirm_date')
                //     ->label(__('forms.confirm_date'))
                //     ->date()
                //     ->sortable(),
                // TextColumn::make('approval_date')
                //     ->label(__('forms.approval_date'))
                //     ->date()
                //     ->sortable(),
                // TextColumn::make('expire_date')
                //     ->label(__('forms.expire_date'))
                //     ->date()
                //     ->sortable(),
                // ImageColumn::make('applicant_image')
                //     ->label(__('forms.applicant_image')),
                // ImageColumn::make('signature_image')
                //     ->label(__('forms.signature_image')),
                // ImageColumn::make('nid_image')
                //     ->label(__('forms.nid_image')),
                // ImageColumn::make('py_order_image')
                //     ->label(__('forms.py_order_image')),
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
