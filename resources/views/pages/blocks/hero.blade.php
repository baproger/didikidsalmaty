@php
    $l        = app()->getLocale();
    $title    = $data['title_'.$l]    ?? $data['title_ru']    ?? '';
    $subtitle = $data['subtitle_'.$l] ?? $data['subtitle_ru'] ?? '';
    $btnText  = $data['btn_text_'.$l] ?? $data['btn_text_ru'] ?? '';
    $btnUrl   = $data['btn_url_'.$l] ?? $data['btn_url_ru'] ?? $data['btn_url'] ?? '';
    $image    = $data['image']        ?? '';
    $style    = $data['style']        ?? 'green';

    $bg = match($style) {
        'dark'  => 'background:#2D3748',
        'light' => 'background:#FAFAF8',
        default => 'background:linear-gradient(135deg,#e8f8f0 0%,#f0f9f9 40%,#fff3e8 100%)',
    };
    $textColor = $style === 'dark' ? 'text-white' : 'text-[#2D3748]';
    $subColor  = $style === 'dark' ? 'text-gray-300' : 'text-gray-500';
@endphp

<section class="py-20 overflow-hidden" style="{{ $bg }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid {{ $image ? 'lg:grid-cols-2' : 'lg:grid-cols-1' }} gap-12 items-center">
            <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="opacity-0">
                @if($title)
                <h1 class="text-3xl lg:text-5xl font-extrabold font-sans {{ $textColor }} leading-tight mb-5">
                    {{ $title }}
                </h1>
                @endif
                @if($subtitle)
                <p class="text-lg {{ $subColor }} mb-8 max-w-xl leading-relaxed">{{ $subtitle }}</p>
                @endif
                @if($btnText && $btnUrl)
                <a href="{{ $btnUrl }}"
                   class="inline-flex items-center gap-2 bg-[#7EC8A4] hover:bg-[#68b892] text-white font-bold px-7 py-3.5 rounded-2xl transition-all duration-200 shadow-lg hover:-translate-y-0.5">
                    {{ $btnText }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
                @endif
            </div>
            @if($image)
            <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="opacity-0 [animation-delay:0.2s] flex justify-center">
                <img src="{{ Storage::disk('public')->url($image) }}" alt="{{ $title }}"
                     class="rounded-3xl shadow-2xl max-h-[500px] w-full object-cover">
            </div>
            @endif
        </div>
    </div>
</section>
