<?php

return [
    'inertia' => env('SEO_TOOLS_INERTIA', false),
    'meta' => [
        'defaults' => [
            'title'        => false,
            'titleBefore'  => false,
            'description'  => 'Современный детский сад в Атырау с индивидуальным подходом.',
            'separator'    => ' | ',
            'keywords'     => ['детский сад', 'балабақша', 'kindergarten', 'Атырау', 'Atyrau'],
            'canonical'    => 'full',
            'robots'       => 'index, follow',
        ],
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
            'norton'    => null,
        ],
        'add_notranslate_class' => false,
    ],
    'opengraph' => [
        'defaults' => [
            'title'       => env('APP_NAME', 'Didi Kindergarten'),
            'description' => 'Современный детский сад в Атырау с индивидуальным подходом.',
            'url'         => null,
            'type'        => 'website',
            'site_name'   => 'Didi Kindergarten',
            'images'      => [],
        ],
    ],
    'twitter' => [
        'defaults' => [
            'card' => 'summary_large_image',
        ],
    ],
    'json-ld' => [
        'defaults' => [
            'title'       => env('APP_NAME', 'Didi Kindergarten'),
            'description' => 'Современный детский сад в Атырау с индивидуальным подходом.',
            'url'         => null,
            'type'        => 'WebPage',
            'images'      => [],
        ],
    ],
];
