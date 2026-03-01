@extends('frontend.layouts.app')

@section('title', site_settings()?->about_hero_title ?? 'عن المهندس')

@section('content')
@php
    $s = site_settings();
@endphp

@if($s?->about_hero_title)
<section class="bg-[var(--surface)] border-b border-[var(--border)] py-16 sm:py-20">
    <div class="arch-container text-center max-w-5xl">
        <p class="arch-kicker mb-4">About</p>
        <h1 class="arch-headline text-5xl sm:text-6xl leading-[0.95]">{{ $s->about_hero_title }}</h1>
        @if($s->about_hero_subtitle)
            <p class="mt-6 text-lg text-[var(--muted)] leading-relaxed max-w-3xl mx-auto">{{ $s->about_hero_subtitle }}</p>
        @endif
    </div>
</section>
@endif

<section class="py-14 sm:py-18">
    <div class="arch-container grid md:grid-cols-2 gap-10 items-center">
        @if($s?->profile_image)
            @php
                $rawImage = $s->profile_image;
                $decodedImage = is_string($rawImage) ? json_decode($rawImage, true) : null;
                $getImagePath = function ($value) {
                    if (! is_array($value) || empty($value)) {
                        return null;
                    }

                    if (array_is_list($value)) {
                        return $value[0] ?? null;
                    }

                    $firstKey = array_key_first($value);
                    return is_string($firstKey) ? $firstKey : null;
                };

                $image = is_array($rawImage)
                    ? $getImagePath($rawImage)
                    : (is_array($decodedImage) ? $getImagePath($decodedImage) : $rawImage);

                if ($image && ! Storage::disk('public')->exists($image)) {
                    $profileFiles = Storage::disk('public')->files('profile');
                    rsort($profileFiles);
                    $image = $profileFiles[0] ?? null;
                }
            @endphp

            @if($image)
                <div class="arch-card p-3">
                    <img src="{{ Storage::url($image) }}" class="w-full object-cover" alt="profile">
                </div>
            @endif
        @endif

        <div class="arch-card p-6 sm:p-8">
            @if($s?->profile_section_title)
                <h2 class="arch-headline text-4xl mb-6">{{ $s->profile_section_title }}</h2>
            @endif

            @if($s?->about_description)
                <p class="text-[var(--muted)] leading-relaxed">{{ $s->about_description }}</p>
            @endif
        </div>
    </div>
</section>

@if($s?->philosophy_title)
<section class="py-16 bg-[var(--surface)] border-y border-[var(--border)]">
    <div class="arch-container text-center max-w-4xl">
        <p class="arch-kicker mb-3">Philosophy</p>
        <h2 class="arch-headline text-4xl sm:text-5xl mb-8">{{ $s->philosophy_title }}</h2>
        @if($s->philosophy_text)
            <p class="text-lg text-[var(--muted)] leading-relaxed">{{ $s->philosophy_text }}</p>
        @endif
    </div>
</section>
@endif

@if($s?->experience_list)
<section class="py-14 sm:py-18">
    <div class="arch-container max-w-5xl">
        <h2 class="arch-headline text-4xl sm:text-5xl mb-12 text-center">{{ $s->experience_title ?? 'الخبرات' }}</h2>

        <div class="space-y-6">
            @foreach(json_decode($s->experience_list, true) ?? [] as $item)
                <div class="arch-card p-5">
                    <h3 class="arch-headline text-2xl mb-2">{{ $item['period'] ?? '' }}</h3>
                    <p class="text-[var(--muted)]">{{ $item['description'] ?? '' }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($s?->about_cta_title)
<section class="py-16 bg-[var(--text)] text-white text-center">
    <div class="arch-container">
        <h2 class="arch-headline text-4xl md:text-5xl">{{ $s->about_cta_title }}</h2>
        @if($s->about_cta_subtitle)
            <p class="mt-5 text-white/75 max-w-xl mx-auto">{{ $s->about_cta_subtitle }}</p>
        @endif

        <div class="mt-8">
            <a href="{{ route('contact') }}"
               class="border border-white px-10 py-3 text-sm font-semibold hover:bg-white hover:text-black transition">
                {{ $s->about_cta_button ?? 'تواصل معنا' }}
            </a>
        </div>
    </div>
</section>
@endif
@endsection
