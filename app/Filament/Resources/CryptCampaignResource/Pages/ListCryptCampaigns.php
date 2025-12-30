<?php

namespace App\Filament\Resources\CryptCampaignResource\Pages;

use App\Filament\Resources\CryptCampaignResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCryptCampaigns extends ListRecords
{
    protected static string $resource = CryptCampaignResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
