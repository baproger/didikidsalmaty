@extends('layouts.app')

@section('content')
<div class="pt-28 pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="text-center mb-12">
            <h1 class="text-3xl lg:text-5xl font-extrabold font-sans text-[#2D3748] mb-4">{{ __('nav.blog') }}</h1>
        </div>

        {{-- Category filter --}}
        @if($categories->count())
        <div class="flex flex-wrap gap-2 justify-center mb-10">
            <a href="{{ route('blog.index') }}"
               class="px-5 py-2 rounded-full text-sm font-semibold transition-all {{ !isset($category) ? 'bg-[#7EC8A4] text-white' : 'bg-gray-100 text-gray-600 hover:bg-[#7EC8A4]/10' }}">
               Все
            </a>
            @foreach($categories as $cat)
            <a href="{{ route('blog.category', $cat->slug) }}"
               class="px-5 py-2 rounded-full text-sm font-semibold transition-all {{ (isset($category) && $category->id === $cat->id) ? 'bg-[#7EC8A4] text-white' : 'bg-gray-100 text-gray-600 hover:bg-[#7EC8A4]/10' }}">
               {{ $cat->name }}
            </a>
            @endforeach
        </div>
        @endif

        {{-- Posts grid --}}
        @if($posts->count())
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($posts as $post)
            <article class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                @if($post->getFirstMediaUrl('featured'))
                <img src="{{ $post->getFirstMediaUrl('featured', 'thumb') }}" alt="{{ $post->title }}"
                     class="w-full h-52 object-cover" loading="lazy">
                @else
                <div class="w-full h-52 bg-gradient-to-br from-[#7EC8A4]/20 to-[#A8DADC]/20 flex items-center justify-center">
                    <span class="text-5xl">📰</span>
                </div>
                @endif
                <div class="p-6">
                    @if($post->category)
                    <span class="text-xs font-bold text-[#7EC8A4] uppercase tracking-wider">{{ $post->category->name }}</span>
                    @endif
                    <h2 class="font-bold text-[#2D3748] mt-2 mb-3 font-sans text-lg leading-snug">
                        <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-[#7EC8A4] transition-colors">
                            {{ $post->title }}
                        </a>
                    </h2>
                    <p class="text-gray-400 text-sm line-clamp-2 mb-4">{{ $post->excerpt }}</p>
                    <div class="flex items-center justify-between text-xs text-gray-400">
                        <time>{{ $post->published_at?->format('d.m.Y') }}</time>
                        <a href="{{ route('blog.show', $post->slug) }}" class="font-semibold text-[#7EC8A4] hover:underline">{{ __('nav.read_more') }} →</a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        <div class="mt-10">{{ $posts->links() }}</div>
        @else
        <div class="text-center py-24 text-gray-400">
            <div class="text-6xl mb-4">📭</div>
            <p>Новостей пока нет.</p>
        </div>
        @endif
    </div>
</div>
@endsection
