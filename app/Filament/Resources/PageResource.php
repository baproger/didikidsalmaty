<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;
    protected static ?int $navigationSort = 1;
    protected static ?string $label = 'Страница';
    protected static ?string $pluralLabel = 'Страницы';

    public static function getNavigationIcon(): string|\BackedEnum|null
    {
        return 'heroicon-o-document-text';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Контент';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([

            // ─── Переводы заголовка/SEO (табы здесь безопасны — это НЕ Builder) ──
            Tabs::make('Переводы')
                ->tabs([
                    Tab::make('🇷🇺 Русский')->schema(static::langFields('ru')),
                    Tab::make('🇰🇿 Қазақша')->schema(static::langFields('kk')),
                    Tab::make('🇬🇧 English')->schema(static::langFields('en')),
                ])
                ->columnSpanFull(),

            // ─── Обложка ────────────────────────────────────────────────────────
            Section::make('Обложка страницы')->schema([
                \Filament\Forms\Components\SpatieMediaLibraryFileUpload::make('featured')
                    ->collection('featured')
                    ->disk('public')
                    ->image()
                    ->imagePreviewHeight('180')
                    ->label('Фото / баннер страницы'),
            ])->columnSpanFull(),

            // ─── Конструктор блоков ──────────────────────────────────────────────
            Section::make('Конструктор страницы')->schema([

                Builder::make('blocks')
                    ->label('')
                    ->addActionLabel('+ Добавить блок')
                    ->reorderable()
                    ->collapsible()
                    ->blocks([

                        // ── ТЕКСТ ──────────────────────────────────────────────
                        Block::make('text')
                            ->label('📝 Текстовый блок')
                            ->schema([
                                Forms\Components\Select::make('layout')
                                    ->label('Макет')
                                    ->options([
                                        '1col' => '1 колонка',
                                        '2col' => '2 колонки',
                                    ])
                                    ->default('1col')
                                    ->columnSpanFull(),
                                Forms\Components\Select::make('align')
                                    ->label('Выравнивание текста')
                                    ->options(['left' => 'По левому краю', 'center' => 'По центру'])
                                    ->default('left')
                                    ->columnSpanFull(),
                                // ── RU ──
                                Forms\Components\TextInput::make('title_ru')
                                    ->label('🇷🇺 Заголовок (RU)')
                                    ->columnSpanFull(),
                                Forms\Components\RichEditor::make('content_ru')
                                    ->label('🇷🇺 Текст (RU)')
                                    ->toolbarButtons(static::editorTools())
                                    ->columnSpanFull(),
                                // ── KK ──
                                Forms\Components\TextInput::make('title_kk')
                                    ->label('🇰🇿 Тақырып (KK)')
                                    ->columnSpanFull(),
                                Forms\Components\RichEditor::make('content_kk')
                                    ->label('🇰🇿 Мәтін (KK)')
                                    ->toolbarButtons(static::editorTools())
                                    ->columnSpanFull(),
                                // ── EN ──
                                Forms\Components\TextInput::make('title_en')
                                    ->label('🇬🇧 Title (EN)')
                                    ->columnSpanFull(),
                                Forms\Components\RichEditor::make('content_en')
                                    ->label('🇬🇧 Content (EN)')
                                    ->toolbarButtons(static::editorTools())
                                    ->columnSpanFull(),
                            ]),

                        // ── БАННЕР / HERO ──────────────────────────────────────
                        Block::make('hero')
                            ->label('🖼️ Баннер')
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->label('Изображение баннера')
                                    ->disk('public')->directory('blocks/hero')
                                    ->image()->imagePreviewHeight('150')
                                    ->columnSpanFull(),
                                Forms\Components\Select::make('style')
                                    ->label('Стиль фона')
                                    ->options(['green' => 'Зелёный градиент', 'dark' => 'Тёмный', 'light' => 'Светлый'])
                                    ->default('green'),
                                // ── RU ──
                                Forms\Components\TextInput::make('title_ru')->label('🇷🇺 Заголовок (RU)'),
                                Forms\Components\Textarea::make('subtitle_ru')->label('🇷🇺 Подзаголовок (RU)')->rows(2),
                                Forms\Components\TextInput::make('btn_text_ru')->label('🇷🇺 Текст кнопки (RU)'),
                                Forms\Components\TextInput::make('btn_url_ru')->label('🇷🇺 Ссылка кнопки (RU)')->placeholder('/ru/blog/...'),
                                // ── KK ──
                                Forms\Components\TextInput::make('title_kk')->label('🇰🇿 Тақырып (KK)'),
                                Forms\Components\Textarea::make('subtitle_kk')->label('🇰🇿 Астарлы жазу (KK)')->rows(2),
                                Forms\Components\TextInput::make('btn_text_kk')->label('🇰🇿 Батырма мәтіні (KK)'),
                                Forms\Components\TextInput::make('btn_url_kk')->label('🇰🇿 Батырма сілтемесі (KK)')->placeholder('/kk/blog/...'),
                                // ── EN ──
                                Forms\Components\TextInput::make('title_en')->label('🇬🇧 Title (EN)'),
                                Forms\Components\Textarea::make('subtitle_en')->label('🇬🇧 Subtitle (EN)')->rows(2),
                                Forms\Components\TextInput::make('btn_text_en')->label('🇬🇧 Button text (EN)'),
                                Forms\Components\TextInput::make('btn_url_en')->label('🇬🇧 Button link (EN)')->placeholder('/en/blog/...'),
                            ])->columns(3),

                        // ── КОЛОНКИ ────────────────────────────────────────────
                        Block::make('columns')
                            ->label('⬜ Колонки (2 или 3)')
                            ->schema([
                                Forms\Components\Select::make('cols')
                                    ->label('Количество колонок')
                                    ->options(['2' => '2 колонки', '3' => '3 колонки'])
                                    ->default('2')
                                    ->columnSpanFull(),
                                Forms\Components\Repeater::make('items')
                                    ->label('Блоки колонок')
                                    ->schema([
                                        Forms\Components\FileUpload::make('image')
                                            ->label('Фото')
                                            ->disk('public')->directory('blocks/columns')
                                            ->image()->imagePreviewHeight('100')
                                            ->columnSpanFull(),
                                        Forms\Components\TextInput::make('btn_url')
                                            ->label('Ссылка кнопки')
                                            ->columnSpanFull(),
                                        // ── RU ──
                                        Forms\Components\TextInput::make('title_ru')->label('🇷🇺 Заголовок'),
                                        Forms\Components\Textarea::make('text_ru')->label('🇷🇺 Текст')->rows(3),
                                        Forms\Components\TextInput::make('btn_text_ru')->label('🇷🇺 Кнопка'),
                                        // ── KK ──
                                        Forms\Components\TextInput::make('title_kk')->label('🇰🇿 Тақырып'),
                                        Forms\Components\Textarea::make('text_kk')->label('🇰🇿 Мәтін')->rows(3),
                                        Forms\Components\TextInput::make('btn_text_kk')->label('🇰🇿 Батырма'),
                                        // ── EN ──
                                        Forms\Components\TextInput::make('title_en')->label('🇬🇧 Title'),
                                        Forms\Components\Textarea::make('text_en')->label('🇬🇧 Text')->rows(3),
                                        Forms\Components\TextInput::make('btn_text_en')->label('🇬🇧 Button'),
                                    ])
                                    ->columns(3)
                                    ->minItems(2)->maxItems(3)
                                    ->reorderable()
                                    ->columnSpanFull(),
                            ]),

                        // ── ГАЛЕРЕЯ ────────────────────────────────────────────
                        Block::make('gallery')
                            ->label('🖼️ Галерея фотографий')
                            ->schema([
                                Forms\Components\TextInput::make('title_ru')->label('🇷🇺 Заголовок (RU)'),
                                Forms\Components\TextInput::make('title_kk')->label('🇰🇿 Тақырып (KK)'),
                                Forms\Components\TextInput::make('title_en')->label('🇬🇧 Title (EN)'),
                                Forms\Components\FileUpload::make('images')
                                    ->label('Фотографии')
                                    ->disk('public')->directory('blocks/gallery')
                                    ->image()->multiple()->reorderable()
                                    ->imagePreviewHeight('100')
                                    ->columnSpanFull(),
                            ])->columns(3),

                        // ── ДОКУМЕНТЫ ─────────────────────────────────────────
                        Block::make('documents')
                            ->label('📄 Документы / PDF')
                            ->schema([
                                Forms\Components\TextInput::make('title_ru')->label('🇷🇺 Заголовок раздела (RU)'),
                                Forms\Components\TextInput::make('title_kk')->label('🇰🇿 Тақырып (KK)'),
                                Forms\Components\TextInput::make('title_en')->label('🇬🇧 Section title (EN)'),
                                Forms\Components\Repeater::make('files')
                                    ->label('Файлы')
                                    ->schema([
                                        Forms\Components\FileUpload::make('file')
                                            ->label('Файл (PDF / Word / Excel)')
                                            ->disk('public')->directory('blocks/docs')
                                            ->acceptedFileTypes([
                                                'application/pdf',
                                                'application/msword',
                                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                                'application/vnd.ms-excel',
                                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                            ])
                                            ->maxSize(20480)
                                            ->columnSpanFull(),
                                        Forms\Components\TextInput::make('name_ru')->label('🇷🇺 Название файла'),
                                        Forms\Components\TextInput::make('name_kk')->label('🇰🇿 Файл атауы'),
                                        Forms\Components\TextInput::make('name_en')->label('🇬🇧 File name'),
                                    ])
                                    ->columns(3)
                                    ->reorderable()
                                    ->columnSpanFull(),
                            ])->columns(3),

                        // ── CTA ───────────────────────────────────────────────
                        Block::make('cta')
                            ->label('🚀 Призыв к действию (CTA)')
                            ->schema([
                                Forms\Components\Select::make('style')
                                    ->label('Стиль')
                                    ->options(['gradient' => 'Градиент', 'green' => 'Зелёный', 'dark' => 'Тёмный'])
                                    ->default('gradient'),
                                Forms\Components\TextInput::make('btn_url')->label('Ссылка 1-й кнопки'),
                                Forms\Components\TextInput::make('btn2_url')->label('Ссылка 2-й кнопки'),
                                // ── RU ──
                                Forms\Components\TextInput::make('title_ru')->label('🇷🇺 Заголовок (RU)'),
                                Forms\Components\Textarea::make('subtitle_ru')->label('🇷🇺 Подзаголовок (RU)')->rows(2),
                                Forms\Components\TextInput::make('btn_text_ru')->label('🇷🇺 Кнопка 1'),
                                Forms\Components\TextInput::make('btn2_text_ru')->label('🇷🇺 Кнопка 2'),
                                // ── KK ──
                                Forms\Components\TextInput::make('title_kk')->label('🇰🇿 Тақырып (KK)'),
                                Forms\Components\Textarea::make('subtitle_kk')->label('🇰🇿 Астарлы жазу (KK)')->rows(2),
                                Forms\Components\TextInput::make('btn_text_kk')->label('🇰🇿 Батырма 1'),
                                Forms\Components\TextInput::make('btn2_text_kk')->label('🇰🇿 Батырма 2'),
                                // ── EN ──
                                Forms\Components\TextInput::make('title_en')->label('🇬🇧 Title (EN)'),
                                Forms\Components\Textarea::make('subtitle_en')->label('🇬🇧 Subtitle (EN)')->rows(2),
                                Forms\Components\TextInput::make('btn_text_en')->label('🇬🇧 Button 1'),
                                Forms\Components\TextInput::make('btn2_text_en')->label('🇬🇧 Button 2'),
                            ])->columns(4),

                    ])
                    ->columnSpanFull(),

            ])->columnSpanFull(),

            // ─── Шаблон ──────────────────────────────────────────────────────
            Section::make('Шаблон страницы')->schema([
                Forms\Components\Radio::make('template')
                    ->label('')
                    ->options([
                        'default'  => '🏠 Default — градиентная шапка + блоки конструктора',
                        'centered' => '📰 Centered — узкая колонка, журнальный стиль',
                        'hero'     => '🖼️  Hero — полноэкранная фото-шапка',
                        'sidebar'  => '📋 Sidebar — контент + боковое оглавление',
                        'landing'  => '🚀 Landing — маркетинговая посадочная страница',
                    ])
                    ->default('default')
                    ->required()
                    ->columnSpanFull(),
            ])->columnSpanFull(),

            // ─── Настройки ───────────────────────────────────────────────────
            Section::make('Настройки страницы')->schema([
                Forms\Components\TextInput::make('slug')
                    ->label('URL (slug)')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->placeholder('o-nas')
                    ->helperText('Только латинские буквы, цифры и дефис'),
                Forms\Components\Select::make('status')
                    ->label('Статус')
                    ->options(['draft' => 'Черновик', 'published' => 'Опубликована', 'scheduled' => 'Запланирована'])
                    ->default('published')
                    ->required(),
                Forms\Components\DateTimePicker::make('published_at')
                    ->label('Дата публикации')
                    ->default(now()),
                Forms\Components\TextInput::make('order')
                    ->label('Порядок в меню')
                    ->numeric()->default(99),
            ])->columns(2),

            // ─── Меню ────────────────────────────────────────────────────────
            Section::make('Меню')->schema([
                Forms\Components\Toggle::make('show_in_menu')
                    ->label('Показывать в меню')
                    ->helperText('Страница автоматически появится в навигации')
                    ->default(false)
                    ->live(),
                Forms\Components\Select::make('parent_id')
                    ->label('Родительский пункт (подменю)')
                    ->options(fn () => Page::whereNull('parent_id')
                        ->whereNot('id', request()->route('record') ?? 0)
                        ->get()
                        ->mapWithKeys(fn ($p) => [
                            $p->id => (is_array($p->title) ? ($p->title['ru'] ?? '') : $p->title) . ' (/' . $p->slug . ')',
                        ])
                        ->toArray()
                    )
                    ->placeholder('— Верхний уровень —')
                    ->searchable()
                    ->nullable()
                    ->visible(fn (Get $get) => (bool) $get('show_in_menu')),
            ])->columns(2),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Название')
                    ->getStateUsing(fn ($record) => $record && is_array($record->title)
                        ? ($record->title['ru'] ?? array_values($record->title)[0] ?? '—')
                        : ($record?->title ?? '—'))
                    ->searchable(query: fn ($query, $search) => $query->whereRaw("JSON_EXTRACT(title, '$.ru') LIKE ?", ["%{$search}%"]))
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')->label('URL')->copyable(),
                Tables\Columns\IconColumn::make('show_in_menu')->label('В меню')->boolean(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'draft'     => 'warning',
                        'published' => 'success',
                        'scheduled' => 'primary',
                        default     => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'draft'     => 'Черновик',
                        'published' => 'Опубликована',
                        'scheduled' => 'Запланирована',
                        default     => $state,
                    }),
                Tables\Columns\TextColumn::make('template')
                    ->label('Шаблон')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'hero'     => 'info',
                        'centered' => 'warning',
                        'sidebar'  => 'gray',
                        'landing'  => 'success',
                        default    => 'primary',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'default'  => 'Default',
                        'centered' => 'Centered',
                        'hero'     => 'Hero',
                        'sidebar'  => 'Sidebar',
                        'landing'  => 'Landing',
                        default    => $state ?: 'Default',
                    }),
                Tables\Columns\TextColumn::make('order')->label('Порядок')->sortable(),
            ])
            ->defaultSort('order')
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit'   => Pages\EditPage::route('/{record}/edit'),
        ];
    }

    private static function langFields(string $locale): array
    {
        return [
            Forms\Components\TextInput::make("title.{$locale}")
                ->label('Название страницы')
                ->required($locale === 'ru')
                ->live(onBlur: true)
                ->afterStateUpdated(function (string $context, $state, Set $set) use ($locale) {
                    if ($context === 'create' && $locale === 'ru') {
                        $set('slug', Str::slug($state));
                    }
                }),
            Forms\Components\Textarea::make("excerpt.{$locale}")
                ->label('Краткое описание (SEO)')
                ->rows(2),
            Forms\Components\TextInput::make("meta_title.{$locale}")->label('Meta Title'),
            Forms\Components\Textarea::make("meta_description.{$locale}")->label('Meta Description')->rows(2),
        ];
    }

    private static function editorTools(): array
    {
        return ['bold', 'italic', 'underline', 'strike', 'link', 'bulletList', 'orderedList', 'h2', 'h3', 'blockquote'];
    }
}
