<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Category;
use App\Models\Post;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?int $navigationSort = 2;
    protected static ?string $label = 'Новость';
    protected static ?string $pluralLabel = 'Новости';

    public static function getNavigationIcon(): string|\BackedEnum|null
    {
        return 'heroicon-o-newspaper';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Контент';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Translations')
                ->tabs([
                    Tab::make('🇷🇺 Русский')->schema(static::translationFields('ru')),
                    Tab::make('🇰🇿 Қазақша')->schema(static::translationFields('kk')),
                    Tab::make('🇬🇧 English')->schema(static::translationFields('en')),
                ])
                ->columnSpanFull(),

            Section::make('Настройки')->schema([
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, \Filament\Schemas\Components\Utilities\Set $set) => $set('slug', Str::slug($state))),

                Forms\Components\Select::make('category_id')
                    ->label('Категория')
                    ->options(fn () => Category::all()->pluck('name', 'id'))
                    ->searchable(),

                Forms\Components\Select::make('status')
                    ->options(['draft' => 'Черновик', 'published' => 'Опубликовано', 'scheduled' => 'Запланировано'])
                    ->default('draft')->required(),

                Forms\Components\DateTimePicker::make('published_at')->label('Дата публикации'),
            ]),

            Section::make('Обложка')->schema([
                \Filament\Forms\Components\SpatieMediaLibraryFileUpload::make('featured')
                    ->collection('featured')
                    ->disk('public')
                    ->image()
                    ->imagePreviewHeight('200')
                    ->label('Фото для обложки (отображается в списке новостей и на странице новости)'),
            ]),
        ]);
    }

    protected static function translationFields(string $locale): array
    {
        return [
            Forms\Components\TextInput::make("title.{$locale}")->label('Заголовок')->required($locale === 'ru'),
            Forms\Components\RichEditor::make("content.{$locale}")->label('Контент')->columnSpanFull(),
            Forms\Components\Textarea::make("excerpt.{$locale}")->label('Краткое описание')->rows(3),
            Forms\Components\TextInput::make("meta_title.{$locale}")->label('Meta Title'),
            Forms\Components\Textarea::make("meta_description.{$locale}")->label('Meta Description')->rows(2),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\SpatieMediaLibraryImageColumn::make('featured')
                    ->collection('featured')
                    ->label('Фото'),
                Tables\Columns\TextColumn::make('title')->label('Заголовок')->searchable()->limit(50),
                Tables\Columns\TextColumn::make('category.name')->label('Категория'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'warning',
                        'published' => 'success',
                        'scheduled' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('published_at')->label('Дата')->dateTime('d.m.Y')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(['draft' => 'Черновик', 'published' => 'Опубликовано']),
                Tables\Filters\SelectFilter::make('category_id')->label('Категория')
                    ->options(fn () => Category::all()->pluck('name', 'id')),
            ])
            ->defaultSort('published_at', 'desc')
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
