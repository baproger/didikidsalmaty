@php
    $footerMenu = \App\Models\Menu::where('location', 'header')
        ->with(['items' => fn($q) => $q->where('is_active', true)->whereNull('parent_id')->orderBy('order')])
        ->first();
    $footerItems = $footerMenu?->items ?? collect();
    $fLocale = app()->getLocale();
@endphp

<footer style="background:#1a2535; color:#fff">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

            {{-- Brand --}}
            <div>
                <a href="{{ route('home') }}" class="flex items-center mb-4 group">
                    @if (file_exists(public_path('images/didilogotype.png')))
                        <img src="/images/didilogotype.png" alt="DiDi Kindergarten"
                            class="h-14 w-auto object-contain group-hover:scale-105 transition-transform duration-200">
                    @else
                        <div
                            style="width:36px;height:36px;border-radius:14px;background:#7EC8A4;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:18px;color:#fff;flex-shrink:0">
                            D</div>
                        <span style="margin-left:10px;font-weight:800;font-size:18px;color:#fff">Didi Kindergarten</span>
                    @endif
                </a>
                <p style="color:#94a3b8;font-size:14px;line-height:1.6">
                    {{ \App\Models\Setting::get('site_tagline_' . $fLocale) ?: __('nav.tagline') }}
                </p>
            </div>

            {{-- Navigation --}}
            <div>
                <h4 style="font-weight:600;margin-bottom:16px;color:rgba(255,255,255,.9);font-size:14px">
                    {{ __('nav.navigation') }}</h4>
                <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:8px">
                    @if ($footerItems->count())
                        @foreach ($footerItems as $item)
                            <li>
                                <a href="{{ $item->href }}" target="{{ $item->target }}"
                                    style="color:#94a3b8;font-size:14px;text-decoration:none;transition:color .15s ease"
                                    onmouseover="this.style.color='#7EC8A4'" onmouseout="this.style.color='#94a3b8'">
                                    {{ $item->getTranslation('label', $fLocale, false) ?: $item->getTranslation('label', 'ru', false) }}
                                </a>
                            </li>
                        @endforeach
                    @else
                        @foreach ([[route('home'), __('nav.home')], [route('teachers.index'), __('nav.teachers')], [route('blog.index'), __('nav.blog')], [route('gallery.index'), __('nav.gallery')], [route('contact.index'), __('nav.contact')]] as [$href, $label])
                            <li>
                                <a href="{{ $href }}"
                                    style="color:#94a3b8;font-size:14px;text-decoration:none;transition:color .15s ease"
                                    onmouseover="this.style.color='#7EC8A4'"
                                    onmouseout="this.style.color='#94a3b8'">{{ $label }}</a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h4 style="font-weight:600;margin-bottom:16px;color:rgba(255,255,255,.9);font-size:14px">
                    {{ __('contact.title') }}</h4>
                <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:10px">
                    @if ($address = \App\Models\Setting::get('contact_address'))
                        <li style="display:flex;align-items:flex-start;gap:8px">
                            <svg style="width:16px;height:16px;color:#7EC8A4;flex-shrink:0;margin-top:2px"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            </svg>
                            <span style="color:#94a3b8;font-size:14px;line-height:1.5">{{ $address }}</span>
                        </li>
                    @endif
                    @if ($phone = \App\Models\Setting::get('contact_phone'))
                        <li style="display:flex;align-items:center;gap:8px">
                            <svg style="width:16px;height:16px;color:#7EC8A4;flex-shrink:0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <a href="tel:{{ preg_replace('/\D/', '', $phone) }}"
                                style="color:#94a3b8;font-size:14px;text-decoration:none;transition:color .15s ease"
                                onmouseover="this.style.color='#7EC8A4'"
                                onmouseout="this.style.color='#94a3b8'">{{ $phone }}</a>
                        </li>
                    @endif
                    @if ($email = \App\Models\Setting::get('contact_email'))
                        <li style="display:flex;align-items:center;gap:8px">
                            <svg style="width:16px;height:16px;color:#7EC8A4;flex-shrink:0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <a href="mailto:{{ $email }}"
                                style="color:#94a3b8;font-size:14px;text-decoration:none;transition:color .15s ease"
                                onmouseover="this.style.color='#7EC8A4'"
                                onmouseout="this.style.color='#94a3b8'">{{ $email }}</a>
                        </li>
                    @endif
                    @if ($hours = \App\Models\Setting::get('work_hours'))
                        <li style="display:flex;align-items:center;gap:8px">
                            <svg style="width:16px;height:16px;color:#7EC8A4;flex-shrink:0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span style="color:#94a3b8;font-size:14px">{{ $hours }}</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <div
            style="border-top:1px solid rgba(255,255,255,.08);margin-top:40px;padding-top:24px;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:8px">
            <span style="color:rgba(255,255,255,.3);font-size:12px">© {{ date('Y') }} Didi .
                {{ __('nav.all_rights') }}</span>
            <div class="flex items-center gap-4">
                @include('components.language-switcher')
            </div>
            <span style="color:rgba(255,255,255,.2);font-size:11px;width:100%;text-align:center;margin-top:4px">
                Сайт разработан
                <a href="https://www.instagram.com/baproger.kz/" target="_blank" rel="noopener"
                    style="color:rgba(255,255,255,.4);text-decoration:none;font-weight:600;transition:color .15s"
                    onmouseover="this.style.color='#7EC8A4'"
                    onmouseout="this.style.color='rgba(255,255,255,.4)'">baproger</a>
            </span>
        </div>
    </div>
</footer>
