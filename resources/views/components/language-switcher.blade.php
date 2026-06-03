@php
$langFlags  = ['ru' => '🇷🇺', 'kk' => '🇰🇿', 'en' => '🇬🇧'];
$langLabels = ['ru' => 'RU',   'kk' => 'KZ',   'en' => 'EN'];
@endphp
<div class="flex items-center gap-1 bg-gray-100 rounded-xl p-1">
    @foreach(LaravelLocalization::getSupportedLocales() as $locale => $properties)
        <a
            href="{{ LaravelLocalization::getLocalizedURL($locale, null, [], true) }}"
            hreflang="{{ $locale }}"
            class="flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold transition-all duration-200
                   {{ app()->getLocale() === $locale
                        ? 'bg-white text-[#7EC8A4] shadow-sm'
                        : 'text-gray-500 hover:text-gray-800' }}"
        >
            <span>{{ $langLabels[$locale] ?? strtoupper($locale) }}</span>
        </a>
    @endforeach
</div>
