{{-- Shared partial: рендер блоков конструктора --}}
@php $locale = $locale ?? app()->getLocale(); @endphp

@if(!empty($blocks))
    @foreach($blocks as $block)
        @php $bType = $block['type'] ?? ''; $bData = $block['data'] ?? []; @endphp
        @if($bType && \Illuminate\Support\Facades\View::exists('pages.blocks.'.$bType))
            @include('pages.blocks.'.$bType, ['data' => $bData])
        @endif
    @endforeach
@elseif(!empty($content))
    <section class="py-14 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="prose prose-lg max-w-none text-gray-600 prose-headings:text-[#2D3748] prose-a:text-[#7EC8A4]">
                {!! $content !!}
            </div>
        </div>
    </section>
@endif
