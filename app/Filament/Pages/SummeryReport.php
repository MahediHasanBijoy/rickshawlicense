<?php

namespace App\Filament\Pages;

use App\Helpers\Helper;
use App\Models\Payment;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use pxlrbt\FilamentExcel\Actions\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use Rakibhstu\Banglanumber\NumberToBangla;
use UnitEnum;

class SummeryReport extends Page implements HasTable, HasForms
{
    use InteractsWithTable, InteractsWithForms;
    protected string $view = 'filament.pages.summery-report';

    protected static ?string $navigationLabel = 'সামারি রিপোর্ট';

    protected static string | UnitEnum | null $navigationGroup = 'রিপোর্ট সমূহ';
    
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::BookOpen;

    public ?int $area_id = null;
    public ?int $category_id = null;
    public ?string $year = null;

    public function getTitle(): string
    {
        return 'সামারি রিপোর্ট';
    }

    public function mount()
    {
        $this->year = now()->format('Y');
    }

    protected function getFormSchema(): array
    {
        return[

            Grid::make(4)
                ->schema([
                    Select::make('area_id')
                        ->label('এলাকা')
                        ->options(\App\Models\Area::all()->pluck('area_name', 'id')->toArray())
                        ->placeholder('সকল এলাকা')
                        ->reactive(),

                    Select::make('category_id')
                        ->label('ক্যাটাগরি')
                        ->options(\App\Models\Category::all()->pluck('category_name', 'id')->toArray())
                        ->placeholder('সকল ক্যাটাগরি')
                        ->reactive(),

                    Select::make('year')
                        ->label('বছর')
                        ->options(function () {
                            $currentYear = date('Y');
                            $years = [];
                            for ($year = $currentYear; $year >= 2000; $year--) {
                                $years[$year] = $year;
                            }
                            return $years;
                        })
                        ->placeholder('সকল বছর')
                        ->reactive(),
                ]),

        ];
    }

    protected function getTableQuery()
    {
        return Payment::query()
            ->whereHas('applicant',function ($query) {
                return $query->when($this->area_id, fn ($query) => $query->where('area_id', $this->area_id))
                ->when($this->category_id, fn ($query) => $query->where('category_id', $this->category_id))
                ->when($this->year, fn ($query) => $query->whereYear('created_at', $this->year));
            });        
    }

    protected function getTableColumns(): array
    {
        $numto = new NumberToBangla();
        return [
            TextColumn::make('applicant.application_number')
                ->label(__('forms.application_number'))
                ->formatStateUsing(fn($state)=>Helper::en2bn($state))
                ->searchable(),
            TextColumn::make('applicant.applicant_name')
                ->label(__('forms.applicant_name'))
                ->formatStateUsing(fn($state)=>Helper::en2bn($state))
                ->searchable(),
            TextColumn::make('fee')
                ->label(__('forms.fee'))
                ->formatStateUsing(fn($state)=>$numto->bnCommaLakh($state))
                ->searchable()
                ->suffix(' ৳'),
            TextColumn::make('yearly_fee')
                ->label(__('forms.yearly_fee'))
                ->formatStateUsing(fn($state)=>$numto->bnCommaLakh($state))
                ->searchable()
                ->suffix(' ৳'),
            TextColumn::make('yearly_fee_refund')
                ->label(__('forms.yearly_fee_refund'))
                ->formatStateUsing(fn($state)=>$numto->bnCommaLakh($state))
                ->searchable()
                ->suffix(' ৳'),
            TextColumn::make('security_fee')
                ->label(__('forms.security_fee'))
                ->formatStateUsing(fn($state)=>$numto->bnCommaLakh($state))
                ->searchable()
                ->suffix(' ৳'),
            TextColumn::make('security_fee_refund')
                ->label(__('forms.security_fee_refund'))
                ->formatStateUsing(fn($state)=>$numto->bnCommaLakh($state))
                ->searchable()
                ->suffix(' ৳'),
            TextColumn::make('total_paid')
                ->label(__('forms.total_paid'))
                ->formatStateUsing(fn($state)=>$numto->bnCommaLakh($state))
                ->searchable()
                ->suffix(' ৳'),
        ];
    }

    protected function getTableHeaderActions(): array
    {
        return[
            ExportAction::make('ExportExcel')
                ->label('এক্সেলে ডাউনলোড')
                ->color('success')
                ->exports([
                    ExcelExport::make()
                        ->fromTable()
                        ->withFilename('সামারি রিপোর্ট_' . now()->format('Y-m-d'))
                        ->withWriterType(\Maatwebsite\Excel\Excel::XLSX),          
                ]),
            Action::make('print_report')
                ->label('রিপোর্ট প্রিন্ট করুন')
                ->url(fn () => route('summery-application-report-print', [
                    'area_id' => $this->area_id,
                    'category_id' => $this->category_id,
                    'year' => $this->year,
                ]))
                ->openUrlInNewTab(),
                ];
    }
}
