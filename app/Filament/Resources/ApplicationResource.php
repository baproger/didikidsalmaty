<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApplicationResource\Pages;
use App\Models\Application;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ApplicationResource extends Resource
{
    protected static ?string $model = Application::class;

    protected static ?int $navigationSort = 0;

    protected static ?string $label = 'Заявка';

    protected static ?string $pluralLabel = 'Заявки';

    public static function getNavigationIcon(): string|\BackedEnum|null
    {
        return 'heroicon-o-inbox-stack';
    }

    public static function getNavigationBadge(): ?string
    {
        $count = Application::where('status', 'new')->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): array|string|null
    {
        return 'danger';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Данные заявки')->schema([
                Forms\Components\TextInput::make('name')->label('Имя')->disabled(),
                Forms\Components\TextInput::make('email')->label('Email')->disabled(),
                Forms\Components\TextInput::make('phone')->label('Телефон')->disabled(),
                Forms\Components\TextInput::make('child_age')->label('Возраст ребёнка')->disabled(),
                Forms\Components\Textarea::make('message')->label('Сообщение')->disabled()->rows(5)->columnSpanFull(),
            ]),
            Section::make('Статус')->schema([
                Forms\Components\Select::make('status')
                    ->label('Статус')
                    ->options([
                        'new'       => 'Новая',
                        'read'      => 'Прочитана',
                        'processed' => 'Обработана',
                    ])
                    ->required(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('#')->sortable(),
                Tables\Columns\TextColumn::make('name')->label('Имя')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->label('Email')->searchable(),
                Tables\Columns\TextColumn::make('phone')->label('Телефон')->default('—'),
                Tables\Columns\TextColumn::make('child_age')->label('Возраст')->default('—'),
                Tables\Columns\TextColumn::make('message')->label('Сообщение')->limit(50),
                Tables\Columns\TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->color(fn (string $state): string => Application::statusColor($state))
                    ->formatStateUsing(fn (string $state): string => Application::statusLabel($state)),
                Tables\Columns\TextColumn::make('created_at')->label('Дата')->dateTime('d.m.Y H:i')->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Статус')
                    ->options([
                        'new'       => 'Новые',
                        'read'      => 'Прочитанные',
                        'processed' => 'Обработанные',
                    ]),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApplications::route('/'),
            'edit'  => Pages\EditApplication::route('/{record}/edit'),
        ];
    }
}
