<?php

namespace App\Filament\Resources\ApplicationSettings;

use App\Filament\Resources\ApplicationSettings\Pages\CreateApplicationSetting;
use App\Filament\Resources\ApplicationSettings\Pages\EditApplicationSetting;
use App\Filament\Resources\ApplicationSettings\Pages\ListApplicationSettings;
use App\Filament\Resources\ApplicationSettings\Schemas\ApplicationSettingForm;
use App\Filament\Resources\ApplicationSettings\Tables\ApplicationSettingsTable;
use App\Models\ApplicationSetting;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ApplicationSettingResource extends Resource
{
    protected static ?string $model = ApplicationSetting::class;
    protected static string|UnitEnum|null $navigationGroup = 'সেটিংস';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Cog8Tooth;

     

    public static function getModelLabel(): string
    {
        return 'আবেদন সেটিংস';
    }

    public static function getPluralModelLabel(): string
    {
        return 'আবেদন সেটিংস সমূহ';
    }

    public static function form(Schema $schema): Schema
    {
        return ApplicationSettingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ApplicationSettingsTable::configure($table);
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
            'index' => ListApplicationSettings::route('/'),
            'create' => CreateApplicationSetting::route('/create'),
            'edit' => EditApplicationSetting::route('/{record}/edit'),
        ];
    }
}
