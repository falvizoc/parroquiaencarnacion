<?php

namespace App\Filament\Resources\EmailCampaignResource\Pages;

use App\Filament\Resources\EmailCampaignResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewEmailCampaign extends ViewRecord
{
    protected static string $resource = EmailCampaignResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->visible(fn () => $this->record->puedeEnviarse()),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Información de la Campaña')
                    ->schema([
                        Infolists\Components\TextEntry::make('nombre')
                            ->label('Nombre'),
                        Infolists\Components\TextEntry::make('nombre_tipo')
                            ->label('Tipo')
                            ->badge(),
                        Infolists\Components\TextEntry::make('nombre_estado')
                            ->label('Estado')
                            ->badge()
                            ->color(fn () => $this->record->color_estado),
                        Infolists\Components\TextEntry::make('creador.name')
                            ->label('Creado por'),
                    ])
                    ->columns(4),

                Infolists\Components\Section::make('Contenido')
                    ->schema([
                        Infolists\Components\TextEntry::make('asunto')
                            ->label('Asunto'),
                        Infolists\Components\TextEntry::make('contenido')
                            ->label('Contenido')
                            ->html()
                            ->columnSpanFull(),
                    ]),

                Infolists\Components\Section::make('Estadísticas')
                    ->schema([
                        Infolists\Components\TextEntry::make('total_destinatarios')
                            ->label('Total Destinatarios')
                            ->numeric(),
                        Infolists\Components\TextEntry::make('enviados')
                            ->label('Enviados')
                            ->numeric()
                            ->color('success'),
                        Infolists\Components\TextEntry::make('fallidos')
                            ->label('Fallidos')
                            ->numeric()
                            ->color('danger'),
                        Infolists\Components\TextEntry::make('porcentaje_enviado')
                            ->label('Progreso')
                            ->formatStateUsing(fn ($state) => $state . '%')
                            ->badge()
                            ->color(fn ($state) => $state >= 100 ? 'success' : ($state > 0 ? 'warning' : 'gray')),
                    ])
                    ->columns(4),

                Infolists\Components\Section::make('Fechas')
                    ->schema([
                        Infolists\Components\TextEntry::make('programada_para')
                            ->label('Programada para')
                            ->dateTime('d/m/Y H:i')
                            ->placeholder('No programada'),
                        Infolists\Components\TextEntry::make('enviada_at')
                            ->label('Enviada el')
                            ->dateTime('d/m/Y H:i')
                            ->placeholder('No enviada'),
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Creada el')
                            ->dateTime('d/m/Y H:i'),
                    ])
                    ->columns(3),
            ]);
    }
}
