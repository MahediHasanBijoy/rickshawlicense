<?php

namespace App\Filament\Resources\AllApplicants;

use App\Filament\Resources\AllApplicants\Pages\CreateAllApplicant;
use App\Filament\Resources\AllApplicants\Pages\CustomList;
use App\Filament\Resources\AllApplicants\Pages\EditAllApplicant;
use App\Filament\Resources\AllApplicants\Pages\ListAllApplicants;
use App\Filament\Resources\AllApplicants\Pages\ViewAllApplicant;
use App\Filament\Resources\AllApplicants\Schemas\AllApplicantForm;
use App\Filament\Resources\AllApplicants\Schemas\AllApplicantInfolist;
use App\Filament\Resources\AllApplicants\Tables\AllApplicantsTable;
use App\Models\AllApplicant;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AllApplicantResource extends Resource
{
    protected static ?string $model = AllApplicant::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $slug = 'old-applicants';

    public static function getModelLabel(): string
    {
        return 'পুরাতন আবেদন';
    }

    public static function getPluralModelLabel(): string
    {
        return 'পুরাতন আবেদন সমূহ'; 
    }

    public static function form(Schema $schema): Schema
    {
        return AllApplicantForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AllApplicantInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AllApplicantsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => CustomList::route('/'),
            'create' => CreateAllApplicant::route('/create'),
            'view' => ViewAllApplicant::route('/{record}'),
            'edit' => EditAllApplicant::route('/{record}/edit'),
        ];
    }
}
