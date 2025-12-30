<?php

namespace App\Filament\Resources\CryptInfoResource\Pages;

use App\Filament\Resources\CryptInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCryptInfos extends ListRecords
{
    protected static string $resource = CryptInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
