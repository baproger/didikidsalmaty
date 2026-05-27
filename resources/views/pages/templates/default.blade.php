{{-- Template 1: Default — заголовок + блоки --}}
@extends('layouts.app')
@section('content')
@php
    $locale    = app()->getLocale();
    $pageTitle = $page->getTranslation('title',   $locale, false) ?: $page->getTranslation('title','ru',false);
    $excerpt   = $page->getTranslation('excerpt', $locale, false) ?: $page->getTranslation('excerpt','ru',false);
    $coverUrl  = $page->getFirstMediaUrl('featured');
    $hasCover  = collect($page->blocks ?? [])->contains(fn($b) => ($b['type']??'') === 'hero');
    $content   = $page->getTranslation('content', $locale, false) ?: $page->getTranslation('content','ru',false);
@endphp

<div class="pt-20" style="background:linear-gradient(135deg,#e8f8f0 0%,#f0f9f9 40%,#fff3e8 100%)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-center">
        <div class="inline-flex items-center gap-2 bg-white/70 text-[#7EC8A4] text-xs font-bold px-4 py-2 rounded-full mb-5 border border-[#7EC8A4]/30">
            <span class="w-2 h-2 rounded-full bg-[#7EC8A4] animate-pulse"></span>DiDi
        </div>
        <h1 class="text-3xl lg:text-5xl font-extrabold text-[#2D3748] mb-4">{{ $pageTitle }}</h1>
        @if($excerpt)<p class="text-gray-400 max-w-xl mx-auto text-lg">{{ $excerpt }}</p>@endif
    </div>
</div>

@if(!$hasCover && $coverUrl)
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="rounded-3xl overflow-hidden shadow-xl" style="max-height:500px">
        <img src="{{ $coverUrl }}" alt="{{ $pageTitle }}" class="w-full h-full object-cover">
    </div>
</div>
@endif

@include('pages._blocks', compact('locale','content') + ['blocks' => $page->blocks ?? []])
@endsection
