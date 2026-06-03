<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Teacher;
use Artesaos\SEOTools\Facades\SEOTools;

class HomeController extends Controller
{
    public function index()
    {
        $siteName    = Setting::get('site_name', 'Didi Kindergarten');
        $siteTagline = Setting::get('site_tagline', 'Место, где дети растут счастливыми');

        SEOTools::setTitle($siteName);
        SEOTools::setDescription($siteTagline);
        SEOTools::opengraph()->setUrl(request()->url());
        SEOTools::opengraph()->addProperty('type', 'website');
        SEOTools::jsonLd()->setType('Organization');

        $latestPosts = Post::published()
            ->with('category')
            ->latest('published_at')
            ->limit(3)
            ->get();

        $teachers = Teacher::where('is_active', true)
            ->orderBy('order')
            ->get();

        $faqs = Faq::active()->orderBy('order')->get();

        $heroTitle    = $this->localized('hero_title',    ['ru' => 'Место, где дети растут счастливыми', 'kk' => 'Балалар бақытты өсетін орын', 'en' => 'Where children grow up happy']);
        $heroSubtitle = $this->localized('hero_subtitle', ['ru' => 'Современный детский сад с индивидуальным подходом, творческими занятиями и любящими воспитателями.', 'kk' => 'Жеке тәсілмен заманауи балабақша.', 'en' => 'A modern kindergarten with individual approach and caring teachers.']);
        $heroCta      = $this->localized('hero_cta',     ['ru' => 'Записаться', 'kk' => 'Жазылу', 'en' => 'Enroll now']);
        $aboutTitle   = $this->localized('about_title',  ['ru' => 'Мы ждём ваших детей в Didi!', 'kk' => 'Біз балаларыңызды DiDi-де күтеміз!', 'en' => 'We welcome your children at Didi!']);
        $aboutText    = $this->localized('about_text',   ['ru' => 'Наш детский сад — это уютная среда, где каждый ребёнок чувствует себя любимым и важным.', 'kk' => 'Балабақша — ыңғайлы орта.', 'en' => 'Our kindergarten is a cozy environment where every child feels loved.']);

        $ageGroupsRu = Setting::get('age_groups_ru', [
            ['name' => 'Балапан', 'age' => '2+', 'emoji' => '🐣', 'bg' => '#FFF3E8'],
            ['name' => 'Лучики',  'age' => '3+', 'emoji' => '☀️', 'bg' => '#FFF8E1'],
            ['name' => 'Улыбка',  'age' => '4+', 'emoji' => '😊', 'bg' => '#FCE4EC'],
            ['name' => 'Умники',  'age' => '5+', 'emoji' => '🦁', 'bg' => '#EDE7F6'],
            ['name' => 'Эрудиты', 'age' => '6+', 'emoji' => '🎓', 'bg' => '#E3F2FD'],
        ]);

        $ageGroupsKk = Setting::get('age_groups_kk', [
            ['name' => 'Күлыншақ', 'age' => '2+', 'emoji' => '🌺', 'bg' => '#FCE4EC'],
            ['name' => 'Балдырған', 'age' => '3+', 'emoji' => '🌿', 'bg' => '#E8F5E9'],
            ['name' => 'Бәйтерек', 'age' => '4+', 'emoji' => '🌳', 'bg' => '#E0F2F1'],
            ['name' => 'Балдәурен', 'age' => '5+', 'emoji' => '🌸', 'bg' => '#FCE4EC'],
            ['name' => 'Болашақ',  'age' => '6+', 'emoji' => '⭐', 'bg' => '#FFF8E1'],
        ]);

        $defaultIcons = ['🎓', '💚', '🏠', '🛡️', '🍎', '❤️'];
        $priorities = Setting::get('priorities', [
            ['icon' => '🎓', 'title_ru' => 'Образование', 'title_kk' => 'Білім',        'desc_ru' => 'Индивидуальный подход и развивающие программы.'],
            ['icon' => '💚', 'title_ru' => 'Здоровье',    'title_kk' => 'Денсаулық',    'desc_ru' => 'Гимнастика, свежий воздух, медицинское наблюдение.'],
            ['icon' => '🏠', 'title_ru' => 'Комфорт',     'title_kk' => 'Жайлылық',     'desc_ru' => 'Уютные классы и пространство для игр.'],
            ['icon' => '🛡️', 'title_ru' => 'Безопасность','title_kk' => 'Қауіпсіздік', 'desc_ru' => 'Видеонаблюдение и контроль доступа.'],
            ['icon' => '🍎', 'title_ru' => 'Питание',     'title_kk' => 'Тамақтану',    'desc_ru' => 'Сбалансированное меню из свежих продуктов.'],
            ['icon' => '❤️', 'title_ru' => 'Воспитание',  'title_kk' => 'Тәрбие',       'desc_ru' => 'Нравственное воспитание, доброта и уважение.'],
        ]);
        foreach ($priorities as $i => $p) {
            $icon = $p['icon'] ?? '';
            if (empty(trim($icon)) || mb_strlen($icon) === mb_strlen(preg_replace('/[^\x00-\x7F]/u', '', $icon))) {
                $priorities[$i]['icon'] = $defaultIcons[$i] ?? '⭐';
            }
        }

        return view('home.index', compact(
            'latestPosts', 'teachers', 'faqs',
            'heroTitle', 'heroSubtitle', 'heroCta',
            'aboutTitle', 'aboutText',
            'ageGroupsRu', 'ageGroupsKk',
            'priorities'
        ));
    }

    private function localized(string $key, mixed $default = null): mixed
    {
        $value  = Setting::get($key, $default);
        $locale = app()->getLocale();

        if (is_array($value)) {
            return $value[$locale] ?? $value['ru'] ?? reset($value) ?? $default;
        }

        return $value;
    }
}
