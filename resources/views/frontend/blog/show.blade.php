@extends('layouts.frontend')

@section('title', $post->meta_title ?? $post->name . ' — ' . $settings['site_name'])
@section('description', $post->meta_description ?? $post->excerpt)

@section('content')
{{-- Article Header --}}
<section class="vb-section" style="padding-top: calc(var(--nav-height) + var(--space-4xl)); padding-bottom: var(--space-2xl);">
    <div class="vb-container">
        <div style="max-width: 800px;">
            {{-- Breadcrumb --}}
            <div class="vb-blog__breadcrumb" data-reveal style="margin-bottom: var(--space-xl);">
                <a href="{{ route('home') }}" class="vb-body-sm" style="color: var(--vb-gray-500);">Home</a>
                <span class="vb-body-sm" style="color: var(--vb-gray-400); margin: 0 var(--space-sm);">/</span>
                <a href="{{ route('blog.index') }}" class="vb-body-sm" style="color: var(--vb-gray-500);">Blog</a>
                <span class="vb-body-sm" style="color: var(--vb-gray-400); margin: 0 var(--space-sm);">/</span>
                <span class="vb-body-sm" style="color: var(--vb-black);">{{ Str::limit($post->name, 40) }}</span>
            </div>

            {{-- Category & Meta --}}
            <div class="vb-blog__meta" data-reveal data-delay="0.1" style="display: flex; gap: var(--space-md); align-items: center; margin-bottom: var(--space-lg); flex-wrap: wrap;">
                @if($post->category)
                    <a href="{{ route('blog.index', ['category' => $post->category->slug]) }}" class="vb-blog__cat-badge">
                        {{ $post->category->name }}
                    </a>
                @endif
                @if($post->published_at)
                    <span class="vb-caption" style="color: var(--vb-gray-400);">{{ $post->published_at->format('F d, Y') }}</span>
                @endif
                @if($post->reading_time)
                    <span class="vb-caption" style="color: var(--vb-gray-400);">{{ $post->reading_time }} min read</span>
                @endif
            </div>

            {{-- Title --}}
            <h1 class="vb-display" data-reveal data-delay="0.2" style="font-size: clamp(2rem, 5vw, 3.5rem); margin-bottom: var(--space-lg);">
                {{ $post->name }}
            </h1>

            {{-- Excerpt --}}
            @if($post->excerpt)
                <p class="vb-body-lg" data-reveal data-delay="0.3" style="color: var(--vb-gray-500); max-width: 700px; line-height: 1.7;">
                    {{ $post->excerpt }}
                </p>
            @endif

            {{-- Author --}}
            @if($post->author)
                <div class="vb-blog__author" data-reveal data-delay="0.4" style="display: flex; align-items: center; gap: var(--space-md); margin-top: var(--space-xl); padding-top: var(--space-xl); border-top: 2px solid var(--vb-gray-200);">
                    <div class="vb-blog__author-avatar">
                        {{ strtoupper(substr($post->author->name, 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-weight: 600;">{{ $post->author->name }}</div>
                        <div class="vb-caption" style="color: var(--vb-gray-400);">Author</div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

{{-- Featured Image --}}
@if($post->featured_image)
<section style="padding: 0 var(--space-xl); margin-bottom: var(--space-3xl);">
    <div class="vb-container">
        <div class="vb-blog__featured" data-reveal style="border: 2px solid var(--vb-black); overflow: hidden;">
            <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->name }}" style="width: 100%; max-height: 500px; object-fit: cover;">
        </div>
    </div>
</section>
@endif

{{-- Article Content + Sidebar --}}
<section class="vb-section" style="padding-top: 0;">
    <div class="vb-container">
        <div class="vb-blog__layout">
            {{-- Main Content --}}
            <article class="vb-blog__content" data-reveal="left">
                {!! $post->content !!}

                {{-- Tags --}}
                @if($post->tags->count())
                    <div class="vb-blog__tags" style="margin-top: var(--space-3xl); padding-top: var(--space-xl); border-top: 2px solid var(--vb-gray-200);">
                        <span class="vb-overline" style="color: var(--vb-gray-400); display: block; margin-bottom: var(--space-md);">Tags</span>
                        <div style="display: flex; gap: var(--space-sm); flex-wrap: wrap;">
                            @foreach($post->tags as $tag)
                                <span class="vb-blog__tag">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Share --}}
                <div class="vb-blog__share" style="margin-top: var(--space-xl); padding-top: var(--space-xl); border-top: 1px solid var(--vb-gray-200);">
                    <span class="vb-overline" style="color: var(--vb-gray-400); display: block; margin-bottom: var(--space-md);">Share</span>
                    <div style="display: flex; gap: var(--space-sm);">
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->name) }}&url={{ urlencode(url()->current()) }}" target="_blank" class="vb-blog__share-btn" data-cursor>Twitter</a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" target="_blank" class="vb-blog__share-btn" data-cursor>LinkedIn</a>
                        <button onclick="navigator.clipboard.writeText(window.location.href)" class="vb-blog__share-btn" data-cursor>Copy Link</button>
                    </div>
                </div>
            </article>

            {{-- Sidebar --}}
            <aside class="vb-blog__sidebar" data-reveal="right">
                {{-- Table of Contents (basic) --}}
                <div class="vb-blog__widget">
                    <h3 class="vb-blog__widget-title">In This Article</h3>
                    <div class="vb-blog__toc" id="toc"></div>
                </div>

                {{-- Recent Posts --}}
                @if($recentPosts->count())
                    <div class="vb-blog__widget">
                        <h3 class="vb-blog__widget-title">Recent Articles</h3>
                        <div class="vb-blog__recent">
                            @foreach($recentPosts as $recent)
                                <a href="{{ route('blog.show', $recent->slug) }}" class="vb-blog__recent-item">
                                    <div class="vb-blog__recent-thumb">
                                        @if($recent->featured_image)
                                            <img src="{{ Storage::url($recent->featured_image) }}" alt="{{ $recent->name }}">
                                        @else
                                            <span>{{ strtoupper(substr($recent->name, 0, 1)) }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="vb-blog__recent-title">{{ Str::limit($recent->name, 50) }}</div>
                                        @if($recent->published_at)
                                            <div class="vb-caption" style="color: var(--vb-gray-400);">{{ $recent->published_at->format('M d, Y') }}</div>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Back to Blog --}}
                <div class="vb-blog__widget">
                    <a href="{{ route('blog.index') }}" class="vb-btn vb-btn--primary" style="width: 100%; justify-content: center;">
                        ← All Articles
                    </a>
                </div>
            </aside>
        </div>
    </div>
