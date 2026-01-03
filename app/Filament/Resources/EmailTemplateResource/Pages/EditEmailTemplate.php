<?php

namespace App\Filament\Resources\EmailTemplateResource\Pages;

use App\Filament\Resources\EmailTemplateResource;
use App\Filament\Traits\PersistentTranslatable;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmailTemplate extends EditRecord
{
    use EditRecord\Concerns\Translatable;
    use PersistentTranslatable;

    protected static string $resource = EmailTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
