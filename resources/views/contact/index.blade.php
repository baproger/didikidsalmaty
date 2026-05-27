@extends('layouts.app')

@section('content')
<div class="pt-28 pb-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-14">
            <h1 class="text-3xl lg:text-5xl font-extrabold font-sans text-[#2D3748] mb-4">{{ __('contact.title') }}</h1>
        </div>

        <div class="grid lg:grid-cols-2 gap-10">

            {{-- Info cards --}}
            <div class="space-y-4">
                @if($address = \App\Models\Setting::get('contact_address'))
                <div class="flex items-start gap-4 bg-[#7EC8A4]/10 rounded-3xl p-6">
                    <div class="w-12 h-12 bg-[#7EC8A4] rounded-2xl flex items-center justify-center shrink-0 shadow-md">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-[#2D3748]">{{ __('contact.address') }}</h3>
                        <p class="text-gray-500 text-sm mt-1">{{ $address }}</p>
                    </div>
                </div>
                @endif

                @if($phone = \App\Models\Setting::get('contact_phone'))
                <div class="flex items-start gap-4 bg-[#A8DADC]/10 rounded-3xl p-6">
                    <div class="w-12 h-12 bg-[#A8DADC] rounded-2xl flex items-center justify-center shrink-0 shadow-md">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-[#2D3748]">{{ __('contact.phone_label') }}</h3>
                        <a href="tel:{{ $phone }}" class="text-[#7EC8A4] font-semibold text-sm mt-1 block hover:underline">{{ $phone }}</a>
                    </div>
                </div>
                @endif

                @if($email = \App\Models\Setting::get('contact_email'))
                <div class="flex items-start gap-4 bg-[#F4A261]/10 rounded-3xl p-6">
                    <div class="w-12 h-12 bg-[#F4A261] rounded-2xl flex items-center justify-center shrink-0 shadow-md">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-[#2D3748]">{{ __('contact.email_label') }}</h3>
                        <a href="mailto:{{ $email }}" class="text-[#7EC8A4] font-semibold text-sm mt-1 block hover:underline">{{ $email }}</a>
                    </div>
                </div>
                @endif

                <div class="flex items-start gap-4 bg-purple-50 rounded-3xl p-6">
                    <div class="w-12 h-12 bg-purple-400 rounded-2xl flex items-center justify-center shrink-0 shadow-md">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-[#2D3748]">{{ __('contact.work_hours') }}</h3>
                        <p class="text-gray-500 text-sm mt-1">{{ \App\Models\Setting::get('work_hours', 'Пн–Пт: 07:30 – 19:00') }}</p>
                    </div>
                </div>
            </div>

            {{-- Contact form --}}
            <div class="glass rounded-3xl p-8 shadow-xl" x-data="contactForm()">

                @if(session('success'))
                <div class="mb-6 bg-[#7EC8A4]/10 border border-[#7EC8A4]/30 text-[#2D3748] rounded-2xl px-5 py-4 text-sm font-medium">
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" @submit="loading = true">
                    @csrf

                    <div class="grid sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-semibold text-[#2D3748] mb-1.5">{{ __('contact.name') }}</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                   class="w-full rounded-2xl border border-gray-200 bg-white/80 px-4 py-3 text-sm focus:outline-none focus:border-[#7EC8A4] focus:ring-2 focus:ring-[#7EC8A4]/20 transition-all @error('name') border-red-400 @enderror">
                            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#2D3748] mb-1.5">{{ __('contact.email') }}</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   class="w-full rounded-2xl border border-gray-200 bg-white/80 px-4 py-3 text-sm focus:outline-none focus:border-[#7EC8A4] focus:ring-2 focus:ring-[#7EC8A4]/20 transition-all @error('email') border-red-400 @enderror">
                            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-semibold text-[#2D3748] mb-1.5">{{ __('contact.phone') }}</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}"
                                   class="w-full rounded-2xl border border-gray-200 bg-white/80 px-4 py-3 text-sm focus:outline-none focus:border-[#7EC8A4] focus:ring-2 focus:ring-[#7EC8A4]/20 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#2D3748] mb-1.5">{{ __('contact.child_age') }}</label>
                            <select name="child_age"
                                    class="w-full rounded-2xl border border-gray-200 bg-white/80 px-4 py-3 text-sm focus:outline-none focus:border-[#7EC8A4] focus:ring-2 focus:ring-[#7EC8A4]/20 transition-all">
                                <option value="">{{ __('contact.child_age_placeholder') }}</option>
                                <option value="1 год" {{ old('child_age') === '1 год' ? 'selected' : '' }}>1 {{ __('contact.year') }}</option>
                                <option value="2 года" {{ old('child_age') === '2 года' ? 'selected' : '' }}>2 {{ __('contact.years_2') }}</option>
                                <option value="3 года" {{ old('child_age') === '3 года' ? 'selected' : '' }}>3 {{ __('contact.years_2') }}</option>
                                <option value="4 года" {{ old('child_age') === '4 года' ? 'selected' : '' }}>4 {{ __('contact.years_2') }}</option>
                                <option value="5 лет" {{ old('child_age') === '5 лет' ? 'selected' : '' }}>5 {{ __('contact.years_5') }}</option>
                                <option value="6 лет" {{ old('child_age') === '6 лет' ? 'selected' : '' }}>6 {{ __('contact.years_5') }}</option>
                                <option value="7 лет" {{ old('child_age') === '7 лет' ? 'selected' : '' }}>7 {{ __('contact.years_5') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-[#2D3748] mb-1.5">{{ __('contact.message') }}</label>
                        <textarea name="message" rows="5" required
                                  class="w-full rounded-2xl border border-gray-200 bg-white/80 px-4 py-3 text-sm focus:outline-none focus:border-[#7EC8A4] focus:ring-2 focus:ring-[#7EC8A4]/20 transition-all resize-none @error('message') border-red-400 @enderror">{{ old('message') }}</textarea>
                        @error('message')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit"
                            :disabled="loading"
                            class="w-full bg-[#7EC8A4] hover:bg-[#68b892] disabled:opacity-60 text-white font-bold py-3.5 rounded-2xl transition-all duration-200 shadow-lg shadow-[#7EC8A4]/30 hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <span x-show="!loading">{{ __('contact.send') }}</span>
                        <span x-show="loading" class="flex items-center gap-2">
                            <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                            </svg>
                            Отправка...
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