</section>

{{-- Related Posts --}}
@if($relatedPosts->count())
<section class="vb-section vb-section--gray">
    <div class="vb-container">
        <div class="vb-section__header" data-reveal>
            <span class="vb-section__overline vb-overline">Keep Reading</span>
            <h2 class="vb-section__title vb-h1">Related Articles</h2>
            <div class="vb-section__divider"></div>
        </div>

        <div class="vb-blog__grid" data-stagger style="grid-template-columns: repeat(2, 1fr);">
            @foreach($relatedPosts->take(2) as $related)
                <article class="vb-post">
                    <a href="{{ route('blog.show', $related->slug) }}" class="vb-post__link">
                        <div class="vb-post__image">
                            @if($related->featured_image)
                                <img src="{{ Storage::url($related->featured_image) }}" alt="{{ $related->name }}">
                            @else
                                <div class="vb-post__placeholder">
                                    <span>{{ strtoupper(substr($related->name, 0, 2)) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="vb-post__body">
                            <div class="vb-post__meta">
                                @if($related->category)
                                    <span class="vb-post__category vb-overline">{{ $related->category->name }}</span>
                                @endif
                                @if($related->published_at)
                                    <span class="vb-post__date vb-caption">{{ $related->published_at->format('M d, Y') }}</span>
                                @endif
                            </div>
                            <h3 class="vb-post__title">{{ $related->name }}</h3>
                            @if($related->excerpt)
                                <p class="vb-post__excerpt">{{ Str::limit($related->excerpt, 120) }}</p>
                            @endif
                            <span class="vb-post__read">Read →</span>
                        </div>
                    </a>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

@push('head')
<style>
    .vb-post__link { display: block; color: inherit; text-decoration: none; }
    .vb-post__placeholder {
        width: 100%; height: 100%;
        background: var(--vb-gray-100);
        display: flex; align-items: center; justify-content: center;
        font-family: var(--font-display); font-size: 3rem; color: var(--vb-gray-300);
    }

    .vb-blog__cat-badge {
        padding: 4px 12px;
        border: 2px solid var(--vb-red);
        color: var(--vb-red);
        font-size: 0.6875rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        text-decoration: none;
        transition: all 0.3s;
    }
    .vb-blog__cat-badge:hover {
        background: var(--vb-red);
        color: var(--vb-white);
    }

    .vb-blog__author-avatar {
        width: 48px; height: 48px;
        background: var(--vb-black);
        color: var(--vb-white);
        display: flex; align-items: center; justify-content: center;
        font-family: var(--font-display); font-size: 1.25rem;
    }

    .vb-blog__layout {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: var(--space-3xl);
        align-items: start;
    }

    .vb-blog__content {
        font-size: 1.0625rem;
        line-height: 1.8;
        color: var(--vb-gray-900);
    }
    .vb-blog__content h2 {
        font-family: var(--font-display);
        font-size: 1.75rem;
        margin: var(--space-2xl) 0 var(--space-lg);
        line-height: 1.2;
    }
    .vb-blog__content h3 {
        font-family: var(--font-display);
        font-size: 1.375rem;
        margin: var(--space-xl) 0 var(--space-md);
        line-height: 1.25;
    }
    .vb-blog__content p {
        margin-bottom: var(--space-lg);
    }
    .vb-blog__content ul,
    .vb-blog__content ol {
        margin: var(--space-lg) 0;
        padding-left: var(--space-xl);
    }
    .vb-blog__content li {
        margin-bottom: var(--space-sm);
        list-style: disc;
    }
    .vb-blog__content ol li { list-style: decimal; }
    .vb-blog__content code {
        font-family: var(--font-mono);
        background: var(--vb-gray-100);
        padding: 2px 6px;
        font-size: 0.9em;
    }
    .vb-blog__content pre {
        background: var(--vb-black);
        color: var(--vb-white);
        padding: var(--space-lg);
        margin: var(--space-xl) 0;
        overflow-x: auto;
        border: 2px solid var(--vb-black);
    }
    .vb-blog__content pre code {
        background: none;
        padding: 0;
        color: inherit;
    }
    .vb-blog__content blockquote {
        border-left: 4px solid var(--vb-red);
        padding: var(--space-md) var(--space-xl);
        margin: var(--space-xl) 0;
        background: var(--vb-gray-100);
        font-style: italic;
    }
    .vb-blog__content a {
        color: var(--vb-red);
        text-decoration: underline;
        text-underline-offset: 3px;
    }
    .vb-blog__content a:hover { text-decoration-thickness: 2px; }
    .vb-blog__content img {
        width: 100%;
        border: 2px solid var(--vb-gray-200);
        margin: var(--space-xl) 0;
    }

    .vb-blog__tag {
        padding: 4px 12px;
        border: 1px solid var(--vb-gray-300);
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--vb-gray-500);
    }
    .vb-blog__share-btn {
        padding: 8px 16px;
        border: 2px solid var(--vb-gray-300);
        background: transparent;
        font-family: var(--font-body);
        font-size: 0.8125rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        color: var(--vb-black);
        text-decoration: none;
        display: inline-block;
    }
    .vb-blog__share-btn:hover {
        background: var(--vb-black);
        border-color: var(--vb-black);
        color: var(--vb-white);
    }

    /* Sidebar */
    .vb-blog__sidebar {
        position: sticky;
        top: calc(var(--nav-height) + var(--space-xl));
    }
    .vb-blog__widget {
        border: 2px solid var(--vb-gray-200);
        padding: var(--space-xl);
        margin-bottom: var(--space-lg);
    }
    .vb-blog__widget-title {
        font-family: var(--font-display);
        font-size: 1rem;
        margin-bottom: var(--space-lg);
        padding-bottom: var(--space-md);
        border-bottom: 2px solid var(--vb-gray-200);
    }

    .vb-blog__toc {
        display: flex;
        flex-direction: column;
        gap: var(--space-sm);
    }
    .vb-blog__toc a {
        font-size: 0.875rem;
        color: var(--vb-gray-500);
        padding: 4px 0;
        border-left: 2px solid transparent;
        padding-left: var(--space-md);
        transition: all 0.3s;
        text-decoration: none;
    }
    .vb-blog__toc a:hover,
    .vb-blog__toc a.is-active {
        color: var(--vb-black);
        border-left-color: var(--vb-red);
    }
    .vb-blog__toc a.toc-h3 { padding-left: calc(var(--space-md) + var(--space-md)); font-size: 0.8125rem; }

    .vb-blog__recent {
        display: flex;
        flex-direction: column;
        gap: var(--space-md);
    }
    .vb-blog__recent-item {
        display: flex;
        gap: var(--space-md);
        text-decoration: none;
        color: inherit;
        padding: var(--space-sm) 0;
        transition: color 0.3s;
    }
    .vb-blog__recent-item:hover { color: var(--vb-red); }
    .vb-blog__recent-thumb {
        width: 56px; height: 56px;
        flex-shrink: 0;
        background: var(--vb-gray-100);
        display: flex; align-items: center; justify-content: center;
        font-family: var(--font-display); font-size: 1rem; color: var(--vb-gray-400);
        overflow: hidden;
        border: 1px solid var(--vb-gray-200);
    }
    .vb-blog__recent-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .vb-blog__recent-title {
        font-weight: 600;
        font-size: 0.875rem;
        line-height: 1.4;
    }

    @media (max-width: 900px) {
        .vb-blog__layout {
            grid-template-columns: 1fr;
        }
        .vb-blog__sidebar { position: static; }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Build Table of Contents
    const content = document.querySelector('.vb-blog__content');
    const toc = document.getElementById('toc');
    if (!content || !toc) return;

    const headings = content.querySelectorAll('h2, h3');
    if (headings.length === 0) {
        document.querySelector('.vb-blog__widget')?.remove();
        return;
    }

    headings.forEach((heading, i) => {
        const id = 'heading-' + i;
        heading.id = id;
        const link = document.createElement('a');
        link.href = '#' + id;
        link.textContent = heading.textContent;
        if (heading.tagName === 'H3') link.classList.add('toc-h3');
        toc.appendChild(link);
    });

    // Active TOC highlight on scroll
    const tocLinks = toc.querySelectorAll('a');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                tocLinks.forEach(l => l.classList.remove('is-active'));
                const activeLink = toc.querySelector(`a[href="#${entry.target.id}"]`);
                if (activeLink) activeLink.classList.add('is-active');
            }
        });
    }, { rootMargin: '-80px 0px -70% 0px' });

    headings.forEach(h => observer.observe(h));
});
</script>
@endpush
