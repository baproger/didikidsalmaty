<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;
    protected static ?string $label = 'Настройка';
    protected static ?string $pluralLabel = 'Настройки';

    public static function getNavigationIcon(): string|\BackedEnum|null
    {
        return 'heroicon-o-cog-6-tooth';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Система';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\TextInput::make('key')->required()->unique(ignoreRecord: true)->label('Ключ'),
            Forms\Components\Select::make('group')
                ->options(['general' => 'Общие', 'contact' => 'Контакты', 'social' => 'Соцсети', 'seo' => 'SEO'])
                ->default('general')->label('Группа'),
            Forms\Components\Textarea::make('value')->label('Значение')->rows(3)->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')->label('Ключ')->searchable(),
                Tables\Columns\TextColumn::make('group')->label('Группа'),
                Tables\Columns\TextColumn::make('updated_at')->label('Обновлено')->dateTime('d.m.Y H:i'),
            ])
            ->filters([Tables\Filters\SelectFilter::make('group')
                ->options(['general' => 'Общие', 'contact' => 'Контакты', 'social' => 'Соцсети', 'seo' => 'SEO'])])
            ->recordActions([EditAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
