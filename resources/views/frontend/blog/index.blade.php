@extends('layouts.frontend')

@section('title', 'Blog — ' . $settings['site_name'])

@section('content')
{{-- Page Header --}}
<section class="vb-section" style="padding-top: calc(var(--nav-height) + var(--space-4xl));">
    <div class="vb-container">
        <div class="vb-section__header" data-reveal>
            <span class="vb-section__overline vb-overline">Blog</span>
            <h1 class="vb-section__title vb-display">Articles & Thoughts</h1>
            <p class="vb-body-lg" style="color: var(--vb-gray-500); max-width: 600px; margin-top: var(--space-lg);">
                Technical articles, tutorials, and opinions on web development, software architecture, and the technologies I work with.
            </p>
            <div class="vb-section__divider"></div>
        </div>

        {{-- Category Filter --}}
        @if($categories->count())
            <div class="vb-blog__filters" data-reveal data-delay="0.2" style="display: flex; gap: var(--space-sm); flex-wrap: wrap; margin-bottom: var(--space-3xl);">
                <a href="{{ route('blog.index') }}"
                   class="vb-blog__filter {{ !request('category') ? 'vb-blog__filter--active' : '' }}">
                    All
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('blog.index', ['category' => $cat->slug]) }}"
                       class="vb-blog__filter {{ request('category') === $cat->slug ? 'vb-blog__filter--active' : '' }}">
                        {{ $cat->name }}
                        <span class="vb-blog__filter-count">{{ $cat->posts_count }}</span>
                    </a>
                @endforeach
            </div>
        @endif

        {{-- Posts Grid --}}
        @if($posts->count())
            <div class="vb-blog__grid" data-stagger>
                @foreach($posts as $post)
                    <article class="vb-post">
                        <a href="{{ route('blog.show', $post->slug) }}" class="vb-post__link">
                            <div class="vb-post__image">
                                @if($post->featured_image)
                                    <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->name }}">
                                @else
                                    <div class="vb-post__placeholder">
                                        <span>{{ strtoupper(substr($post->name, 0, 2)) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="vb-post__body">
                                <div class="vb-post__meta">
                                    @if($post->category)
                                        <span class="vb-post__category vb-overline">{{ $post->category->name }}</span>
                                    @endif
                                    @if($post->published_at)
                                        <span class="vb-post__date vb-caption">{{ $post->published_at->format('M d, Y') }}</span>
                                    @endif
                                    @if($post->reading_time)
                                        <span class="vb-post__date vb-caption">{{ $post->reading_time }} min read</span>
                                    @endif
                                </div>
                                <h2 class="vb-post__title">{{ $post->name }}</h2>
                                @if($post->excerpt)
                                    <p class="vb-post__excerpt">{{ Str::limit($post->excerpt, 140) }}</p>
                                @endif
                                <span class="vb-post__read">Read Article →</span>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($posts->hasPages())
                <div class="vb-blog__pagination" data-reveal style="margin-top: var(--space-3xl); display: flex; justify-content: center;">
                    {{ $posts->links() }}
                </div>
            @endif
        @else
            <div class="vb-blog__empty" data-reveal style="text-align: center; padding: var(--space-4xl) 0;">
                <h3 class="vb-h2" style="margin-bottom: var(--space-md);">No Articles Yet</h3>
                <p class="vb-body" style="color: var(--vb-gray-500);">Check back soon for new content.</p>
            </div>
        @endif
    </div>
</section>
@endsection

@push('head')
<style>
    .vb-post__link {
        display: block;
        color: inherit;
        text-decoration: none;
    }
    .vb-post__placeholder {
        width: 100%;
        height: 100%;
        background: var(--vb-gray-100);
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: var(--font-display);
        font-size: 3rem;
        color: var(--vb-gray-300);
    }
    .vb-blog__filter {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 16px;
        border: 2px solid var(--vb-gray-300);
        font-size: 0.8125rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--vb-gray-500);
        transition: all 0.3s;
    }
    .vb-blog__filter:hover,
    .vb-blog__filter--active {
        background: var(--vb-black);
        border-color: var(--vb-black);
        color: var(--vb-white);
    }
    .vb-blog__filter-count {
        font-size: 0.6875rem;
        background: var(--vb-gray-200);
        color: var(--vb-gray-500);
        padding: 1px 6px;
    }
    .vb-blog__filter--active .vb-blog__filter-count {
        background: rgba(255,255,255,0.2);
        color: var(--vb-white);
    }
    /* Pagination */
    .vb-blog__pagination nav {
        display: flex;
        gap: var(--space-xs);
    }
    .vb-blog__pagination .pagination {
        display: flex;
        gap: var(--space-xs);
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .vb-blog__pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 12px;
        border: 2px solid var(--vb-gray-300);
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--vb-black);
        transition: all 0.3s;
    }
    .vb-blog__pagination .page-link:hover {
        background: var(--vb-black);
        border-color: var(--vb-black);
        color: var(--vb-white);
    }
    .vb-blog__pagination .page-item.active .page-link {
        background: var(--vb-red);
        border-color: var(--vb-red);
        color: var(--vb-white);
    }
    .vb-blog__pagination .page-item.disabled .page-link {
        opacity: 0.35;
        pointer-events: none;
    }
</style>
@endpush
