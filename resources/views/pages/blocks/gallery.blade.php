@php
    $l      = app()->getLocale();
    $title  = $data['title_'.$l] ?? $data['title_ru'] ?? '';
    $images = $data['images'] ?? [];
    if (!is_array($images)) $images = [];
@endphp

<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($title)
        <h2 class="text-2xl lg:text-3xl font-extrabold font-sans text-[#2D3748] mb-10 text-center">{{ $title }}</h2>
        @endif

        <div class="columns-2 sm:columns-3 lg:columns-4 gap-4 space-y-4">
            @foreach($images as $i => $img)
            @php $url = is_string($img) ? Storage::disk('public')->url($img) : ''; @endphp
            @if($url)
            <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="opacity-0 break-inside-avoid"
                 style="animation-delay:{{ $i * 0.05 }}s">
                <img src="{{ $url }}" alt=""
                     class="w-full rounded-2xl shadow-sm hover:shadow-lg hover:scale-[1.02] transition-all duration-300 cursor-zoom-in"
                     onclick="this.closest('section').querySelector('.lightbox')?.remove(); const lb=document.createElement('div'); lb.className='lightbox fixed inset-0 bg-black/90 z-50 flex items-center justify-center p-4 cursor-pointer'; lb.onclick=()=>lb.remove(); const img=document.createElement('img'); img.src=this.src; img.className='max-h-[90vh] max-w-full rounded-2xl'; lb.appendChild(img); this.closest('section').appendChild(lb)">
            </div>
            @endif
            @endforeach
        </div>
    </div>
</section>
