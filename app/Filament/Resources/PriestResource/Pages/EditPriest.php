<?php

namespace App\Filament\Resources\PriestResource\Pages;

use App\Filament\Resources\PriestResource;
use App\Filament\Traits\PersistentTranslatable;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPriest extends EditRecord
{
    use EditRecord\Concerns\Translatable;
    use PersistentTranslatable;

    protected static string $resource = PriestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
