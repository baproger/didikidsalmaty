@extends('layouts.app')

@push('styles')
    <style>
        .t-reveal {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity .55s cubic-bezier(.16, 1, .3, 1), transform .55s cubic-bezier(.16, 1, .3, 1);
        }

        .t-reveal.in {
            opacity: 1;
            transform: translateY(0);
        }

        .other-card {
            display: block;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, .06);
            box-shadow: 0 2px 10px rgba(0, 0, 0, .04);
            text-decoration: none;
            transition: transform .35s cubic-bezier(.16, 1, .3, 1), box-shadow .35s cubic-bezier(.16, 1, .3, 1);
        }

        .other-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 14px 36px rgba(0, 0, 0, .09);
        }

        .other-card .card-img {
            overflow: hidden;
            aspect-ratio: 3/4;
            background: linear-gradient(135deg, #edf7f2, #d8ede5);
        }

        .other-card .card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top;
            display: block;
            transition: transform .55s cubic-bezier(.16, 1, .3, 1);
        }

        .other-card:hover .card-img img {
            transform: scale(1.04);
        }

        .others-grid {
            grid-template-columns: repeat(4, 1fr);
        }

        @media (max-width: 767px) {
            .others-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .hero-photo-wrap {
                width: 160px !important;
                margin: 0 auto;
            }

            .hero-info-wrap {
                min-width: 0 !important;
            }
        }

        .pill-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border-radius: 10px;
            padding: 7px 13px;
            font-size: 13px;
            font-weight: 500;
            line-height: 1;
        }

        .cta-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 700;
            padding: 12px 22px;
            border-radius: 12px;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: transform .2s ease, filter .2s ease;
        }

        .cta-btn:hover {
            transform: translateY(-2px);
            filter: brightness(1.06);
        }
    </style>
@endpush

