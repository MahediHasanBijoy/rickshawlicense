<?php

namespace App\Filament\Resources\AllApplicants\Pages;

use App\Filament\Resources\AllApplicants\AllApplicantResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAllApplicant extends ViewRecord
{
    protected static string $resource = AllApplicantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
