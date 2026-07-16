@php
    $siteName = \App\Helpers\SettingHelper::get('site_name', 'Portfolio');
    $footerSections = $footerSections ?? collect();
    $socialLinks = $socialLinks ?? collect();
@endphp

<footer class="vbox-footer">
    <div class="vbox-container">
        <div class="vbox-footer-grid">
            <div>
                <div class="vbox-footer-brand">{{ $siteName }}<span>.</span></div>
                <p class="vbox-footer-desc">{{ \App\Helpers\SettingHelper::get('site_tagline', 'Building digital experiences that matter.') }}</p>
                @if($socialLinks->count())
                    <div class="vbox-footer-social" style="margin-top: 1.5rem;">
                        @foreach($socialLinks as $link)
                            <a href="{{ $link->url }}" target="_blank" rel="noopener" class="vbox-footer-social-link" aria-label="{{ $link->platform }}">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            @foreach($footerSections as $section)
                <div>
                    <h4 class="vbox-footer-heading">{{ $section->title }}</h4>
                    @if($section->type === 'text')
                        <p class="vbox-footer-desc" style="max-width:none;">{!! $section->content !!}</p>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="vbox-footer-bottom">
            <p>&copy; {{ date('Y') }} {{ $siteName }}. All rights reserved.</p>
            <div class="vbox-footer-social">
                <a href="#" class="vbox-footer-link">Privacy</a>
                <a href="#" class="vbox-footer-link">Terms</a>
            </div>
        </div>
    </div>
</footer>
