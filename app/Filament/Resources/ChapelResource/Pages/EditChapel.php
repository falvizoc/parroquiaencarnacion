<?php

namespace App\Filament\Resources\ChapelResource\Pages;

use App\Filament\Resources\ChapelResource;
use App\Filament\Traits\PersistentTranslatable;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditChapel extends EditRecord
{
    use EditRecord\Concerns\Translatable;
    use PersistentTranslatable;

    protected static string $resource = ChapelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
