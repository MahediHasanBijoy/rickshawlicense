<?php

namespace App\Filament\Resources\Applicants\Schemas;

use App\Helpers\Helper;
use Dom\Text;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Carbon\Carbon;

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
                                            ->unique(ignoreRecord: true, modifyRuleUsing: fn ($rule) =>
                                                    $rule->where('applicant_year', now()->year)
                                            )
                                            ->required()
                                            ->formatStateUsing(fn ($state) => \App\Helpers\Helper::en2bn($state))
                                            ->dehydrateStateUsing(fn ($state) => \App\Helpers\Helper::bn2en($state)),
                                        TextInput::make('email')
                                            ->label(__('forms.email'))
                                            ->email()
                                            ->default(null),
                                        TextInput::make('phone')
                                            ->label(__('forms.phone'))
                                            ->unique(ignoreRecord: true, modifyRuleUsing: fn ($rule) =>
                                                $rule->where('applicant_year', now()->year)
                                            )
                                            ->formatStateUsing(fn ($state) => \App\Helpers\Helper::en2bn($state))
                                            ->dehydrateStateUsing(fn ($state) => \App\Helpers\Helper::bn2en($state))
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
                                        ->directory('applicant')
                                        ->required(),
                                    
                                    FileUpload::make('nid_image')
                                        ->label(__('forms.nid_image'))
                                        ->image()
                                        ->imageEditor()
                                        ->disk('public')
                                        ->directory('applicants/nid')
                                        ->required(),

                                    FileUpload::make('citizen_certificate_image')
                                        ->label(__('forms.citizen_certificate_image'))
                                        ->image()
                                        ->imageEditor()
                                        ->disk('public')
                                        ->directory('citizen_certificate'),

                                    FileUpload::make('category_proof_image')
                                        ->label(__('forms.category_proof_image'))
                                        ->image()
                                        ->imageEditor()
                                        ->disk('public')
                                        ->directory('category_proof'),
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
                                        ->default(null)
                                        ->required(),
                                    TextInput::make('pay_order_no')
                                        ->label(__('forms.pay_order_no'))
                                        ->default(null)
                                        ->required(),
                                    TextInput::make('amount')
                                        ->label(__('forms.amount'))
                                        ->formatStateUsing(fn ($state) => \App\Helpers\Helper::en2bn($state))
                                        ->dehydrateStateUsing(fn ($state) => \App\Helpers\Helper::bn2en($state))
                                        ->default(null)
                                        ->required(),
                                    DatePicker::make('order_date')
                                        ->label(__('forms.order_date'))
                                        ->required(),
                                ])
                                ->columns(2)
                                ->columnSpanFull(),
                            
                            Section::make('প্রয়োজনীয় ডকুমেন্ট সংযুক্তকরণ')
                                ->schema([
                                    
                                    FileUpload::make('py_order_image')
                                        ->label(__('forms.py_order_image'))
                                        ->image()
                                        ->imageEditor()
                                        ->required()
                                        ->disk('public')
                                        ->directory('pay_order'),
                                ])
                                ->columns(2)
                                ->columnSpanFull(),
                    ]),
                        Step::make('সিদ্ধান্ত')
                            ->visible(fn ($livewire) => ! ($livewire instanceof \Filament\Resources\Pages\CreateRecord))
                            ->schema([
                                Section::make('সিদ্ধান্ত')
                                    ->relationship('payment')
                                    ->schema([ 
                                        Grid::make(2)
                                            ->schema([
                                                Select::make('fee_paid')
                                                ->label(__('forms.fee_paid'))
                                                ->options(function ($record) {
                                                        if ($record->fee_paid === 'no') {
                                                            return [
                                                                'yes' => 'হ্যাঁ',
                                                                'no' => 'না',
                                                            ];
                                                        }
                                                        return [
                                                            
                                                            'no' => 'না',
                                                            'paid' => 'পরিশোধিত',
                                                        ];
                                                })
                                                ->preload()
                                                ->searchable()
                                                ->required()
                                                ->default('no'),
                                                TextInput::make('fee')
                                                    ->label(__('forms.fee'))
                                                    ->reactive()
                                                    ->required()
                                                    ->default(function () {
                                                        $setting = \App\Models\ApplicationSetting::first();
                                                        return $setting ? $setting->application_fee : 0;
                                                    })
                                                    ->disabled()
                                                    ->formatStateUsing(fn ($state) => Helper::en2bn($state))
                                                    ->dehydrateStateUsing(fn ($state) => Helper::bn2en($state))
                                                    ->dehydrated(true),
                                                   
                                            ])
                                            ->disabled(fn($record)=>$record?->security_paid=='paid' && auth()->user()->hasRole('super_admin')
                                                    ||($record?->fee_paid=='paid' && auth()->user()->hasRole('admin')) ||$record?->is_yearly_fee_refund==true)
                                            //  ->visible(fn ($livewire) => $livewire->getRecord()?->status === 'pending'
                                            //         || ($livewire->getRecord()?->status !== 'pending' && auth()->user()->hasRole('super_admin')))
                                            ->columnSpanFull(),
                                        Grid::make(2)
                                            ->schema([
                                                Select::make('security_paid')
                                                    ->label(__('forms.security_paid'))
                                                    ->options(function ($record) {
                                                        if ($record->security_paid === 'no') {
                                                            return [
                                                                'yes' => 'হ্যাঁ',
                                                                'no' => 'না',
                                                            ];
                                                        }
                                                        return [
                                                            
                                                            'no' => 'না',
                                                            'paid' => 'পরিশোধিত',
                                                        ];
                                                    })
                                                    ->required()
                                                    ->searchable()
                                                    ->preload()
                                                    ->default('no'),
                                                 TextInput::make('security_payable')
                                                    ->label(__('forms.security_fee'))
                                                    ->disabled()
                                                    ->dehydrated(true)
                                                    ->formatStateUsing(fn ($state) => Helper::en2bn($state))
                                                    ->dehydrateStateUsing(fn ($state) => Helper::bn2en($state))
                                                    ,
                                            ])
                                            ->disabled(fn($record,$livewire)=>($record?->is_security_refund==true && auth()->user()->hasRole('super_admin'))
                                                    || ($record?->security_paid=='paid' && auth()->user()->hasRole('admin')) || Carbon::parse($livewire->getRecord()->expire_date)->lt(now()))
                                            ->visible(fn ($livewire) => $livewire->getRecord()?->status === 'selected'
                                                    || $livewire->getRecord()?->status === 'approved')
                                            ->columnSpanFull(),
                                        Grid::make(2)
                                            ->schema([
                                                Select::make('is_security_refund')
                                                    ->label(__('forms.is_security_refund'))
                                                    ->options([
                                                        1 => 'হ্যাঁ',
                                                        0 => 'না',
                                                    ])
                                                    ->required()
                                                    ->default(0),
                                                    // ->visible(fn ($livewire) => $livewire->getRecord()?->status === 'rejected'
                                                    // || ($livewire->getRecord()?->status === 'refunded' && auth()->user()->hasRole('super_admin'))),
                                                TextInput::make('security_refundable')
                                                        ->label(__('forms.security_refundable'))
                                                        ->disabled(),
                                            ])
                                            ->disabled(fn($record)=>$record?->is_security_refund==true && auth()->user()->hasRole('admin'))
                                            ->visible(fn($livewire)=> 
                                                Carbon::parse($livewire->getRecord()?->expire_date)->lt(now()) && $livewire->getRecord()?->expire_date!=null)
                                            ->columnSpanFull(),
                                        Grid::make(2)
                                            ->schema([
                                                Select::make('is_yearly_fee_refund')
                                                    ->label('বার্ষিক ফি ফেরত দিতে চান?')
                                                    ->options([
                                                        1 => 'হ্যাঁ',
                                                        0 => 'না',
                                                    ])
                                                    ->required()
                                                    ->default(0), 
                                                TextInput::make('yearly_fee')   
                                                    ->label(__('forms.yearly_fee_refund'))
                                                    ->required()
                                                    ->disabled()
                                                    ->dehydrated(true),
                                            ])
                                            ->visible(fn ($livewire) => $livewire->getRecord()?->status === 'rejected')
                                            ->disabled(fn($record)=>$record?->is_yearly_fee_refund==true && auth()->user()->hasRole('admin'))
                                            ->columnSpanFull(),
                                        
                                    ])
                                    ->columns(2),
                                    Section::make('পূর্বের কার্যক্রমের সংক্ষিপ্ত বিবরন')
                                        ->relationship('payment')
                                        ->schema([
                                            Grid::make(3)
                                                ->schema([
                                                    TextEntry::make('invoice_no')
                                                        ->label(__('forms.invoice_no'))
                                                        ->disabled(),
                                                    TextEntry::make('yearly_fee')
                                                        ->label(__('forms.yearly_fee'))
                                                        ->disabled(),
                                                    TextEntry::make('yearly_fee_date')
                                                        ->label(__('forms.date'))
                                                        ->disabled(),

                                                ])
                                               ,
                                            Grid::make(3)
                                                ->schema([
                                                    TextEntry::make('fee')
                                                        ->label(__('forms.fee'))
                                                        
                                                        ->disabled(),
                                                    TextEntry::make('fee_date')
                                                        ->label(__('forms.date'))
                                                        ->disabled(),
                                                    TextEntry::make('created_by')
                                                        ->label(__('forms.created_by'))
                                                        ->formatStateUsing(fn ($record) => $record?->createdBy?->name),
                                                    ])
                                                    ->hidden(fn ($livewire) => $livewire->getRecord()?->status === 'pending'),
                                            Grid::make(3)
                                                ->schema([
                                                    TextEntry::make('security_fee')
                                                        ->label(__('forms.security_fee'))
                                                        ->disabled(),
                                                    TextEntry::make('security_fee_date')
                                                        ->label(__('forms.date')),
                                                    TextEntry::make('security_fee_by')
                                                        ->label(__('forms.security_fee_by'))
                                                       ->formatStateUsing(fn ($record) => $record?->securityFeeBy?->name) 
                                                ])      
                                                ->hidden(fn ($livewire) => $livewire->getRecord()?->status === 'selected' 
                                                                            || $livewire->getRecord()?->status === 'pending'
                                                                            || $livewire->getRecord()?->status === 'confirmed'
                                                                            || $livewire->getRecord()?->status === 'rejected'),
                                                  Grid::make(3)
                                                    ->schema([
                                                        TextEntry::make('security_fee_refund')
                                                            ->label(__('forms.security_fee_refund'))
                                                            ->disabled(),
                                                        TextEntry::make('security_fee_refund_date')
                                                            ->label(__('forms.date')),
                                                        TextEntry::make('security_fee_refund_by')
                                                            ->label(__('forms.actor'))
                                                        ->formatStateUsing(fn ($record) => $record?->securityFeeRefundBy?->name)
                                                    ])
                                                    ->hidden(fn ($record) => $record?->is_security_refund == false),
                                                Grid::make(3)
                                                    ->schema([
                                                        TextEntry::make('yearly_fee_refund')
                                                            ->label(__('forms.yearly_fee_refund'))
                                                            ->disabled(),
                                                        TextEntry::make('yearly_fee_refund_date')
                                                            ->label(__('forms.date')),
                                                        TextEntry::make('yearly_fee_refund_by')
                                                            ->label(__('forms.actor'))
                                                        ->formatStateUsing(fn ($record) => $record?->yearlyFeeRefundBy?->name) 
                                                    ])
                                                    ->hidden(fn($record)=>$record?->is_yearly_fee_refund==false), 
                                          
                                                
                                                ]),
                                            
                                                // ->visible(fn($record)=>$record->is_security_refund===true),                  

                            ]),
                            
                        ])
                        ->skippable()
                        ->columns(2)
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
