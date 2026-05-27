<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryResource\Pages;
use App\Models\Gallery;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;
    protected static ?string $label = 'Галерея';
    protected static ?string $pluralLabel = 'Галереи';

    public static function getNavigationIcon(): string|\BackedEnum|null
    {
        return 'heroicon-o-photo';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Медиа';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Переводы')->schema([
                Forms\Components\TextInput::make('title.ru')->label('Название (RU)')->required(),
                Forms\Components\TextInput::make('title.kk')->label('Атауы (KK)'),
                Forms\Components\TextInput::make('title.en')->label('Title (EN)'),
                Forms\Components\Textarea::make('description.ru')->label('Описание (RU)')->rows(2),
                Forms\Components\Textarea::make('description.kk')->label('Сипаттама (KK)')->rows(2),
                Forms\Components\Textarea::make('description.en')->label('Description (EN)')->rows(2),
            ])->columns(3),

            Section::make('Настройки')->schema([
                Forms\Components\TextInput::make('slug')
                    ->required()->unique(ignoreRecord: true)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, \Filament\Schemas\Components\Utilities\Set $set) => $set('slug', Str::slug($state))),
                Forms\Components\Toggle::make('is_active')->label('Активна')->default(true),
            ])->columns(2),

            Section::make('Фотографии')->schema([
                \Filament\Forms\Components\SpatieMediaLibraryFileUpload::make('images')
                    ->collection('images')
                    ->disk('public')
                    ->multiple()
                    ->reorderable()
                    ->image()
                    ->maxFiles(50)
                    ->label('Загрузить фото'),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\SpatieMediaLibraryImageColumn::make('images')
                    ->collection('images')
                    ->label('Фото'),
                Tables\Columns\TextColumn::make('title')->label('Название')->searchable(),
                Tables\Columns\IconColumn::make('is_active')->label('Активна')->boolean(),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalleries::route('/'),
            'create' => Pages\CreateGallery::route('/create'),
            'edit' => Pages\EditGallery::route('/{record}/edit'),
        ];
    }
}
