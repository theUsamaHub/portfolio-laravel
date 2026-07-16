<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $seoPage = $seoPage ?? 'home';
        $seoData = \App\Helpers\SeoHelper::get($seoPage);
    @endphp
    {!! \App\Helpers\SeoHelper::renderMeta($seoPage) !!}
    <link rel="icon" type="image/svg+xml" href="{{ \App\Helpers\SettingHelper::get('site_favicon', '/favicon.svg') }}">
    @vite(['resources/css/voicebox.scss', 'resources/js/voicebox.js'])
    {!! \App\Helpers\SeoHelper::renderSchema($seoPage) !!}
</head>
<body>
    <a href="#main-content" class="skip-link">Skip to main content</a>
    @yield('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    @stack('scripts')
</body>
</html>
