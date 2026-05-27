@extends('layouts.app')

@section('content')
<div class="pt-28 pb-20" x-data="lightbox()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-12">
            <h1 class="text-3xl lg:text-5xl font-extrabold font-sans text-[#2D3748] mb-4">{{ __('nav.gallery') }}</h1>
        </div>

        @forelse($galleries as $gallery)
        <div class="mb-16">
            <h2 class="text-xl font-bold font-sans text-[#2D3748] mb-6">{{ $gallery->title }}</h2>
            @php $images = $gallery->getMedia('images'); @endphp
            @if($images->count())
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                @foreach($images as $media)
                <button
                    @click="openImage('{{ $media->getUrl() }}', {{ json_encode($images->map(fn($m) => $m->getUrl())->values()) }})"
                    class="group relative aspect-square overflow-hidden rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300"
                >
                    <img src="{{ $media->getUrl('thumb') }}"
                         alt="{{ $gallery->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                         loading="lazy">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300 flex items-center justify-center">
                        <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                        </svg>
                    </div>
                </button>
                @endforeach
            </div>
            @endif
        </div>
        @empty
        <div class="text-center py-24 text-gray-400">
            <div class="text-6xl mb-4">🖼️</div>
            <p>Фотографии скоро появятся.</p>
        </div>
        @endforelse
    </div>

    {{-- Lightbox --}}
    <div x-show="open" x-transition.opacity
         class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center p-4"
         @keydown.escape.window="close()"
         @click.self="close()">
        <button @click="close()" class="absolute top-4 right-4 text-white/70 hover:text-white">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <button @click="prev()" class="absolute left-4 text-white/70 hover:text-white">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <img :src="current" class="max-h-[85vh] max-w-[90vw] object-contain rounded-2xl shadow-2xl">
        <button @click="next()" class="absolute right-4 text-white/70 hover:text-white">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
    </div>
</div>
@endsection
