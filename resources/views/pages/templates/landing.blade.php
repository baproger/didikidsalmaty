{{-- Template 5: Landing — маркетинговая посадочная страница --}}
@extends('layouts.app')
@section('content')
@php
    $locale    = app()->getLocale();
    $pageTitle = $page->getTranslation('title',   $locale, false) ?: $page->getTranslation('title','ru',false);
    $excerpt   = $page->getTranslation('excerpt', $locale, false) ?: $page->getTranslation('excerpt','ru',false);
    $coverUrl  = $page->getFirstMediaUrl('featured');
    $content   = $page->getTranslation('content', $locale, false) ?: $page->getTranslation('content','ru',false);
    $blocks    = $page->blocks ?? [];
    $heroBlock = collect($blocks)->first(fn($b) => ($b['type'] ?? '') === 'hero');
@endphp

{{-- Hero section --}}
<div class="relative overflow-hidden pt-20"
     style="{{ $coverUrl ? 'background-image:url('.$coverUrl.');background-size:cover;background-position:center' : '' }}">
    @if($coverUrl)
    <div class="absolute inset-0 bg-gradient-to-br from-[#1a2535]/85 via-[#1a3a2a]/75 to-[#7EC8A4]/30"></div>
    @else
    <div class="absolute inset-0" style="background:linear-gradient(135deg,#e8f8f0 0%,#d4f0e4 35%,#f0f9f9 65%,#fff3e8 100%)"></div>
    @endif

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
        <div class="max-w-2xl">
            <div class="inline-flex items-center gap-2 {{ $coverUrl ? 'bg-white/20 text-white border-white/30' : 'bg-[#7EC8A4]/15 text-[#2d7a5a] border-[#7EC8A4]/40' }} text-xs font-bold px-4 py-2 rounded-full mb-6 border backdrop-blur-sm">
                <span class="w-1.5 h-1.5 rounded-full {{ $coverUrl ? 'bg-white' : 'bg-[#7EC8A4]' }} animate-pulse"></span>
                DiDi
            </div>
            <h1 class="text-4xl lg:text-6xl xl:text-7xl font-extrabold leading-tight mb-6 {{ $coverUrl ? 'text-white' : 'text-[#1a2535]' }}">
                {{ $pageTitle }}
            </h1>
            @if($excerpt)
            <p class="text-xl {{ $coverUrl ? 'text-white/80' : 'text-gray-500' }} mb-8 max-w-xl">{{ $excerpt }}</p>
            @endif
            <div class="flex flex-wrap gap-3">
                <a href="#content"
                   class="inline-flex items-center gap-2 bg-[#7EC8A4] hover:bg-[#5db389] text-white font-semibold px-7 py-3.5 rounded-full transition-all shadow-lg hover:shadow-[#7EC8A4]/40 hover:-translate-y-0.5">
                    @if($locale==='kk') Толығырақ @elseif($locale==='en') Learn more @else Узнать больше @endif
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </a>
                <a href="{{ \Illuminate\Support\Facades\URL::to('/contact') }}"
                   class="inline-flex items-center gap-2 {{ $coverUrl ? 'bg-white/20 text-white border-white/40 hover:bg-white/30' : 'bg-white text-[#1a2535] border-gray-200 hover:border-[#7EC8A4]' }} font-semibold px-7 py-3.5 rounded-full border transition-all backdrop-blur-sm">
                    @if($locale==='kk') Байланысу @elseif($locale==='en') Contact us @else Связаться @endif
                </a>
            </div>
        </div>
    </div>

    {{-- Wave divider --}}
    <div class="relative">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 60" class="w-full block" preserveAspectRatio="none" style="height:60px">
            <path fill="#f8faf9" d="M0,32 C360,60 1080,0 1440,32 L1440,60 L0,60 Z"/>
        </svg>
    </div>
</div>

{{-- Stats strip --}}
<div id="content" class="bg-[#f8faf9] py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            @php
                $stats = [
                    ['num' => '10+',  'ru' => 'лет опыта',          'kk' => 'жыл тәжірибе',   'en' => 'years of experience'],
                    ['num' => '200+', 'ru' => 'воспитанников',       'kk' => 'тәрбиеленуші',   'en' => 'students'],
                    ['num' => '30+',  'ru' => 'педагогов',           'kk' => 'педагог',         'en' => 'teachers'],
                    ['num' => '5★',   'ru' => 'рейтинг родителей',   'kk' => 'ата-ана рейтингі','en' => 'parent rating'],
                ];
            @endphp
            @foreach($stats as $s)
            <div class="bg-white rounded-2xl p-6 text-center shadow-sm hover:shadow-md transition-shadow">
                <div class="text-3xl font-extrabold text-[#7EC8A4] mb-1">{{ $s['num'] }}</div>
                <div class="text-sm text-gray-500">{{ $s[$locale] ?? $s['ru'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Blocks --}}
@include('pages._blocks', compact('locale','content') + ['blocks' => $blocks])

{{-- Bottom CTA strip --}}
<div class="bg-gradient-to-r from-[#1a3a2a] to-[#2d5440] py-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl lg:text-4xl font-extrabold text-white mb-4">
            @if($locale==='kk') Балаңызды DiDi-ге жазыңыз
            @elseif($locale==='en') Enroll your child in DiDi
            @else Запишите вашего ребёнка в DiDi
            @endif
        </h2>
        <p class="text-white/70 mb-8 text-lg">
            @if($locale==='kk') Бізге хабарласыңыз — бос орын тексереміз
            @elseif($locale==='en') Contact us — we'll check availability for you
            @else Свяжитесь с нами — проверим наличие мест
            @endif
        </p>
        <a href="{{ \Illuminate\Support\Facades\URL::to('/contact') }}"
           class="inline-flex items-center gap-2 bg-[#7EC8A4] hover:bg-[#5db389] text-white font-bold px-8 py-4 rounded-full transition-all shadow-xl hover:shadow-[#7EC8A4]/30 hover:-translate-y-0.5 text-lg">
            @if($locale==='kk') Қазір жазылу @elseif($locale==='en') Enroll now @else Записаться сейчас @endif
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
    </div>
</div>
@endsection
