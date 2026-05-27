@extends('layouts.app')

@push('styles')
<style>
.reveal {
    opacity: 0;
    transform: translateY(22px);
    transition: opacity .6s cubic-bezier(.16,1,.3,1), transform .6s cubic-bezier(.16,1,.3,1);
}
.reveal.in { opacity: 1; transform: translateY(0); }

.tc {
    display: block;
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 1px 8px rgba(0,0,0,.06);
    text-decoration: none;
    transition: transform .38s cubic-bezier(.16,1,.3,1), box-shadow .38s cubic-bezier(.16,1,.3,1);
    will-change: transform;
}
.tc:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 44px rgba(0,0,0,.09);
}
.tc-img {
    overflow: hidden;
    aspect-ratio: 4/5;
    background: linear-gradient(135deg,#e8f6ee,#d5ecdf);
}
.tc-img img {
    width: 100%; height: 100%;
    object-fit: cover; object-position: top;
    display: block;
    transition: transform .6s cubic-bezier(.16,1,.3,1);
}
.tc:hover .tc-img img { transform: scale(1.04); }

.tc-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:24px; }
@media (max-width:1023px) { .tc-grid { grid-template-columns:repeat(3,1fr); } }
@media (max-width:639px)  { .tc-grid { grid-template-columns:repeat(2,1fr); } }
</style>
@endpush

@section('content')
@php $locale = app()->getLocale(); @endphp

{{-- ─── HEADER ────────────────────────────────────────────────────── --}}
<div style="background:#ffffff; padding: 96px 0 52px">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="reveal" x-intersect.once="$el.classList.add('in')">
            <p style="color:#7EC8A4; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.18em; margin-bottom:16px">
                @if($locale==='kk') Команда @elseif($locale==='en') Team @else Команда @endif
            </p>
            <div style="display:flex; flex-wrap:wrap; align-items:flex-end; justify-content:space-between; gap:12px">
                <h1 style="font-size:clamp(32px,5vw,52px); font-weight:800; color:#1a2535; line-height:1.05; letter-spacing:-.02em; margin:0">
                    @if($locale==='kk') Біздің педагогтар
                    @elseif($locale==='en') Our Teachers
                    @else Наши педагоги
                    @endif
                </h1>
                @if($teachers->count())
                <p style="color:#9ca3af; font-size:14px; max-width:260px; line-height:1.6; margin:0">
                    @if($locale==='kk') {{ $teachers->count() }} маман
                    @elseif($locale==='en') {{ $teachers->count() }} professionals
                    @else {{ $teachers->count() }} специалистов
                    @endif
                </p>
                @endif
            </div>
        </div>
    </div>
</div>

@if($teachers->count())

{{-- ─── GRID ──────────────────────────────────────────────────────── --}}
<section style="background:#f8faf9; padding:48px 0 80px">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="tc-grid">

            @foreach($teachers as $i => $teacher)
            @php
                $thumb  = $teacher->getFirstMediaUrl('photo','thumb') ?: $teacher->getFirstMediaUrl('photo');
                $tName  = $teacher->getTranslation('name', $locale, false) ?: $teacher->getTranslation('name', 'ru', false);
                $tPos   = $teacher->getTranslation('position', $locale, false) ?: $teacher->getTranslation('position', 'ru', false);
                $subj   = $teacher->getTranslation('subjects', $locale, false) ?: $teacher->getTranslation('subjects', 'ru', false);
                $delay  = ($i % 4) * 70;
            @endphp

            <div class="reveal" x-intersect.once="$el.classList.add('in')" style="transition-delay:{{ $delay }}ms">
                <a href="{{ route('teachers.show', $teacher) }}" class="tc">

                    {{-- Photo --}}
                    <div class="tc-img">
                        @if($thumb)
                            <img src="{{ $thumb }}" alt="{{ $tName }}" loading="lazy">
                        @else
                            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;aspect-ratio:4/5">
                                <svg style="width:44px;height:44px;opacity:.22;color:#7EC8A4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div style="padding:14px 16px 16px">
                        <p style="font-weight:700; color:#1a2535; font-size:14px; line-height:1.3; margin:0 0 4px">{{ $tName }}</p>
                        @if($tPos)
                        <p style="font-size:12px; color:#7EC8A4; font-weight:500; margin:0; overflow:hidden; text-overflow:ellipsis; white-space:nowrap">{{ $tPos }}</p>
                        @elseif($subj)
                        <p style="font-size:12px; color:#9ca3af; margin:0; overflow:hidden; text-overflow:ellipsis; white-space:nowrap">{{ $subj }}</p>
                        @endif
                    </div>

                </a>
            </div>
            @endforeach

        </div>

    </div>
</section>

@else

