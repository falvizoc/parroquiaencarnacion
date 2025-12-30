<?php

namespace App\Filament\Resources\ChapelResource\Pages;

use App\Filament\Resources\ChapelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditChapel extends EditRecord
{
    protected static string $resource = ChapelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
