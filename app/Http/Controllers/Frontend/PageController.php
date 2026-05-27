<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Artesaos\SEOTools\Facades\SEOTools;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class PageController extends Controller
{
    public function show(string $slug)
    {
        $page   = Page::where('slug', $slug)->published()->firstOrFail();
        $locale = app()->getLocale();

        SEOTools::setTitle(
            ($page->getTranslation('meta_title', $locale) ?: $page->getTranslation('title', $locale))
            . ' | ' . config('app.name')
        );
        SEOTools::setDescription($page->getTranslation('meta_description', $locale));
        SEOTools::opengraph()->setUrl(request()->url());
        $this->setHreflang($page->slug);

        $template = $page->template ?: 'default';
        $view     = 'pages.templates.' . $template;

        if (!\Illuminate\Support\Facades\View::exists($view)) {
            $view = 'pages.templates.default';
        }

        return view($view, compact('page'));
    }

    private function setHreflang(string $slug): void
    {
        foreach (['ru', 'kk', 'en'] as $locale) {
            SEOTools::metatags()->addMeta(
                'alternate',
                LaravelLocalization::getLocalizedURL($locale, url("/{$slug}")),
                'rel'
            );
        }
    }
}
