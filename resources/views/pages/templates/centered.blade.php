{{-- Template 2: Centered — узкая колонка, журнальный стиль --}}
@extends('layouts.app')
@section('content')
@php
    $locale    = app()->getLocale();
    $pageTitle = $page->getTranslation('title',   $locale, false) ?: $page->getTranslation('title','ru',false);
    $excerpt   = $page->getTranslation('excerpt', $locale, false) ?: $page->getTranslation('excerpt','ru',false);
    $coverUrl  = $page->getFirstMediaUrl('featured');
    $content   = $page->getTranslation('content', $locale, false) ?: $page->getTranslation('content','ru',false);
@endphp

<div class="bg-white pt-24 pb-10">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        @if($excerpt)
        <p class="text-[#7EC8A4] text-sm font-bold uppercase tracking-[0.2em] mb-4">{{ $excerpt }}</p>
        @endif
        <h1 class="text-4xl lg:text-6xl font-extrabold text-[#1a2535] leading-tight mb-6">{{ $pageTitle }}</h1>
        <div class="w-12 h-1 bg-[#7EC8A4] rounded-full mx-auto"></div>
    </div>
</div>

@if($coverUrl)
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-2 mb-12">
    <div class="rounded-3xl overflow-hidden shadow-2xl" style="max-height:480px">
        <img src="{{ $coverUrl }}" alt="{{ $pageTitle }}" class="w-full h-full object-cover">
    </div>
</div>
@endif

@include('pages._blocks', compact('locale','content') + ['blocks' => $page->blocks ?? []])
@endsection
