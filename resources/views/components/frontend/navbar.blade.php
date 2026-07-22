@props(['navigation', 'settings'])

@php
    $currentPath = request()->path();
@endphp

<nav class="vb-nav">
    <a href="/" class="vb-nav__logo" data-cursor>{{ $settings['site_name'] ?? 'Portfolio' }}</a>

    <div class="vb-nav__links">
        @foreach($navigation as $item)
            @php
                $isActive = false;
                $url = $item->url;

                if (str_contains($url, '#')) {
                    $isActive = false;
                } else {
                    $cleanUrl = ltrim($url, '/');
                    if ($cleanUrl === '') {
                        $isActive = request()->is('/');
                    } else {
                        $isActive = request()->is($cleanUrl);
                    }
                }
            @endphp
            <a href="{{ $url }}"
               class="vb-nav__link {{ $isActive ? 'vb-nav__link--active' : '' }}"
               @if($item->open_in_new_tab) target="_blank" @endif
               data-cursor>
                {{ $item->label }}
            </a>
        @endforeach
        @if(Route::has('login'))
            <a href="{{ route('login') }}" class="vb-nav__cta magnetic" data-cursor>Admin</a>
        @endif
        <button class="vb-theme-toggle" id="themeToggle" data-cursor title="Toggle dark mode">
            <svg class="vb-theme-toggle__sun" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
            <svg class="vb-theme-toggle__moon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
        </button>
    </div>

    <button class="vb-nav__toggle" aria-label="Toggle menu">
        <span></span>
        <span></span>
        <span></span>
    </button>
</nav>

<div class="vb-nav__mobile">
    @foreach($navigation as $item)
        <a href="{{ $item->url }}" @if($item->open_in_new_tab) target="_blank" @endif>{{ $item->label }}</a>
    @endforeach
    @if(Route::has('login'))
        <a href="{{ route('login') }}">Admin</a>
    @endif
</div>
