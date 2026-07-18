@php
    $l     = app()->getLocale();
    $title = $data['title_'.$l] ?? $data['title_ru'] ?? '';
    $items = $data['items'] ?? [];
@endphp

@if(!empty($items))
<section class="py-16 bg-[#FAFAF8]">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($title)
        <h2 class="text-2xl lg:text-3xl font-extrabold font-sans text-[#2D3748] mb-10 text-center">{{ $title }}</h2>
        @endif

        <div class="space-y-6">
            @foreach($items as $i => $item)
            @php
                $nTitle = $item['title_'.$l] ?? $item['title_ru'] ?? '';
                $nText  = $item['text_'.$l]  ?? $item['text_ru']  ?? '';
                $image  = $item['image']     ?? '';
                $link   = $item['link']      ?? '';
                $date   = '';
                if (!empty($item['date'])) {
                    try { $date = \Carbon\Carbon::parse($item['date'])->translatedFormat('d F Y'); }
                    catch (\Throwable $e) { $date = $item['date']; }
                }
            @endphp
            <article x-data x-intersect.once="$el.classList.add('animate-fade-in-up')"
                     class="opacity-0 bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 sm:flex"
                     style="animation-delay:{{ $i * 0.08 }}s">
                @if($image)
                <div class="sm:w-64 lg:w-72 shrink-0 overflow-hidden">
                    <img src="{{ Storage::disk('public')->url($image) }}" alt="{{ $nTitle }}"
                         class="w-full h-48 sm:h-full object-cover">
                </div>
                @endif
                <div class="p-6 lg:p-7 flex-1">
                    @if($date)
                    <span class="inline-block bg-[#7EC8A4]/10 text-[#7EC8A4] text-xs font-semibold px-3 py-1 rounded-full mb-3">{{ $date }}</span>
                    @endif
                    @if($nTitle)
                    <h3 class="text-lg lg:text-xl font-bold text-[#2D3748] font-sans mb-2">
                        @if($link)
                        <a href="{{ $link }}" class="hover:text-[#7EC8A4] transition-colors">{{ $nTitle }}</a>
                        @else
                        {{ $nTitle }}
                        @endif
                    </h3>
                    @endif
                    @if($nText)
                    <p class="text-gray-500 text-sm leading-relaxed whitespace-pre-line">{{ $nText }}</p>
                    @endif
                    @if($link)
                    <a href="{{ $link }}"
                       class="inline-flex items-center gap-2 text-[#7EC8A4] font-semibold text-sm mt-4 hover:gap-3 transition-all">
                        {{ ['ru' => 'Подробнее', 'kk' => 'Толығырақ', 'en' => 'Read more'][$l] ?? 'Подробнее' }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    @endif
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif
