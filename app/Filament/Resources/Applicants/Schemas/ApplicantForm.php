<?php

namespace App\Filament\Resources\Applicants\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;

class ApplicantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make('রুট ও ক্যাটাগরি নির্বাচন')
                        ->id('selection')
                        ->schema([
                            Section::make('রুট ও ক্যাটাগরি নির্বাচন')
                            ->schema([
                                Select::make('area_id')
                                    ->label(__('forms.area_name'))
                                    ->relationship('area', 'area_name')
                                    ->required(),
                                Select::make('category_id')
                                    ->label(__('forms.category_name'))
                                    ->relationship('category', 'category_name')
                                    ->required(),

                            ])
                            ->columns(2)
                            ->columnSpanFull(),
                        ]),
                    Step::make('ব্যক্তিগত তথ্য')
                        ->id('personal')
                        ->schema([
                            Section::make('ব্যক্তিগত তথ্য')
                            ->schema([
                                TextInput::make('applicant_name')
                                    ->label(__('forms.applicant_name'))
                                    ->required(),
                                TextInput::make('guardian_name')
                                    ->label(__('forms.guardian_name'))
                                    ->required(),
                                Textarea::make('present_address')
                                    ->label(__('forms.present_address'))
                                    ->required(),
                                Textarea::make('permanent_address')
                                    ->label(__('forms.permanent_address'))
                                    ->required(),
                                Grid::make(3)
                                    ->schema([
                                        TextInput::make('nid_no')
                                            ->label(__('forms.nid_no'))
                                            ->required(),
                                        TextInput::make('email')
                                            ->label(__('forms.email'))
                                            ->email()
                                            ->default(null),
                                        TextInput::make('phone')
                                            ->label(__('forms.phone'))
                                            ->tel()
                                            ->required(),
                                    ])
                                    ->columnSpanFull(),
                                    
                            
                            ])
                            ->columns(2)
                            ->columnSpanFull(),
                        Section::make('প্রয়োজনীয় ডকুমেন্ট সংযুক্তকরণ')
                            ->schema([
                                
                                FileUpload::make('applicant_image')
                                        ->label(__('forms.applicant_image'))
                                        ->image()
                                        ->previewable()
                                        ->imageEditor()
                                        ->circleCropper()
                                        ->disk('public')
                                        ->directory('applicants/profile')
                                        ->required(),
                                    FileUpload::make('signature_image')
                                        ->label(__('forms.signature_image'))
                                        ->image()
                                        ->imageEditor()
                                        ->disk('public')
                                        ->directory('applicants/signature'),
                                    FileUpload::make('nid_image')
                                        ->label(__('forms.nid_image'))
                                        ->image()
                                        ->imageEditor()
                                        ->disk('public')
                                        ->directory('applicants/nid')
                                        ->required(),
                            ])
                            ->columns(2)
                            ->columnSpanFull(),

                        ]),
                    Step::make('পে অর্ডারের বিবরন')
                        ->id('payment')
                        ->schema([
                
                            Section::make('পে অর্ডারের বিবরন')
                                ->schema([
                                    TextInput::make('bank_name')
                                        ->label(__('forms.bank_name'))
                                        ->default(null),
                                    TextInput::make('pay_order_no')
                                        ->label(__('forms.pay_order_no'))
                                        ->default(null),
                                    TextInput::make('amount')
                                        ->label(__('forms.amount'))
                                        ->default(null),
                                    DatePicker::make('order_date')
                                        ->label(__('forms.order_date')),
                                ])
                                ->columns(2)
                                ->columnSpanFull(),
                            
                            Section::make('প্রয়োজনীয় ডকুমেন্ট সংযুক্তকরণ')
                                ->schema([
                                    
                                    FileUpload::make('py_order_image')
                                        ->label(__('forms.py_order_image'))
                                        ->image()
                                        ->imageEditor()
                                        ->disk('public')
                                        ->directory('applicants/pay_order'),
                                ])
                                ->columns(2)
                                ->columnSpanFull(),
                    ]),
                        Step::make('সিদ্ধান্ত')
                            ->schema([
                    ]),
                ])
                ->skippable()
                ->columnSpanFull(),
                
                
                // TextInput::make('confirmed_by')
                //     ->numeric()
                //     ->default(null),
                // TextInput::make('approved_by')
                //     ->numeric()
                //     ->default(null),
               
                // DatePicker::make('applicaton_date'),
                // DatePicker::make('confirm_date'),
                // DatePicker::make('approval_date'),
                // DatePicker::make('expire_date'),
               
            ]);
    }
}
