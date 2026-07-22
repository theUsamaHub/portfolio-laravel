@props(['settings', 'socialLinks', 'contact'])

<footer class="vb-footer">
    <div class="vb-footer__top">
        <div>
            <div class="vb-footer__brand">{{ $settings['site_name'] ?? 'Portfolio' }}</div>
            <p class="vb-footer__desc">{{ $settings['site_tagline'] ?? 'Building digital experiences that matter.' }}</p>
        </div>

        <div>
            <div class="vb-footer__heading">Navigation</div>
            <div class="vb-footer__links">
                <a href="#hero" class="vb-footer__link">Home</a>
                <a href="#about" class="vb-footer__link">About</a>
                <a href="#skills" class="vb-footer__link">Skills</a>
                <a href="#projects" class="vb-footer__link">Projects</a>
                <a href="#blog" class="vb-footer__link">Blog</a>
                <a href="#contact" class="vb-footer__link">Contact</a>
            </div>
        </div>

        <div>
            <div class="vb-footer__heading">Contact</div>
            <div class="vb-footer__links">
                @if($contact && $contact->email)
                    <a href="mailto:{{ $contact->email }}" class="vb-footer__link">{{ $contact->email }}</a>
                @endif
                @if($contact && $contact->phone)
                    <a href="tel:{{ $contact->phone }}" class="vb-footer__link">{{ $contact->phone }}</a>
                @endif
                @if($contact && $contact->address)
                    <span class="vb-footer__link">{{ $contact->address }}</span>
                @endif
            </div>
        </div>
    </div>

    <div class="vb-footer__bottom">
        <span class="vb-footer__copy">{{ $settings['footer_copyright'] ?? '© ' . date('Y') . '. All Rights Reserved.' }}</span>

        @if($socialLinks->count())
            <div class="vb-footer__socials">
                @foreach($socialLinks as $link)
                    <a href="{{ $link->url }}" target="_blank" class="vb-footer__social" title="{{ $link->platform }}" data-cursor>
                        {{ strtoupper(substr($link->platform, 0, 2)) }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</footer>
