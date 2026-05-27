<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Roles
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $editor     = Role::firstOrCreate(['name' => 'editor',      'guard_name' => 'web']);

        // Admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@didi.kz'],
            ['name' => 'Admin', 'password' => Hash::make('password')]
        );
        $admin->assignRole($superAdmin);

        // ─── Settings ───────────────────────────────────────────────────────────
        $settings = [
            // General
            ['key' => 'site_name',    'value' => 'Didi Kindergarten',               'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Место, где дети растут счастливыми', 'group' => 'general'],

            // Hero section
            ['key' => 'hero_title', 'value' => ['ru' => 'Место, где дети растут счастливыми', 'kk' => 'Балалар бақытты өсетін орын', 'en' => 'Where children grow up happy'], 'group' => 'home'],
            ['key' => 'hero_subtitle', 'value' => ['ru' => 'Современный детский сад с индивидуальным подходом, творческими занятиями и любящими воспитателями.', 'kk' => 'Жеке тәсілмен, шығармашылық сабақтарымен және сүйікті тәрбиешілерімен заманауи балабақша.', 'en' => 'A modern kindergarten with individual approach, creative activities and caring teachers.'], 'group' => 'home'],
            ['key' => 'hero_cta',   'value' => ['ru' => 'Записаться',   'kk' => 'Жазылу',      'en' => 'Enroll now'], 'group' => 'home'],

            // About section
            ['key' => 'about_title', 'value' => ['ru' => 'Мы ждём ваших детей в Didi!', 'kk' => 'Біз балаларыңызды DiDi-де күтеміз!', 'en' => 'We welcome your children at Didi!'], 'group' => 'home'],
            ['key' => 'about_text',  'value' => ['ru' => 'Наш детский сад — это уютная среда, где каждый ребёнок чувствует себя любимым и важным. Мы создаём условия для гармоничного развития: физического, интеллектуального и творческого. Опытные педагоги, современные методики обучения и безопасное пространство — всё это Didi.', 'kk' => 'Біздің балабақша — әр бала өзін сүйікті және маңызды сезінетін ыңғайлы орта. Біз үйлесімді дамуға жағдай жасаймыз: дене, интеллектуалдық және шығармашылық. Тәжірибелі педагогтар, заманауи оқыту әдістері және қауіпсіз кеңістік — бәрі де DiDi-де.', 'en' => 'Our kindergarten is a cozy environment where every child feels loved and important. We create conditions for harmonious development: physical, intellectual and creative.'], 'group' => 'home'],

            // Age groups
            ['key' => 'age_groups_ru', 'value' => [
                ['name' => 'Балапан', 'age' => '2+', 'emoji' => '🐣', 'bg' => '#FFF3E8'],
                ['name' => 'Лучики',  'age' => '3+', 'emoji' => '☀️', 'bg' => '#FFF8E1'],
                ['name' => 'Улыбка',  'age' => '4+', 'emoji' => '😊', 'bg' => '#FCE4EC'],
                ['name' => 'Умники',  'age' => '5+', 'emoji' => '🦁', 'bg' => '#EDE7F6'],
                ['name' => 'Эрудиты','age' => '6+', 'emoji' => '🎓', 'bg' => '#E3F2FD'],
            ], 'group' => 'home'],
            ['key' => 'age_groups_kk', 'value' => [
                ['name' => 'Күлыншақ', 'age' => '2+', 'emoji' => '🌺', 'bg' => '#FCE4EC'],
                ['name' => 'Балдырған','age' => '3+', 'emoji' => '🌿', 'bg' => '#E8F5E9'],
                ['name' => 'Бәйтерек','age' => '4+', 'emoji' => '🌳', 'bg' => '#E0F2F1'],
                ['name' => 'Балдәурен','age' => '5+', 'emoji' => '🌸', 'bg' => '#FCE4EC'],
                ['name' => 'Болашақ', 'age' => '6+', 'emoji' => '⭐', 'bg' => '#FFF8E1'],
            ], 'group' => 'home'],

            // Priorities
            ['key' => 'priorities', 'value' => [
                ['icon' => '🎓', 'title_ru' => 'Образование', 'title_kk' => 'Білім',         'title_en' => 'Education',  'desc_ru' => 'Индивидуальный подход и развивающие программы по возрасту.',   'desc_kk' => 'Жеке тәсіл және жасқа сай дамытушы бағдарламалар.'],
                ['icon' => '💚', 'title_ru' => 'Здоровье',    'title_kk' => 'Денсаулық',     'title_en' => 'Health',     'desc_ru' => 'Ежедневная гимнастика, свежий воздух и медицинское наблюдение.','desc_kk' => 'Күнделікті гимнастика, таза ауа және медициналық бақылау.'],
                ['icon' => '🏠', 'title_ru' => 'Комфорт',     'title_kk' => 'Жайлылық',     'title_en' => 'Comfort',    'desc_ru' => 'Уютные классы, мягкая мебель и пространство для игр.',          'desc_kk' => 'Ыңғайлы сыныптар, жұмсақ жиһаз және ойын кеңістігі.'],
                ['icon' => '🛡️','title_ru' => 'Безопасность', 'title_kk' => 'Қауіпсіздік',  'title_en' => 'Safety',     'desc_ru' => 'Видеонаблюдение, охрана и контроль доступа круглосуточно.',    'desc_kk' => 'Бейнебақылау, күзет және кіруді бақылау тәулік бойы.'],
                ['icon' => '🍎', 'title_ru' => 'Питание',     'title_kk' => 'Тамақтану',     'title_en' => 'Nutrition',  'desc_ru' => 'Сбалансированное меню из свежих продуктов для каждого возраста.','desc_kk' => 'Әр жас үшін жаңа өнімдерден теңдестірілген мәзір.'],
                ['icon' => '❤️', 'title_ru' => 'Воспитание',  'title_kk' => 'Тәрбие',       'title_en' => 'Upbringing', 'desc_ru' => 'Нравственное воспитание, доброта, уважение и ответственность.',  'desc_kk' => 'Адамгершілік тәрбиесі, мейірімділік, сыйластық және жауапкершілік.'],
            ], 'group' => 'home'],

            // Contact
            ['key' => 'contact_address', 'value' => 'г. Атырау, ул. Абылай хана, 15', 'group' => 'contact'],
            ['key' => 'contact_phone',   'value' => '+7 (7122) 12-34-56',              'group' => 'contact'],
            ['key' => 'contact_email',   'value' => 'info@didi.kz',                    'group' => 'contact'],
            ['key' => 'work_hours',      'value' => 'Пн–Пт: 07:30 – 19:00',           'group' => 'contact'],
        ];
        foreach ($settings as $s) {
            Setting::firstOrCreate(['key' => $s['key']], $s);
        }

        // ─── Categories ─────────────────────────────────────────────────────────
        $news = Category::firstOrCreate(['slug' => 'news'], ['order' => 1]);
        $news->setTranslations('name', ['ru' => 'Новости', 'kk' => 'Жаңалықтар', 'en' => 'News']);
        $news->save();

        $events = Category::firstOrCreate(['slug' => 'events'], ['order' => 2]);
        $events->setTranslations('name', ['ru' => 'События', 'kk' => 'Іс-шаралар', 'en' => 'Events']);
        $events->save();

        // ─── Pages ──────────────────────────────────────────────────────────────
        $aboutPage = Page::firstOrCreate(['slug' => 'about'], [
            'status'       => 'published',
            'published_at' => now(),
            'show_in_menu' => true,
            'order'        => 1,
        ]);
        $aboutPage->setTranslations('title',   ['ru' => 'О нас', 'kk' => 'Біз туралы', 'en' => 'About us']);
        $aboutPage->setTranslations('content', [
            'ru' => '<p>Детский сад «Didi» — современное учреждение образования, где каждый ребёнок окружён заботой, теплом и профессиональными педагогами.</p>',
            'kk' => '<p>«Didi» балабақшасы — заманауи білім беру мекемесі.</p>',
            'en' => '<p>Didi Kindergarten is a modern educational institution.</p>',
        ]);
        $aboutPage->save();

        // ─── Sample posts ────────────────────────────────────────────────────────
        $samplePosts = [
            [
                'slug'     => 'welcome-to-didi',
                'title'    => ['ru' => 'Добро пожаловать в Didi!',         'kk' => 'Didi-ге қош келдіңіз!',       'en' => 'Welcome to Didi!'],
                'excerpt'  => ['ru' => 'Мы рады приветствовать вас в нашем детском саду.', 'kk' => 'Балабақшамызға қош келдіңіз.', 'en' => 'We are glad to welcome you.'],
                'content'  => ['ru' => '<p>Это первая новость нашего сайта. Следите за обновлениями!</p>', 'kk' => '<p>Бұл сайтымыздың бірінші жаңалығы.</p>', 'en' => '<p>This is our first post. Stay tuned!</p>'],
                'category' => $news,
            ],
            [
                'slug'     => 'new-season-enrollment',
                'title'    => ['ru' => 'Открыт набор на новый учебный год!', 'kk' => 'Жаңа оқу жылына жазылу ашылды!', 'en' => 'Enrollment for new academic year is open!'],
                'excerpt'  => ['ru' => 'Приглашаем детей от 2 до 7 лет. Узнайте подробности на странице контактов.', 'kk' => '2-ден 7 жасқа дейінгі балаларды шақырамыз.', 'en' => 'We invite children from 2 to 7 years. Learn details on the contact page.'],
                'content'  => ['ru' => '<p>Уважаемые родители, мы рады сообщить об открытии набора детей на новый учебный год. Количество мест ограничено!</p>', 'kk' => '<p>Құрметті ата-аналар, жаңа оқу жылына балаларды қабылдау ашылғанын хабарлаймыз.</p>', 'en' => '<p>Dear parents, we are pleased to announce enrollment for the new academic year. Places are limited!</p>'],
                'category' => $news,
            ],
            [
                'slug'     => 'summer-camp-2025',
                'title'    => ['ru' => 'Летний лагерь 2025 — регистрация открыта', 'kk' => 'Жазғы лагерь 2025 — тіркеу ашылды', 'en' => 'Summer camp 2025 — registration open'],
                'excerpt'  => ['ru' => 'Насыщенная программа, творческие мастер-классы и безопасная среда для вашего ребёнка.', 'kk' => 'Балаңыз үшін бай бағдарлама, шығармашылық шеберхана.', 'en' => 'Rich program, creative workshops and a safe environment for your child.'],
                'content'  => ['ru' => '<p>Летний лагерь Didi — это незабываемые каникулы с новыми друзьями, интересными занятиями и развлечениями на свежем воздухе.</p>', 'kk' => '<p>Didi жазғы лагері — жаңа достармен, қызықты сабақтармен ұмытылмас демалыс.</p>', 'en' => '<p>Didi Summer Camp is an unforgettable holiday with new friends and fun activities outdoors.</p>'],
                'category' => $events,
            ],
        ];

        foreach ($samplePosts as $p) {
            $post = Post::firstOrCreate(['slug' => $p['slug']], [
                'category_id' => $p['category']->id,
                'user_id'     => $admin->id,
                'status'      => 'published',
                'published_at' => now()->subDays(rand(1, 30)),
            ]);
            $post->setTranslations('title',   $p['title']);
            $post->setTranslations('excerpt', $p['excerpt']);
            $post->setTranslations('content', $p['content']);
            $post->save();
        }

        // ─── Sample teachers ─────────────────────────────────────────────────────
        $teachers = [
            ['name' => 'Алия Нурланова',    'position' => 'Старший воспитатель',  'order' => 1],
            ['name' => 'Гүлнар Сейткали',   'position' => 'Воспитатель (КК/РУ)', 'order' => 2],
            ['name' => 'Светлана Иванова',   'position' => 'Преподаватель английского', 'order' => 3],
            ['name' => 'Дина Ахметова',      'position' => 'Психолог',            'order' => 4],
        ];
        foreach ($teachers as $t) {
            Teacher::firstOrCreate(['name' => $t['name']], $t);
        }

        // ─── Menu ────────────────────────────────────────────────────────────────
        $menu = Menu::firstOrCreate(['location' => 'header']);

        $menuItems = [
            ['label' => ['ru' => 'Главная', 'kk' => 'Басты бет', 'en' => 'Home'],    'url' => '/',        'order' => 1],
            ['label' => ['ru' => 'О нас',   'kk' => 'Біз туралы', 'en' => 'About'],  'page_id' => $aboutPage->id, 'order' => 2],
            ['label' => ['ru' => 'Новости', 'kk' => 'Жаңалықтар', 'en' => 'News'],   'url' => '/blog',    'order' => 3],
            ['label' => ['ru' => 'Галерея', 'kk' => 'Галерея',   'en' => 'Gallery'], 'url' => '/gallery', 'order' => 4],
            ['label' => ['ru' => 'Контакты','kk' => 'Байланыс',  'en' => 'Contact'], 'url' => '/contact', 'order' => 5],
        ];
        foreach ($menuItems as $item) {
            $mi = MenuItem::firstOrCreate(['menu_id' => $menu->id, 'order' => $item['order']], [
                'url'     => $item['url']     ?? null,
                'page_id' => $item['page_id'] ?? null,
                'target'  => '_self',
            ]);
            $mi->setTranslations('label', $item['label']);
            $mi->save();
        }
    }
}
