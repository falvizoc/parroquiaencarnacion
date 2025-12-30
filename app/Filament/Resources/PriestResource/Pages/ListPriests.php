<?php

namespace App\Filament\Resources\PriestResource\Pages;

use App\Filament\Resources\PriestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPriests extends ListRecords
{
    protected static string $resource = PriestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
