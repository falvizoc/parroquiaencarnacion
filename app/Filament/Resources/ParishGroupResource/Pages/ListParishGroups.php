<?php

namespace App\Filament\Resources\ParishGroupResource\Pages;

use App\Filament\Resources\ParishGroupResource;
use App\Filament\Traits\PersistentTranslatable;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListParishGroups extends ListRecords
{
    use ListRecords\Concerns\Translatable;
    use PersistentTranslatable;

    protected static string $resource = ParishGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\CreateAction::make(),
        ];
    }
}
