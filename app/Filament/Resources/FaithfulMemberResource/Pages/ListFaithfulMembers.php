<?php

namespace App\Filament\Resources\FaithfulMemberResource\Pages;

use App\Filament\Resources\FaithfulMemberResource;
use App\Models\FaithfulMember;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Response;

class ListFaithfulMembers extends ListRecords
{
    protected static string $resource = FaithfulMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('exportar')
                ->label('Exportar')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->form([
                    \Filament\Forms\Components\Select::make('formato')
                        ->label('Formato')
                        ->options([
                            'csv' => 'CSV',
                            'excel' => 'Excel (CSV UTF-8)',
                        ])
                        ->default('csv')
                        ->required(),
                    \Filament\Forms\Components\Select::make('filtro')
                        ->label('Fieles a exportar')
                        ->options([
                            'todos' => 'Todos los fieles',
                            'activos' => 'Solo activos',
                            'verificados' => 'Solo verificados',
                            'newsletter' => 'Suscritos a newsletter',
                        ])
                        ->default('activos')
                        ->required(),
                    \Filament\Forms\Components\CheckboxList::make('campos')
                        ->label('Campos a incluir')
                        ->options([
                            'nombre_completo' => 'Nombre completo',
                            'email' => 'Email',
                            'telefono' => 'Teléfono',
                            'direccion' => 'Dirección',
                            'colonia' => 'Colonia',
                            'codigo_postal' => 'Código postal',
                            'fecha_nacimiento' => 'Fecha de nacimiento',
                            'genero' => 'Género',
                            'estado_civil' => 'Estado civil',
                            'capilla' => 'Capilla',
                            'fecha_registro' => 'Fecha de registro',
                        ])
                        ->default(['nombre_completo', 'email', 'telefono'])
                        ->columns(2),
                ])
                ->action(function (array $data) {
                    $query = FaithfulMember::query();

                    // Aplicar filtro
                    match ($data['filtro']) {
                        'activos' => $query->activo(),
                        'verificados' => $query->verificado(),
                        'newsletter' => $query->conNewsletter(),
                        default => null,
                    };

                    $fieles = $query->ordenado()->get();

                    // Generar CSV
                    $headers = [];
                    $campos = $data['campos'];

                    $mapeoHeaders = [
                        'nombre_completo' => 'Nombre',
                        'email' => 'Email',
                        'telefono' => 'Teléfono',
                        'direccion' => 'Dirección',
                        'colonia' => 'Colonia',
                        'codigo_postal' => 'Código Postal',
                        'fecha_nacimiento' => 'Fecha Nacimiento',
                        'genero' => 'Género',
                        'estado_civil' => 'Estado Civil',
                        'capilla' => 'Capilla',
                        'fecha_registro' => 'Fecha Registro',
                    ];

                    foreach ($campos as $campo) {
                        $headers[] = $mapeoHeaders[$campo] ?? $campo;
                    }

                    $output = fopen('php://temp', 'r+');

                    // BOM para Excel UTF-8
                    if ($data['formato'] === 'excel') {
                        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));
                    }

                    fputcsv($output, $headers);

                    foreach ($fieles as $fiel) {
                        $row = [];
                        foreach ($campos as $campo) {
                            $row[] = match ($campo) {
                                'nombre_completo' => $fiel->nombre_completo,
                                'email' => $fiel->email,
                                'telefono' => $fiel->telefono ?? '',
                                'direccion' => $fiel->direccion ?? '',
                                'colonia' => $fiel->colonia ?? '',
                                'codigo_postal' => $fiel->codigo_postal ?? '',
                                'fecha_nacimiento' => $fiel->fecha_nacimiento?->format('d/m/Y') ?? '',
                                'genero' => $fiel->nombre_genero,
                                'estado_civil' => $fiel->nombre_estado_civil,
                                'capilla' => $fiel->chapel?->nombre ?? 'Templo Principal',
                                'fecha_registro' => $fiel->created_at->format('d/m/Y'),
                                default => '',
                            };
                        }
                        fputcsv($output, $row);
                    }

                    rewind($output);
                    $csv = stream_get_contents($output);
                    fclose($output);

                    $filename = 'fieles_' . now()->format('Y-m-d_His') . '.csv';

                    return Response::streamDownload(
                        fn () => print($csv),
                        $filename,
                        [
                            'Content-Type' => 'text/csv; charset=UTF-8',
                        ]
                    );
                })
                ->modalHeading('Exportar Directorio de Fieles')
                ->modalSubmitActionLabel('Descargar'),

            Actions\CreateAction::make(),
        ];
    }
}
