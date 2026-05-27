{{-- Template 3: Hero — полноэкранная шапка с фото --}}
@extends('layouts.app')
@section('content')
@php
    $locale    = app()->getLocale();
    $pageTitle = $page->getTranslation('title',   $locale, false) ?: $page->getTranslation('title','ru',false);
    $excerpt   = $page->getTranslation('excerpt', $locale, false) ?: $page->getTranslation('excerpt','ru',false);
    $coverUrl  = $page->getFirstMediaUrl('featured');
    $content   = $page->getTranslation('content', $locale, false) ?: $page->getTranslation('content','ru',false);
@endphp

{{-- Full-screen hero --}}
<div class="relative min-h-[70vh] flex items-end overflow-hidden"
     style="{{ $coverUrl ? 'background-image:url('.$coverUrl.');background-size:cover;background-position:center' : 'background:linear-gradient(135deg,#1a3a2a,#2d5440)' }}">
    <div class="absolute inset-0 bg-gradient-to-b from-black/20 via-black/30 to-black/80"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-14 pt-32 w-full">
        <span class="inline-flex items-center gap-2 bg-[#7EC8A4]/20 backdrop-blur-sm text-[#7EC8A4] text-xs font-bold px-4 py-2 rounded-full mb-5 border border-[#7EC8A4]/30">
            <span class="w-1.5 h-1.5 rounded-full bg-[#7EC8A4] animate-pulse"></span>DiDi
        </span>
        <h1 class="text-4xl lg:text-6xl xl:text-7xl font-extrabold text-white leading-tight mb-4 max-w-3xl">{{ $pageTitle }}</h1>
        @if($excerpt)<p class="text-white/70 text-xl max-w-xl">{{ $excerpt }}</p>@endif
    </div>
</div>

@include('pages._blocks', compact('locale','content') + ['blocks' => $page->blocks ?? []])
@endsection
