@php
    $siteName = \App\Helpers\SettingHelper::get('site_name', 'VoiceBox');
    $navigation = $navigation ?? collect();
    $socialLinks = $socialLinks ?? collect();
@endphp

<header class="vb-header" id="vb-header">
    <div class="vb-container">
        <div class="vb-header-inner">
            <a href="{{ route('home') }}" class="vb-logo">{{ $siteName }}</a>

            <nav class="vb-nav" aria-label="Main navigation">
                @foreach($navigation as $item)
                    @if($item->children->count())
                        <div style="position:relative;" class="vb-nav-parent">
                            <a href="{{ $item->url ?? '#' }}" class="vb-nav-link {{ request()->is(ltrim($item->url ?? '', '/')) ? 'active' : '' }}">
                                {{ $item->label }}
                            </a>
                            <div class="vb-nav-dropdown">
                                @foreach($item->children as $child)
                                    <a href="{{ $child->url ?? '#' }}" class="vb-nav-dropdown-item" @if($child->open_in_new_tab) target="_blank" @endif>{{ $child->label }}</a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ $item->url ?? '#' }}" class="vb-nav-link {{ request()->is(ltrim($item->url ?? '', '/')) ? 'active' : '' }}">{{ $item->label }}</a>
                    @endif
                @endforeach
            </nav>

            <div class="vb-header-actions">
                <button class="vb-btn vb-btn-ghost vb-btn-sm" id="vb-theme-toggle" aria-label="Toggle dark mode">
                    <svg class="icon-sun" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
                    <svg class="icon-moon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                </button>
                <button class="vb-mobile-toggle vb-btn vb-btn-ghost vb-btn-sm" id="vb-mobile-toggle" aria-label="Toggle menu">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
            </div>
        </div>
    </div>
</header>

<div class="vb-mobile-overlay" id="vb-mobile-overlay"></div>
<nav class="vb-mobile-menu" id="vb-mobile-menu" aria-label="Mobile navigation">
    <button class="vb-mobile-close" id="vb-mobile-close" aria-label="Close menu">
        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>
    <div class="vb-mobile-nav">
        @foreach($navigation as $item)
            <a href="{{ $item->url ?? '#' }}" class="vb-mobile-nav-link">{{ $item->label }}</a>
        @endforeach
        @auth
            <a href="{{ route('admin.dashboard') }}" class="vb-mobile-nav-link" style="color:var(--vb-secondary);">Admin</a>
        @endauth
    </div>
</nav>

<style>
    .vb-nav-dropdown { position: absolute; top: 100%; left: -8px; min-width: 180px; background: var(--vb-primary); border: 2px solid var(--vb-primary); padding: 0; opacity: 0; pointer-events: none; transform: translateY(4px); transition: all 0.15s; z-index: 100; }
    .vb-nav-parent:hover .vb-nav-dropdown { opacity: 1; pointer-events: auto; transform: translateY(0); }
    .vb-nav-dropdown-item { display: block; padding: 10px 16px; font-size: 14px; color: var(--vb-tertiary); text-decoration: none; border-bottom: 1px solid #262626; transition: background 0.15s; }
    .vb-nav-dropdown-item:last-child { border-bottom: none; }
    .vb-nav-dropdown-item:hover { background: var(--vb-secondary); }
</style>
