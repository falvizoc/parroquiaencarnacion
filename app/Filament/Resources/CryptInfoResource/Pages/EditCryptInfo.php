<?php

namespace App\Filament\Resources\CryptInfoResource\Pages;

use App\Filament\Resources\CryptInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCryptInfo extends EditRecord
{
    protected static string $resource = CryptInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
