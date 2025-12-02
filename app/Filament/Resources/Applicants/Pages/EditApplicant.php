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

    public ?string $activeStep = null;

    public function getTitle(): string
    {
        return "আবেদন নং: {$this->record->application_number} — {$this->record->applicant_name}";
    }

    public function mount($record): void
    {
        parent::mount($record);
         if (request()->filled('step')) {
        return;
    }
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
                ->visible(fn () => ! in_array($this->record->status, ['pending', 'rejected'])),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $this->record->load('payment');   // 🟩 THIS FIXES THE ISSUE
        return $data;
    }

   public function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('edit', ['record' => $this->record->id]);
    }
}
