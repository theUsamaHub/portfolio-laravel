@extends('layouts.voicebox')

@section('content')
@include('partials.vb-header')

<main id="main-content" style="padding-top:100px;">
    <section class="vb-section">
        <div class="vb-container" style="max-width:800px;">
            @if($post->category)
                <a href="{{ route('blog.index', ['category' => $post->category->slug]) }}" class="overline" data-vb-reveal>{{ $post->category->name }}</a>
            @endif
            <h1 data-vb-reveal data-vb-delay="0.1">{{ $post->name }}</h1>

            <div class="vb-flex vb-gap-4" style="margin:24px 0;flex-wrap:wrap;font-size:14px;color:var(--vb-text-tertiary);" data-vb-reveal data-vb-delay="0.15">
                @if($post->author)<span>By {{ $post->author->name }}</span>@endif
                @if($post->published_at)<span>{{ $post->published_at->format('M d, Y') }}</span>@endif
                @if($post->reading_time)<span>{{ $post->reading_time }} min read</span>@endif
                <span>{{ $post->views_count }} views</span>
            </div>

            @if($post->featured_image)
                <div style="margin:32px 0;border:4px solid var(--vb-primary);overflow:hidden;" data-vb-reveal data-vb-delay="0.2">
                    <img src="{{ \App\Helpers\ImageHelper::url($post->featured_image, 'blog') }}" alt="{{ $post->name }}" style="width:100%;max-height:400px;object-fit:cover;">
                </div>
            @endif

            @if($post->tags->count())
                <div class="vb-flex" style="flex-wrap:wrap;gap:8px;margin-bottom:32px;" data-vb-reveal>
                    @foreach($post->tags as $tag)
                        <a href="{{ route('blog.index', ['tag' => $tag->slug]) }}" class="vb-chip">{{ $tag->name }}</a>
                    @endforeach
                </div>
            @endif

            <div class="vb-divider"></div>

            <div style="font-size:16px;line-height:1.7;color:var(--vb-text-secondary);margin:32px 0;" data-vb-reveal>
                {!! $post->content !!}
            </div>
        </div>

        {{-- Related Posts --}}
        @if($relatedPosts->count())
            <div class="vb-container" style="max-width:800px;">
                <div class="vb-divider-strong"></div>
                <h2 style="margin:32px 0;" data-vb-reveal>Related Articles</h2>
                <div class="vb-grid vb-grid-3">
                    @foreach($relatedPosts as $related)
                        <a href="{{ route('blog.show', $related->slug) }}" class="vb-blog-card" data-vb-reveal>
                            @if($related->featured_image)
                                <div class="vb-blog-image">
                                    <img src="{{ \App\Helpers\ImageHelper::url($related->featured_image, 'blog') }}" alt="{{ $related->name }}" loading="lazy">
                                </div>
                            @endif
                            <div class="vb-blog-body">
                                <h3 class="vb-blog-title">{{ $related->name }}</h3>
                                <p class="vb-blog-excerpt">{{ Str::limit(strip_tags($related->content), 100) }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
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
