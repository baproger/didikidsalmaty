@extends('layouts.app')

@section('content')
<div class="pt-28 pb-20">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        @if($post->category)
        <a href="{{ route('blog.category', $post->category->slug) }}"
           class="inline-block text-xs font-bold text-[#7EC8A4] uppercase tracking-widest mb-4 hover:underline">
            ← {{ $post->category->name }}
        </a>
        @endif

        <h1 class="text-3xl lg:text-4xl font-extrabold font-sans text-[#2D3748] mb-4 leading-tight">
            {{ $post->title }}
        </h1>

        <div class="flex items-center gap-4 text-sm text-gray-400 mb-8">
            @if($post->published_at)
            <time>{{ $post->published_at->format('d.m.Y') }}</time>
            @endif
        </div>

        @if($post->getFirstMediaUrl('featured'))
        <img src="{{ $post->getFirstMediaUrl('featured') }}" alt="{{ $post->title }}"
             class="w-full h-72 lg:h-96 object-cover rounded-3xl mb-10 shadow-lg">
        @endif

        <div class="prose prose-lg max-w-none text-gray-600 leading-relaxed">
            {!! $post->getTranslation('content', app()->getLocale()) !!}
        </div>

        @if($related->count())
        <div class="mt-16 pt-10 border-t border-gray-100">
            <h3 class="font-bold text-xl font-sans text-[#2D3748] mb-6">{{ __('nav.other_news') }}</h3>
            <div class="grid md:grid-cols-3 gap-4">
                @foreach($related as $rel)
                <a href="{{ route('blog.show', $rel->slug) }}"
                   class="bg-[#7EC8A4]/10 rounded-2xl p-4 hover:bg-[#7EC8A4]/20 transition-colors">
                    <h4 class="font-semibold text-sm text-[#2D3748] leading-snug">{{ $rel->title }}</h4>
                    <time class="text-xs text-gray-400 mt-1 block">{{ $rel->published_at?->format('d.m.Y') }}</time>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
