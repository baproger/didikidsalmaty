<?php

namespace App\Observers;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;

class PageObserver
{
    public function saved(Page $page): void
    {
        $menu = Menu::where('location', 'header')->first();
        if (! $menu) {
            return;
        }

        if ($page->show_in_menu) {
            // Если страница вложена — найти родительский пункт меню
            $parentMenuItemId = null;
            if ($page->parent_id) {
                $parentMenuItemId = MenuItem::where('page_id', $page->parent_id)->value('id');
            }

            MenuItem::updateOrCreate(
                ['page_id' => $page->id],
                [
                    'menu_id'   => $menu->id,
                    'parent_id' => $parentMenuItemId,
                    'url'       => '/' . $page->slug,
                    'target'    => '_self',
                    'order'     => $page->order ?? 99,
                    'is_active' => $page->status === 'published',
                    'label'     => $page->getTranslations('title'),
                ]
            );
        } else {
            MenuItem::where('page_id', $page->id)->delete();
        }
    }

    public function deleted(Page $page): void
    {
        MenuItem::where('page_id', $page->id)->delete();
    }
}
