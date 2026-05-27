<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SiteSettings extends Page
{
    protected string $view = 'filament.pages.site-settings';

    public static function getNavigationIcon(): string|\BackedEnum|null
    {
        return 'heroicon-o-cog-6-tooth';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Система';
    }

    public static function getNavigationLabel(): string
    {
        return 'Настройки сайта';
    }

    public static function getNavigationSort(): ?int
    {
        return 99;
    }

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'site_name'        => Setting::get('site_name', ''),
            'site_tagline'     => Setting::get('site_tagline', ''),
            'contact_phone'    => Setting::get('contact_phone', ''),
            'contact_email'    => Setting::get('contact_email', ''),
            'contact_address'  => Setting::get('contact_address', ''),
            'work_hours'       => Setting::get('work_hours', ''),
            'social_instagram' => Setting::get('social_instagram', ''),
            'social_whatsapp'  => Setting::get('social_whatsapp', ''),
            'social_telegram'  => Setting::get('social_telegram', ''),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([

                Section::make('Информация о сайте')
                    ->description('Название и слоган — отображаются в шапке и футере сайта')
                    ->icon('heroicon-o-building-office-2')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('site_name')
                            ->label('Название сайта')
                            ->placeholder('DiDi Kindergarten')
                            ->maxLength(100),

                        Forms\Components\TextInput::make('site_tagline')
                            ->label('Слоган / подзаголовок')
                            ->placeholder('Место, где дети растут счастливыми')
                            ->maxLength(200),
                    ]),

                Section::make('Контактные данные')
                    ->description('Отображаются на странице «Контакты» и в футере сайта')
                    ->icon('heroicon-o-phone')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('contact_phone')
                            ->label('Телефон')
                            ->placeholder('+7 (701) 755 77 46')
                            ->prefixIcon('heroicon-o-phone'),

                        Forms\Components\TextInput::make('contact_email')
                            ->label('Email')
                            ->email()
                            ->placeholder('info@didikids.kz')
                            ->prefixIcon('heroicon-o-envelope'),

                        Forms\Components\TextInput::make('contact_address')
                            ->label('Адрес')
                            ->placeholder('г. Атырау, ул. Ветеран, 21')
                            ->prefixIcon('heroicon-o-map-pin')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('work_hours')
                            ->label('Часы работы')
                            ->placeholder('Пн–Пт: 07:30 – 18:00')
                            ->prefixIcon('heroicon-o-clock')
                            ->columnSpanFull(),
                    ]),

                Section::make('Социальные сети')
                    ->description('Оставьте пустым, если нет аккаунта')
                    ->icon('heroicon-o-share')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('social_instagram')
                            ->label('Instagram')
                            ->placeholder('https://instagram.com/didi_kids')
                            ->prefixIcon('heroicon-o-camera'),

                        Forms\Components\TextInput::make('social_whatsapp')
                            ->label('WhatsApp')
                            ->placeholder('+77017557746')
                            ->prefixIcon('heroicon-o-chat-bubble-left-ellipsis'),

                        Forms\Components\TextInput::make('social_telegram')
                            ->label('Telegram')
                            ->placeholder('@didi_kids')
                            ->prefixIcon('heroicon-o-paper-airplane'),
                    ]),

            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $groups = [
            'site_name'        => 'general',
            'site_tagline'     => 'general',
            'contact_phone'    => 'contact',
            'contact_email'    => 'contact',
            'contact_address'  => 'contact',
            'work_hours'       => 'contact',
            'social_instagram' => 'social',
            'social_whatsapp'  => 'social',
            'social_telegram'  => 'social',
        ];

        foreach ($data as $key => $value) {
            Setting::set($key, $value ?? '', $groups[$key] ?? 'general');
        }

        Notification::make()
            ->title('Настройки сохранены')
            ->success()
            ->send();
    }
}
