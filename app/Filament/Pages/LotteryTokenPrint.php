<?php

namespace App\Filament\Pages;

use App\Helpers\Helper;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
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
use UnitEnum;

class LotteryTokenPrint extends Page implements HasTable, HasForms
{
    use InteractsWithTable, InteractsWithForms;
    // use HasPageShield;
    protected string $view = 'filament.pages.lottery-token-print';
    protected static ?string $navigationLabel = 'টোকেন প্রিন্ট';

    protected static string | UnitEnum | null $navigationGroup = 'টোকেন প্রিন্ট';
    
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::CommandLine;

    public ?int $category_id = null;
    public ?string $year = null;

    public function getTitle(): string
    {
        return 'লটারি টোকেন';
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
                    // Select::make('area_id')
                    //     ->label('এলাকা')
                    //     ->options(\App\Models\Area::all()->pluck('area_name', 'id')->toArray())
                    //     ->placeholder('সকল এলাকা')
                    //     ->reactive(),
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
        return \App\Models\Applicant::query()
            ->when($this->category_id, fn ($query) => $query->where('category_id', $this->category_id))
            ->when($this->year, fn ($query) => $query->whereYear('created_at', $this->year))
            ->where('status','confirmed');
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('application_number')->label('আবেদন নং')
                ->formatStateUsing(fn (string $state): string => Helper::en2bn($state))
                ->sortable(),
            TextColumn::make('applicant_name')->label('নাম')->sortable(),
            TextColumn::make('area.area_name')->label('এলাকা')->sortable(),
            TextColumn::make('category.category_name')->label('ক্যাটাগরি')->sortable(),
            TextColumn::make('status')->label('অবস্থা')->sortable()
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'confirmed' => 'info',
                    'pending' => 'warning',
                    'approved' => 'success',
                    'rejected' => 'danger',
                }),
            TextColumn::make('applicaton_date')->label('আবেদনের তারিখ')
                ->formatStateUsing(fn (string $state): string => Helper::en2bn(date('d-m-Y', strtotime($state))))
                ->sortable(),
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
                        ->withFilename('টোকেন প্রিন্ট_' . now()->format('Y-m-d'))
                        ->withWriterType(\Maatwebsite\Excel\Excel::XLSX),          
                ]),
            Action::make('print_report')
                ->label('টোকেন প্রিন্ট করুন')
                ->url(fn () => route('lottery-token-print', [
                    'category_id' => $this->category_id,
                    'year' => $this->year,
                ]))
                ->openUrlInNewTab(),
                ];
    }
}
