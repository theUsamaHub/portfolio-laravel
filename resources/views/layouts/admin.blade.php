<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <title>Admin - {{ $title ?? 'Dashboard' }}</title>
    @vite(['resources/css/app.scss', 'resources/css/admin.scss', 'resources/js/app.js', 'resources/js/admin.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body>
    <div class="admin-layout">
        {{-- Sidebar --}}
        <aside class="admin-sidebar" id="admin-sidebar">
            <div class="sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="site-logo" style="font-size: 1.125rem;">
                    {{ \App\Helpers\SettingHelper::get('site_name', 'Portfolio') }}
                    <span class="badge badge-sm badge-primary" style="margin-left: 0.5rem;">Admin</span>
                </a>
            </div>
            <nav class="sidebar-nav" aria-label="Admin navigation">
                <div class="sidebar-section">
                    <p class="sidebar-section-title">Overview</p>
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                        Dashboard
                    </a>
                </div>

                <div class="sidebar-section">
                    <p class="sidebar-section-title">Homepage</p>
                    <a href="{{ route('admin.hero.edit') }}" class="sidebar-link {{ request()->routeIs('admin.hero.*') ? 'active' : '' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                        Hero Section
                    </a>
                    <a href="{{ route('admin.about.edit') }}" class="sidebar-link {{ request()->routeIs('admin.about.*') ? 'active' : '' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        About Section
                    </a>
                    <a href="{{ route('admin.skills.index') }}" class="sidebar-link {{ request()->routeIs('admin.skills.*') ? 'active' : '' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                        Skills
                    </a>
                    <a href="{{ route('admin.statistics.index') }}" class="sidebar-link {{ request()->routeIs('admin.statistics.*') ? 'active' : '' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                        Statistics
                    </a>
                </div>

                <div class="sidebar-section">
                    <p class="sidebar-section-title">Content</p>
                    <a href="{{ route('admin.projects.index') }}" class="sidebar-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                        Projects
                    </a>
                    <a href="{{ route('admin.posts.index') }}" class="sidebar-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Blog Posts
                    </a>
                    <a href="{{ route('admin.services.index') }}" class="sidebar-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4"/></svg>
                        Services
                    </a>
                    <a href="{{ route('admin.testimonials.index') }}" class="sidebar-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        Testimonials
                    </a>
                </div>

                <div class="sidebar-section">
                    <p class="sidebar-section-title">Resume</p>
                    <a href="{{ route('admin.experiences.index') }}" class="sidebar-link {{ request()->routeIs('admin.experiences.*') ? 'active' : '' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                        Experience
                    </a>
                    <a href="{{ route('admin.educations.index') }}" class="sidebar-link {{ request()->routeIs('admin.educations.*') ? 'active' : '' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                        Education
                    </a>
                    <a href="{{ route('admin.certificates.index') }}" class="sidebar-link {{ request()->routeIs('admin.certificates.*') ? 'active' : '' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                        Certificates
                    </a>
                    <a href="{{ route('admin.awards.index') }}" class="sidebar-link {{ request()->routeIs('admin.awards.*') ? 'active' : '' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        Awards
                    </a>
                </div>

                <div class="sidebar-section">
                    <p class="sidebar-section-title">Site</p>
                    <a href="{{ route('admin.navigation.index') }}" class="sidebar-link {{ request()->routeIs('admin.navigation.*') ? 'active' : '' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                        Navigation
                    </a>
                    <a href="{{ route('admin.tags.index') }}" class="sidebar-link {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                        Tags
                    </a>
                    <a href="{{ route('admin.social-links.index') }}" class="sidebar-link {{ request()->routeIs('admin.social-links.*') ? 'active' : '' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                        Social Links
                    </a>
                    <a href="{{ route('admin.clients.index') }}" class="sidebar-link {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        Clients
                    </a>
                    <a href="{{ route('admin.contact-settings.edit') }}" class="sidebar-link {{ request()->routeIs('admin.contact-settings.*') ? 'active' : '' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        Contact Info
                    </a>
                    <a href="{{ route('admin.messages.index') }}" class="sidebar-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        Messages
                        @if(\App\Models\ContactMessage::tableExists())
                            @php $unreadCount = \App\Models\ContactMessage::unread()->count(); @endphp
                            @if($unreadCount)
                                <span class="badge badge-sm badge-danger" style="margin-left: auto;">{{ $unreadCount }}</span>
                            @endif
                        @endif
                    </a>
                </div>

                <div class="sidebar-section">
                    <p class="sidebar-section-title">Settings</p>
                    <a href="{{ route('admin.seo.index') }}" class="sidebar-link {{ request()->routeIs('admin.seo.*') ? 'active' : '' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        SEO
                    </a>
                    <a href="{{ route('admin.auth-routes') }}" class="sidebar-link {{ request()->routeIs('admin.auth-routes*') ? 'active' : '' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        Auth Routes
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                        Site Settings
                    </a>
                </div>
            </nav>
        </aside>
        <div id="sidebar-overlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:1019;"></div>

        {{-- Main Content --}}
        <div class="admin-content">
            <header class="admin-header">
                <div class="flex items-center gap-4">
                    <button class="btn btn-icon btn-ghost sidebar-toggle-btn" id="sidebar-toggle" aria-label="Toggle sidebar">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                    </button>
                    <h1 style="font-size: 1.25rem; font-weight: 600;">{{ $pageTitle ?? 'Dashboard' }}</h1>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" class="btn btn-ghost btn-sm" target="_blank">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                        View Site
                    </a>
                    <button class="btn btn-icon btn-ghost" id="theme-toggle" aria-label="Toggle dark mode" title="Toggle dark mode">
                        <svg class="icon-sun" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
                        <svg class="icon-moon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                    </button>
                    <div class="dropdown">
                        <button class="btn btn-ghost btn-sm flex items-center gap-2" id="user-dropdown">
                            <span style="width: 2rem; height: 2rem; border-radius: 50%; background: var(--color-primary); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 0.75rem; font-weight: 600;">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            <span class="hidden md:inline">{{ auth()->user()->name }}</span>
                        </button>
                        <div class="dropdown-menu" id="user-dropdown-menu">
                            <a href="{{ route('profile.edit') }}" class="dropdown-item">Profile</a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item danger">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="admin-main">
                {{-- Flash Messages --}}
                @if(session('success'))
                    <div class="alert alert-success" style="padding: 0.75rem 1rem; background: var(--color-success-light); color: var(--color-success); border-radius: var(--radius); margin-bottom: 1.5rem; font-size: 0.9375rem;">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger" style="padding: 0.75rem 1rem; background: var(--color-danger-light); color: var(--color-danger); border-radius: var(--radius); margin-bottom: 1.5rem; font-size: 0.9375rem;">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('admin-content')
            </main>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 600, once: true, offset: 50 });

        // Theme toggle
        const html = document.documentElement;
        const savedTheme = localStorage.getItem('theme') || 'light';
        html.setAttribute('data-theme', savedTheme);
        updateThemeIcon(savedTheme);

        document.getElementById('theme-toggle')?.addEventListener('click', () => {
            const current = html.getAttribute('data-theme');
            const next = current === 'light' ? 'dark' : 'light';
            html.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
            updateThemeIcon(next);
        });

        function updateThemeIcon(theme) {
            const sun = document.querySelector('.icon-sun');
            const moon = document.querySelector('.icon-moon');
            if (sun && moon) {
                sun.style.display = theme === 'dark' ? 'none' : 'block';
                moon.style.display = theme === 'dark' ? 'block' : 'none';
            }
        }

        const sidebar = document.getElementById('admin-sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const toggle = document.getElementById('sidebar-toggle');

        function isMobile() { return window.innerWidth < 1024; }

        function closeSidebar() {
            sidebar?.classList.remove('active');
            if (isMobile()) {
                if (overlay) overlay.style.display = 'none';
                document.body.style.overflow = '';
            } else {
                document.body.classList.add('sidebar-collapsed');
            }
        }

        function openSidebar() {
            sidebar?.classList.add('active');
            document.body.classList.remove('sidebar-collapsed');
            if (isMobile()) {
                if (overlay) overlay.style.display = 'block';
                document.body.style.overflow = 'hidden';
            }
        }

        toggle?.addEventListener('click', () => {
            if (sidebar?.classList.contains('active')) closeSidebar();
            else openSidebar();
        });

        overlay?.addEventListener('click', () => { if (isMobile()) closeSidebar(); });

        // Close mobile sidebar on resize to desktop
        window.addEventListener('resize', () => {
            if (!isMobile() && overlay) overlay.style.display = 'none';
        });

        document.getElementById('user-dropdown')?.addEventListener('click', (e) => {
            e.stopPropagation();
            document.getElementById('user-dropdown-menu')?.classList.toggle('active');
        });
        document.addEventListener('click', () => {
            document.getElementById('user-dropdown-menu')?.classList.remove('active');
        });
    </script>
    @stack('scripts')
</body>
</html>
