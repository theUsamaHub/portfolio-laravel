@php
    $siteName = \App\Helpers\SettingHelper::get('site_name', 'Portfolio');
    $navigation = $navigation ?? collect();
    $socialLinks = $socialLinks ?? collect();
@endphp

<header class="site-header" id="site-header">
    <div class="container">
        <div class="header-inner">
            <a href="{{ route('home') }}" class="site-logo">{{ $siteName }}</a>

            <nav class="site-nav" aria-label="Main navigation">
                @foreach($navigation as $item)
                    @if($item->children->count())
                        <div class="nav-dropdown">
                            <a href="{{ $item->url ?? '#' }}"
                               class="nav-link {{ request()->is(ltrim($item->url ?? '', '/')) ? 'active' : '' }}"
                               @if($item->open_in_new_tab) target="_blank" rel="noopener" @endif>
                                {{ $item->label }}
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-left:0.25rem;"><polyline points="6 9 12 15 18 9"/></svg>
                            </a>
                            <div class="nav-dropdown-menu">
                                @foreach($item->children as $child)
                                    <a href="{{ $child->url ?? '#' }}" class="nav-dropdown-item" @if($child->open_in_new_tab) target="_blank" rel="noopener" @endif>{{ $child->label }}</a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ $item->url ?? '#' }}"
                           class="nav-link {{ request()->is(ltrim($item->url ?? '', '/')) ? 'active' : '' }}"
                           @if($item->open_in_new_tab) target="_blank" rel="noopener" @endif>
                            {{ $item->label }}
                        </a>
                    @endif
                @endforeach
            </nav>

            <div class="header-actions">
                <button class="btn btn-icon btn-ghost theme-toggle" id="theme-toggle" aria-label="Toggle dark mode">
                    <svg class="icon-sun" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
                    <svg class="icon-moon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                </button>

                <button class="mobile-toggle btn btn-icon btn-ghost" id="mobile-toggle" aria-label="Toggle menu" aria-expanded="false">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
            </div>
        </div>
    </div>
</header>

{{-- Mobile Menu --}}
<div class="mobile-overlay" id="mobile-overlay"></div>
<nav class="mobile-menu" id="mobile-menu" aria-label="Mobile navigation">
    <button class="btn btn-icon btn-ghost" id="mobile-close" aria-label="Close menu" style="align-self: flex-end;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>
    <div class="mobile-nav">
        @foreach($navigation as $item)
            <a href="{{ $item->url ?? '#' }}" class="mobile-nav-link">{{ $item->label }}</a>
            @if($item->children->count())
                @foreach($item->children as $child)
                    <a href="{{ $child->url ?? '#' }}" class="mobile-nav-link" style="padding-left:2rem;font-size:0.9375rem;">{{ $child->label }}</a>
                @endforeach
            @endif
        @endforeach
        @auth
            <a href="{{ route('admin.dashboard') }}" class="mobile-nav-link">Admin</a>
        @endauth
    </div>
</nav>
