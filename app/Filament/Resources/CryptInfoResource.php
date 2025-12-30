<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CryptInfoResource\Pages;
use App\Models\CryptInfo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CryptInfoResource extends Resource
{
    protected static ?string $model = CryptInfo::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    protected static ?string $navigationGroup = 'Servicios';

    protected static ?string $navigationLabel = 'Criptas';

    protected static ?string $modelLabel = 'Información de Criptas';

    protected static ?string $pluralModelLabel = 'Criptas';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información Principal')
                    ->schema([
                        Forms\Components\TextInput::make('titulo')
                            ->label('Título')
                            ->required()
                            ->maxLength(255)
                            ->default('Zona de Criptas'),

                        Forms\Components\TextInput::make('subtitulo')
                            ->label('Subtítulo')
                            ->maxLength(255)
                            ->placeholder('Ej: Un lugar de paz y recuerdo'),

                        Forms\Components\RichEditor::make('descripcion')
                            ->label('Descripción Completa')
                            ->required()
                            ->toolbarButtons([
                                'bold', 'italic', 'underline', 'link',
                                'orderedList', 'bulletList', 'h3',
                            ])
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('descripcion_corta')
                            ->label('Descripción Corta (para inicio)')
                            ->rows(3)
                            ->maxLength(300)
                            ->helperText('Máximo 300 caracteres. Se muestra en la página de inicio.')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Imagen')
                    ->schema([
                        Forms\Components\FileUpload::make('imagen')
                            ->label('Imagen de la zona de criptas')
                            ->image()
                            ->directory('criptas')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('1200')
                            ->imageResizeTargetHeight('675'),
                    ]),

                Forms\Components\Section::make('Información de Contacto')
                    ->schema([
                        Forms\Components\TextInput::make('telefono_contacto')
                            ->label('Teléfono de Contacto')
                            ->tel()
                            ->maxLength(20),

                        Forms\Components\TextInput::make('email_contacto')
                            ->label('Email de Contacto')
                            ->email()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('horario_atencion')
                            ->label('Horario de Atención')
                            ->maxLength(100)
                            ->placeholder('Ej: Lunes a Viernes 9:00 - 17:00'),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Visibilidad')
                    ->schema([
                        Forms\Components\Toggle::make('mostrar_en_inicio')
                            ->label('Mostrar en página de inicio')
                            ->default(true)
                            ->helperText('Si está activo, aparecerá una sección en la página de inicio'),

                        Forms\Components\Toggle::make('activo')
                            ->label('Activo')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('imagen')
                    ->label('Imagen')
                    ->circular(false)
                    ->width(80)
                    ->height(45),

                Tables\Columns\TextColumn::make('titulo')
                    ->label('Título')
                    ->searchable(),

                Tables\Columns\TextColumn::make('telefono_contacto')
                    ->label('Teléfono')
                    ->searchable(),

                Tables\Columns\IconColumn::make('mostrar_en_inicio')
                    ->label('En Inicio')
                    ->boolean(),

                Tables\Columns\IconColumn::make('activo')
                    ->label('Activo')
                    ->boolean(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCryptInfos::route('/'),
            'create' => Pages\CreateCryptInfo::route('/create'),
            'edit' => Pages\EditCryptInfo::route('/{record}/edit'),
        ];
    }
}
