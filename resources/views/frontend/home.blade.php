@extends('frontend.layouts.app')

@section('title', 'الرئيسية')

@section('content')
@php
    $s = site_settings();
@endphp

<section class="bg-[var(--surface)] border-b border-[var(--border)]">
    <div class="arch-container py-10 sm:py-14">
        <div class="arch-card p-3 sm:p-4">
            @if($featuredProjects->count())
                <div class="sm:hidden">
                    <div class="arch-mobile-swipe flex gap-2 overflow-x-auto snap-x snap-mandatory pb-2">
                        @foreach($featuredProjects as $slideProject)
                            @php $slideMedia = $slideProject->getFirstMedia('cover'); @endphp
                            <a href="{{ route('projects.show', $slideProject->slug) }}"
                               class="relative block shrink-0 w-[84%] snap-start border border-[var(--border)]">
                                @if($slideMedia)
                                    <img src="{{ $slideMedia->getUrl() }}"
                                         alt="{{ $slideProject->title }}"
                                         class="w-full h-60 object-cover">
                                @else
                                    <div class="w-full h-60 bg-[var(--surface-soft)] flex items-center justify-center text-[var(--muted)]">
                                        لا توجد صورة
                                    </div>
                                @endif
                                <div class="absolute inset-x-0 bottom-0 p-3 text-white bg-gradient-to-t from-black/70 via-black/25 to-transparent">
                                    <p class="text-sm font-semibold leading-tight">{{ $slideProject->title }}</p>
                                    <p class="text-xs text-white/85">{{ $slideProject->location ?: '-' }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div id="home-featured-slider" class="relative hidden sm:block">
                    <div>
                        @foreach($featuredProjects as $slideProject)
                            @php $slideMedia = $slideProject->getFirstMedia('cover'); @endphp
                            <article data-slide class="{{ $loop->first ? '' : 'hidden' }}">
                                <a href="{{ route('projects.show', $slideProject->slug) }}" class="block">
                                    <div class="arch-feature-media">
                                        @if($slideMedia)
                                            <img src="{{ $slideMedia->getUrl() }}"
                                                 alt="{{ $slideProject->title }}"
                                                 class="w-full h-[520px] object-cover">
                                        @else
                                            <div class="w-full h-[520px] bg-[var(--surface-soft)] flex items-center justify-center text-[var(--muted)]">
                                                لا توجد صورة
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-3 sm:p-4">
                                        <p class="arch-kicker mb-3">Featured Project</p>
                                        <h1 class="arch-headline text-4xl sm:text-6xl leading-[0.95] mb-3">
                                            {{ $slideProject->title }}
                                        </h1>
                                        <p class="text-sm sm:text-base text-[var(--muted)]">
                                            {{ $slideProject->location ?: ($s?->hero_subtitle ?? 'مشاريع معمارية حديثة تعكس هوية واضحة وتجربة مكانية متكاملة.') }}
                                        </p>
                                    </div>
                                </a>
                            </article>
                        @endforeach
                    </div>

                    @if($featuredProjects->count() > 1)
                        <button type="button"
                                id="home-featured-prev"
                                aria-label="السابق"
                                class="absolute top-1/2 -translate-y-1/2 right-3 z-10 w-10 h-10 bg-black/45 text-white hover:bg-black/65 transition">
                            &#10095;
                        </button>
                        <button type="button"
                                id="home-featured-next"
                                aria-label="التالي"
                                class="absolute top-1/2 -translate-y-1/2 left-3 z-10 w-10 h-10 bg-black/45 text-white hover:bg-black/65 transition">
                            &#10094;
                        </button>

                        <div class="absolute bottom-3 left-1/2 -translate-x-1/2 z-10 flex items-center gap-2">
                            @foreach($featuredProjects as $dotProject)
                                <button type="button"
                                        data-slide-dot
                                        aria-label="Slide {{ $loop->iteration }}"
                                        class="w-2.5 h-2.5 rounded-full border border-white/80 {{ $loop->first ? 'bg-white' : 'bg-white/30' }}">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            @else
                <div class="w-full h-[360px] sm:h-[520px] bg-[var(--surface-soft)] flex items-center justify-center text-[var(--muted)]">
                    لا توجد مشاريع مميزة
                </div>
            @endif
        </div>
    </div>
</section>

<section class="py-12 sm:py-16">
    <div class="arch-container">
        <div class="flex items-center justify-between mb-8 sm:mb-10">
            <div>
                <p class="arch-kicker mb-2">Projects</p>
                <h2 class="arch-headline text-4xl sm:text-5xl">
                    {{ $s?->featured_section_title ?? 'مشاريع مميزة' }}
                </h2>
            </div>
            <a href="{{ route('projects.index') }}" class="text-sm font-semibold arch-link">
                عرض الكل
            </a>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($featuredProjects as $project)
                @php $media = $project->getFirstMedia('cover'); @endphp
                <article class="arch-card overflow-hidden">
                    <a href="{{ route('projects.show', $project->slug) }}" class="block">
                        <div class="overflow-hidden">
                            @if($media)
                                <img src="{{ $media->getUrl() }}"
                                     alt="{{ $project->title }}"
                                     class="arch-thumb transition duration-500 hover:scale-105">
                            @else
                                <div class="w-full aspect-[16/10] bg-[var(--surface-soft)]"></div>
                            @endif
                        </div>
                        <div class="p-4 sm:p-5">
                            <p class="arch-kicker mb-2">{{ $project->year }}</p>
                            <h3 class="arch-card-title mb-2">{{ $project->title }}</h3>
                            <p class="text-sm text-[var(--muted)]">{{ $project->location }}</p>
                        </div>
                    </a>
                </article>
            @empty
                <p class="col-span-3 text-center text-[var(--muted)]">لا توجد مشاريع مميزة حالياً.</p>
            @endforelse
        </div>
    </div>
</section>

<section class="py-16 bg-[var(--surface)] border-y border-[var(--border)]">
    <div class="arch-container text-center">
        <p class="arch-kicker mb-3">Profile</p>
        <h2 class="arch-headline text-4xl sm:text-5xl mb-5">
            {{ $s?->about_headline ?? 'عن المهندس' }}
        </h2>
        <p class="text-lg text-[var(--muted)] leading-relaxed max-w-4xl mx-auto">
            {{ $s?->about_description ?? 'نقدّم رؤية معمارية متوازنة تجمع بين الكفاءة الجمالية والوظيفية.' }}
        </p>
    </div>
</section>

<section class="py-14 sm:py-18 text-center">
    <div class="arch-container">
        <p class="arch-kicker mb-3">Start A Project</p>
        <h2 class="arch-headline text-4xl sm:text-5xl mb-4">
            {{ $s?->cta_title ?? 'هل لديك مشروع جديد؟' }}
        </h2>
        <p class="text-[var(--muted)] mb-8">
            {{ $s?->cta_subtitle ?? 'دعنا نحول فكرتك إلى مساحة عملية وجذابة.' }}
        </p>
        <a href="{{ route('contact') }}"
           class="inline-block border border-[var(--text)] px-8 py-3 font-semibold hover:bg-[var(--text)] hover:text-white transition">
            {{ $s?->cta_button_text ?? 'تواصل معنا' }}
        </a>
    </div>
</section>
@endsection