@section('content')
    @php
        $locale = app()->getLocale();
        $tName  = $teacher->getTranslation('name', $locale, false) ?: $teacher->getTranslation('name', 'ru', false) ?: $teacher->name;
        $tPos   = $teacher->getTranslation('position', $locale, false) ?: $teacher->getTranslation('position', 'ru', false);
        $bio    = $teacher->getTranslation('bio', $locale, false) ?: $teacher->getTranslation('bio', 'ru', false);
        $edu    = $teacher->getTranslation('education', $locale, false) ?: $teacher->getTranslation('education', 'ru', false);
        $exp    = $teacher->getTranslation('experience', $locale, false) ?: $teacher->getTranslation('experience', 'ru', false);
        $subj   = $teacher->getTranslation('subjects', $locale, false) ?: $teacher->getTranslation('subjects', 'ru', false);
        $photo  = $teacher->getFirstMediaUrl('photo');
        $phone  = \App\Models\Setting::get('contact_phone');
    @endphp

    {{-- ─── Breadcrumb ────────────────────────────────────────────────── --}}
    <div style="background:#fff; border-bottom:1px solid rgba(0,0,0,.05); position:sticky; top:68px; z-index:30">
        <div
            style="max-width:1280px; margin:0 auto; padding:0 24px; height:44px; display:flex; align-items:center; justify-content:space-between">
            <nav style="display:flex; align-items:center; gap:6px; font-size:12px; color:#9ca3af">
                <a href="{{ route('home') }}" style="color:#9ca3af; text-decoration:none"
                    onmouseover="this.style.color='#7EC8A4'" onmouseout="this.style.color='#9ca3af'">{{ __('nav.home') }}</a>
                <span style="color:#e5e7eb">/</span>
                <a href="{{ route('teachers.index') }}" style="color:#9ca3af; text-decoration:none"
                    onmouseover="this.style.color='#7EC8A4'"
                    onmouseout="this.style.color='#9ca3af'">{{ __('nav.teachers') }}</a>
                <span style="color:#e5e7eb">/</span>
                <span
                    style="color:#374151; font-weight:500; max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap">{{ $tName }}</span>
            </nav>
            <a href="{{ route('teachers.index') }}"
                style="display:inline-flex; align-items:center; gap:4px; font-size:12px; font-weight:600; color:#7EC8A4; text-decoration:none"
                onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                {{ __('nav.back') }}
            </a>
        </div>
    </div>

    {{-- ─── HERO ───────────────────────────────────────────────────────── --}}
    <div style="background:#ffffff; border-bottom:1px solid rgba(0,0,0,.05)">
        <div style="max-width:1280px; margin:0 auto; padding:120px 24px 48px">

            {{-- Two-column flex --}}
            <div style="display:flex; flex-wrap:wrap; gap:32px; align-items:flex-start">

                {{-- ── Photo ── --}}
                <div class="hero-photo-wrap" style="flex-shrink:0; width:220px">
                    <div
                        style="border-radius:18px; overflow:hidden; aspect-ratio:3/4; box-shadow:0 8px 32px rgba(0,0,0,.12); background:linear-gradient(135deg,#edf7f2,#d8ede5)">
                        @if ($photo)
                            <img src="{{ $photo }}" alt="{{ $tName }}"
                                style="width:100%; height:100%; object-fit:cover; object-position:top; display:block">
                        @else
                            <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center">
                                <svg style="width:52px; height:52px; color:#7EC8A4; opacity:.3" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- ── Info ── --}}
                <div class="hero-info-wrap" style="flex:1; min-width:240px; padding-top:8px">

                    {{-- Label --}}
                    {{-- <div
                        style="display:inline-flex; align-items:center; gap:8px; color:#7EC8A4; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:.15em; margin-bottom:12px">
                        <span style="width:18px; height:1px; background:#7EC8A4; display:inline-block"></span>
                        @if ($locale === 'kk')
                            Педагог
                        @elseif($locale === 'en')
                            Teacher
                        @else
                            Педагог
                        @endif
                    </div> --}}

                    {{-- Name --}}
                    <h1
                        style="font-size:clamp(20px,2.4vw,30px); font-weight:800; color:#1a2535; line-height:1.2; letter-spacing:-.01em; margin:0 0 6px">
                        {{ $tName }}
                    </h1>

                    {{-- Position --}}
                    @if ($tPos)
                        <p style="font-size:15px; font-weight:600; color:#7EC8A4; margin:0 0 20px">{{ $tPos }}
                        </p>
                    @else
                        <div style="margin-bottom:20px"></div>
                    @endif

                    {{-- Pills --}}
                    @if ($exp || $edu || $subj)
                        <div style="display:flex; flex-wrap:wrap; gap:8px; margin-bottom:22px">
                            @if ($exp)
                                <span class="pill-tag" style="background:rgba(126,200,164,.12); color:#1e6040">
                                    <svg style="width:13px;height:13px;color:#7EC8A4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $exp }}
                                </span>
                            @endif
                            @if ($edu)
                                <span class="pill-tag" style="background:#eff6ff; color:#1d4ed8">
                                    <svg style="width:13px;height:13px;color:#60a5fa" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                    </svg>
                                    {{ $edu }}
                                </span>
                            @endif
                            @if ($subj)
                                <span class="pill-tag" style="background:#f5f3ff; color:#6d28d9">
                                    <svg style="width:13px;height:13px;color:#a78bfa" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                    {{ $subj }}
                                </span>
                            @endif
                        </div>
                    @endif

                    {{-- Divider --}}
                    <div style="width:100%; height:1px; background:rgba(0,0,0,.07); margin-bottom:20px"></div>

                    {{-- Buttons --}}
                    <div style="display:flex; flex-wrap:wrap; gap:10px">
                        <a href="{{ route('contact.index') }}" class="cta-btn" style="background:#7EC8A4; color:#fff">
                            @if ($locale === 'kk')
                                Жазылу
                            @elseif($locale === 'en')
                                Book
                            @else
                                Записаться
                            @endif
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                        @if ($phone)
                            @php $wa = 'https://wa.me/' . preg_replace('/\D/','',$phone); @endphp
                            <a href="{{ $wa }}" target="_blank" rel="noopener" class="cta-btn"
                                style="background:#25D366; color:#fff">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                </svg>
                                WhatsApp
                            </a>
                            <a href="tel:{{ preg_replace('/\D/', '', $phone) }}" class="cta-btn"
                                style="background:#fff; color:#1a2535; border:1.5px solid rgba(0,0,0,.10)">
                                <svg width="14" height="14" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                {{ $phone }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ─── BIO ────────────────────────────────────────────────────────── --}}
    @if ($bio)
        <div style="background:#f8faf9; padding:40px 0 8px">
            <div style="max-width:1280px; margin:0 auto; padding:0 24px">
                <div class="t-reveal" x-intersect.once="$el.classList.add('in')">
                    <div
                        style="background:#fff; border-radius:18px; padding:28px 32px; box-shadow:0 2px 16px rgba(0,0,0,.05); border:1px solid rgba(0,0,0,.04)">
                        <div style="display:flex; align-items:center; gap:10px; margin-bottom:18px">
                            <div style="width:3px; height:20px; border-radius:2px; background:#7EC8A4"></div>
                            <h2 style="font-weight:700; color:#1a2535; font-size:15px; margin:0">
                                @if ($locale === 'kk')
                                    Педагог туралы
                                @elseif($locale === 'en')
                                    About
                                @else
                                    О педагоге
                                @endif
                            </h2>
                        </div>
                        <div
                            style="color:#4b5563; line-height:1.75; font-size:14px; display:flex; flex-direction:column; gap:10px">
                            @foreach (array_filter(array_map('trim', explode("\n", $bio))) as $para)
                                <p style="margin:0">{{ $para }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ─── OTHER TEACHERS ─────────────────────────────────────────────── --}}
    @if ($others->count())
        <section style="background:#f8faf9; padding:36px 0 60px">
            <div style="max-width:1280px; margin:0 auto; padding:0 24px">

                <div class="t-reveal"
                    style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px"
                    x-intersect.once="$el.classList.add('in')">
                    <h2 style="font-weight:700; color:#1a2535; font-size:17px; margin:0">
                        @if ($locale === 'kk')
                            Басқа педагогтар
                        @elseif($locale === 'en')
                            Other Teachers
                        @else
                            Другие педагоги
                        @endif
                    </h2>
                    <a href="{{ route('teachers.index') }}"
                        style="display:inline-flex; align-items:center; gap:4px; font-size:13px; font-weight:600; color:#7EC8A4; text-decoration:none"
                        onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                        @if ($locale === 'kk')
                            Барлығы
                        @elseif($locale === 'en')
                            All
                        @else
                            Все
                        @endif
                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <div class="others-grid" style="display:grid; gap:16px">
                    @foreach ($others->take(4) as $i => $other)
                        @php
                            $op = $other->getFirstMediaUrl('photo', 'thumb') ?: $other->getFirstMediaUrl('photo');
                            $delay = $i * 70;
                        @endphp
                        <div class="t-reveal" x-intersect.once="$el.classList.add('in')"
                            style="transition-delay:{{ $delay }}ms">
                            @php
                                $oName = $other->getTranslation('name', $locale, false) ?: $other->getTranslation('name', 'ru', false);
                                $oPos  = $other->getTranslation('position', $locale, false) ?: $other->getTranslation('position', 'ru', false);
                            @endphp
                            <a href="{{ route('teachers.show', $other) }}" class="other-card">
                                <div class="card-img">
                                    @if ($op)
                                        <img src="{{ $op }}" alt="{{ $oName }}" loading="lazy">
                                    @else
                                        <div
                                            style="width:100%;height:100%;display:flex;align-items:center;justify-content:center">
                                            <svg style="width:36px;height:36px;opacity:.25;color:#7EC8A4" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div style="padding:11px 13px 13px">
                                    <p
                                        style="font-weight:700; color:#1a2535; font-size:13px; line-height:1.3; margin:0 0 3px">
                                        {{ $oName }}</p>
                                    @if ($oPos)
                                        <p
                                            style="font-size:11px; color:#7EC8A4; font-weight:500; margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis">
                                            {{ $oPos }}</p>
                                    @endif
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>


            </div>
        </section>
    @endif

@endsection
