@php
    $l     = app()->getLocale();
    $cols  = (int) ($data['cols'] ?? 2);
    $items = $data['items'] ?? [];
    $gridClass = match($cols) {
        3       => 'lg:grid-cols-3',
        default => 'lg:grid-cols-2',
    };
@endphp

<section class="py-16 bg-[#FAFAF8]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid sm:grid-cols-2 {{ $gridClass }} gap-8">
            @foreach($items as $i => $item)
            @php
                $title   = $item['title_'.$l]   ?? $item['title_ru']   ?? '';
                $text    = $item['text_'.$l]     ?? $item['text_ru']    ?? '';
                $btnText = $item['btn_text_'.$l] ?? $item['btn_text_ru'] ?? '';
                $btnUrl  = $item['btn_url']      ?? '';
                $image   = $item['image']        ?? '';
            @endphp
            <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="opacity-0 bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1"
                 style="animation-delay:{{ $i * 0.1 }}s">
                @if($image)
                <div class="overflow-hidden" style="aspect-ratio:16/9">
                    <img src="{{ Storage::disk('public')->url($image) }}" alt="{{ $title }}"
                         class="w-full h-full object-cover">
                </div>
                @endif
                <div class="p-7">
                    @if($title)
                    <h3 class="text-xl font-bold text-[#2D3748] font-sans mb-3">{{ $title }}</h3>
                    @endif
                    @if($text)
                    <p class="text-gray-500 text-sm leading-relaxed mb-5">{{ $text }}</p>
                    @endif
                    @if($btnText && $btnUrl)
                    <a href="{{ $btnUrl }}"
                       class="inline-flex items-center gap-2 bg-[#7EC8A4]/10 hover:bg-[#7EC8A4] text-[#7EC8A4] hover:text-white font-semibold px-5 py-2.5 rounded-xl transition-all duration-200 text-sm">
                        {{ $btnText }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