<section style="background:#f8faf9; padding:120px 0; text-align:center">
    <p style="color:#d1d5db; font-size:14px">
        @if($locale==='kk') Жақында қосылады @elseif($locale==='en') Coming soon @else Скоро появятся @endif
    </p>
</section>

@endif

{{-- ─── CTA ────────────────────────────────────────────────────────── --}}
<section style="background:#ffffff; padding:64px 0 80px">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="reveal" x-intersect.once="$el.classList.add('in')">

            <div style="background:linear-gradient(135deg, #7EC8A4 0%, #4ab882 100%); border-radius:28px; overflow:hidden; position:relative">

                {{-- Decorative circles --}}
                <div style="position:absolute;top:-60px;right:-60px;width:240px;height:240px;border-radius:50%;background:rgba(255,255,255,.10);pointer-events:none"></div>
                <div style="position:absolute;bottom:-40px;left:38%;width:160px;height:160px;border-radius:50%;background:rgba(255,255,255,.07);pointer-events:none"></div>
                <div style="position:absolute;top:40%;left:-30px;width:90px;height:90px;border-radius:50%;background:rgba(255,255,255,.08);pointer-events:none"></div>

                <div style="position:relative; padding:52px 48px; display:flex; flex-wrap:wrap; align-items:center; gap:40px; justify-content:space-between">

                    {{-- Left: text --}}
                    <div style="flex:1; min-width:240px">
                        <span style="display:inline-block; background:rgba(255,255,255,.25); color:#fff; font-size:11px; font-weight:700; letter-spacing:.15em; text-transform:uppercase; padding:5px 12px; border-radius:20px; margin-bottom:20px">
                            DiDi Kindergarten
                        </span>
                        <h2 style="font-size:clamp(22px,3vw,34px); font-weight:800; color:#fff; line-height:1.2; letter-spacing:-.02em; margin:0 0 12px">
                            @if($locale==='kk') Балаңызды DiDi-ге<br>жаздырыңыз
                            @elseif($locale==='en') Enroll your child<br>at DiDi
                            @else Запишите ребёнка<br>в DiDi
                            @endif
                        </h2>
                        <p style="color:rgba(255,255,255,.75); font-size:14px; line-height:1.65; margin:0 0 28px; max-width:300px">
                            @if($locale==='kk') Бізге хабарласыңыз — бос орын тексереміз
                            @elseif($locale==='en') Contact us and we'll check availability
                            @else Свяжитесь с нами — проверим наличие мест
                            @endif
                        </p>
                        <div style="display:flex; flex-wrap:wrap; gap:12px">
                            <a href="{{ route('contact.index') }}"
                               style="display:inline-flex;align-items:center;gap:8px;background:#fff;color:#2a8a5c;font-weight:700;font-size:14px;padding:13px 26px;border-radius:14px;text-decoration:none;transition:all .2s ease"
                               onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px rgba(0,0,0,.12)'"
                               onmouseout="this.style.transform='none';this.style.boxShadow='none'">
                                @if($locale==='kk') Жазылу @elseif($locale==='en') Enroll now @else Записаться @endif
                                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                            @if($phone = \App\Models\Setting::get('contact_phone'))
                            <a href="tel:{{ preg_replace('/\D/','',$phone) }}"
                               style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.2);color:#fff;font-weight:600;font-size:14px;padding:12px 22px;border-radius:14px;text-decoration:none;border:1.5px solid rgba(255,255,255,.35);transition:all .2s ease"
                               onmouseover="this.style.background='rgba(255,255,255,.3)';this.style.transform='translateY(-2px)'"
                               onmouseout="this.style.background='rgba(255,255,255,.2)';this.style.transform='none'">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                {{ $phone }}
                            </a>
                            @endif
                        </div>
                    </div>

                    {{-- Right: stats --}}
                    <div style="display:grid; grid-template-columns:repeat(2,1fr); gap:12px; shrink:0">
                        @foreach([
                            ['200+', $locale==='kk'?'Тәрбиеленуші':($locale==='en'?'Students':'Детей')],
                            ['15+',  $locale==='kk'?'Педагог':($locale==='en'?'Teachers':'Педагогов')],
                            ['10',   $locale==='kk'?'Жыл':($locale==='en'?'Years':'Лет')],
                            ['3',    $locale==='kk'?'Тіл':($locale==='en'?'Languages':'Языка')],
                        ] as [$n,$l])
                        <div style="background:rgba(255,255,255,.18);border:1px solid rgba(255,255,255,.25);border-radius:16px;padding:18px 20px;text-align:center;min-width:90px">
                            <div style="font-size:24px;font-weight:800;color:#fff;line-height:1">{{ $n }}</div>
                            <div style="font-size:11px;color:rgba(255,255,255,.7);margin-top:5px;font-weight:500">{{ $l }}</div>
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

@endsection
