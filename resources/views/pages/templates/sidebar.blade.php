{{-- Template 4: Sidebar — контент + боковое оглавление --}}
@extends('layouts.app')
@section('content')
@php
    $locale    = app()->getLocale();
    $pageTitle = $page->getTranslation('title',   $locale, false) ?: $page->getTranslation('title','ru',false);
    $excerpt   = $page->getTranslation('excerpt', $locale, false) ?: $page->getTranslation('excerpt','ru',false);
    $coverUrl  = $page->getFirstMediaUrl('featured');
    $content   = $page->getTranslation('content', $locale, false) ?: $page->getTranslation('content','ru',false);
    $blocks    = $page->blocks ?? [];
    $navBlocks = collect($blocks)->filter(fn($b) => !empty($b['data']['title_'.$locale] ?? $b['data']['title_ru'] ?? ''));
@endphp

<div class="bg-white pt-24 pb-8 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl lg:text-4xl font-extrabold text-[#1a2535] mb-2">{{ $pageTitle }}</h1>
        @if($excerpt)<p class="text-gray-400 text-lg">{{ $excerpt }}</p>@endif
    </div>
</div>

<div class="bg-[#f8faf9] py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-[240px,1fr] lg:gap-10">

            {{-- Sidebar --}}
            <aside class="hidden lg:block">
                <div class="sticky top-24 bg-white rounded-2xl p-5 shadow-sm">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">
                        @if($locale==='kk') Мазмұны @elseif($locale==='en') Contents @else Содержание @endif
                    </p>
                    @if($coverUrl)
                    <div class="rounded-xl overflow-hidden mb-4" style="max-height:140px">
                        <img src="{{ $coverUrl }}" alt="{{ $pageTitle }}" class="w-full h-full object-cover">
                    </div>
                    @endif
                    <nav class="space-y-1">
                        @foreach($navBlocks as $i => $b)
                        @php $t = $b['data']['title_'.$locale] ?? $b['data']['title_ru'] ?? ''; @endphp
                        @if($t)
                        <a href="#block-{{ $i }}"
                           class="block px-3 py-2 rounded-xl text-sm text-gray-500 hover:text-[#7EC8A4] hover:bg-[#7EC8A4]/8 transition-colors">
                            {{ Str::limit($t, 36) }}
                        </a>
                        @endif
                        @endforeach
                    </nav>
                </div>
            </aside>

            {{-- Content --}}
            <main>
                @foreach($blocks as $i => $block)
                @php $bType = $block['type'] ?? ''; $bData = $block['data'] ?? []; @endphp
                <div id="block-{{ $i }}">
                    @if($bType && \Illuminate\Support\Facades\View::exists('pages.blocks.'.$bType))
                        @include('pages.blocks.'.$bType, ['data' => $bData])
                    @endif
                </div>
                @endforeach

                @if(empty($blocks) && $content)
                <div class="bg-white rounded-3xl p-8 shadow-sm">
                    <div class="prose prose-lg max-w-none text-gray-600 prose-headings:text-[#2D3748] prose-a:text-[#7EC8A4]">
                        {!! $content !!}
                    </div>
                </div>
                @endif
            </main>
        </div>
    </div>
</div>
@endsection
