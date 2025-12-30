<?php

namespace App\Filament\Resources\ChapelResource\Pages;

use App\Filament\Resources\ChapelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListChapels extends ListRecords
{
    protected static string $resource = ChapelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
