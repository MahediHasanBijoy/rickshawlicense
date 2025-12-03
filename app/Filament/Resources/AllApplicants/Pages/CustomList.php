<?php

namespace App\Filament\Resources\AllApplicants\Pages;

use App\Filament\Resources\AllApplicants\AllApplicantResource;
use App\Helpers\Helper;
use App\Models\Applicant;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use PhpParser\Node\Stmt\Label;

use function Symfony\Component\Clock\now;

class CustomList extends Page implements HasTable, HasForms
{
    use InteractsWithForms, InteractsWithTable;
    protected static string $resource = AllApplicantResource::class;

    protected string $view = 'filament.resources.all-applicants.pages.custom-list';

    public function getTitle(): string
    {
        return 'পুরাতন আবেদনের তালিকা';
    }

    public ?int $year=null;

    public function mount(): void
    {
        $this->year=now()->format('Y');
    }


    protected function getFormSchema(): array
    {
        return [
            Grid::make(4)
                ->schema([
                    Select::make('year')
                    ->label(__('forms.applicant_year'))
                    ->options(function () {
                        $currentYear = date('Y');
                        $years = [];
                        for ($year = $currentYear; $year >= 2025; $year--) {
                            $years[$year] = $year;
                        }
                        return $years;
                    })
                    ->required(),
                ])    
        ];

    }

    protected function getTableQuery()
    {

        return Applicant::query()->when($this->year, fn($query)=>$query->where('applicant_year',$this->year));
        
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('application_number')
                ->label('আবেদন নং')
                ->formatStateUsing(fn($state)=> Helper::en2bn($state))
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
        ];
    }

     protected function getTableActions(): array
    {
        return [
            Action::make('edit')
                ->Label('দেখুন')
                ->icon(Heroicon::Eye)
                ->url(fn (\App\Models\Applicant $record): string => route('filament.admin.resources.old-applicants.view', $record)),
            Action::make('edit')
                ->Label('সম্পাদন করুন')
                ->icon(Heroicon::PencilSquare)
                ->url(fn (\App\Models\Applicant $record): string => route('filament.admin.resources.old-applicants.edit', $record)),
            
        ];
    }
}
