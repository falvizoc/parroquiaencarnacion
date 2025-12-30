<?php

namespace App\Filament\Resources\CryptCampaignResource\Pages;

use App\Filament\Resources\CryptCampaignResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCryptCampaign extends EditRecord
{
    protected static string $resource = CryptCampaignResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
