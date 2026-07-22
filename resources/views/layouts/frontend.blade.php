<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', $settings['site_name'] ?? 'Portfolio')</title>
    <meta name="description" content="@yield('description', $settings['site_description'] ?? '')">

    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Work+Sans:wght@300;400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

    {{-- GSAP — must load before Vite JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

    {{-- Three.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>

    {{-- Vite Assets --}}
    @vite(['resources/css/frontend.scss', 'resources/js/frontend.js'])

    @stack('head')
</head>
<body>
    {{-- Cursor Follower --}}
    <div class="cursor" id="cursor"></div>
    <div class="cursor-follower" id="cursorFollower"></div>

    {{-- Navigation --}}
    <x-frontend.navbar :navigation="$navigation" :settings="$settings" />

    {{-- Page Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <x-frontend.footer :settings="$settings" :socialLinks="$socialLinks" :contact="$contact" />

    {{-- Scripts --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Custom Cursor
            const cursor = document.getElementById('cursor');
            const follower = document.getElementById('cursorFollower');

            if (cursor && follower && window.matchMedia('(pointer: fine)').matches) {
                document.addEventListener('mousemove', (e) => {
                    cursor.style.transform = `translate(${e.clientX}px, ${e.clientY}px)`;
                    follower.style.transform = `translate(${e.clientX}px, ${e.clientY}px)`;
                });

                document.querySelectorAll('a, button, [data-cursor]').forEach(el => {
                    el.addEventListener('mouseenter', () => {
                        cursor.classList.add('cursor-hover');
                        follower.classList.add('cursor-follower-hover');
                    });
                    el.addEventListener('mouseleave', () => {
                        cursor.classList.remove('cursor-hover');
                        follower.classList.remove('cursor-follower-hover');
                    });
                });
            }

            // Magnetic Buttons
            document.querySelectorAll('.magnetic').forEach(btn => {
                btn.addEventListener('mousemove', (e) => {
                    const rect = btn.getBoundingClientRect();
                    const x = e.clientX - rect.left - rect.width / 2;
                    const y = e.clientY - rect.top - rect.height / 2;
                    btn.style.transform = `translate(${x * 0.3}px, ${y * 0.3}px)`;
                });
                btn.addEventListener('mouseleave', () => {
                    btn.style.transform = 'translate(0, 0)';
                });
            });

            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            });

            // Navbar scroll effect
            const nav = document.querySelector('.vb-nav');
            if (nav) {
                let lastScroll = 0;
                window.addEventListener('scroll', () => {
                    const currentScroll = window.pageYOffset;
                    if (currentScroll > 100) {
                        nav.classList.add('vb-nav--scrolled');
                    } else {
                        nav.classList.remove('vb-nav--scrolled');
                    }
                    lastScroll = currentScroll;
                });
            }

            // Scroll to anchor on page load (e.g. /#skills from another page)
            if (window.location.hash) {
                setTimeout(() => {
                    const target = document.querySelector(window.location.hash);
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                }, 300);
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
