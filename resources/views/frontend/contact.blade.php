@extends('frontend.layouts.app')

@section('title', 'تواصل معنا')

@section('content')
@php
    $s = site_settings();
    $phone = $s?->phone ?: '+966 5XXXXXXXX';
    $email = $s?->email ?: 'info@example.com';
    $location = $s?->location ?: 'الرياض، المملكة العربية السعودية';
    $phoneLink = preg_replace('/[^0-9+]/', '', $phone);
@endphp

<section class="bg-[var(--surface)] border-b border-[var(--border)] py-16 sm:py-20">
    <div class="arch-container text-center">
        <p class="arch-kicker mb-4">Contact</p>
        <h1 class="arch-headline text-5xl sm:text-6xl leading-[0.95] mb-5">تواصل معنا</h1>
        <p class="text-lg text-[var(--muted)] max-w-3xl mx-auto leading-relaxed">
            نرحب دائماً بالتواصل لمناقشة المشاريع الجديدة، الشراكات المعمارية، أو أي استفسارات عامة.
        </p>
    </div>
</section>

<section class="py-14 sm:py-18">
    <div class="arch-container grid md:grid-cols-3 gap-6">
        <article class="arch-card p-6 text-center">
            <p class="arch-kicker mb-3">Phone</p>
            <a href="tel:{{ $phoneLink }}" class="arch-headline text-3xl arch-link">{{ $phone }}</a>
        </article>

        <article class="arch-card p-6 text-center">
            <p class="arch-kicker mb-3">Email</p>
            <a href="mailto:{{ $email }}" class="arch-headline text-3xl arch-link break-all">{{ $email }}</a>
        </article>

        <article class="arch-card p-6 text-center">
            <p class="arch-kicker mb-3">Location</p>
            <p class="arch-headline text-3xl">{{ $location }}</p>
        </article>
    </div>
</section>
@endsection
