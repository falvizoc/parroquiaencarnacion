<?php

namespace App\Filament\Resources\ChapelResource\Pages;

use App\Filament\Resources\ChapelResource;
use App\Filament\Traits\PersistentTranslatable;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateChapel extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;
    use PersistentTranslatable;

    protected static string $resource = ChapelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
}
