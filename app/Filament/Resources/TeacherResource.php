<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeacherResource\Pages;
use App\Models\Teacher;
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

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;
    protected static ?string $label = 'Педагог';
    protected static ?string $pluralLabel = 'Педагоги';

    public static function getNavigationIcon(): string|\BackedEnum|null
    {
        return 'heroicon-o-academic-cap';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Контент';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Фото педагога')->schema([
                \Filament\Forms\Components\SpatieMediaLibraryFileUpload::make('photo')
                    ->collection('photo')
                    ->disk('public')
                    ->image()
                    ->imagePreviewHeight('220')
                    ->label('Фото (рекомендуется квадратное, мин. 400×400 px)'),
            ])->columnSpanFull(),

            Section::make('Основная информация')->schema([
                Tabs::make('Переводы')->tabs([
                    Tab::make('🇷🇺 Русский')->schema([
                        Forms\Components\TextInput::make('name.ru')
                            ->label('Имя и фамилия (рус)')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('position.ru')
                            ->label('Должность (рус)')
                            ->placeholder('Воспитатель, педагог-психолог...')
                            ->columnSpanFull(),
                    ]),
                    Tab::make('🇰🇿 Қазақша')->schema([
                        Forms\Components\TextInput::make('name.kk')
                            ->label('Аты-жөні (қаз)')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('position.kk')
                            ->label('Лауазымы (қаз)')
                            ->placeholder('Тәрбиеші, педагог-психолог...')
                            ->columnSpanFull(),
                    ]),
                    Tab::make('🇬🇧 English')->schema([
                        Forms\Components\TextInput::make('name.en')
                            ->label('Full name (eng)')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('position.en')
                            ->label('Position (eng)')
                            ->placeholder('Teacher, psychologist...')
                            ->columnSpanFull(),
                    ]),
                ])->columnSpanFull(),
                Forms\Components\TextInput::make('order')
                    ->label('Порядок отображения')
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->label('Показывать на сайте')
                    ->default(true),
            ])->columns(2)->columnSpanFull(),

            Section::make('Биография и данные')->schema([
                Tabs::make('Языки')->tabs([
                    Tab::make('🇷🇺 Русский')->schema([
                        Forms\Components\Textarea::make('bio.ru')
                            ->label('Биография')->rows(4)->columnSpanFull(),
                        Forms\Components\TextInput::make('education.ru')
                            ->label('Образование')
                            ->placeholder('КазНПУ им. Абая, дошкольное образование'),
                        Forms\Components\TextInput::make('experience.ru')
                            ->label('Опыт работы')
                            ->placeholder('8 лет педагогического стажа'),
                        Forms\Components\TextInput::make('subjects.ru')
                            ->label('Предметы / направления')
                            ->placeholder('Развитие речи, математика, ИЗО'),
                    ])->columns(2),
                    Tab::make('🇰🇿 Қазақша')->schema([
                        Forms\Components\Textarea::make('bio.kk')
                            ->label('Өмірбаян')->rows(4)->columnSpanFull(),
                        Forms\Components\TextInput::make('education.kk')
                            ->label('Білімі')
                            ->placeholder('Абай атындағы ҚазҰПУ'),
                        Forms\Components\TextInput::make('experience.kk')
                            ->label('Еңбек өтілі')
                            ->placeholder('8 жылдық педагогикалық өтіл'),
                        Forms\Components\TextInput::make('subjects.kk')
                            ->label('Бағыттар')
                            ->placeholder('Сөйлеу дамыту, математика'),
                    ])->columns(2),
                    Tab::make('🇬🇧 English')->schema([
                        Forms\Components\Textarea::make('bio.en')
                            ->label('Biography')->rows(4)->columnSpanFull(),
                        Forms\Components\TextInput::make('education.en')
                            ->label('Education')
                            ->placeholder('KazNPU, Early Childhood Education'),
                        Forms\Components\TextInput::make('experience.en')
                            ->label('Experience')
                            ->placeholder('8 years of teaching experience'),
                        Forms\Components\TextInput::make('subjects.en')
                            ->label('Subjects')
                            ->placeholder('Speech development, math, art'),
                    ])->columns(2),
                ]),
            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\SpatieMediaLibraryImageColumn::make('photo')
                    ->collection('photo')->label('Фото')->circular()->height(48),
                Tables\Columns\TextColumn::make('name')
                    ->label('Имя')
                    ->searchable()
                    ->weight('bold')
                    ->formatStateUsing(fn ($record) => $record->getTranslation('name', 'ru', false) ?: $record->getTranslation('name', 'kk', false) ?: '—'),
                Tables\Columns\TextColumn::make('position')
                    ->label('Должность')
                    ->color('gray')
                    ->formatStateUsing(fn ($record) => $record->getTranslation('position', 'ru', false) ?: $record->getTranslation('position', 'kk', false) ?: '—'),
                Tables\Columns\TextColumn::make('order')->label('Порядок')->sortable(),
                Tables\Columns\IconColumn::make('is_active')->label('На сайте')->boolean(),
            ])
            ->defaultSort('order')
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListTeachers::route('/'),
            'create' => Pages\CreateTeacher::route('/create'),
            'edit'   => Pages\EditTeacher::route('/{record}/edit'),
        ];
    }
}
