@extends('layouts.app')

@push('styles')
    <style>
        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity .65s cubic-bezier(.16, 1, .3, 1), transform .65s cubic-bezier(.16, 1, .3, 1);
        }

        .reveal.in {
            opacity: 1;
            transform: translateY(0);
        }

        .teacher-card {
            background: #fff;
            border-radius: 24px;
            border: 1px solid rgba(0, 0, 0, .06);
            box-shadow: 0 2px 16px rgba(0, 0, 0, .05);
            overflow: hidden;
            transition: transform .45s cubic-bezier(.16, 1, .3, 1), box-shadow .45s cubic-bezier(.16, 1, .3, 1);
            will-change: transform;
        }

        .teacher-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 24px 60px rgba(0, 0, 0, .10);
        }

        .teacher-card .card-img {
            overflow: hidden;
            aspect-ratio: 3/4;
        }

        .teacher-card .card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top;
            transition: transform .65s cubic-bezier(.16, 1, .3, 1);
        }

        .teacher-card:hover .card-img img {
            transform: scale(1.05);
        }

        .glass-badge {
            background: rgba(255, 255, 255, .80);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-top: 1px solid rgba(255, 255, 255, .6);
        }
    </style>
@endpush

@section('content')

    {{-- ══════════════════════════════════════════════════════════
     HERO
══════════════════════════════════════════════════════════ --}}
    <section class="relative min-h-screen flex items-center overflow-hidden pt-16"
        style="background: linear-gradient(135deg, #e8f8f0 0%, #f0f9f9 40%, #fff3e8 100%)">

        <div class="absolute top-20 right-20 w-80 h-80 bg-[#7EC8A4]/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-20 left-10 w-64 h-64 bg-[#F4A261]/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid lg:grid-cols-2 gap-12 items-center">

                {{-- Left: Text --}}
                <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="opacity-0">
                    <div
                        class="inline-flex items-center gap-2 bg-white/70 backdrop-blur-sm text-[#7EC8A4] text-sm font-bold px-4 py-2 rounded-full mb-6 border border-[#7EC8A4]/30 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-[#7EC8A4] animate-pulse"></span>
                        {{ __('home.badge') }}
                    </div>
                    <h1 class="font-extrabold font-sans text-4xl lg:text-5xl xl:text-6xl text-[#2D3748] leading-tight mb-6">
                        {{ $heroTitle }}
                    </h1>
                    <p class="text-gray-500 text-lg leading-relaxed mb-8 max-w-lg">
                        {{ $heroSubtitle }}
                    </p>
                    <div class="flex flex-wrap gap-4 mb-10">
                        <a href="{{ route('contact.index') }}"
                            class="inline-flex items-center gap-2 bg-[#7EC8A4] hover:bg-[#68b892] text-white font-bold px-7 py-3.5 rounded-2xl transition-all duration-200 shadow-lg shadow-[#7EC8A4]/30 hover:-translate-y-0.5">
                            {{ $heroCta }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                        <a href="{{ route('gallery.index') }}"
                            class="inline-flex items-center gap-2 bg-white/80 text-[#2D3748] font-semibold px-7 py-3.5 rounded-2xl border border-white/50 hover:bg-white transition-all duration-200 shadow-sm">
                            {{ __('nav.gallery') }}
                        </a>
                    </div>
                    <div class="flex flex-wrap gap-8">
                        @foreach ([['200+', __('home.stat_children')], ['15+', __('home.stat_teachers')], ['10', __('home.stat_years')], ['3', __('home.stat_languages')]] as [$n, $l])
                            <div class="text-center">
                                <div class="text-2xl font-extrabold text-[#7EC8A4] font-sans">{{ $n }}</div>
                                <div class="text-xs text-gray-400 mt-0.5">{{ $l }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Right: Hero image --}}
                <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')"
                    class="opacity-0 [animation-delay:0.2s] relative flex justify-center">
                    <div class="relative flex justify-center items-end">
                        @if (file_exists(public_path('images/hero.png')))
                            <img src="/images/hero.png" alt="Детский сад Didi"
                                class="relative z-10 w-full max-w-lg drop-shadow-2xl"
                                style="max-height:600px;object-fit:contain;">
                        @elseif(file_exists(public_path('images/hero.jpg')))
                            <img src="/images/hero.jpg" alt="Детский сад Didi"
                                class="relative z-10 w-full max-w-lg rounded-3xl drop-shadow-2xl"
                                style="max-height:600px;object-fit:cover;">
                        @else
                            <div class="w-full max-w-sm flex flex-col items-center justify-center gap-4 py-16">
                                <div class="text-8xl drop-shadow-lg">🏫</div>
                            </div>
                        @endif
                        <div
                            class="absolute top-4 right-0 bg-[#F4A261] text-white text-xs font-bold px-4 py-2 rounded-2xl shadow-lg rotate-3 z-20">
                            {{ __('home.enroll_open') }}</div>
                        <div
                            class="absolute left-0 top-1/3 bg-white rounded-2xl shadow-xl px-4 py-3 flex items-center gap-3 z-20 hidden lg:flex">
                            <div class="w-10 h-10 rounded-xl bg-[#7EC8A4]/15 flex items-center justify-center text-xl">🌍
                            </div>
                            <div>
                                <div class="text-[10px] text-gray-400 font-medium">{{ __('home.program_label') }}</div>
                                <div class="text-sm font-bold text-[#2D3748]">{{ __('home.program_value') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0 h-16"
            style="background:#ffffff; clip-path:ellipse(100% 100% at 50% 100%)"></div>
    </section>

    {{-- ══════════════════════════════════════════════════════════
     AGE GROUPS
══════════════════════════════════════════════════════════ --}}
    <section style="background:#ffffff" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center mb-14" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')"
                class="opacity-0">
                <h2 class="text-3xl lg:text-4xl font-extrabold font-sans text-[#2D3748] mb-3">
                    {{ __('home.age_groups_title') }}</h2>
                <p class="text-gray-400 max-w-xl mx-auto">{{ __('home.age_groups_subtitle') }}</p>
            </div>

            {{-- Kazakh groups --}}
            @php
                $groupCard = function ($group, $accentColor) {
                    return $group;
                };
            @endphp

            <div class="mb-10" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="opacity-0">
                <div class="flex items-center gap-3 mb-6">
                    <span class="text-lg">🇰🇿</span>
                    <h3 class="font-bold text-[#2D3748] text-base font-sans">{{ __('home.kazakh_groups') }}</h3>
                    <div class="flex-1 h-px bg-gray-200"></div>
                </div>
                <div class="grid grid-cols-3 sm:grid-cols-5 gap-4">
                    @foreach ($ageGroupsKk as $i => $group)
                        <div class="flex flex-col items-center gap-3 p-4 bg-white rounded-3xl shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1 group cursor-default"
                            style="animation-delay:{{ $i * 0.07 }}s">
                            @if (!empty($group['image']) && file_exists(public_path('images/' . $group['image'])))
                                <div class="w-24 h-24 rounded-full overflow-hidden flex items-center justify-center"
                                    style="background-color:{{ $group['bg'] ?? '#F0FDF4' }}">
                                    <img src="/images/{{ $group['image'] }}" alt="{{ $group['name'] }}"
                                        class="w-20 h-20 object-contain group-hover:scale-110 transition-transform duration-300">
                                </div>
                            @else
                                <div class="w-24 h-24 rounded-full flex items-center justify-center text-4xl"
                                    style="background-color:{{ $group['bg'] ?? '#F0FDF4' }}">{{ $group['emoji'] ?? '🎒' }}
                                </div>
                            @endif
                            <div class="text-center">
                                <div class="text-xs text-gray-400 font-medium">{{ $group['age'] }} {{ __('home.years') }}
                                </div>
                                <div class="font-bold text-[#2D3748] text-sm font-sans mt-0.5">{{ $group['name'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Russian groups --}}
            <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="opacity-0">
                <div class="flex items-center gap-3 mb-6">
                    <span class="text-lg">🇷🇺</span>
                    <h3 class="font-bold text-[#2D3748] text-base font-sans">{{ __('home.russian_groups') }}</h3>
                    <div class="flex-1 h-px bg-gray-200"></div>
                </div>
                <div class="grid grid-cols-3 sm:grid-cols-5 gap-4">
                    @foreach ($ageGroupsRu as $i => $group)
                        <div class="flex flex-col items-center gap-3 p-4 bg-white rounded-3xl shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1 group cursor-default"
                            style="animation-delay:{{ $i * 0.07 }}s">
                            @if (!empty($group['image']) && file_exists(public_path('images/' . $group['image'])))
                                <div class="w-24 h-24 rounded-full overflow-hidden flex items-center justify-center"
                                    style="background-color:{{ $group['bg'] ?? '#F0FDF4' }}">
                                    <img src="/images/{{ $group['image'] }}" alt="{{ $group['name'] }}"
                                        class="w-20 h-20 object-contain group-hover:scale-110 transition-transform duration-300">
                                </div>
                            @else
                                <div class="w-24 h-24 rounded-full flex items-center justify-center text-4xl"
                                    style="background-color:{{ $group['bg'] ?? '#F0FDF4' }}">{{ $group['emoji'] ?? '🎒' }}
                                </div>
                            @endif
                            <div class="text-center">
                                <div class="text-xs text-gray-400 font-medium">{{ $group['age'] }} {{ __('home.years') }}
                                </div>
                                <div class="font-bold text-[#2D3748] text-sm font-sans mt-0.5">{{ $group['name'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════
     ABOUT / BUILDING
══════════════════════════════════════════════════════════ --}}
    <section style="background:#f8faf9" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="opacity-0">
                    <div class="relative rounded-3xl overflow-hidden shadow-xl" style="aspect-ratio:4/3;">
                        @if (file_exists(public_path('images/building.png')))
                            <img src="/images/building.png" alt="Здание DiDi" class="w-full h-full object-cover">
                        @elseif(file_exists(public_path('images/building.jpg')))
                            <img src="/images/building.jpg" alt="Здание DiDi" class="w-full h-full object-cover">
                        @else
                            <div
                                class="w-full h-full flex flex-col items-center justify-center gap-4 bg-gradient-to-br from-[#7EC8A4]/20 to-[#A8DADC]/15">
                                <div class="text-7xl">🏗️</div>
                                <p class="text-[#7EC8A4] font-semibold text-sm text-center px-4">Добавьте building.png<br>в
                                    public/images/</p>
                            </div>
                        @endif
                        <div
                            class="absolute bottom-4 left-4 bg-[#7EC8A4] text-white text-xs font-bold px-3 py-1.5 rounded-xl shadow">
                            г. Алматы</div>
                    </div>
                </div>
                <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')"
                    class="opacity-0 [animation-delay:0.15s]">
                    <div class="inline-flex items-center gap-2 text-[#7EC8A4] text-sm font-bold mb-4">
                        <span class="w-8 h-0.5 bg-[#7EC8A4] rounded"></span>{{ __('home.about_label') }}
                    </div>
                    <h2 class="text-3xl lg:text-4xl font-extrabold font-sans text-[#2D3748] mb-5 leading-tight">
                        {{ $aboutTitle }}</h2>
                    <p class="text-gray-500 leading-relaxed mb-8">{{ $aboutText }}</p>
                    <div class="space-y-4 mb-8">
                        @foreach ([['🎨', __('home.feature_art')], ['🌍', __('home.feature_lang')], ['👩‍⚕️', __('home.feature_health')]] as [$ic, $tx])
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-10 h-10 rounded-xl bg-[#7EC8A4]/10 flex items-center justify-center text-xl flex-shrink-0">
                                    {{ $ic }}</div>
                                <span class="text-gray-600 text-sm font-medium">{{ $tx }}</span>
                            </div>
                        @endforeach
                    </div>
                    <a href="{{ route('contact.index') }}"
                        class="inline-flex items-center gap-2 bg-[#7EC8A4] hover:bg-[#68b892] text-white font-bold px-6 py-3 rounded-2xl transition-all duration-200 shadow-md hover:-translate-y-0.5">
                        {{ __('home.contact_us') }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════
     PRIORITIES
══════════════════════════════════════════════════════════ --}}
    <section style="background:#ffffff" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')"
                class="opacity-0">
                <h2 class="text-3xl lg:text-4xl font-extrabold font-sans text-[#2D3748] mb-3">
                    @if (app()->getLocale() === 'kk')
                        Біздің басымдықтар
                    @elseif(app()->getLocale() === 'en')
                        Our priorities
                    @else
                        Наши приоритеты
                    @endif
                </h2>
                <p class="text-gray-400 max-w-xl mx-auto">
                    @if (app()->getLocale() === 'kk')
                        Жұмысымыздың негізін қалайтын алты негізгі қағида.
                    @elseif(app()->getLocale() === 'en')
                        Six key principles that form the foundation of our work.
                    @else
                        Шесть ключевых принципов, которые лежат в основе нашей работы.
                    @endif
                </p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($priorities as $i => $priority)
                    <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')"
                        class="opacity-0 relative bg-white rounded-3xl p-7 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 overflow-hidden group"
                        style="animation-delay:{{ $i * 0.08 }}s">
                        <div
                            class="absolute top-3 right-5 text-8xl font-black text-gray-50 select-none pointer-events-none">
                            {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</div>
                        <div class="relative">
                            <div class="text-4xl mb-4">{{ $priority['icon'] }}</div>
                            <h3 class="font-bold text-xl text-[#2D3748] mb-2 font-sans">
                                @if (app()->getLocale() === 'kk' && isset($priority['title_kk']))
                                    {{ $priority['title_kk'] }}
                                @elseif(app()->getLocale() === 'en' && isset($priority['title_en']))
                                    {{ $priority['title_en'] }}
                                    @else{{ $priority['title_ru'] ?? '' }}
                                @endif
                            </h3>
                            <p class="text-gray-500 text-sm leading-relaxed">
                                @if (app()->getLocale() === 'kk' && isset($priority['desc_kk']))
                                    {{ $priority['desc_kk'] }}
                                    @else{{ $priority['desc_ru'] ?? '' }}
                                @endif
                            </p>
                        </div>
                        <div
                            class="absolute bottom-0 left-0 right-0 h-1 bg-[#7EC8A4] scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left rounded-b-3xl">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════
     TEACHERS CAROUSEL
══════════════════════════════════════════════════════════ --}}
    @if ($teachers->count())
        @php
            $hLocale = app()->getLocale();
            $allTeachers = $teachers
                ->map(function ($t) use ($hLocale) {
                    return [
                        'url' => route('teachers.show', $t),
                        'thumb' => $t->getFirstMediaUrl('photo', 'thumb') ?: $t->getFirstMediaUrl('photo'),
                        'name' =>
                            $t->getTranslation('name', $hLocale, false) ?: $t->getTranslation('name', 'ru', false),
                        'pos' =>
                            $t->getTranslation('position', $hLocale, false) ?:
                            $t->getTranslation('position', 'ru', false),
                    ];
                })
                ->values()
                ->toArray();
        @endphp
        <section style="background:#f8faf9" class="py-20 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                {{-- Header --}}
                <div class="reveal flex items-end justify-between mb-10" x-intersect.once="$el.classList.add('in')">
                    <div>
                        <span
                            class="inline-flex items-center gap-2 text-[#7EC8A4] text-xs font-semibold uppercase tracking-[.18em] mb-2">
                            <span style="width:18px;height:1px;background:#7EC8A4;display:inline-block"></span>
                            {{ __('home.team_label') }}
                        </span>
                        <h2 class="text-3xl lg:text-4xl font-extrabold text-[#1a2535] tracking-tight">
                            {{ __('home.our_teachers') }}
                        </h2>
                    </div>
                    <a href="{{ route('teachers.index') }}"
                        style="display:inline-flex;align-items:center;gap:6px;font-size:13px;font-weight:600;color:#7EC8A4;text-decoration:none"
                        class="hidden sm:inline-flex hover:underline">
                        {{ __('home.all_teachers') }}
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                {{-- Carousel --}}
                <div x-data="{
                    current: 0,
                    total: {{ count($allTeachers) }},
                    autoTimer: null,
                    get perPage() {
                        if (window.innerWidth >= 1024) return 4;
                        if (window.innerWidth >= 640) return 3;
                        return 2;
                    },
                    get maxIndex() { return Math.max(0, this.total - this.perPage); },
                    next() { this.current = this.current < this.maxIndex ? this.current + 1 : 0; },
                    startAuto() { this.autoTimer = setInterval(() => this.next(), 3500); },
                    init() { this.startAuto(); }
                }">
                    {{-- Track --}}
                    <div class="overflow-hidden">
                        <div class="flex transition-transform duration-500 ease-[cubic-bezier(.16,1,.3,1)]"
                            :style="`transform: translateX(-${current * (100 / perPage)}%)`">
                            @foreach ($allTeachers as $t)
                                <div class="shrink-0 px-2 lg:px-2.5" :style="`width: ${100 / perPage}%`">
                                    <a href="{{ $t['url'] }}"
                                        style="display:block;background:#fff;border-radius:18px;overflow:hidden;
                                  border:1px solid rgba(0,0,0,.06);box-shadow:0 2px 12px rgba(0,0,0,.04);
                                  transition:transform .35s cubic-bezier(.16,1,.3,1),box-shadow .35s cubic-bezier(.16,1,.3,1)"
                                        onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 18px 44px rgba(0,0,0,.10)'"
                                        onmouseout="this.style.transform='none';this.style.boxShadow='0 2px 12px rgba(0,0,0,.04)'">
                                        {{-- Photo --}}
                                        <div
                                            style="overflow:hidden;aspect-ratio:3/4;background:linear-gradient(135deg,#edf7f2,#d8ede5)">
                                            @if ($t['thumb'])
                                                <img src="{{ $t['thumb'] }}" alt="{{ $t['name'] }}" loading="lazy"
                                                    style="width:100%;height:100%;object-fit:cover;object-position:top;display:block;
                                                transition:transform .6s cubic-bezier(.16,1,.3,1)"
                                                    onmouseover="this.style.transform='scale(1.05)'"
                                                    onmouseout="this.style.transform='scale(1)'">
                                            @else
                                                <div
                                                    style="width:100%;height:100%;display:flex;align-items:center;justify-content:center">
                                                    <svg style="width:40px;height:40px;opacity:.25;color:#7EC8A4"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1"
                                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        {{-- Info --}}
                                        <div style="padding:12px 14px 15px">
                                            <p
                                                style="font-weight:700;color:#1a2535;font-size:14px;line-height:1.35;margin:0 0 3px">
                                                {{ $t['name'] }}</p>
                                            @if ($t['pos'])
                                                <p
                                                    style="font-size:11px;color:#7EC8A4;font-weight:500;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                                                    {{ $t['pos'] }}</p>
                                            @endif
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Dots
            <div class="flex justify-center gap-2 mt-7">
                <template x-for="i in maxIndex + 1" :key="i">
                    <button @click="current = i - 1"
                            :class="current === i - 1 ? 'w-5 bg-[#7EC8A4]' : 'w-2 bg-gray-300 hover:bg-gray-400'"
                            class="h-2 rounded-full transition-all duration-300 focus:outline-none">
                    </button>
                </template>
            </div> --}}
                </div>

                <div class="text-center mt-6 sm:hidden">
                    <a href="{{ route('teachers.index') }}"
                        style="font-size:13px;font-weight:600;color:#7EC8A4">{{ __('home.all_teachers') }} →</a>
                </div>
            </div>
        </section>
    @endif

    {{-- ══════════════════════════════════════════════════════════
     LATEST NEWS
══════════════════════════════════════════════════════════ --}}
    <section style="background:#ffffff" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex items-end justify-between mb-10">
                <div>
                    <div class="inline-flex items-center gap-2 text-[#7EC8A4] text-sm font-bold mb-3">
                        <span class="w-8 h-0.5 bg-[#7EC8A4] rounded"></span>{{ __('home.news_label') }}
                    </div>
                    <h2 class="text-3xl lg:text-4xl font-extrabold text-[#1a2535]">{{ __('home.latest_news') }}</h2>
                </div>
                <a href="{{ route('blog.index') }}"
                    class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#7EC8A4] hover:underline">
                    {{ __('home.all_news') }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>

            @if ($latestPosts->count())
                <div class="grid md:grid-cols-3 gap-6">
                    @foreach ($latestPosts as $i => $post)
                        @php
                            $img = $post->getFirstMediaUrl('featured', 'thumb') ?: $post->getFirstMediaUrl('featured');
                            $catName = $post->category
                                ? ($post->category->getTranslation('name', app()->getLocale(), false) ?:
                                $post->category->getTranslation('name', 'ru', false) ?:
                                $post->category->name)
                                : null;
                        @endphp
                        <article
                            class="group bg-white rounded-3xl overflow-hidden border border-gray-100 hover:border-[#7EC8A4]/25 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col">

                            {{-- Thumbnail --}}
                            <a href="{{ route('blog.show', $post->slug) }}" class="block overflow-hidden"
                                style="aspect-ratio:16/9">
                                @if ($img)
                                    <img src="{{ $img }}" alt="{{ $post->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-600"
                                        loading="lazy">
                                @else
                                    <div
                                        class="w-full h-full bg-gradient-to-br from-[#e8f8f0] to-[#d4f0e4] flex items-center justify-center">
                                        <svg class="w-12 h-12 text-[#7EC8A4]/40" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                        </svg>
                                    </div>
                                @endif
                            </a>

                            {{-- Content --}}
                            <div class="flex-1 flex flex-col p-6">
                                <div class="flex items-center gap-2 mb-3">
                                    @if ($catName)
                                        <span
                                            class="text-[11px] font-bold text-[#5aaf88] bg-[#7EC8A4]/10 px-2.5 py-0.5 rounded-full uppercase tracking-wide">{{ $catName }}</span>
                                    @endif
                                    <time
                                        class="text-xs text-gray-400 ml-auto">{{ $post->published_at?->format('d.m.Y') }}</time>
                                </div>
                                <h3
                                    class="font-bold text-[#1a2535] leading-snug line-clamp-2 mb-2 group-hover:text-[#5aaf88] transition-colors text-[15px]">
                                    <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                                </h3>
                                @if ($post->excerpt)
                                    <p class="text-gray-400 text-sm line-clamp-2 flex-1">{{ $post->excerpt }}</p>
                                @endif
                                <div class="pt-4 mt-auto">
                                    <a href="{{ route('blog.show', $post->slug) }}"
                                        class="inline-flex items-center gap-1.5 text-sm font-bold text-[#5aaf88] hover:gap-2.5 transition-all">
                                        {{ __('home.read') }}
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 text-gray-400 text-sm">
                    {{ __('home.no_news') }}
                </div>
            @endif

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════
     FAQ
══════════════════════════════════════════════════════════ --}}
    @if ($faqs->count())
        <section style="background:#ffffff" class="py-20">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

                {{-- Header --}}
                <div class="text-center mb-12" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="opacity-0">
                    <span class="inline-flex items-center gap-2 bg-[#7EC8A4]/10 text-[#7EC8A4] text-xs font-bold px-4 py-1.5 rounded-full mb-4 uppercase tracking-widest">
                        {{ __('home.faq_label') }}
                    </span>
                    <h2 class="text-3xl lg:text-4xl font-extrabold font-sans text-[#2D3748] mb-3">
                        {{ __('home.faq_title') }}
                    </h2>
                    <p class="text-gray-400 max-w-xl mx-auto">{{ __('home.faq_subtitle') }}</p>
                </div>

                {{-- Accordion --}}
                <div x-data="{ open: null }" class="space-y-3">
                    @foreach ($faqs as $i => $faq)
                        @php
                            $question = $faq->getTranslation('question', app()->getLocale(), false) ?: $faq->getTranslation('question', 'ru', false);
                            $answer   = $faq->getTranslation('answer',   app()->getLocale(), false) ?: $faq->getTranslation('answer',   'ru', false);
                        @endphp
                        <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')"
                             class="opacity-0 rounded-2xl border border-gray-100 overflow-hidden transition-all duration-300"
                             :class="open === {{ $i }} ? 'shadow-md border-[#7EC8A4]/30' : 'bg-white hover:border-[#7EC8A4]/20 hover:shadow-sm'"
                             style="animation-delay:{{ $i * 0.05 }}s">

                            <button @click="open = open === {{ $i }} ? null : {{ $i }}"
                                    class="w-full flex items-center gap-4 px-6 py-5 text-left transition-colors duration-200"
                                    :class="open === {{ $i }} ? 'bg-[#7EC8A4]/5' : 'bg-white'">

                                {{-- Number badge --}}
                                <span class="flex-shrink-0 w-8 h-8 rounded-xl flex items-center justify-center text-xs font-bold transition-all duration-300"
                                      :class="open === {{ $i }} ? 'bg-[#7EC8A4] text-white' : 'bg-gray-100 text-gray-400'">
                                    {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                                </span>

                                {{-- Question --}}
                                <span class="flex-1 font-semibold text-sm sm:text-base pr-2 transition-colors duration-200"
                                      :class="open === {{ $i }} ? 'text-[#7EC8A4]' : 'text-[#2D3748]'">
                                    {{ $question }}
                                </span>

                                {{-- Icon --}}
                                <span class="flex-shrink-0 w-8 h-8 rounded-xl flex items-center justify-center transition-all duration-300"
                                      :class="open === {{ $i }} ? 'bg-[#7EC8A4] text-white' : 'bg-gray-100 text-gray-400'">
                                    <svg class="w-4 h-4 transition-transform duration-300"
                                         :class="open === {{ $i }} ? 'rotate-180' : ''"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </span>
                            </button>

                            {{-- Answer --}}
                            <div x-show="open === {{ $i }}"
                                 x-collapse
                                 class="bg-[#7EC8A4]/5"
                                 style="display:none">
                                <div class="px-6 pb-6 pt-1">
                                    <div class="pl-12 text-gray-500 text-sm leading-relaxed border-l-2 border-[#7EC8A4]/30">
                                        {{ $answer }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>
    @endif

    {{-- ══════════════════════════════════════════════════════════
     CTA
══════════════════════════════════════════════════════════ --}}
    @php
        $ctaPhone = \App\Models\Setting::get('contact_phone', '');
        $ctaLocale = app()->getLocale();
    @endphp
    <section style="background:#ffffff; padding:64px 0 80px">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="reveal" x-intersect.once="$el.classList.add('in')">
                <div
                    style="background:linear-gradient(135deg,#7EC8A4 0%,#4ab882 100%); border-radius:28px; overflow:hidden; position:relative">
                    {{-- Decorative circles --}}
                    <div
                        style="position:absolute;top:-60px;right:-60px;width:240px;height:240px;border-radius:50%;background:rgba(255,255,255,.10);pointer-events:none">
                    </div>
                    <div
                        style="position:absolute;bottom:-40px;left:38%;width:160px;height:160px;border-radius:50%;background:rgba(255,255,255,.07);pointer-events:none">
                    </div>
                    <div
                        style="position:absolute;top:40%;left:-30px;width:90px;height:90px;border-radius:50%;background:rgba(255,255,255,.08);pointer-events:none">
                    </div>

                    <div
                        style="position:relative; padding:52px 48px; display:flex; flex-wrap:wrap; align-items:center; gap:40px; justify-content:space-between">

                        <div style="flex:1; min-width:240px">
                            <span
                                style="display:inline-block;background:rgba(255,255,255,.25);color:#fff;font-size:11px;font-weight:700;letter-spacing:.15em;text-transform:uppercase;padding:5px 12px;border-radius:20px;margin-bottom:20px">
                                DiDi
                            </span>
                            <h2
                                style="font-size:clamp(22px,3vw,34px);font-weight:800;color:#fff;line-height:1.2;letter-spacing:-.02em;margin:0 0 12px">
                                @if ($ctaLocale === 'kk')
                                    Балаңызды DiDi-ге жаздырыңыз
                                @elseif($ctaLocale === 'en')
                                    Enroll your child at DiDi
                                @else
                                    Запишите ребёнка в DiDi
                                @endif
                            </h2>
                            <p
                                style="color:rgba(255,255,255,.75);font-size:14px;line-height:1.65;margin:0 0 28px;max-width:300px">
                                @if ($ctaLocale === 'kk')
                                    Бізге хабарласыңыз — бос орын тексереміз
                                @elseif($ctaLocale === 'en')
                                    Contact us and we'll check availability
                                @else
                                    Свяжитесь с нами — проверим наличие мест
                                @endif
                            </p>
                            <div style="display:flex;flex-wrap:wrap;gap:12px">
                                <a href="{{ route('contact.index') }}"
                                    style="display:inline-flex;align-items:center;gap:8px;background:#fff;color:#2a8a5c;font-weight:700;font-size:14px;padding:13px 26px;border-radius:14px;text-decoration:none;transition:all .2s ease"
                                    onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px rgba(0,0,0,.12)'"
                                    onmouseout="this.style.transform='none';this.style.boxShadow='none'">
                                    @if ($ctaLocale === 'kk')
                                        Жазылу
                                    @elseif($ctaLocale === 'en')
                                        Enroll now
                                    @else
                                        Записаться
                                    @endif
                                    <svg width="15" height="15" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </a>
                                @if ($ctaPhone)
                                    <a href="tel:{{ preg_replace('/\D/', '', $ctaPhone) }}"
                                        style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.2);color:#fff;font-weight:600;font-size:14px;padding:12px 22px;border-radius:14px;text-decoration:none;border:1.5px solid rgba(255,255,255,.35);transition:all .2s ease"
                                        onmouseover="this.style.background='rgba(255,255,255,.3)';this.style.transform='translateY(-2px)'"
                                        onmouseout="this.style.background='rgba(255,255,255,.2)';this.style.transform='none'">
                                        <svg width="14" height="14" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        {{ $ctaPhone }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:12px">
                            @foreach ([['200+', $ctaLocale === 'kk' ? 'Тәрбиеленуші' : ($ctaLocale === 'en' ? 'Students' : 'Детей')], ['15+', $ctaLocale === 'kk' ? 'Педагог' : ($ctaLocale === 'en' ? 'Teachers' : 'Педагогов')], ['10', $ctaLocale === 'kk' ? 'Жыл' : ($ctaLocale === 'en' ? 'Years' : 'Лет')], ['3', $ctaLocale === 'kk' ? 'Тіл' : ($ctaLocale === 'en' ? 'Languages' : 'Языка')]] as [$n, $l])
                                <div
                                    style="background:rgba(255,255,255,.18);border:1px solid rgba(255,255,255,.25);border-radius:16px;padding:18px 20px;text-align:center;min-width:90px">
                                    <div style="font-size:24px;font-weight:800;color:#fff;line-height:1">
                                        {{ $n }}</div>
                                    <div style="font-size:11px;color:rgba(255,255,255,.7);margin-top:5px;font-weight:500">
                                        {{ $l }}</div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
