@extends('frontend.layouts.app')

@section('title', $project->title)

@section('content')
@php
    $cover = $project->getFirstMedia('cover');
@endphp

<section class="bg-[var(--surface)] border-b border-[var(--border)]">
    <div class="arch-container py-10 sm:py-14">
        <p class="arch-kicker mb-4">
            {{ $project->category->name ?? 'Project' }}
        </p>
        <h1 class="arch-headline text-5xl sm:text-6xl leading-[0.95] mb-4">{{ $project->title }}</h1>
        <div class="flex flex-wrap items-center gap-4 text-sm text-[var(--muted)]">
            <span>{{ $project->location ?: 'الموقع غير محدد' }}</span>
            <span>•</span>
            <span>{{ $project->year ?: '-' }}</span>
            <span>•</span>
            <span>{{ $project->status }}</span>
        </div>
    </div>
</section>

<section class="py-8 sm:py-10">
    <div class="arch-container">
        <div class="arch-card p-3">
            @if($cover)
                <img src="{{ $cover->getUrl() }}" alt="{{ $project->title }}" class="w-full h-[360px] sm:h-[560px] object-cover">
            @else
                <div class="w-full h-[360px] sm:h-[560px] bg-[var(--surface-soft)] flex items-center justify-center text-[var(--muted)]">
                    لا توجد صورة رئيسية
                </div>
            @endif
        </div>
    </div>
</section>

<section class="pb-14 sm:pb-20">
    <div class="arch-container grid lg:grid-cols-12 gap-8">
        <aside class="lg:col-span-4 arch-card p-6 h-fit">
            <h2 class="arch-headline text-3xl mb-5">تفاصيل المشروع</h2>
            <div class="space-y-3 text-sm sm:text-base">
                <p><strong>التصنيف:</strong> {{ $project->category->name ?? '-' }}</p>
                <p><strong>العميل:</strong> {{ $project->client ?: '-' }}</p>
                <p><strong>الموقع:</strong> {{ $project->location ?: '-' }}</p>
                <p><strong>المساحة:</strong> {{ $project->area ?: '-' }}</p>
                <p><strong>السنة:</strong> {{ $project->year ?: '-' }}</p>
            </div>
        </aside>

        <div class="lg:col-span-8 arch-card p-6 sm:p-8">
            <h2 class="arch-headline text-3xl mb-5">وصف المشروع</h2>
            <div class="text-[var(--muted)] leading-8 prose max-w-none">
                {!! $project->description !!}
            </div>
        </div>
    </div>
</section>

@if($project->getMedia('gallery')->count())
<section class="py-14 sm:py-20 bg-[var(--surface)] border-y border-[var(--border)]">
    <div class="arch-container">
        <h2 class="arch-headline text-4xl sm:text-5xl mb-8">معرض المشروع</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($project->getMedia('gallery') as $image)
                <button type="button"
                        onclick="openLightbox('{{ $image->getUrl() }}')"
                        class="arch-card overflow-hidden text-right">
                    <img src="{{ $image->getUrl() }}"
                         alt="{{ $project->title }}"
                         class="w-full h-72 object-cover transition duration-500 hover:scale-105">
                    @if($image->getCustomProperty('caption'))
                        <div class="p-3 text-sm text-[var(--muted)] text-right">
                            {{ $image->getCustomProperty('caption') }}
                        </div>
                    @endif
                </button>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($project->getMedia('plans')->count())
<section class="py-14 sm:py-20">
    <div class="arch-container">
        <h2 class="arch-headline text-4xl sm:text-5xl mb-8">المخططات</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($project->getMedia('plans') as $plan)
                @php
                    $isImagePlan = str_starts_with($plan->mime_type ?? '', 'image/');
                    $isPdfPlan = ($plan->mime_type ?? '') === 'application/pdf' || str_ends_with(strtolower($plan->file_name), '.pdf');
                    $planTitle = $plan->getCustomProperty('title') ?: pathinfo($plan->file_name, PATHINFO_FILENAME);
                @endphp
                <article class="arch-card p-4">
                    @if($isImagePlan)
                        <img src="{{ $plan->getUrl() }}" alt="{{ $plan->file_name }}" class="w-full h-64 object-cover mb-4">
                    @elseif($isPdfPlan)
                        <iframe
                            src="{{ $plan->getUrl() }}#page=1&view=FitH&toolbar=0&navpanes=0&scrollbar=0"
                            title="{{ $planTitle }}"
                            class="w-full h-64 border border-[var(--border)] mb-4 bg-[var(--surface-soft)]"
                            loading="lazy">
                        </iframe>
                    @else
                        <div class="w-full h-64 bg-[var(--surface-soft)] flex items-center justify-center text-[var(--muted)] mb-4">
                            {{ strtoupper(pathinfo($plan->file_name, PATHINFO_EXTENSION)) }}
                        </div>
                    @endif
                    <p class="text-sm text-[var(--muted)] break-words mb-1">{{ $planTitle }}</p>
                    <p class="text-xs text-[var(--muted)]/80 break-all mb-4">{{ $plan->file_name }}</p>
                    <a href="{{ $plan->getUrl() }}"
                       target="_blank"
                       class="inline-block border border-[var(--text)] px-5 py-2 text-sm font-semibold hover:bg-[var(--text)] hover:text-white transition">
                        فتح / تحميل
                    </a>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="py-10 border-t border-[var(--border)]">
    <div class="arch-container flex items-center justify-between gap-4">
        <div>
            @if($previous)
                <a href="{{ route('projects.show', $previous->slug) }}" class="text-sm sm:text-base hover:text-[var(--brand)] transition">
                    المشروع السابق
                </a>
            @endif
        </div>
        <a href="{{ route('projects.index') }}" class="text-sm sm:text-base font-semibold hover:text-[var(--brand)] transition">
            كل المشاريع
        </a>
        <div>
            @if($next)
                <a href="{{ route('projects.show', $next->slug) }}" class="text-sm sm:text-base hover:text-[var(--brand)] transition">
                    المشروع التالي
                </a>
            @endif
        </div>
    </div>
</section>

<div id="lightbox"
     class="fixed inset-0 bg-black/90 hidden items-center justify-center z-[100]"
     onclick="closeLightbox()">
    <img id="lightbox-img" class="max-w-[92%] max-h-[92%] object-contain" alt="preview">
</div>

<script>
function openLightbox(src) {
    const box = document.getElementById('lightbox');
    const img = document.getElementById('lightbox-img');
    img.src = src;
    box.classList.remove('hidden');
    box.classList.add('flex');
}

function closeLightbox() {
    const box = document.getElementById('lightbox');
    box.classList.add('hidden');
    box.classList.remove('flex');
}
</script>
@endsection
