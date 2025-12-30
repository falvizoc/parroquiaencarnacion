<?php

namespace App\Filament\Resources\PriestResource\Pages;

use App\Filament\Resources\PriestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPriest extends EditRecord
{
    protected static string $resource = PriestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
