<?php

namespace App\Filament\Resources\PriestResource\Pages;

use App\Filament\Resources\PriestResource;
use App\Filament\Traits\PersistentTranslatable;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePriest extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;
    use PersistentTranslatable;

    protected static string $resource = PriestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
}
