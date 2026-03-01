@extends('frontend.layouts.app')

@section('title', 'المشاريع')

@section('content')
<section class="py-8 sm:py-10">
    <div class="arch-container max-w-5xl">
        <div class="mb-6 sm:mb-8">
            <h1 class="arch-headline text-4xl sm:text-5xl leading-[0.95] mb-2">المشاريع</h1>
            <div class="h-px bg-[var(--border)] mt-3"></div>
        </div>

        <p class="text-sm text-[var(--muted)] mb-5 sm:mb-6">
            عدد المشاريع: <span class="font-semibold text-[var(--text)]">{{ $projects->count() }}</span>
        </p>

        <div class="space-y-4 sm:space-y-5">
            @forelse($projects as $project)
                @php $media = $project->getFirstMedia('cover'); @endphp
                <article class="bg-white border border-[#d8d8d3] shadow-[0_1px_2px_rgba(0,0,0,0.04)]">
                    <a href="{{ route('projects.show', $project->slug) }}" class="block p-4 sm:p-5">
                        <div class="flex flex-row-reverse sm:flex-row items-start gap-4 sm:gap-5">
                            <div class="w-28 sm:w-40 shrink-0 overflow-hidden rounded">
                                @if($media)
                                    <img src="{{ $media->getUrl() }}"
                                         alt="{{ $project->title }}"
                                         class="w-full h-20 sm:h-24 object-cover">
                                @else
                                    <div class="w-full h-20 sm:h-24 bg-[var(--surface-soft)]"></div>
                                @endif
                            </div>

                            <div class="flex-1 min-w-0 text-right">
                                <h2 class="text-lg sm:text-[33px] leading-[1.15] text-[var(--text)]">
                                    {{ $project->title }}
                                </h2>
                                <p class="mt-2 text-sm sm:text-base text-[#4b4b4b] leading-snug">
                                    {{ $project->category->name ?? 'ARQUITECTOS' }}
                                    @if($project->location || $project->year)
                                        <span class="mx-1">|</span>
                                        {{ $project->location ?: '' }}{{ $project->location && $project->year ? ' - ' : '' }}{{ $project->year ?: '' }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </a>
                </article>
            @empty
                <div class="bg-white border border-[#d8d8d3] p-10 text-center text-[var(--muted)]">
                    لا توجد مشاريع مضافة حالياً.
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
