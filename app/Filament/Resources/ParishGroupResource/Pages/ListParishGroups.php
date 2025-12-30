<?php

namespace App\Filament\Resources\ParishGroupResource\Pages;

use App\Filament\Resources\ParishGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListParishGroups extends ListRecords
{
    protected static string $resource = ParishGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
