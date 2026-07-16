@php
    $siteName = \App\Helpers\SettingHelper::get('site_name', 'Portfolio');
    $navigation = $navigation ?? collect();
@endphp

<header class="vbox-header" id="vbox-header">
    <div class="vbox-header-inner">
        <a href="{{ route('home') }}" class="vbox-logo">{{ $siteName }}<span>.</span></a>

        <nav class="vbox-nav" aria-label="Main navigation">
            @foreach($navigation as $item)
                <a href="{{ $item->url ?? '#' }}"
                   class="vbox-nav-link {{ request()->is(ltrim($item->url ?? '', '/')) ? 'active' : '' }}"
                   @if($item->open_in_new_tab) target="_blank" rel="noopener" @endif>
                    {{ $item->label }}
                </a>
            @endforeach
        </nav>

        <div class="vbox-header-actions">
            <button class="vbox-theme-btn" id="vbox-theme-toggle" aria-label="Toggle dark mode">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
            </button>
            <button class="vbox-mobile-toggle" id="vbox-mobile-toggle" aria-label="Toggle menu">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
        </div>
    </div>
</header>

<div class="vbox-mobile-overlay" id="vbox-mobile-overlay"></div>
<nav class="vbox-mobile-menu" id="vbox-mobile-menu" aria-label="Mobile navigation">
    <button class="vbox-mobile-close" id="vbox-mobile-close" aria-label="Close menu">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>
    <div class="vbox-mobile-nav">
        @foreach($navigation as $item)
            <a href="{{ $item->url ?? '#' }}" class="vbox-mobile-link">{{ $item->label }}</a>
        @endforeach
        @auth
            <a href="{{ route('admin.dashboard') }}" class="vbox-mobile-link">Admin</a>
        @endauth
    </div>
</nav>
