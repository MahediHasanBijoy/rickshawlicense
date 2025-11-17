<?php

namespace App\Filament\Resources\Applicants\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ApplicantInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('area.id')
                    ->label('Area'),
                TextEntry::make('category.id')
                    ->label('Category'),
                TextEntry::make('applicant_name'),
                TextEntry::make('guardian_name'),
                TextEntry::make('present_address')
                    ->columnSpanFull(),
                TextEntry::make('permanent_address')
                    ->columnSpanFull(),
                TextEntry::make('nid_no'),
                TextEntry::make('email')
                    ->label('Email address')
                    ->placeholder('-'),
                TextEntry::make('phone'),
                TextEntry::make('bank_name')
                    ->placeholder('-'),
                TextEntry::make('pay_order_no')
                    ->placeholder('-'),
                TextEntry::make('amount')
                    ->placeholder('-'),
                TextEntry::make('order_date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('applicaton_date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('confirm_date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('approval_date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('expire_date')
                    ->date()
                    ->placeholder('-'),
                ImageEntry::make('applicant_image'),
                ImageEntry::make('signature_image')
                    ->placeholder('-'),
                ImageEntry::make('nid_image'),
                ImageEntry::make('py_order_image')
                    ->placeholder('-'),
                TextEntry::make('confirmed_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('approved_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
