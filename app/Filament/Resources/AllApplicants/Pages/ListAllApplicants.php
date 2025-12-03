<?php

namespace App\Filament\Resources\AllApplicants\Pages;

use App\Filament\Resources\AllApplicants\AllApplicantResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAllApplicants extends ListRecords
{
    protected static string $resource = AllApplicantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
