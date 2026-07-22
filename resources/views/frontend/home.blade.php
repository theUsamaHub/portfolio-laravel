@extends('layouts.frontend')

@section('content')
    {{-- Hero --}}
    <x-frontend.hero :hero="$hero" :settings="$settings" :socialLinks="$socialLinks" :statistics="$statistics" />

    {{-- About --}}
    <x-frontend.about :about="$about" />

    {{-- Skills --}}
    <x-frontend.skills :skillCategories="$skillCategories" />

    {{-- Services --}}
    <x-frontend.services :services="$services" />

    {{-- Projects --}}
    <x-frontend.projects :projects="$projects" />

    {{-- Statistics --}}
    <x-frontend.stats :statistics="$statistics" />

    {{-- Experience --}}
    <x-frontend.experience :experiences="$experiences" :educations="$educations" />

    {{-- Testimonials --}}
    <x-frontend.testimonials :testimonials="$testimonials" />

    {{-- Blog --}}
    <x-frontend.blog :posts="$posts" />

    {{-- Contact --}}
    <x-frontend.contact :contact="$contact" :settings="$settings" />
@endsection
