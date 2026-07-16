@php
    $siteName = \App\Helpers\SettingHelper::get('site_name', 'VoiceBox');
    $footerTagline = \App\Helpers\SettingHelper::get('footer_tagline', 'Building digital experiences that matter.');
    $footerCopyright = \App\Helpers\SettingHelper::get('footer_copyright', '© ' . date('Y') . '. All Rights Reserved.');
    $socialLinks = $socialLinks ?? collect();
    $navigation = $navigation ?? collect();
@endphp

<footer class="vb-footer">
    <div class="vb-container">
        <div class="vb-footer-grid">
            <div>
                <div class="vb-footer-brand">{{ $siteName }}</div>
                <p class="vb-footer-desc">{{ $footerTagline }}</p>
                @if($socialLinks->count())
                    <div class="vb-footer-social" style="margin-top:16px;">
                        @foreach($socialLinks as $link)
                            <a href="{{ $link->url }}" target="_blank" rel="noopener" class="vb-footer-social-link" aria-label="{{ $link->platform }}">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
            <div>
                <div class="vb-footer-heading">Navigation</div>
                <div class="vb-footer-links">
                    @foreach($navigation as $item)
                        <a href="{{ $item->url ?? '#' }}" class="vb-footer-link">{{ $item->label }}</a>
                    @endforeach
                </div>
            </div>
            <div>
                <div class="vb-footer-heading">Contact</div>
                <div class="vb-footer-links">
                    @php $contact = \App\Models\ContactSetting::active()->first(); @endphp
                    @if($contact && $contact->email)<a href="mailto:{{ $contact->email }}" class="vb-footer-link">{{ $contact->email }}</a>@endif
                    @if($contact && $contact->phone)<a href="tel:{{ $contact->phone }}" class="vb-footer-link">{{ $contact->phone }}</a>@endif
                    @if($contact && $contact->address)<span class="vb-footer-link">{{ $contact->address }}</span>@endif
                </div>
            </div>
        </div>
        <div class="vb-footer-bottom">
            <span>{{ $footerCopyright }}</span>
            <span>Built with passion</span>
        </div>
    </div>
</footer>
