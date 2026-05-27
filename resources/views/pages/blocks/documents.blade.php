@php
    $l     = app()->getLocale();
    $title = $data['title_'.$l] ?? $data['title_ru'] ?? '';
    $files = $data['files'] ?? [];

    $icons = [
        'pdf'  => ['icon' => '📄', 'color' => 'text-red-500',  'bg' => 'bg-red-50'],
        'doc'  => ['icon' => '📝', 'color' => 'text-blue-500', 'bg' => 'bg-blue-50'],
        'docx' => ['icon' => '📝', 'color' => 'text-blue-500', 'bg' => 'bg-blue-50'],
        'xls'  => ['icon' => '📊', 'color' => 'text-green-600','bg' => 'bg-green-50'],
        'xlsx' => ['icon' => '📊', 'color' => 'text-green-600','bg' => 'bg-green-50'],
    ];
@endphp

<section class="py-14 bg-[#FAFAF8]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($title)
        <h2 class="text-2xl font-extrabold font-sans text-[#2D3748] mb-8">{{ $title }}</h2>
        @endif

        <div class="space-y-3">
            @foreach($files as $i => $file)
            @php
                $name  = $file['name_'.$l] ?? $file['name_ru'] ?? '';
                $path  = $file['file'] ?? '';
                $ext   = $path ? strtolower(pathinfo($path, PATHINFO_EXTENSION)) : '';
                $meta  = $icons[$ext] ?? ['icon' => '📎', 'color' => 'text-gray-500', 'bg' => 'bg-gray-50'];
                $url   = $path ? Storage::disk('public')->url($path) : '';
                $size  = $path && Storage::disk('public')->exists($path)
                    ? round(Storage::disk('public')->size($path) / 1024) . ' KB'
                    : '';
            @endphp
            @if($url)
            <a href="{{ $url }}" download target="_blank"
               class="flex items-center gap-4 bg-white rounded-2xl px-6 py-4 shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-0.5 group">
                <div class="w-12 h-12 {{ $meta['bg'] }} rounded-xl flex items-center justify-center text-2xl flex-shrink-0">
                    {{ $meta['icon'] }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-semibold text-[#2D3748] group-hover:text-[#7EC8A4] transition-colors truncate">
                        {{ $name ?: strtoupper($ext).' файл' }}
                    </div>
                    @if($size)
                    <div class="text-xs text-gray-400 mt-0.5">{{ strtoupper($ext) }} · {{ $size }}</div>
                    @endif
                </div>
                <svg class="w-5 h-5 text-gray-300 group-hover:text-[#7EC8A4] transition-colors flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
            </a>
            @endif
            @endforeach
        </div>
    </div>
</section>
