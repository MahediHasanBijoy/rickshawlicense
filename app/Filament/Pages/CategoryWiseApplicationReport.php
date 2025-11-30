<?php

namespace App\Filament\Pages;

use App\Helpers\Helper;
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

class CategoryWiseApplicationReport extends Page implements HasTable, HasForms
{
    use InteractsWithTable, InteractsWithForms;
    protected string $view = 'filament.pages.category-wise-application-report';

    protected static ?string $navigationLabel = 'ক্যাটাগরি ভিত্তিক রিপোর্ট';

    protected static string | UnitEnum | null $navigationGroup = 'রিপোর্ট সমূহ';
    
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::ClipboardDocumentList;

    public ?int $area_id = null;
    public ?string $year = null;

    public function getTitle(): string
    {
        return 'ক্যাটাগরি ভিত্তিক রিপোর্ট';
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
        return \App\Models\Category::query()
            ->withCount([
            'applicants as pending_count' => function ($q) {
                $q->when($this->area_id, fn ($q) => $q->where('area_id', $this->area_id))
                  ->when($this->year, fn ($q) => $q->whereYear('created_at', $this->year))
                  ->where('status', 'pending');
            },

            'applicants as selected_count' => function ($q) {
                $q->when($this->area_id, fn ($q) => $q->where('area_id', $this->area_id))
                  ->when($this->year, fn ($q) => $q->whereYear('created_at', $this->year))
                  ->where('status', 'selected')->orWhere(function($query){
                     return $query->where('status', 'approved');
                  });
            },

            'applicants as approved_count' => function ($q) {
                $q->when($this->area_id, fn ($q) => $q->where('area_id', $this->area_id))
                  ->when($this->year, fn ($q) => $q->whereYear('created_at', $this->year))
                  ->where('status', 'approved');
            },

            'applicants as confirmed_count' => function ($q) {
                $q->when($this->area_id, fn ($q) => $q->where('area_id', $this->area_id))
                  ->when($this->year, fn ($q) => $q->whereYear('created_at', $this->year))
                  ->where('status','!=', 'pending');
            },

            'applicants as rejected_count' => function ($q) {
                $q->when($this->area_id, fn ($q) => $q->where('area_id', $this->area_id))
                  ->when($this->year, fn ($q) => $q->whereYear('created_at', $this->year))
                  ->where('status', 'rejected');
            },

            // total count
            'applicants as total_count' => function ($q) {
                $q->when($this->area_id, fn ($q) => $q->where('area_id', $this->area_id))
                  ->when($this->year, fn ($q) => $q->whereYear('created_at', $this->year));
            },
        ]);
    }

    protected function getTableColumns(): array
    {
        $numto = new NumberToBangla();
        return [
            TextColumn::make('category_name')
                ->label('ক্যাটাগরি'),

            TextColumn::make('pending_count')
                ->label('বিচারাধীন')
                ->sortable()
                ->formatStateUsing(fn($state)=>$numto->bnCommaLakh($state)),

            TextColumn::make('confirmed_count')
                ->label('নিশ্চিত')
                ->sortable()
                ->formatStateUsing(fn($state)=>$numto->bnCommaLakh($state)),

            TextColumn::make('selected_count')
                ->label('নির্বাচিত')
                ->sortable()
                ->formatStateUsing(fn($state)=>$numto->bnCommaLakh($state)),


            TextColumn::make('approved_count')
                ->label('অনুমোদিত')
                ->sortable()
                ->formatStateUsing(fn($state)=>$numto->bnCommaLakh($state)),

            TextColumn::make('rejected_count')
                ->label('বাতিল')
                ->sortable()
                ->formatStateUsing(fn($state)=>$numto->bnCommaLakh($state)),

            TextColumn::make('total_count')
                ->label('মোট আবেদন')
                ->formatStateUsing(fn($state)=>$numto->bnCommaLakh($state)),
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
                        ->withFilename('ক্যাটাগরি ভিত্তিক রিপোর্ট_' . now()->format('Y-m-d'))
                        ->withWriterType(\Maatwebsite\Excel\Excel::XLSX),          
                ]),
            Action::make('print_report')
                ->label('রিপোর্ট প্রিন্ট করুন')
                ->url(fn () => route('category-application-report-print', [
                    'area_id' => $this->area_id,
                    
                    'year' => $this->year,
                ]))
                ->openUrlInNewTab(),
                ];
    }
    
}
