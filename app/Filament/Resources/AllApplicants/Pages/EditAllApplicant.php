<?php

namespace App\Filament\Resources\AllApplicants\Pages;

use App\Filament\Resources\AllApplicants\AllApplicantResource;
use App\Helpers\Helper;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAllApplicant extends EditRecord
{
    protected static string $resource = AllApplicantResource::class;

    public function getTitle(): string
    {
        $title=Helper::en2bn($this->record->application_number);
        return "আবেদন নং: {$title} — {$this->record->applicant_name}";
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
