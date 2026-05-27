@php
    $l        = app()->getLocale();
    $title    = $data['title_'.$l]    ?? $data['title_ru']    ?? '';
    $subtitle = $data['subtitle_'.$l] ?? $data['subtitle_ru'] ?? '';
    $btn1     = $data['btn_text_'.$l] ?? $data['btn_text_ru'] ?? '';
    $btn2     = $data['btn2_text_'.$l] ?? $data['btn2_text_ru'] ?? '';
    $url1     = $data['btn_url']  ?? '';
    $url2     = $data['btn2_url'] ?? '';
    $style    = $data['style'] ?? 'gradient';

    $bg = match($style) {
        'dark'  => 'background:#2D3748',
        'green' => 'background:linear-gradient(135deg,#7EC8A4,#68b892)',
        default => 'background:linear-gradient(135deg,#e8f8f0 0%,#f0f9f9 40%,#fff3e8 100%)',
    };
    $textColor  = in_array($style, ['dark','green']) ? 'text-white' : 'text-[#2D3748]';
    $subColor   = in_array($style, ['dark','green']) ? 'text-white/80' : 'text-gray-500';
    $btn1Class  = in_array($style, ['dark','green'])
        ? 'bg-white text-[#2D3748] hover:bg-gray-100'
        : 'bg-[#2D3748] text-white hover:bg-[#3d4a5c]';
    $btn2Class  = in_array($style, ['dark','green'])
        ? 'bg-white/20 text-white hover:bg-white/30 border border-white/40'
        : 'bg-[#7EC8A4] text-white hover:bg-[#68b892]';
@endphp

<section class="py-20" style="{{ $bg }}">
    <div class="max-w-3xl mx-auto px-4 text-center" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="opacity-0">
        @if($title)
        <h2 class="text-3xl lg:text-4xl font-extrabold font-sans {{ $textColor }} mb-4">{{ $title }}</h2>
        @endif
        @if($subtitle)
        <p class="{{ $subColor }} mb-10 text-lg max-w-xl mx-auto">{{ $subtitle }}</p>
        @endif
        @if($btn1 || $btn2)
        <div class="flex flex-wrap gap-4 justify-center">
            @if($btn1 && $url1)
            <a href="{{ $url1 }}"
               class="inline-flex items-center gap-2 {{ $btn1Class }} font-bold px-8 py-4 rounded-2xl transition-all duration-200 shadow-lg hover:-translate-y-0.5">
                {{ $btn1 }}
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            @endif
            @if($btn2 && $url2)
            <a href="{{ $url2 }}"
               class="inline-flex items-center gap-2 {{ $btn2Class }} font-bold px-8 py-4 rounded-2xl transition-all duration-200 hover:-translate-y-0.5">
                {{ $btn2 }}
            </a>
            @endif
        </div>
        @endif
    </div>
</section>
