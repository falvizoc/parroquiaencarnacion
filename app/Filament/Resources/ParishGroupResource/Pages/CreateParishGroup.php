<?php

namespace App\Filament\Resources\ParishGroupResource\Pages;

use App\Filament\Resources\ParishGroupResource;
use App\Filament\Traits\PersistentTranslatable;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateParishGroup extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;
    use PersistentTranslatable;

    protected static string $resource = ParishGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
}
