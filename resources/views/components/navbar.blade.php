@php
    $navMenu  = \App\Models\Menu::where('location', 'header')
        ->with(['items' => fn($q) => $q->where('is_active', true)
            ->with(['children' => fn($q2) => $q2->where('is_active', true)->orderBy('order')])
            ->whereNull('parent_id')->orderBy('order')])
        ->first();
    $navItems   = $navMenu?->items ?? collect();
    $locale     = app()->getLocale();
    $currentUrl = url()->current();
@endphp

<header
    x-data="{
        open: false,
        scrolled: false,
        activeDropdown: null,
        init() {
            window.addEventListener('scroll', () => {
                this.scrolled = window.scrollY > 20;
            });
        }
    }"
    @keydown.escape.window="open = false; activeDropdown = null"
    class="fixed top-0 inset-x-0 z-50 transition-all duration-300"
    :class="scrolled
        ? 'bg-white shadow-md shadow-black/5'
        : 'bg-white/90 backdrop-blur-xl'"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-[68px] lg:h-[76px]">

            {{-- ── Logo ──────────────────────────────────────────────── --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0 group">
                @if(file_exists(public_path('images/didilogotype.png')))
                    <img src="/images/didilogotype.png" alt="DiDi"
                         class="h-14 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                @else
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-[#7EC8A4] to-[#5db888]
                                flex items-center justify-center shadow-lg shadow-[#7EC8A4]/30
                                group-hover:scale-105 transition-transform duration-300">
                        <span class="text-white font-extrabold text-lg font-sans leading-none">D</span>
                    </div>
                    <div class="hidden sm:block">
                        <div class="font-extrabold text-[#2D3748] text-lg font-sans leading-tight">Didi</div>
                        <div class="text-[10px] text-[#7EC8A4] font-semibold uppercase tracking-widest leading-none">Kindergarten</div>
                    </div>
                @endif
            </a>

            {{-- ── Desktop navigation ────────────────────────────────── --}}
            <nav class="hidden lg:flex items-center gap-1" aria-label="Главное меню">
                @foreach($navItems as $item)
                    @php
                        $label    = $item->getTranslation('label', $locale, false) ?: $item->getTranslation('label', 'ru', false);
                        $href     = $item->href;
                        $hasKids  = $item->children->count();
                        $isActive = !$hasKids && (
                            $currentUrl === $href ||
                            str_starts_with($currentUrl, rtrim($href, '/') . '/')
                        );
                    @endphp

                    @if($hasKids)
                        {{-- Dropdown --}}
                        <div class="relative"
                             x-data="{ open: false }"
                             @mouseenter="open = true"
                             @mouseleave="open = false">

                            <button
                                class="flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-sm font-semibold
                                       transition-all duration-200 outline-none
                                       text-gray-600 hover:text-[#7EC8A4] hover:bg-[#7EC8A4]/8"
                                :class="open ? 'text-[#7EC8A4] bg-[#7EC8A4]/8' : ''"
                                aria-haspopup="true" :aria-expanded="open">
                                {{ $label }}
                                <svg class="w-3.5 h-3.5 transition-transform duration-200 text-gray-400"
                                     :class="open ? 'rotate-180 text-[#7EC8A4]' : ''"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            {{-- Dropdown panel --}}
                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 scale-95 translate-y-1"
                                 class="absolute top-[calc(100%+6px)] left-0 w-56 origin-top-left
                                        bg-white rounded-2xl shadow-xl shadow-black/10
                                        border border-gray-100/80 py-1.5 z-50"
                                 style="display:none;">
                                @foreach($item->children as $child)
                                    @php
                                        $childLabel = $child->getTranslation('label', $locale, false) ?: $child->getTranslation('label', 'ru', false);
                                        $childHref  = $child->href;
                                        $childActive = $currentUrl === $childHref || str_starts_with($currentUrl, rtrim($childHref,'/').'/' );
                                    @endphp
                                    <a href="{{ $childHref }}"
                                       target="{{ $child->target }}"
                                       class="flex items-center gap-3 mx-1.5 px-3 py-2.5 rounded-xl text-sm font-medium
                                              transition-all duration-150 group
                                              {{ $childActive
                                                  ? 'bg-[#7EC8A4]/10 text-[#7EC8A4]'
                                                  : 'text-gray-600 hover:bg-[#7EC8A4]/8 hover:text-[#7EC8A4]' }}">
                                        <span class="w-1.5 h-1.5 rounded-full shrink-0 transition-colors
                                                     {{ $childActive ? 'bg-[#7EC8A4]' : 'bg-gray-200 group-hover:bg-[#7EC8A4]' }}"></span>
                                        {{ $childLabel }}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                    @else
                        {{-- Regular link --}}
                        <a href="{{ $href }}"
                           target="{{ $item->target }}"
                           class="relative px-4 py-2.5 rounded-xl text-sm font-semibold
                                  transition-all duration-200
                                  {{ $isActive
                                      ? 'text-[#7EC8A4] bg-[#7EC8A4]/10'
                                      : 'text-gray-600 hover:text-[#7EC8A4] hover:bg-[#7EC8A4]/8' }}">
                            {{ $label }}
                            @if($isActive)
                            <span class="absolute bottom-1.5 left-1/2 -translate-x-1/2 w-1 h-1 rounded-full bg-[#7EC8A4]"></span>
                            @endif
                        </a>
                    @endif
                @endforeach
            </nav>

            {{-- ── Right side ─────────────────────────────────────────── --}}
            <div class="flex items-center gap-2 lg:gap-3">

                {{-- Language switcher --}}
                @php $langFlags=['ru'=>'🇷🇺','kk'=>'🇰🇿','en'=>'🇬🇧']; $langLabels=['ru'=>'RU','kk'=>'KZ','en'=>'EN']; @endphp
                <div class="hidden sm:flex items-center bg-gray-100/80 rounded-xl p-1 gap-0.5">
                    @foreach(LaravelLocalization::getSupportedLocales() as $loc => $props)
                        <a href="{{ LaravelLocalization::getLocalizedURL($loc, null, [], true) }}"
                           hreflang="{{ $loc }}"
                           class="flex items-center gap-1 px-2.5 py-1 rounded-lg text-[11px] font-bold
                                  transition-all duration-200
                                  {{ app()->getLocale() === $loc
                                      ? 'bg-white text-[#7EC8A4] shadow-sm'
                                      : 'text-gray-400 hover:text-gray-600' }}">
                            <span>{{ $langLabels[$loc] ?? strtoupper($loc) }}</span>
                        </a>
                    @endforeach
                </div>

                {{-- CTA button --}}
                <a href="{{ route('contact.index') }}"
                   class="hidden md:inline-flex items-center gap-2
                          bg-[#7EC8A4] hover:bg-[#68b892] text-white
                          text-sm font-bold px-5 py-2.5 rounded-xl
                          transition-all duration-200 shadow-md shadow-[#7EC8A4]/25
                          hover:shadow-lg hover:shadow-[#7EC8A4]/30 hover:-translate-y-0.5">
                    {{ __('nav.enroll') }}
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>

                {{-- Mobile burger --}}
                <button @click="open = !open"
                        class="lg:hidden w-10 h-10 flex items-center justify-center
                               rounded-xl text-gray-600 hover:bg-gray-100 transition-colors"
                        aria-label="Меню">
                    <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- ── Mobile menu ────────────────────────────────────────────────── --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-3"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-3"
         class="lg:hidden bg-white border-t border-gray-100 shadow-lg"
         style="display:none;">

        <div class="max-w-7xl mx-auto px-4 py-3 space-y-0.5">

            @foreach($navItems as $item)
                @php
                    $label   = $item->getTranslation('label', $locale, false) ?: $item->getTranslation('label', 'ru', false);
                    $hasKids = $item->children->count();
                @endphp

                @if($hasKids)
                    <div x-data="{ sub: false }">
                        <button @click="sub = !sub"
                                class="w-full flex items-center justify-between px-4 py-3 rounded-xl
                                       text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                            <span>{{ $label }}</span>
                            <svg class="w-4 h-4 text-gray-400 transition-transform duration-200"
                                 :class="sub ? 'rotate-180' : ''"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="sub" class="pl-4 pb-1 space-y-0.5" style="display:none">
                            @foreach($item->children as $child)
                                @php $cl = $child->getTranslation('label', $locale, false) ?: $child->getTranslation('label', 'ru', false); @endphp
                                <a href="{{ $child->href }}" @click="open = false"
                                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl
                                          text-sm text-gray-500 hover:text-[#7EC8A4] hover:bg-[#7EC8A4]/8 transition-colors">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span>
                                    {{ $cl }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <a href="{{ $item->href }}" @click="open = false"
                       class="block px-4 py-3 rounded-xl text-sm font-semibold
                              text-gray-700 hover:text-[#7EC8A4] hover:bg-[#7EC8A4]/8 transition-colors">
                        {{ $label }}
                    </a>
                @endif
            @endforeach

            {{-- Mobile lang + CTA --}}
            <div class="pt-3 pb-2 border-t border-gray-100 flex items-center justify-between">
                <div class="flex items-center bg-gray-100 rounded-xl p-1 gap-0.5">
                    @foreach(LaravelLocalization::getSupportedLocales() as $loc => $props)
                        <a href="{{ LaravelLocalization::getLocalizedURL($loc, null, [], true) }}"
                           class="flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-bold transition-all
                                  {{ app()->getLocale() === $loc ? 'bg-white text-[#7EC8A4] shadow-sm' : 'text-gray-400' }}">
                            <span>{{ $langLabels[$loc] ?? strtoupper($loc) }}</span>
                        </a>
                    @endforeach
                </div>
                <a href="{{ route('contact.index') }}"
                   class="inline-flex items-center gap-2 bg-[#7EC8A4] text-white
                          text-sm font-bold px-5 py-2.5 rounded-xl shadow-md shadow-[#7EC8A4]/25">
                    {{ __('nav.enroll') }}
                </a>
            </div>
        </div>
    </div>
</header>
