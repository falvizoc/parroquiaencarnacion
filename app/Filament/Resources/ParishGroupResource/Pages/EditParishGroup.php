<?php

namespace App\Filament\Resources\ParishGroupResource\Pages;

use App\Filament\Resources\ParishGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditParishGroup extends EditRecord
{
    protected static string $resource = ParishGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
