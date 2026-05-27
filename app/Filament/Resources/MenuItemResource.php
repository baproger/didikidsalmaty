<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuItemResource\Pages;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class MenuItemResource extends Resource
{
    protected static ?string $model = MenuItem::class;
    protected static ?string $label = 'Пункт меню';
    protected static ?string $pluralLabel = 'Меню (навигация)';

    public static function getNavigationIcon(): string|\BackedEnum|null
    {
        return 'heroicon-o-bars-3';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Настройки';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Название (перевод)')->schema([
                Forms\Components\TextInput::make('label.ru')->label('Название (RU)')->required(),
                Forms\Components\TextInput::make('label.kk')->label('Атауы (KK)'),
                Forms\Components\TextInput::make('label.en')->label('Label (EN)'),
            ])->columns(3),

            Section::make('Настройки')->schema([
                Forms\Components\Select::make('menu_id')
                    ->label('Меню')
                    ->options(fn () => Menu::all()->pluck('location', 'id'))
                    ->default(fn () => Menu::where('location', 'header')->first()?->id)
                    ->required(),

                Forms\Components\Select::make('parent_id')
                    ->label('Родительский пункт (подменю)')
                    ->placeholder('— Корневой уровень —')
                    ->options(fn () => MenuItem::whereNull('parent_id')->get()->mapWithKeys(fn ($i) => [$i->id => $i->label])),

                Forms\Components\Select::make('page_id')
                    ->label('Ссылка на страницу')
                    ->placeholder('— Или введите URL вручную —')
                    ->options(fn () => Page::published()->get()->mapWithKeys(fn ($p) => [$p->id => $p->title]))
                    ->searchable(),

                Forms\Components\TextInput::make('url')
                    ->label('URL вручную')
                    ->placeholder('/blog или https://...'),

                Forms\Components\Select::make('target')
                    ->label('Открывать')
                    ->options(['_self' => 'В этой же вкладке', '_blank' => 'В новой вкладке'])
                    ->default('_self'),

                Forms\Components\TextInput::make('order')
                    ->label('Порядок сортировки')
                    ->numeric()
                    ->default(0),

                Forms\Components\Toggle::make('is_active')
                    ->label('Показывать в меню')
                    ->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('label')
                    ->label('Название')
                    ->searchable()
                    ->description(fn ($record) => $record->parent ? '↳ ' . $record->parent->label : null),
                Tables\Columns\TextColumn::make('url')->label('URL')->limit(40),
                Tables\Columns\TextColumn::make('order')->label('Порядок')->sortable(),
                Tables\Columns\IconColumn::make('is_active')->label('Активен')->boolean(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListMenuItems::route('/'),
            'create' => Pages\CreateMenuItem::route('/create'),
            'edit'   => Pages\EditMenuItem::route('/{record}/edit'),
        ];
    }
}
