@extends('layouts.admin')
@section('admin-content')
<div class="mb-6">
    <h2 style="font-size: 1.25rem; font-weight: 700;">Site Settings</h2>
    <p class="text-muted" style="font-size:0.875rem;">Configure your site settings, appearance, and integrations.</p>
</div>

<div class="grid grid-2 gap-4">
    @php
    $groupInfo = [
        'general' => ['icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>', 'desc' => 'Site name, logo, description, keywords, author, timezone'],
        'appearance' => ['icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="13.5" cy="6.5" r="2.5"/><path d="M17.5 10.5l1 1"/><circle cx="8.5" cy="6.5" r="2.5"/><path d="M3 14c0-3.87 3.13-7 7-7s7 3.13 7 7v4H3v-4z"/></svg>', 'desc' => 'Colors, theme, custom CSS/JS, fonts'],
        'contact' => ['icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>', 'desc' => 'Email, phone, address, map embed'],
        'footer' => ['icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>', 'desc' => 'Copyright text, tagline, footer options'],
        'analytics' => ['icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>', 'desc' => 'Google Analytics, Tag Manager, Facebook Pixel, Hotjar'],
        'email' => ['icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>', 'desc' => 'SMTP configuration for emails'],
        'security' => ['icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>', 'desc' => 'reCAPTCHA, HSTS, maintenance mode'],
    ];
    @endphp

    @foreach($groups as $group => $count)
        @php $info = $groupInfo[$group] ?? ['icon' => '', 'desc' => '']; @endphp
        <a href="{{ route('admin.settings.group', $group) }}" class="card card-interactive" style="display:flex;align-items:flex-start;gap:1rem;">
            <div style="width:3rem;height:3rem;border-radius:var(--radius);background:var(--color-primary-light);display:flex;align-items:center;justify-content:center;color:var(--color-primary);flex-shrink:0;">
                {!! $info['icon'] !!}
            </div>
            <div>
                <h3 style="font-weight: 600; margin-bottom: 0.25rem;">{{ ucfirst(str_replace('_', ' ', $group)) }}</h3>
                <p style="font-size: 0.8125rem;color:var(--text-muted);margin:0;">{{ $info['desc'] }}</p>
                <p style="font-size: 0.75rem;color:var(--color-primary);margin-top:0.25rem;">{{ $count }} settings</p>
            </div>
        </a>
    @endforeach
</div>
@endsection
