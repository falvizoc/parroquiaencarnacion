<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Models\News;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Contenido';

    protected static ?string $modelLabel = 'Noticia';

    protected static ?string $pluralModelLabel = 'Noticias';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Contenido')
                    ->schema([
                        Forms\Components\TextInput::make('titulo')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) =>
                                $set('slug', Str::slug($state))
                            ),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Forms\Components\Textarea::make('extracto')
                            ->label('Extracto')
                            ->rows(2)
                            ->maxLength(500)
                            ->helperText('Resumen breve para listados (máx. 500 caracteres)'),

                        Forms\Components\RichEditor::make('contenido')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('imagen')
                            ->image()
                            ->directory('noticias')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('1200')
                            ->imageResizeTargetHeight('675'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Publicación')
                    ->schema([
                        Forms\Components\DateTimePicker::make('fecha_publicacion')
                            ->label('Fecha de publicación')
                            ->native(false)
                            ->displayFormat('d/m/Y H:i')
                            ->default(now())
                            ->helperText('Dejar en blanco para publicar inmediatamente'),

                        Forms\Components\TextInput::make('autor')
                            ->maxLength(255)
                            ->placeholder('Nombre del autor'),

                        Forms\Components\Select::make('categoria')
                            ->options(News::CATEGORIAS)
                            ->required()
                            ->native(false)
                            ->default('parroquia'),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Configuración')
                    ->schema([
                        Forms\Components\Toggle::make('es_destacado')
                            ->label('Noticia destacada')
                            ->helperText('Las noticias destacadas aparecen en la página de inicio'),

                        Forms\Components\Toggle::make('activo')
                            ->label('Noticia activa')
                            ->default(true)
                            ->helperText('Las noticias inactivas no se muestran en el sitio público'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('imagen')
                    ->circular()
                    ->defaultImageUrl(fn () => 'https://ui-avatars.com/api/?name=N&background=6366f1&color=fff'),

                Tables\Columns\TextColumn::make('titulo')
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                Tables\Columns\TextColumn::make('fecha_publicacion')
                    ->label('Publicación')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('categoria')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => News::CATEGORIAS[$state] ?? $state)
                    ->color(fn (string $state): string => match ($state) {
                        'parroquia' => 'primary',
                        'diocesis' => 'success',
                        'papa' => 'warning',
                        'comunidad' => 'info',
                        default => 'gray',
                    }),

                Tables\Columns\IconColumn::make('es_destacado')
                    ->label('Destacado')
                    ->boolean()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('activo')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('activo')
                    ->label('Estado')
                    ->placeholder('Todos')
                    ->trueLabel('Activas')
                    ->falseLabel('Inactivas'),

                Tables\Filters\SelectFilter::make('categoria')
                    ->options(News::CATEGORIAS),

                Tables\Filters\TernaryFilter::make('es_destacado')
                    ->label('Destacada')
                    ->placeholder('Todas')
                    ->trueLabel('Destacadas')
                    ->falseLabel('No destacadas'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('fecha_publicacion', 'desc');
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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
