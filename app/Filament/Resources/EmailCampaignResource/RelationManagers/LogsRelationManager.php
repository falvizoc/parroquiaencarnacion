<?php

namespace App\Filament\Resources\EmailCampaignResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class LogsRelationManager extends RelationManager
{
    protected static string $relationship = 'logs';

    protected static ?string $title = 'Registro de Envíos';

    protected static ?string $recordTitleAttribute = 'email';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('email')
            ->columns([
                Tables\Columns\TextColumn::make('faithfulMember.nombre_completo')
                    ->label('Destinatario')
                    ->searchable(['nombre', 'apellidos']),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('nombre_estado')
                    ->label('Estado')
                    ->badge()
                    ->color(fn ($record) => $record->color_estado),

                Tables\Columns\TextColumn::make('error')
                    ->label('Error')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->error)
                    ->visible(fn ($livewire) => $livewire->ownerRecord->fallidos > 0),

                Tables\Columns\TextColumn::make('enviado_at')
                    ->label('Enviado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'enviado' => 'Enviado',
                        'fallido' => 'Fallido',
                        'rebotado' => 'Rebotado',
                    ]),
            ])
            ->headerActions([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('reintentar')
                    ->label('Reintentar')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->visible(fn ($record) => $record->estado === 'fallido')
                    ->action(function ($record) {
                        $record->update(['estado' => 'pendiente', 'error' => null]);
                        // Aquí se podría disparar un job para reintentar
                    }),
            ])
            ->bulkActions([
                //
            ]);
    }
}
