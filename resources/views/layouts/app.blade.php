<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $seoPage = $seoPage ?? 'home';
        $seoData = \App\Helpers\SeoHelper::get($seoPage);
    @endphp

    {{-- Dynamic SEO Meta Tags --}}
    {!! \App\Helpers\SeoHelper::renderMeta($seoPage) !!}

    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="{{ \App\Helpers\SettingHelper::get('site_favicon', '/favicon.svg') }}">

    {{-- Vite Assets --}}
    @vite(['resources/css/app.scss', 'resources/js/app.js'])

    {{-- JSON-LD Schema --}}
    {!! \App\Helpers\SeoHelper::renderSchema($seoPage) !!}

    {{-- AOS CSS --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    {{-- reCAPTCHA --}}
    @if(\App\Models\SiteSetting::get('enable_recaptcha', false))
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif

    {{-- Custom CSS --}}
    @php $customCss = \App\Models\SiteSetting::get('custom_css', ''); @endphp
    @if($customCss)
        <style>{!! $customCss !!}</style>
    @endif
</head>
<body>
    {{-- Skip Link --}}
    <a href="#main-content" class="skip-link">Skip to main content</a>

    @yield('content')

    {{-- AOS JS --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    @stack('scripts')
</body>
</html>
