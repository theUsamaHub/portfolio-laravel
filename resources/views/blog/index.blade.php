@extends('layouts.voicebox')

@section('content')
@include('partials.vb-header')

<main id="main-content" style="padding-top:100px;">
    <section class="vb-section">
        <div class="vb-container">
            <div class="vb-section-header" data-vb-reveal>
                <span class="overline">Blog</span>
                <h1>Latest Articles</h1>
            </div>

            <div class="vb-grid vb-grid-3">
                @forelse($posts as $post)
                    <a href="{{ route('blog.show', $post->slug) }}" class="vb-blog-card" data-vb-reveal data-vb-delay="{{ ($loop->index % 3) * 0.1 }}">
                        @if($post->featured_image)
                            <div class="vb-blog-image">
                                <img src="{{ \App\Helpers\ImageHelper::url($post->featured_image, 'blog') }}" alt="{{ $post->name }}" loading="lazy">
                            </div>
                        @endif
                        <div class="vb-blog-body">
                            <div class="vb-blog-meta">
                                @if($post->category)<span>{{ $post->category->name }}</span>@endif
                                @if($post->published_at)<span>{{ $post->published_at->format('M d, Y') }}</span>@endif
                                @if($post->reading_time)<span>{{ $post->reading_time }} min read</span>@endif
                            </div>
                            <h3 class="vb-blog-title">{{ $post->name }}</h3>
                            <p class="vb-blog-excerpt">{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 150) }}</p>
                        </div>
                    </a>
                @empty
                    <div style="grid-column:1/-1;text-align:center;padding:96px 0;">
                        <p class="overline">Blog</p>
                        <h2>No Articles Yet</h2>
                        <p style="color:var(--vb-text-secondary);">Check back soon for new content.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">{{ $posts->withQueryString()->links() }}</div>
        </div>
    </section>
</main>

@include('partials.vb-footer')

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    AOS.init({ duration: 800, once: true, offset: 80 });
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);
        document.querySelectorAll('[data-vb-reveal]').forEach(el => {
            const delay = parseFloat(el.dataset.vbDelay) || 0;
            gsap.fromTo(el, { opacity: 0, y: 40 }, { opacity: 1, y: 0, duration: 0.8, delay, scrollTrigger: { trigger: el, start: 'top 85%', once: true } });
        });
    }
    const html = document.documentElement;
    const saved = localStorage.getItem('vb-theme') || 'light';
    html.setAttribute('data-theme', saved);
    document.getElementById('vb-theme-toggle')?.addEventListener('click', () => { const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark'; html.setAttribute('data-theme', next); localStorage.setItem('vb-theme', next); document.querySelector('.icon-sun').style.display = next === 'dark' ? 'none' : 'block'; document.querySelector('.icon-moon').style.display = next === 'dark' ? 'block' : 'none'; });
    window.addEventListener('scroll', () => document.getElementById('vb-header')?.classList.toggle('scrolled', window.scrollY > 50));
    const mt = document.getElementById('vb-mobile-toggle'), mm = document.getElementById('vb-mobile-menu'), mo = document.getElementById('vb-mobile-overlay'), mc = document.getElementById('vb-mobile-close');
    const openM = () => { mm?.classList.add('active'); mo?.classList.add('active'); document.body.style.overflow = 'hidden'; };
    const closeM = () => { mm?.classList.remove('active'); mo?.classList.remove('active'); document.body.style.overflow = ''; };
    mt?.addEventListener('click', () => mm?.classList.contains('active') ? closeM() : openM());
    mo?.addEventListener('click', closeM); mc?.addEventListener('click', closeM);
});
</script>
@endpush
@endsection
