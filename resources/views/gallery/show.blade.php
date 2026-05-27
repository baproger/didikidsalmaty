@extends('layouts.app')
@section('content')
<div class="pt-28 pb-20">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-3xl font-extrabold font-sans text-[#2D3748] mb-8">{{ $gallery->title }}</h1>
        @php $images = $gallery->getMedia('images'); @endphp
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
            @foreach($images as $media)
            <div class="aspect-square overflow-hidden rounded-2xl shadow-sm">
                <img src="{{ $media->getUrl('thumb') }}" alt="{{ $gallery->title }}"
                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" loading="lazy">
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
