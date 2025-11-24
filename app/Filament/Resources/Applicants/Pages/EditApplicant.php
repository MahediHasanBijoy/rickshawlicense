<?php

namespace App\Filament\Resources\Applicants\Pages;

use App\Filament\Resources\Applicants\ApplicantResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditApplicant extends EditRecord
{
    protected static string $resource = ApplicantResource::class;

    public function getTitle(): string
    {
        return "আবেদন নং: {$this->record->application_number} — {$this->record->applicant_name}";
    }
    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            Action::make('Print Receipt')
                ->label('রশিদ প্রিন্ট করুন')
                ->url(fn () => route('applicant.receipt', ['app_id' => $this->record->id]))
                ->openUrlInNewTab()
                ->visible(fn()=>$this->record->status!='pending'),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $this->record->load('payment');   // 🟩 THIS FIXES THE ISSUE
        return $data;
    }

}
