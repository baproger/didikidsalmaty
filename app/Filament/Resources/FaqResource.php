<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FaqResource\Pages;
use App\Models\Faq;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;
    protected static ?string $label = 'Вопрос';
    protected static ?string $pluralLabel = 'Часто задаваемые вопросы';

    public static function getNavigationIcon(): string|\BackedEnum|null
    {
        return 'heroicon-o-question-mark-circle';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Контент';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Вопрос и ответ')->schema([
                Forms\Components\TextInput::make('question.ru')->label('Вопрос (RU)')->required(),
                Forms\Components\TextInput::make('question.kk')->label('Сұрақ (KK)'),
                Forms\Components\TextInput::make('question.en')->label('Question (EN)'),
                Forms\Components\Textarea::make('answer.ru')->label('Ответ (RU)')->rows(4)->required(),
                Forms\Components\Textarea::make('answer.kk')->label('Жауап (KK)')->rows(4),
                Forms\Components\Textarea::make('answer.en')->label('Answer (EN)')->rows(4),
            ])->columns(3),

            Section::make('Настройки')->schema([
                Forms\Components\TextInput::make('order')->numeric()->default(0)->label('Порядок'),
                Forms\Components\Toggle::make('is_active')->label('Активен')->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('question')->label('Вопрос')->searchable()->limit(60),
                Tables\Columns\TextColumn::make('order')->label('Порядок')->sortable(),
                Tables\Columns\IconColumn::make('is_active')->label('Активен')->boolean(),
            ])
            ->defaultSort('order')
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListFaqs::route('/'),
            'create' => Pages\CreateFaq::route('/create'),
            'edit'   => Pages\EditFaq::route('/{record}/edit'),
        ];
    }
}
