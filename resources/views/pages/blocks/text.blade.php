@php
    $l      = app()->getLocale();
    $title   = $data['title_'.$l]   ?? $data['title_ru']   ?? '';
    $content = $data['content_'.$l] ?? $data['content_ru'] ?? '';
    $align   = $data['align'] ?? 'left';
    $centerClass = $align === 'center' ? 'text-center mx-auto' : '';
@endphp

<section class="py-14 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($title)
        <h2 class="text-2xl lg:text-3xl font-extrabold font-sans text-[#2D3748] mb-6 {{ $centerClass }}">
            {{ $title }}
        </h2>
        @endif
        @if($content)
        <div class="prose prose-lg max-w-none text-gray-600 leading-relaxed {{ $centerClass }}
                    prose-headings:text-[#2D3748] prose-a:text-[#7EC8A4] prose-strong:text-[#2D3748]">
            {!! $content !!}
        </div>
        @endif
    </div>
</section>
