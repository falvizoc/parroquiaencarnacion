<?php

namespace App\Filament\Resources\FaithfulMemberResource\Pages;

use App\Filament\Resources\FaithfulMemberResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFaithfulMember extends EditRecord
{
    protected static string $resource = FaithfulMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
