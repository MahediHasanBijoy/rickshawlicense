<?php

namespace App\Filament\Resources\AllApplicants\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AllApplicantInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('area.area_name')
                    ->label(__('forms.area_name')),
                TextEntry::make('category.category_name')
                    ->label(__('forms.category_name')),
                TextEntry::make('applicant_name')
                    ->label(__('forms.applicant_name')),
                TextEntry::make('guardian_name')
                    ->label(__('forms.guardian_name')),
                TextEntry::make('present_address')
                    ->label(__('forms.present_address')),
                TextEntry::make('permanent_address')
                    ->label(__('forms.permanent_address')),
                TextEntry::make('nid_no')
                    ->label(__('forms.nid_no')),
                TextEntry::make('email')
                    ->label(__('forms.email'))
                    ->placeholder('-'),
                TextEntry::make('phone')
                    ->label(__('forms.phone')),
                TextEntry::make('bank_name')
                    ->label(__('forms.bank_name'))
                    ->placeholder('-'),
                TextEntry::make('pay_order_no')
                    ->label(__('forms.pay_order_no'))
                    ->placeholder('-'),
                TextEntry::make('amount')
                    ->label(__('forms.amount'))
                    ->placeholder('-'),
                TextEntry::make('order_date')
                    ->label(__('forms.order_date'))
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('applicaton_date')
                    ->label(__('forms.applicaton_date'))
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('confirm_date')
                    ->label(__('forms.confirm_date'))
                    ->date()
                    ->placeholder('-'),
                
                ImageEntry::make('applicant_image')
                    ->label(__('forms.applicant_image'))
                    ->disk('public')
                    ->visibility('public')
                    ->imageHeight(150)
                    ->imageWidth(150),
                ImageEntry::make('nid_image')
                    ->label(__('forms.nid_image'))
                    ->disk('public')
                    ->imageHeight(150)
                    ->imageWidth(150),
                ImageEntry::make('signature_image')
                    ->label(__('forms.signature_image'))
                    ->disk('public')
                    ->placeholder('-'),
                
                ImageEntry::make('py_order_image')
                    ->label(__('forms.py_order_image'))
                    ->placeholder('-')
                    ->disk('public'),
                TextEntry::make('approval_date')
                    ->label(__('forms.approval_date'))
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('expire_date')
                    ->label(__('forms.expire_date'))
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('confirmed_by')
                    ->label(__('forms.confirmed_by'))
                    ->placeholder('-'),
                TextEntry::make('approved_by')
                    ->label(__('forms.approved_by'))
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
