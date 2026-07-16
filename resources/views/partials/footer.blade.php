@php
    $siteName = \App\Helpers\SettingHelper::get('site_name', 'Portfolio');
    $footerSections = $footerSections ?? collect();
    $socialLinks = $socialLinks ?? collect();
@endphp

<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <div class="footer-brand-name">{{ $siteName }}</div>
                <p class="footer-brand-desc">{{ \App\Helpers\SettingHelper::get('site_tagline', 'Building digital experiences that matter.') }}</p>
                @if($socialLinks->count())
                    <div class="footer-social">
                        @foreach($socialLinks as $link)
                            <a href="{{ $link->url }}" target="_blank" rel="noopener" class="footer-social-link" aria-label="{{ $link->platform }}">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/></svg>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            @foreach($footerSections as $section)
                <div>
                    <h4 class="footer-heading">{{ $section->title }}</h4>
                    @if($section->type === 'text')
                        <p class="footer-brand-desc" style="max-width: none;">{!! $section->content !!}</p>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} {{ $siteName }}. All rights reserved.</p>
            <div class="flex gap-4">
                <a href="#" class="footer-link">Privacy Policy</a>
                <a href="#" class="footer-link">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>
