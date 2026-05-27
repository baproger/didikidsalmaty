<?php

namespace App\Filament\Widgets;

use App\Models\Application;
use App\Models\Gallery;
use App\Models\Page;
use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $newApplications = Application::where('status', 'new')->count();

        return [
            Stat::make('Заявки', Application::count())
                ->description($newApplications ? "Новых: {$newApplications}" : 'Нет новых заявок')
                ->descriptionIcon('heroicon-m-inbox-stack')
                ->color($newApplications ? 'danger' : 'success'),

            Stat::make('Страницы', Page::count())
                ->description('Всего страниц')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success'),

            Stat::make('Новости', Post::count())
                ->description('Всего новостей')
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('info'),

            Stat::make('Фотогалереи', Gallery::count())
                ->description('Всего галерей')
                ->descriptionIcon('heroicon-m-photo')
                ->color('warning'),
        ];
    }
}
