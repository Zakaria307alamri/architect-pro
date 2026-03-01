<!DOCTYPE html>
<html lang="ar" dir="rtl" class="scroll-smooth" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'المهندس المعماري')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="arch-shell text-[var(--text)] font-sans antialiased transition-colors duration-500">
@php
    $mobileCategories = \App\Models\Category::query()
        ->orderBy('name')
        ->get(['name', 'slug']);
@endphp

<header class="sticky top-0 left-0 w-full z-50 border-b border-[var(--border)] bg-[var(--surface)]/95 backdrop-blur">
    <div class="arch-container py-5 relative">
        <button id="mobile-menu-open"
                type="button"
                aria-label="فتح القائمة"
                class="sm:hidden absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 border border-[var(--border)] flex items-center justify-center text-[var(--muted)] hover:text-[var(--text)]">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M4 7h16M4 12h16M4 17h16" />
            </svg>
        </button>
        <a href="{{ route('home') }}" class="arch-logo block text-center text-2xl sm:text-3xl arch-link">
            {{ site_settings()?->profile_name ?? 'المهندس المعماري' }}
        </a>
    </div>

    <div class="hidden sm:block border-t border-[var(--border)]">
        <nav class="arch-container arch-nav py-3 flex flex-wrap items-center justify-center gap-4 sm:gap-8">
            <a href="{{ route('home') }}" class="arch-link">الرئيسية</a>
            <a href="{{ route('projects.index') }}" class="arch-link">المشاريع</a>
            <a href="{{ route('about') }}" class="arch-link">عن المهندس</a>
            <a href="{{ route('contact') }}" class="arch-link">تواصل</a>
        </nav>
    </div>
</header>

<div id="mobile-menu-overlay" class="sm:hidden fixed inset-0 bg-black/45 z-[70] hidden"></div>
<aside id="mobile-menu-drawer"
       class="sm:hidden fixed top-0 right-0 h-full w-72 max-w-[86vw] bg-[var(--surface)] border-l border-[var(--border)] z-[71] translate-x-full transition-transform duration-300 ease-out">
    <div class="p-4 border-b border-[var(--border)] flex items-center justify-between">
        <p class="arch-headline text-2xl">القائمة</p>
        <button id="mobile-menu-close"
                type="button"
                aria-label="إغلاق القائمة"
                class="w-10 h-10 border border-[var(--border)] flex items-center justify-center text-[var(--muted)] hover:text-[var(--text)]">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    <nav class="p-4 flex flex-col gap-2 text-right">
        <a href="{{ route('home') }}" class="arch-link py-3 px-2 border-b border-[var(--border)]">الرئيسية</a>
        <div class="border-b border-[var(--border)]">
            <button id="mobile-projects-toggle"
                    type="button"
                    aria-expanded="false"
                    class="w-full py-3 px-2 flex items-center justify-between arch-link">
                <span>المشاريع</span>
                <svg id="mobile-projects-chevron" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            @if($mobileCategories->isNotEmpty())
                <div id="mobile-projects-submenu" class="hidden pb-3">
                    <div class="space-y-1 pr-4">
                        <a href="{{ route('projects.index') }}"
                           class="block py-1 text-sm {{ request()->routeIs('projects.index') && ! request('category') ? 'text-[var(--brand)] font-semibold' : 'text-[var(--muted)] hover:text-[var(--text)]' }}">
                            كل المشاريع
                        </a>
                        @foreach($mobileCategories as $mobileCategory)
                            <a href="{{ route('projects.index', ['category' => $mobileCategory->slug]) }}"
                               class="block py-1 text-sm {{ request('category') === $mobileCategory->slug ? 'text-[var(--brand)] font-semibold' : 'text-[var(--muted)] hover:text-[var(--text)]' }}">
                                {{ $mobileCategory->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        <a href="{{ route('about') }}" class="arch-link py-3 px-2 border-b border-[var(--border)]">عن المهندس</a>
        <a href="{{ route('contact') }}" class="arch-link py-3 px-2">تواصل</a>
    </nav>
</aside>

{{-- ================= CONTENT ================= --}}
<main>
    @yield('content')
</main>

{{-- ================= FOOTER ================= --}}
<footer class="mt-8 py-10 border-t border-[var(--border)] text-center text-sm text-[var(--muted)] bg-[var(--surface)]">
    <p class="arch-headline text-xl mb-2 text-[var(--text)]">
        {{ site_settings()?->profile_name ?? 'المهندس المعماري' }}
    </p>
    <p>© {{ date('Y') }} جميع الحقوق محفوظة</p>
</footer>

</body>
</html>
